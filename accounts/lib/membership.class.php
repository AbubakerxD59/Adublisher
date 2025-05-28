<?php
/**
 * Membership Class
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: membership.class.php, v1.00 2020-04-20 18:20:24 gewa Exp $
 */

if (!defined("_WOJO"))
	die('Direct access to this location is not allowed.');

class Membership
{
	const mTable = "packages";
	const umTable = "package_to_user";
	const pfTable = "package_feature_user_limit";
	const pTable = "payments";
	const cTable = "cart";

	/**
	 * Membership::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{

	}

	/**
	 * Membership::Index()
	 * 
	 * @return
	 */
	public function Index()
	{

		$sql = "
		  SELECT 
			m.*,
			(SELECT 
			  COUNT(p.membership_id) 
			FROM
			  payments as p 
			WHERE p.membership_id = m.id) AS total
		  FROM
			packages as m
			ORDER BY price;";

		$tpl = App::View(BASEPATHMM . 'view/');
		$tpl->dir = "admin/";
		$tpl->template = 'admin/memberships.tpl.php';
		$tpl->data = Db::run()->pdoQuery($sql)->results();
		$tpl->title = Lang::$word->META_T6;
	}

	/**
	 * Membership::Edit()
	 * 
	 * @param mixed $id
	 * @return
	 */
	public function Edit($id)
	{
		$tpl = App::View(BASEPATHMM . 'view/');
		$tpl->dir = "admin/";
		$tpl->title = Lang::$word->META_T7;
		$tpl->crumbs = ['admin', 'memberships', 'edit'];

		if (!$row = Db::run()->first(self::mTable, null, array("id =" => $id))) {
			$tpl->template = 'admin/error.tpl.php';
			$tpl->error = DEBUG ? "Invalid ID ($id) detected [membership.class.php, ln.:" . __LINE__ . "]" : Lang::$word->META_ERROR;
		} else {
			$features = $this->getFeatures();
			$tpl->features = $features;
			$tpl->data = $row;
			$tpl->template = 'admin/memberships.tpl.php';
		}
	}

	/**
	 * Membership::Save()
	 * 
	 * @return
	 */
	public function Save()
	{
		$tpl = App::View(BASEPATHMM . 'view/');
		$tpl->dir = "admin/";
		$tpl->title = Lang::$word->META_T8;
		$features = $this->getFeatures();
		$tpl->features = $features;
		$tpl->template = 'admin/memberships.tpl.php';
	}

	/**
	 * Membership::History()
	 * 
	 * @param mixed $id
	 * @return
	 */
	public function History($id)
	{

		$tpl = App::View(BASEPATHMM . 'view/');
		$tpl->dir = "admin/";
		$tpl->title = Lang::$word->META_T9;
		$tpl->crumbs = ['admin', 'memberships', 'history'];

		if (!$row = Db::run()->first(self::mTable, null, array("id =" => $id))) {
			$tpl->template = 'admin/error.tpl.php';
			$tpl->error = DEBUG ? "Invalid ID ($id) detected [membership.class.php, ln.:" . __LINE__ . "]" : Lang::$word->META_ERROR;
		} else {

			$pager = Paginator::instance();
			$pager->items_total = Db::run()->count(self::pTable, 'membership_id = ' . $id . ' AND status = 1');
			$pager->default_ipp = App::Core()->perpage;
			$pager->path = Url::url(Router::$path, "?");
			$pager->paginate();

			$sql = "
			  SELECT 
				p.rate_amount,
				p.tax,
				p.coupon,
				p.total,
				p.currency,
				p.created,
				p.user_id,
				CONCAT(u.fname,' ',u.lname) as name
			  FROM
				`" . self::pTable . "` AS p 
				LEFT JOIN " . Users::mTable . " AS u 
				  ON u.id = p.user_id 
			  WHERE p.membership_id = ?
			  AND p.status = ?
			  ORDER BY p.created DESC" . $pager->limit . ";";

			$tpl->data = $row;
			$tpl->plist = Db::run()->pdoQuery($sql, array($id, 1))->results();
			$tpl->pager = $pager;
			$tpl->template = 'admin/memberships.tpl.php';
		}
	}

