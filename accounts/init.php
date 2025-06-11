<?php

/**
 * Init
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: init.php, v1.00 2020-03-05 10:12:05 gewa Exp $
 */
if (!defined("_WOJO"))
    die('Direct access to this location is not allowed.');
$BASEPATHMM = str_replace("init.php", "", realpath(__FILE__));
define("BASEPATHMM", $BASEPATHMM);
//sys_set_temp_dir("/home/admin/tmp");
putenv('TMPDIR=/home/admin/tmp');

$configFile = BASEPATHMM . "lib/config.ini.php";
if (file_exists($configFile)) {
    require_once($configFile);
} else {
    header("Location: setup/");
    exit;
}

require_once(BASEPATHMM . "bootstrap.php");
Bootstrap::init();
wError::run();
Filter::run();
Debug::run();
// new Lang();
define("ADMIN", BASEPATHMM . "admin/");
define("FRONT", BASEPATHMM . "front/");
$dir = '';
$url = preg_replace("#/+#", "/", $_SERVER['HTTP_HOST'] . '/' . $dir);

$site_url = Url::protocol() . "://" . $url;
// APP CONSTANTS
defined('SITEURL') or define('SITEURL', "::1" == $_SERVER['REMOTE_ADDR'] ? 'http://localhost/adublisher/' : 'https://www.adublisher.com/');
define("SITEURLMM", $site_url);
define("TRIALDAYS", 7);
define("UPLOADURL", SITEURLMM . '/uploads');
define("UPLOADS", BASEPATHMM . 'uploads');
define("ADMINURL", SITEURLMM . '/admin');
define("ADMINVIEW", SITEURLMM . 'accounts/view/admin');
define("ADMINBASE", BASEPATHMM . 'accounts/view/admin');
define("FRONTVIEW", SITEURL . 'accounts/view/front');
define("FRONTBASE", BASEPATHMM . 'view/front');
//   Membership Package Features
define('LINK_SHORTENER_ID', 11);
define('URL_TRACKING_ID', 12);
define('POST_PUBLISHING_FB_ID', 13);
define('POST_PUBLISHING_INST_ID', 14);
define('POST_PUBLISHING_PIN_ID', 15);
define('POST_PUBLISHING_YT_ID', 16);
define('POST_SCHEDULING_FB_ID', 17);
define('POST_SCHEDULING_INST_ID', 18);
define('POST_SCHEDULING_PIN_ID', 19);
define('POST_SCHEDULING_YT_ID', 20);
define('GROUP_POSTING_ID', 21);
define('RSS_FEED_LATEST_POST_FETCH_ID', 22);
define('RSS_FEED_OLD_POST_FETCH_ID', 23);
define('RSS_FEED_CATEGORY_FETCH_ID', 24);
define('RSS_FEED_POST_PUBLISH_ID', 25);
define('FACEBOOK_ANALYTICS_ID', 26);
define('AUTHORIZE_SOCIAL_ACCOUNTS_ID', 27);
// ESSENTIALS
define("BUILDNUMBER", 1.25);
define('SITENAME', 'adublisher.com');
define('ADUBSHORTLINK', 'https://adub.link/');
define('BASEURL', SITEURL);
define('SIGNUP', SITEURL . 'accounts/register');
define('SIGNIN', SITEURL . 'accounts');
define('ASSETURL', BASEURL . 'assets/'); // invalid user input
define('AccountAssets', BASEURL . 'accounts/assets/'); // invalid user input
define('AccountUpload', BASEURL . 'accounts/uploads/'); // invalid user input
define('GeneralAssets', BASEURL . 'assets/general/'); // invalid user input
define('LANDINGASSETS', BASEURL . 'assets/newlandingpage/'); // invalid user input
define('NewLandingAssets', BASEURL . 'assets/newlandingpage/'); // invalid user input
define('PublisherAssets', BASEURL . 'assets/publisher/'); // database error
define('BulkAssets', BASEURL . 'assets/bulkuploads/'); // database error
define('AdminAssets', BASEURL . 'assets/admin/'); // database error
define('PubLandingpageAssets', BASEURL . 'assets/landingpage/');
define('SERVER_TZ', 'America/Toronto');
// Test credential
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_eLIe6vRiQYd6vHoaDKrfrMIK');
define('STRIPE_SECRET_KEY', 'sk_test_dPLesifQRZgflEOk4yy4x6Ih');
defined('PINTEREST_CLIENT_ID') or define('PINTEREST_CLIENT_ID', '1483446');
defined('PINTEREST_CLIENT_SECRET') or define('PINTEREST_CLIENT_SECRET', 'badc1731c5cf0e0588c79b0cda785a52e59f9ff8');
// defined('PINTEREST_CLIENT_ID') or define('PINTEREST_CLIENT_ID', '1511913');
// defined('PINTEREST_CLIENT_SECRET') or define('PINTEREST_CLIENT_SECRET', 'dd99270ef26a1e48b5405063f4911d096c5c519d');
// facebook credentials
defined('FACEBOOK_CLIENT_ID') or define('FACEBOOK_CLIENT_ID', '1262896354847218');
defined('FACEBOOK_CLIENT_SECRET') or define('FACEBOOK_CLIENT_SECRET', '33c33582e27e4d4fa22f0f677062af1f');
// instagram credentials
defined('INSTAGRAM_CLIENT_ID') or define('INSTAGRAM_CLIENT_ID', '1262896354847218');
defined('INSTAGRAM_CLIENT_SECRET') or define('INSTAGRAM_CLIENT_SECRET', '33c33582e27e4d4fa22f0f677062af1f');
defined('REVIEW_REQUEST') or define('REVIEW_REQUEST', '');
// google auth credentials
// defined('GOOGLE_CLIENT_ID') or define('GOOGLE_CLIENT_ID', "273614127476-rhvm1f21mkuo56gf9iortn7cah8u948p.apps.googleusercontent.com");
// defined('GOOGLE_CLIENT_SECRET') or define('GOOGLE_CLIENT_SECRET', "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");
defined('GOOGLE_CLIENT_ID') or define('GOOGLE_CLIENT_ID', "548300249090-he2ucj6u2fe0lmr87ek0r5kjqbk37r4o.apps.googleusercontent.com");
defined('GOOGLE_CLIENT_SECRET') or define('GOOGLE_CLIENT_SECRET', "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");
// AWS S3 Bucket credentials
defined('S3_BUCKET') or define('S3_BUCKET', "adublisherbucket");
defined('S3_CLIENT_KEY') or define('S3_CLIENT_KEY', "AKIAW7ONDZH7RCBIT36V");
defined('S3_CLIENT_SECRET') or define('S3_CLIENT_SECRET', "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");
// CALENDARIFIC
defined('CALENDARIFIC_API_KEY') or define('CALENDARIFIC_API_KEY', "7XbVPY1CdlvbxtigvLHR6EzFF9yGN1Dd");
// TIKTOK
// defined('TIKTOK_CLIENT_KEY') or define('TIKTOK_CLIENT_KEY', 'sbawnq8unlvx1nm9sf');
// defined('TIKTOK_CLIENT_SECRET') or define('TIKTOK_CLIENT_SECRET', 'HM61AHUpyvhDiMX4LFilEqbOflWaQjTF');
defined('TIKTOK_CLIENT_KEY') or define('TIKTOK_CLIENT_KEY', 'awh2hd6t7wkeenh4');
defined('TIKTOK_CLIENT_SECRET') or define('TIKTOK_CLIENT_SECRET', 'xofpLVwJ4l3CrQQlNDqy2rezxBoECYYo');
defined('TIKTOK_REDIRECT_URI') or define('TIKTOK_REDIRECT_URI', SITEURL . 'tiktok/redirect');
