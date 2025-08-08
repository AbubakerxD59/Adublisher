<?php
require __DIR__ . '/tiktok/src/TikTok/autoload.php';

use TikTok\Authentication\Authentication;
use TikTok\User\User;
use TikTok\Request\Params;
use TikTok\Post\Post;
use TikTok\Request\Fields;
use TikTok\Video\Video;

class Tiktok
{
    public $authentication;
    public function __construct()
    {
        // config
        $config = ['client_key' => TIKTOK_CLIENT_KEY, 'client_secret' => TIKTOK_CLIENT_SECRET];
        // Auth object
        $this->authentication = new Authentication($config);
    }
    public function getAuthUrl()
    {
        // scopes
        $scopes = ["user.info.basic", "user.info.profile", "video.publish", "video.upload", "user.info.stats", "video.list"];
        $authenticationUrl = $this->authentication->getAuthenticationUrl(TIKTOK_REDIRECT_URI, $scopes);
        return $authenticationUrl;
    }
    public function get_access_token($code = null)
    {
        if (!empty($code)) {
            $authenticationUrl = $this->authentication->getAccessTokenFromCode($code, TIKTOK_REDIRECT_URI);
            return $authenticationUrl;
        } else {
            return array('error' => 'invalid', 'error_description' => 'Something went wrong!');
        }
    }
    public function revokeAccess($access_token = null)
    {
        if (!empty($access_token)) {
            $authenticationUrl = $this->authentication->revokeAccessToken($access_token);
            return $authenticationUrl;
        } else {
            return array('error' => 'invalid', 'error_description' => 'Something went wrong!');
        }
    }
    public function refresh_access_token($refresh_token = null)
    {
        // refresh token
        $tokenRefresh = $this->authentication->getRefreshAccessToken($refresh_token);
        return $tokenRefresh;
    }
    public function get_user_info($access_token)
    {
        if (!empty($access_token)) {
            // check and refresh access token
            $access_token = refresh_tiktok_access_token($access_token);
            $config = array('access_token' => $access_token);
            $user = new User($config);
            $params = Params::getFieldsParam( // params keys the field array and implodes array to string on comma
                array( // user fields to request
                    'open_id',         // scope user.info.basic
                    'union_id',         // scope user.info.basic
                    'avatar_url',         // scope user.info.basic
                    'avatar_url_100',       // scope user.info.basic
                    'avatar_large_url',     // scope user.info.basic
                    'display_name',     // scope user.info.basic
                    'bio_description',     // scope user.info.profile
                    'profile_deep_link',     // scope user.info.profile
                    'is_verified',         // scope user.info.profile
                    'follower_count',     // scope user.info.stats
                    'following_count',     // scope user.info.stats
                    'likes_count',         // scope user.info.stats
                    'video_count'         // scope user.info.stats
                )
            );
            $userInfo = $user->getSelf($params);
            if (!empty($userInfo['error']['message'])) {
                return array(
                    'error' => $userInfo['error']['code'],
                    'error_description' => $userInfo['error']['message'],
                );
            } else {
                return $userInfo['data'];
            }
        } else {
            return array(
                'error' => 'invalid',
                'error_description' => 'Access token not found!'
            );
        }
    }
    public function publish_video($postData, $access_token = null)
    {
        if (!empty($access_token)) {
            // check and refresh access token
            $access_token = refresh_tiktok_access_token($access_token);
            $post = new Post(array('access_token' => $access_token));
            $params = array(
                Fields::POST_INFO => json_encode(array(
                    Fields::PRIVACY_LEVEL => 'SELF_ONLY',
                    Fields::TITLE => !empty($postData['title']) ? urldecode($postData['title']) : ''
                )),
                Fields::SOURCE_INFO => json_encode(array(
                    Fields::SOURCE => 'PULL_FROM_URL',
                    Fields::VIDEO_URL => $postData['url'] // video URL that is publicly accessible
                ))
            );
            // post video to tiktok
            $publish = $post->publish($params);
            if (!empty($publish['error']['message'])) {
                return array(
                    'error' => $publish['error']['code'],
                    'error_description' => $publish['error']['message']
                );
            } else {
                return $publish['data'];
            }
        } else {
            return array(
                'error' => 'invalid',
                'error_description' => 'Access token not found!'
            );
        }
    }

    public function publish_photo($postData, $access_token = null)
    {
        if (!empty($access_token)) {
            // check and refresh access token
            $post = new Post(array('access_token' => $access_token));
            $params = array(
                Fields::MEDIA_TYPE => 'PHOTO',
                Fields::POST_MODE => 'DIRECT_POST',
                Fields::POST_INFO => json_encode(array(
                    Fields::PRIVACY_LEVEL => 'SELF_ONLY',
                    Fields::TITLE => !empty($postData['title']) ? urldecode($postData['title']) : ''
                )),
                Fields::SOURCE_INFO => json_encode(array(
                    Fields::SOURCE => 'PULL_FROM_URL',
                    Fields::PHOTO_IMAGES => array($postData['url']),
                    Fields::PHOTO_COVER_INDEX => 0, // index of the image to use as the cover photo in the photo images array
                )),
            );
            // post photos to tiktok
            $photos = $post->photos($params);
            echo '<pre>'; print_r($params); echo '<br>';
            echo '<pre>'; print_r($photos);
            if (!empty($photos['error']['message'])) {
                return array(
                    'error' => $photos['error']['code'],
                    'error_description' => $photos['error']['message']
                );
            } else {
                return $photos['data'];
            }
        } else {
            return array(
                'error' => 'invalid',
                'error_description' => 'Access token not found!'
            );
        }
    }

    public function fetch_status($access_token, $post_id)
    {
        $post = new Post(array('access_token' => $access_token));
        $params = array(Fields::PUBLISH_ID => $post_id);
        $fetchStatus = $post->fetchStatus($params);
        if (!empty($fetchStatus['error']['message'])) {
            return array(
                'error' => $fetchStatus['error']['code'],
                'error_description' => $fetchStatus['error']['message']
            );
        } else {
            return $fetchStatus['data'];
        }
    }

    public function query_creator_info($access_token)
    {
        $post = new Post(array('access_token' => $access_token));
        // get creator info
        $creatorInfo = $post->queryCreatorInfo();
        dd($creatorInfo);
    }

    public function get_videos($access_token)
    {
        // instantiate the video
        $video = new Video(array('access_token' => $access_token));

        $params = array('max_count' => 20);

        $fields = array( // customize fields for the videos
            Fields::ID,
            Fields::CREATE_TIME,
            Fields::TITLE,
            Fields::COVER_IMAGE_URL,
            Fields::SHARE_URL,
            Fields::VIDEO_DESCRIPTION,
            Fields::DURATION,
            Fields::HEIGHT,
            Fields::WIDTH,
            Fields::TITLE,
            Fields::EMBED_HTML,
            Fields::EMBED_LINK,
            Fields::LIKE_COUNT,
            Fields::COMMENT_COUNT,
            Fields::SHARE_COUNT,
            Fields::VIEW_COUNT
        );

        // get video list (params and fields can both be omitted for default functionality)
        $videoList = $video->getList($params, $fields);
        return $videoList;
    }
}