	public static function updateResources($mid, $uid)
	{
		// debug
		$features = self::getPackageFeatures($mid);
		foreach ($features as $feature) {
			$feature_data['used'] = 0;
			// check and create feature
			$feature_check = Db::run()->select('package_feature_user_limit', null, array("fid" => $feature->fid, "uid" => $uid))->results();
			if (empty($feature_check)) {
				$is_unlimited = $feature->is_unlimited ? 1 : 0;
				$limit = $is_unlimited ? $feature->feature_limit : 0;
				$data = [
					'pid' => $mid,
					'fid' => $feature->id,
					'uid' => $uid,
					'quota' => $limit,
					'used' => 0,
					'is_unlimited' => $is_unlimited
				];
				Db::run()->insert("package_feature_user_limit", $data)->getLastInsertId();
			}

			// update link shortener
			if ($feature->fid == LINK_SHORTENER_ID) {
				$link_shortener_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$link_short_rows = Db::run()->select('short_urls', null, array("user_id" => $uid), "ORDER BY id")->results();
				$feature_data['used'] = count($link_short_rows);
				// if not unlimited
				if (!$link_shortener_unlimited) {
					if ($feature_data['used'] > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
						// rows to be clear
						$rtbd = count($link_short_rows) - $feature->feature_limit;
						for ($i = 1; $i <= $rtbd; $i++) {
							$key = $feature->feature_limit + $i;
							$link = isset($link_short_rows[$key]) ? $link_short_rows[$key] : 0;
							if (!empty($link)) {
								Db::run()->delete('short_urls', array('id' => $link->id, 'user_id' => $uid));
							}
						}
					}
				}
			}

			// update url tracking
			if ($feature->fid == URL_TRACKING_ID) {
				$url_tracking_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$url_tracking_rows = Db::run()->select('tracking_urls', null, array("user_id" => $uid), "ORDER BY id")->results();
				$feature_data['used'] = count($url_tracking_rows);
				// if not unlimited
				if (!$link_shortener_unlimited) {
					if (count($url_tracking_rows) > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
						// rows to be clear
						$rtbd = count($url_tracking_rows) - $feature->feature_limit;
						for ($i = 1; $i <= $rtbd; $i++) {
							$key = $feature->feature_limit + $i;
							$link = isset($url_tracking_rows[$key]) ? $url_tracking_rows[$key] : 0;
							if (!empty($link)) {
								Db::run()->delete('tracking_urls', array('id' => $link->id, 'user_id' => $uid));
							}
						}
					}
				}
			}

			// update facebook post publishing
			if ($feature->fid == POST_PUBLISHING_FB_ID) {
				$fb_post_publishing_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$user_row = Db::run()->select('user', null, array("id" => $uid), "ORDER BY id")->results();
				$feature_data['used'] = $user_row[0]->fb_post_publish_count;
				// if not unlimited
				if (!$fb_post_publishing_unlimited) {
					if (count($user_row[0]->fb_post_publish_count) > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
					}
				}
			}

			// update instagram post publishing
			if ($feature->fid == POST_PUBLISHING_INST_ID) {
				$inst_post_publishing_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$user_row = Db::run()->select('user', null, array("id" => $uid), "ORDER BY id")->results();
				$feature_data['used'] = $user_row[0]->ins_post_publish_count;
				// if not unlimited
				if (!$inst_post_publishing_unlimited) {
					if (count($user_row[0]->ins_post_publish_count) > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
					}
				}
			}

			// update pinterest post publishing
			if ($feature->fid == POST_PUBLISHING_PIN_ID) {
				$pin_post_publishing_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$user_row = Db::run()->select('user', null, array("id" => $uid), "ORDER BY id")->results();
				$feature_data['used'] = $user_row[0]->pin_post_publish_count;
				// if not unlimited
				if (!$pin_post_publishing_unlimited) {
					if (count($user_row[0]->pin_post_publish_count) > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
					}
				}
			}

			// update youtube post publishing
			if ($feature->fid == POST_PUBLISHING_YT_ID) {
				$yt_post_publishing_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$user_row = Db::run()->select('user', null, array("id" => $uid), "ORDER BY id")->results();
				$feature_data['used'] = $user_row[0]->yt_post_publish_count;
				// if not unlimited
				if (!$yt_post_publishing_unlimited) {
					if (count($user_row[0]->yt_post_publish_count) > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
					}
				}
			}

			// update facebook post scheduling
			if ($feature->fid == POST_SCHEDULING_FB_ID) {
				$fb_post_scheduling_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$fb_post_scheduling_rows = Db::run()->select('channels_scheduler', null, array("user_id" => $uid, 'type' => 'facebook'), "AND status IN (0, 1) ORDER BY id")->results();
				$feature_data['used'] = count($fb_post_scheduling_rows);
				// if not unlimited
				if (!$fb_post_scheduling_unlimited) {
					if (count($fb_post_scheduling_rows) > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
						// rows to be clear
						$rtbd = count($fb_post_scheduling_rows) - $feature->feature_limit;
						$key = $feature->feature_limit - 1;
						for ($i = 1; $i <= $rtbd; $i++) {
							$link = isset($fb_post_scheduling_rows[$key]) ? $fb_post_scheduling_rows[$key] : 0;
							if (!empty($link)) {
								Db::run()->delete('channels_scheduler', array('id' => $link->id, 'user_id' => $uid, 'type' => 'facebook'));
							}
							$key++;
						}
					}
				}
			}

			// update instagram post scheduling
			if ($feature->fid == POST_SCHEDULING_INST_ID) {
				$ins_post_scheduling_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$ins_post_scheduling_rows = Db::run()->select('channels_scheduler', null, array("user_id" => $uid, 'type' => 'instagram'), "AND status IN (0, 1) ORDER BY id")->results();
				$feature_data['used'] = count($ins_post_scheduling_rows);
				// if not unlimited
				if (!$ins_post_scheduling_unlimited) {
					if (count($ins_post_scheduling_rows) > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
						// rows to be clear
						$rtbd = count($ins_post_scheduling_rows) - $feature->feature_limit;
						$key = $feature->feature_limit;
						for ($i = 1; $i <= $rtbd; $i++) {
							$link = isset($ins_post_scheduling_rows[$key]) ? $ins_post_scheduling_rows[$key] : 0;
							if (!empty($link)) {
								Db::run()->delete('channels_scheduler', array('id' => $link->id, 'user_id' => $uid, 'type' => 'instagram'));
							}
						}
						$key++;
					}
				}
			}

			// update pinterest post scheduling
			if ($feature->fid == POST_SCHEDULING_PIN_ID) {
				$pin_post_scheduling_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$pin_post_scheduling_rows = Db::run()->select('channels_scheduler', null, array("user_id" => $uid, 'type' => 'pinterest'), "AND status IN (0, 1) ORDER BY id")->results();
				$feature_data['used'] = count($pin_post_scheduling_rows);
				// if not unlimited
				if (!$pin_post_scheduling_unlimited) {
					if (count($pin_post_scheduling_rows) > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
						// rows to be clear
						$rtbd = count($pin_post_scheduling_rows) - $feature->feature_limit;
						$key = $feature->feature_limit;
						for ($i = 1; $i <= $rtbd; $i++) {
							$link = isset($pin_post_scheduling_rows[$key]) ? $pin_post_scheduling_rows[$key] : 0;
							if (!empty($link)) {
								Db::run()->delete('channels_scheduler', array('id' => $link->id, 'user_id' => $uid, 'type' => 'pinterest'));
							}
							$key++;
						}
					}
				}
			}

			// update youtube post scheduling
			if ($feature->fid == POST_SCHEDULING_YT_ID) {
				$yt_post_scheduling_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				// unpublished posts
				$yt_post_scheduling_rows = Db::run()->select('youtube_scheduler', null, array("user_id" => $uid), "AND published IN (0, 1) ORDER BY id")->results();
				$feature_data['used'] = count($yt_post_scheduling_rows);
				// if not unlimited
				if (!$yt_post_scheduling_unlimited) {
					if (count($yt_post_scheduling_rows) > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
						// rows to be clear
						$rtbd = count($yt_post_scheduling_rows) - $feature->feature_limit;
						$key = $feature->feature_limit;
						for ($i = 1; $i <= $rtbd; $i++) {
							$link = isset($yt_post_scheduling_rows[$key]) ? $yt_post_scheduling_rows[$key] : 0;
							if (!empty($link)) {
								Db::run()->delete('youtube_scheduler', array('id' => $link->id, 'user_id' => $uid, 'status' => 0));
							}
							$key++;
						}
					}
				}
			}

			// update group posting
			if ($feature->fid == GROUP_POSTING_ID) {
				$group_posting_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$group_posting_rows = Db::run()->select('events', null, array("user_id" => $uid), "ORDER BY id")->results();
				$feature_data['used'] = count($group_posting_rows);
				// if not unlimited
				if (!$fb_post_publishing_unlimited) {
					if (count($group_posting_rows) > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
						$rtbd = count($group_posting_rows) - $feature->feature_limit;
						$key = $feature->feature_limit;
						for ($i = 1; $i <= $rtbd; $i++) {
							$link = isset($group_posting_rows[$key]) ? $group_posting_rows[$key] : 0;
							if (!empty($link)) {
								Db::run()->delete('events', array('id' => $link->id, 'user_id' => $uid));
							}
							$key++;
						}
					}
				}
			}

			// update rss latest post fetch
			if ($feature->fid == 'RSS_FEED_LATEST_POST_FETCH_ID') {
				$rss_latest_post_fetch_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$user_row = Db::run()->select('user', null, array("id" => $uid), "ORDER BY id")->results();
				$feature_data['used'] = $user_row[0]->rss_latest_post_count;
				// if not unlimited
				if (!$fb_post_publishing_unlimited) {
					if ($user_row[0]->rss_latest_post_count > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
					}
				}
			}

			// update rss old post fetch
			if ($feature->fid == 'RSS_FEED_OLD_POST_FETCH_ID') {
				$rss_latest_post_fetch_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$user_row = Db::run()->select('user', null, array("id" => $uid), "ORDER BY id")->results();
				$feature_data['used'] = $user_row[0]->rss_old_post_count;
				// if not unlimited
				if (!$fb_post_publishing_unlimited) {
					if ($user_row[0]->rss_old_post_count > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
					}
				}
			}

			// update rss category post fetch
			if ($feature->fid == 'RSS_FEED_CATEGORY_FETCH_ID') {
				$rss_latest_post_fetch_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$user_row = Db::run()->select('user', null, array("id" => $uid), "ORDER BY id")->results();
				$feature_data['used'] = $user_row[0]->rss_category_post_count;
				// if not unlimited
				if (!$fb_post_publishing_unlimited) {
					if ($user_row[0]->rss_category_post_count > $feature->feature_limit) {
						$feature_data['used'] = $feature->feature_limit;
					}
				}
			}

			// update rss feed post publish
			if ($feature->fid == 'RSS_FEED_POST_PUBLISH_ID') {
				$rss_post_publish_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$feature_data['used'] = 0;
			}

			// update facebook analytics
			if ($feature->fid == 'RSS_FEED_POST_PUBLISH_ID') {
				$rss_post_publish_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$feature_data['used'] = 0;
			}

			// update facebook analytics
			if ($feature->fid == 'AUTHORIZE_SOCIAL_ACCOUNTS_ID') {
				$rss_post_publish_unlimited = $feature->is_unlimited ? true : false;
				// check feature
				$feature_data['used'] = 0;
			}

			// //update bulk images resources

			// if ($feature->fid == BULKIMAGES_FEATURE_ID) {

			// 	$bulk_rows = Db::run()->select('bulkupload', null, array("user_id" => $uid), "ORDER BY id")->results();
			// 	if (sizeof($bulk_rows) > $feature->feature_limit) {

			// 		$feature_data['used'] = $feature->feature_limit;
			// 		//rows to be deleted
			// 		$rtbd = sizeof($bulk_rows) - $feature->feature_limit;
			// 		//deleting extra data from bulk
			// 		$i = 0;
			// 		foreach ($bulk_rows as $key => $post) {
			// 			$i++;
			// 			if ($i >= $rtbd) {
			// 				break;
			// 			}
			// 			//start clearing data of bulk
			// 			$img_path = $post->link;

			// 			if ("::1" == $_SERVER['REMOTE_ADDR']) {
			// 				$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/" . $img_path;
			// 			} else {
			// 				$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $img_path;
			// 			}

			// 			if (Db::run()->delete('bulkupload', array('id' => $post->id, 'user_id' => $uid))) {
			// 				try {
			// 					$unlink = unlink($delete_path);
			// 				} catch (Exception $e) {

			// 				}

			// 			}

			// 		}

			// 	} else {

			// 		$feature_data['used'] = sizeof($bulk_rows);
			// 	}
			// }

			// //update campaigns resources
			// if ($feature->fid == CAMPAIGNS_FEATURE_ID) {

			// 	$link_rows = Db::run()->select('link', null, array("user_id" => $uid), "ORDER BY id")->results();
			// 	if (sizeof($link_rows) > $feature->feature_limit) {

			// 		$feature_data['used'] = $feature->feature_limit;

			// 		//rows to be deleted
			// 		$rtbd = sizeof($link_rows) - $feature->feature_limit;
			// 		$i = 0;
			// 		foreach ($link_rows as $key => $post) {
			// 			$i++;
			// 			if ($i >= $rtbd) {
			// 				break;
			// 			}
			// 			try {
			// 				//deleting rates
			// 				$multiple = Db::run()->delete('link_rates', array('f_id' => $post->id));
			// 				//delete from clicks backup
			// 				$multiple = Db::run()->delete('clicksbackup', array('cpid' => $post->id));
			// 				//delete clicks
			// 				$multiple = Db::run()->delete('click', array('cpid' => $post->id));
			// 				//delete from collective data
			// 				$multiple = Db::run()->delete('revenue', array('campaign_id' => $post->id));
			// 				//delete all Scheduled data for this post
			// 				$multiple = Db::run()->delete('sceduler', array('post_id' => $post->id));
			// 				//Now delete it
			// 				$multiple = Db::run()->delete('link', array('id' => $post->id));
			// 			} catch (Exception $e) {

			// 			}


			// 		}
			// 	}
			// }

			// //update affiliate resources
			// if ($feature->fid == AFFILIATE_FEATURE_ID) {

			// 	$current_user = Db::run()->first('user', null, array("id" => $uid));
			// 	$affiliate_rows = Db::run()->select('user', null, array("team_id" => $current_user->team_id, 'team_role' => 'affiliate'), "ORDER BY id")->results();
			// 	if (sizeof($affiliate_rows) > $feature->feature_limit) {

			// 		$feature_data['used'] = $feature->feature_limit;
			// 		//rows to be deleted
			// 		$rtbd = sizeof($affiliate_rows) - $feature->feature_limit;
			// 		$i = 0;
			// 		foreach ($affiliate_rows as $key => $affiliate) {
			// 			$i++;
			// 			if ($i >= $rtbd) {
			// 				break;
			// 			}
			// 			try {
			// 				$multiple = Db::run()->delete('user', array('id' => $affiliate->id));
			// 				$multiple = Db::run()->delete('user_domains', array('user_id' => $affiliate->id));
			// 				$multiple = Db::run()->delete('acm_users', array('user_id' => $affiliate->id));
			// 				$multiple = Db::run()->delete('facebook_pages', array('user_id' => $affiliate->id));
			// 				$multiple = Db::run()->delete('bulkupload', array('user_id' => $affiliate->id));
			// 				$multiple = Db::run()->delete('sceduler', array('user_id' => $affiliate->id));
			// 				$multiple = Db::run()->delete('rsssceduler', array('user_id' => $affiliate->id));
			// 				$multiple = Db::run()->delete('tempclick', array('user' => $affiliate->username));
			// 				$multiple = Db::run()->delete('recomendation', array('userid' => $affiliate->id));
			// 				$multiple = Db::run()->delete('menu_assign', array('user' => $affiliate->id));
			// 				$multiple = Db::run()->delete('user_domains', array('user_id' => $affiliate->id));
			// 				$multiple = Db::run()->delete('user_rates', array('f_id' => $affiliate->id));
			// 				$multiple = Db::run()->delete('user_cdomains', array('user_id' => $affiliate->id));
			// 				$multiple = Db::run()->delete('recomendation', array('userid' => $affiliate->id));
			// 			} catch (Exception $e) {

			// 			}



			// 		}

			// 	}
			// }

			$feature_data['quota'] = $feature->feature_limit;
			$feature_data['pid'] = $mid;
			$feature_data['is_unlimited'] = $feature->is_unlimited;
			Db::run()->update('package_feature_user_limit', $feature_data, array("fid" => $feature->fid, "uid" => $uid));
		}
		// update package to user table
		$package = [
			'mid' => $mid
		];
		Db::run()->update('package_to_user', $package, array("uid" => $uid));
	}

	public static function getPakcages($id = NULL)
	{
		$query = "SELECT * FROM packages  WHERE  active = '1'";
		if ($id) {
			$query = "SELECT * FROM packages  WHERE  active = '1' AND id =" . $id;
		}
		$packages = Db::run()->pdoQuery($query)->results();
		foreach ($packages as $keyone => $pkg) {
			$active = self::getPackageFeatures($pkg->id);
			$packages[$keyone]->features = $active;
		}
		return $packages;
	}

	public static function getFeatures()
	{

		$sql = "SELECT * FROM package_features";
		$row = Db::run()->pdoQuery($sql)->results();
		return ($row) ? $row : 0;

	}
	public static function getPackageFeatures($id)
	{

		$sql = "SELECT * from package_to_features 
        LEFT JOIN package_features
        ON package_features.id=package_to_features.fid
        WHERE package_to_features.pid = $id
        ";
		$row = Db::run()->pdoQuery($sql)->results();
		return ($row) ? $row : 0;

	}

	/**
	 * Membership::getMembershipList()
	 * 
	 * @return
	 */
	public function getMembershipList()
	{

		$row = Db::run()->select(self::mTable, array("id", "title"), null, "ORDER BY title")->results();
		return ($row) ? $row : 0;
	}

	/**
	 * Membership::getMemberships()
	 * 
	 * @return
	 */
	public static function getMemberships()
	{

		$row = Db::run()->select(self::mTable, null, null, "ORDER BY price")->results();
		return ($row) ? $row : 0;
	}

	/**
	 * Membership::processMembership()
	 * 
	 * @return
	 */
	public function processMembership()
	{
		$rules = array(
			'title' => array('required|string|min_len,3|max_len,60', Lang::$word->NAME),
			'price' => array('required|numeric', Lang::$word->MEM_PRICE),
			'days' => array('required|numeric', Lang::$word->MEM_DAYS),
			'period' => array('required|alpha|min_len,1|max_len,1', Lang::$word->MEM_DAYS),
			'recurring' => array('required|numeric', Lang::$word->MEM_REC),
			'private' => array('required|numeric', Lang::$word->MEM_PRIVATE),
			'active' => array('required|numeric', Lang::$word->PUBLISHED),
		);

		$filters = array(
			'description' => 'trim|string',
		);


		if (!empty($_FILES['thumb']['name']) and empty(Message::$msgs)) {
			$upl = Upload::instance(3145728, "png,jpg");
			$upl->process("thumb", UPLOADS . '/memberships/', "MEM_");
		}

		$validate = Validator::instance();
		$safe = $validate->doValidate($_POST, $rules);
		$safe = $validate->doFilter($_POST, $filters);

		$features = $_POST['feature_limit'];
		$feature_valid = true;
		foreach ($features as $key => $value) {
			if (empty($value) && $value != 0) {
				$feature_valid = false;
				break;
			}
		}

		if (empty(Message::$msgs)) {
			if (!$feature_valid) {
				// $message = '<div class=\"wojo small list\"><div class=\"item\"><b>1.</b> Field \"Features\" are required.</div>';
				$message = 'Field Features are required.';
				Message::msgReply($message, 'error', $message);
			} else {
				$data = array(
					'title' => $safe->title,
					'description' => $safe->description,
					'price' => $safe->price,
					'days' => $safe->days,
					'period' => $safe->period,
					'recurring' => $safe->recurring,
					'private' => $safe->private,
					'active' => $safe->active,
				);

				if (!empty($_FILES['thumb']['name'])) {
					$data['thumb'] = $upl->fileInfo['fname'];
				}

				(Filter::$id) ? Db::run()->update(self::mTable, $data, array("id" => Filter::$id)) : $last_id = Db::run()->insert(self::mTable, $data)->getLastInsertId();

				// create or update Features
				$feature_limit = $_POST['feature_limit'];
				$unlimited = isset($_POST['unlimited']) ? $_POST['unlimited'] : [];
				foreach ($feature_limit as $id => $limit) {
					$fTable = 'package_to_features';
					$unlimit = isset($unlimited[$id]) ? 1 : 0;
					$limit = $unlimit == 1 ? 0 : $limit;
					$pid = isset(Filter::$id) ? Filter::$id : $last_id;
					$data = [
						'feature_limit' => $limit,
						'is_unlimited' => $unlimit
					];
					$check = [
						'pid' => $pid,
						'fid' => $id
					];
					$sql = "SELECT * from " . $fTable . " where pid = " . $pid . " and fid = " . $id;
					$filter_check = Db::run()->pdoQuery($sql)->results();
					if (count($filter_check) > 0) {
						Db::run()->update($fTable, $data, $check);
					} else {
						$data = [
							'pid' => $pid,
							'fid' => $id,
							'feature_limit' => $limit,
							'is_unlimited' => $unlimit
						];
						Db::run()->insert($fTable, $data)->getLastInsertId();
					}
				}

				$message = Filter::$id ?
					Message::formatSuccessMessage($safe->title, Lang::$word->MEM_UPDATE_OK) :
					Message::formatSuccessMessage($safe->title, Lang::$word->MEM_ADDED_OK);

				Message::msgReply(Db::run()->affected(), 'success', $message);
			}
		} else {
			Message::msgSingleStatus();
		}
	}

	/**
	 * Membership::processGateway()
	 * 
	 * @return
	 */
	public function processGateway()
	{

		$validate = Validator::instance();
		$validate->addSource($_POST);
		$validate->addRule('displayname', 'string', true, 3, 100, Lang::$word->GW_NAME);
		$validate->addRule('extra', 'string', false);
		$validate->addRule('extra2', 'string', false);
		$validate->addRule('extra3', 'string', false);
		$validate->addRule('active', 'numeric', false);
		$validate->addRule('live', 'numeric', false);
		$validate->run();

		if (empty(Message::$msgs)) {
			$data = array(
				'displayname' => $validate->safe->displayname,
				'extra' => $validate->safe->extra,
				'extra2' => $validate->safe->extra2,
				'extra3' => $validate->safe->extra3,
				'live' => $validate->safe->live,
				'active' => $validate->safe->active
			);

			self::$db->update(self::gTable, $data, array('id' => Filter::$id));
			$message = Message::formatSuccessMessage($data['displayname'], Lang::$word->GW_UPDATED);
			Message::msgReply(self::$db->affected(), 'success', $message);
			Logger::writeLog($message);
		} else {
			Message::msgSingleStatus();
		}
	}

	/**
	 * Membership::calculateTax()
	 * 
	 * @param bool $uid
	 * @return
	 */
	public static function calculateTax($uid = false)
	{
		if (App::Core()->enable_tax) {
			if ($uid) {
				$cnt = Db::run()->first(Users::mTable, array("country"), array("id" => $uid));
				if ($cnt) {
					$row = Db::run()->first(Content::cTable, array("vat"), array("abbr" => $cnt->country));
					return ($row->vat / 100);
				} else {
					return 0;
				}
			} else {
				if (App::Auth()->country) {
					$row = Db::run()->first(Content::cTable, array("vat"), array("abbr" => App::Auth()->country));
					return ($row->vat / 100);
				} else {
					return 0;
				}
			}
		} else {
			return 0;
		}
	}

	/**
	 * Membership::getCart()
	 * 
	 * @param bool $uid
	 * @return
	 */
	public static function getCart($uid = false)
	{
		$id = ($uid) ? intval($uid) : App::Auth()->uid;
		$row = Db::run()->first(self::cTable, null, array("uid" => $id));

		return ($row) ? $row : 0;
	}

	/**
	 * Membership::is_valid()
	 * 
	 * @return
	 */
	public static function is_valid(array $mid)
	{
		if (in_array(App::Auth()->membership_id, $mid)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Membership::calculateDays()
	 * 
	 * @param bool $membership_id
	 * @return
	 */
	public static function calculateDays($membership_id)
	{
		$row = Db::run()->first(Membership::mTable, array('days', 'period'), array('id' => $membership_id));
		if ($row) {
			switch ($row->period) {
				case "D":
					$diff = ' day';
					break;
				case "W":
					$diff = ' week';
					break;
				case "M":
					$diff = ' month';
					break;
				case "Y":
					$diff = ' year';
					break;
			}
			$expire = Date::NumberOfDays('+' . $row->days . $diff);
		} else {
			$expire = "";
		}
		return $expire;
	}
}
