<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// short links
$route["link/(:any)/(:any)"] = "rest/publisher/Usersrest/url_redirect/$1/$2";
// index page
$route['default_controller'] = 'Welcome';
// php info
$route["php-info"] = "publisher/Home/php_info";
// new pages
$route['calendar-view'] = 'publisher/Home/calendar_view';
$route['analytic'] = 'publisher/Home/analytic_view';
$route['automations'] = 'publisher/Home/automation_view';
$route['bulk-schedule'] = 'publisher/Home/bulk_schedule_view';
$route['recycling'] = 'publisher/Home/recycle_view';
$route['curate-post'] = 'publisher/Home/curate_post_view';
$route['pricing'] = 'publisher/Home/pricing_view';
$route['blogs'] = 'publisher/Home/blog_view';
$route['product-updates'] = 'publisher/Home/product_updates';
$route['blog/(:any)'] = 'publisher/Home/blog_inner_view/$1';
$route['login'] = 'publisher/Home/login_view';
$route['register'] = 'publisher/Home/signup_view';
$route['forgot-password'] = 'publisher/Home/forgot_password_view';

$route['404_override'] = '';
####### before login #######

// $route['signup'] = 'publisher/Home/signup';
// $route['signin'] = 'publisher/Home/signin';
$route['terms'] = 'publisher/Home/terms';
$route['privacy'] = 'publisher/Home/privacy';
$route['termsfb'] = 'publisher/Home/termsfb';
$route['forgot'] = 'publisher/Home/forgot';
$route['thankyou'] = 'publisher/Home/thankyou';

##############################################
################ Publisher ROUTES ################
##############################################
$route['dashboard'] = 'publisher/Home/dashboard';
$route['facebook_callback'] = 'publisher/Home/redirect';
$route['facebook_addpage'] = 'publisher/Home/redirectaddpage';
// cronjob for publlishing affiliate facebook posts
$route['fbautoposting'] = 'publisher/Autoposting/index';
$route['postShopifyProductsToFacebook'] = 'publisher/Autoposting/postShopifyProductsToFacebook';
// facebook bulk uploading posts
$route['fbautopostingbulk'] = 'publisher/Autoposting/facebookbulkupload';
$route['igautopostingbulk'] = 'publisher/Autoposting/instagrambulkupload';
// cronjob for renewing facebook auto posting
$route['dailysceduler'] = 'publisher/Autoposting/dailysceduler';



$route['widget_area'] = 'publisher/Home/widgetArea';
$route['payment-method'] = 'publisher/Home/paymentmethod';
$route['add_paymentmethod'] = 'publisher/Home/add_paymentmethod';
$route['recycle'] = 'publisher/Home/recycle';
$route['facebook'] = 'publisher/Home/facebook';
$route['link-shortener'] = 'publisher/Home/link_shortener';
$route['url-tracking'] = 'publisher/Home/url_tracking';
$route['groups'] = 'publisher/Home/groups';

$route['youtube'] = 'publisher/Home/youtube';

$route['schedule'] = 'publisher/Home/schedule';

$route['automation'] = 'publisher/Home/automation';
$route['analytics'] = 'publisher/Home/analytics';
$route['calendar'] = 'publisher/Home/calendar';
$route['instagrambulkupload'] = 'publisher/Home/ifnstagrambulkupload';
$route['instagramstorybulkupload'] = 'publisher/Home/instagramstorybulkupload';
$route['saveinstagram'] = 'rest/publisher/Auth/updateUserIG';

$route['bulkuploadpath'] = 'publisher/Home/bulkuploadpath';
$route['addnewmenu/(:any)'] = 'publisher/Home/add_new_menu/$1';
$route['logout'] = 'publisher/Home/logout';
$route['upload_changes'] = 'publisher/Home/uploadchanges';
$route['traffic'] = 'publisher/Home/trafficsummary';
$route['earning'] = 'publisher/Home/earningsummary';
$route['createarticles'] = 'publisher/Home/create_article';
$route['ref/(:any)/(:any)'] = 'publisher/Traffic/index/$1/$2';

############ Social Accounts ##############
$route['social-accounts'] = 'publisher/Home/socialaccounts';
############ Settings ##############
$route['settings'] = 'publisher/Home/settings';
$route['personal-info'] = 'publisher/Home/editprofile';
$route['user-features'] = 'rest/publisher/Usersrest/user_features';
$route['security-settings'] = 'publisher/Home/changepassword';
$route['payments-and-subscriptions'] = 'publisher/Home/paymentsubscriptions';

############ user error log ###########
$route['user_error_log'] = 'publisher/Home/user_error_log';

############ affiliate-marketing ###########
$route['affiliate-marketing'] = 'publisher/Home/affiliatemarketing';
$route['affiliate-manage'] = 'publisher/Home/affiliatemanage';
$route['affiliate-manage-ppc-rates'] = 'publisher/Home/affiliatemanageppcrates';
$route['traffic-reports'] = 'publisher/Home/trafficreports';
$route['add-campaign'] = 'publisher/Home/addcampaign';
$route['affiliate-edit-campaign/(:any)'] = 'publisher/Home/affiliateeditcampaign/$1';

// Calendar View
$route['calendar_events'] = 'rest/publisher/Usersrest/get_calendar_events';
$route['clear_calendar_cache'] = 'rest/publisher/Usersrest/clear_calendar_cache';
$route['get_event_info'] = 'rest/publisher/Usersrest/get_event_info';

########## Rest affiliate-marketing ###########
$route['update_rate_settings_owner'] = 'rest/publisher/Usersrest/updateGenrates';
$route['get_rate_settings_owner'] = 'rest/publisher/Usersrest/getGenrates';
$route['get_rate_owner'] = 'rest/publisher/Usersrest/getGenratesowner';
$route['add_update_rate_owner'] = 'rest/publisher/Usersrest/setUpdateGenrates';
$route['get_adv_domains_owner'] = 'rest/publisher/Usersrest/getAdvDomains';
$route['update_assignadv_settings_owner'] = 'rest/publisher/Usersrest/updateGenassignAdv';
$route['add_update_assignadv_settings_owner'] = 'rest/publisher/Usersrest/setUpdateAdvDomains';
$route['deleteaffiliate'] = 'rest/publisher/Usersrest/deleteaffiliate';
$route['editaffiliate'] = 'rest/publisher/Usersrest/editaffiliate';
$route['updateaffiliate'] = 'rest/publisher/Usersrest/updateaffiliate';
$route['affiliate_analytics_domain_add'] = 'rest/publisher/Usersrest/affiliateanalyticsdomainadd';
$route['affiliate_analytics_domain_edit'] = 'rest/publisher/Usersrest/affiliateanalyticsdomainedit';
$route['affiliate_analytics_domain_delete'] = 'rest/publisher/Usersrest/affiliateanalyticsdomainedelete';
$route['affiliate_redirect_domain_add'] = 'rest/publisher/Usersrest/affiliateredirectdomainadd';
$route['affiliate_redirect_domain_edit'] = 'rest/publisher/Usersrest/affiliateredirectdomainedit';
$route['affiliate_redirect_domain_delete'] = 'rest/publisher/Usersrest/affiliateredirectdomainedelete';
$route['affiliate_owner_traffic_summary'] = 'rest/publisher/Usersrest/affiliateownertrafficsummary';
$route['affiliate_campaign_traffic_summary'] = 'rest/publisher/Usersrest/affiliatecampaigntrafficsummary';
$route['affiliate_individual_country_traffic_summary'] = 'rest/publisher/Usersrest/affiliateindividualcountrytrafficsummary';
$route['affiliate_country_traffic_summary'] = 'rest/publisher/Usersrest/affiliatecountrytrafficsummary';
$route['affiliate_create_account'] = 'rest/publisher/Authrest/signupaffiliate';
$route['affiliate_pay'] = 'rest/publisher/Usersrest/affiliatepay';
$route['affiliate_cancelmembership'] = 'rest/publisher/Usersrest/cancelmembership';


########## Rest Campaigns Affiliate #############
$route['getcampaigns'] = 'rest/publisher/Authrest/get_campaigns';
// load more get campaigns
$route['load_more_getcampaigns'] = 'rest/publisher/Authrest/load_more_getcampaigns';
##Campaigns##
$route['owner_campaign_add_rest'] = 'rest/publisher/Usersrest/addCampaign';
$route['owner_campaign_delete_rest'] = 'rest/publisher/Usersrest/deleteCampaign';
$route['owner_campaign_edit_rest'] = 'rest/publisher/Usersrest/updateCampaign';
$route['owner_campaign_get_meta'] = 'rest/publisher/Usersrest/metaOfUrl';


########## Rest Events Grouping #############
$route['addnewevent'] = 'rest/publisher/Usersrest/addnewevent';
$route['updateevent'] = 'rest/publisher/Usersrest/updateevent';
$route['deleteevent'] = 'rest/publisher/Usersrest/deleteevent';
$route['disconnectfacebookevent'] = 'rest/publisher/Authrest/disconnectFacebookEvent';
$route['channel_settings'] = 'rest/publisher/Usersrest/channel_settings';






$route['zoptmoizicxeozmggmktuecbhzmnbsricfdkynfgcvbbgzmzyedloclvy_error_logs'] = 'publisher/Home/error_logs';

$route['error_logs_api'] = 'publisher/Home/error_logs_api';



$route['test'] = 'publisher/Home/testing';
$route['ppph'] = 'publisher/Home/ppph';
$route['s3bucket'] = 'publisher/Home/s3bucket';

############## REST ############

$route['domainchange'] = 'rest/publisher/Usersrest/changedomain';
$route['redirectlink'] = 'rest/publisher/Usersrest/redirectlink';

$route['facebook_posting'] = 'rest/publisher/Authrest/pagePosting';
$route['facebook_group_posting'] = 'rest/publisher/Authrest/groupPosting';
$route['pinterest_posting'] = 'rest/publisher/Authrest/boardPosting';
$route['ig_posting'] = 'rest/publisher/Authrest/igPosting';
$route['auth_login'] = 'rest/publisher/Authrest/login/';
$route['auth_signup'] = 'rest/publisher/Authrest/signup/';
$route['changepass'] = 'rest/publisher/Authrest/changepass';
$route['resetpass'] = 'rest/publisher/Authrest/resetpass';

$route['getcountrywisepublisher'] = 'rest/publisher/Authrest/getcountrywise';
$route['disconnectfacebook'] = 'rest/publisher/Authrest/disconnectFacebook';
$route['disconnectfacebookpage'] = 'rest/publisher/Authrest/disconnectFacebookPage';
$route['deletefacebookpost'] = 'rest/publisher/Authrest/disconnectFacebookPost';
$route['deletePinterestPosts'] = 'rest/publisher/Authrest/disconnecPinterestPost';
$route['updatefacebookpost'] = 'rest/publisher/Authrest/updateFacebookPost';
$route['getcommingposts'] = 'rest/publisher/Authrest/commingPosts';
$route['updateuseractivehours'] = 'rest/publisher/Authrest/updateUserActiveHours';
$route['updateprofile'] = 'rest/publisher/Usersrest/updateprofile';
$route['user_exists_ajax'] = 'publisher/Home/user_exists_ajax/';
$route['updatepageautopost'] = 'rest/publisher/Authrest/activeAutoPost/';
$route['update_random_auto_posting'] = 'rest/publisher/Authrest/updateRandomAutoPosting/';
$route['update_loop_auto_posting'] = 'rest/publisher/Authrest/updateLoopAutoPosting/';
$route['updateyoutubeautopost'] = 'rest/publisher/Authrest/youtubeAutoPost/';
$route['updatepageautopostquantity'] = 'rest/publisher/Authrest/quantityAutoPost/';
$route['individual_country_click'] = 'rest/publisher/Usersrest/specific_country_click/';
$route['campaignwise'] = 'rest/publisher/Usersrest/campaignwise';
$route['get_roles'] = 'rest/publisher/Usersadmin/users_roles';
$route['get_gmt_status'] = 'rest/publisher/Usersrest/gmt_status';
$route['update_page_timeslots'] = 'rest/publisher/Usersrest/updatetimeslots';
$route['load_facebook_pages'] = 'rest/publisher/Usersrest/loadFacebookPages';
$route['edit_announcement'] = 'rest/publisher/Usersadmin/edit_announcement';
$route['delete_announcement'] = 'rest/publisher/Usersadmin/delete_announcement';
$route['create_announcement'] = 'rest/publisher/Usersadmin/create_announcement';
$route['top_users'] = 'rest/publisher/Usersadmin/top_users';
$route['save_fb_bulkschedule'] = 'rest/publisher/Usersrest/create_facebook_bulkupload';
$route['update_fb_bulkschedule'] = 'rest/publisher/Usersrest/update_facebook_bulkupoad';
$route['save_ig_bulkschedule'] = 'rest/publisher/Usersrest/create_instagram_bulkupload';
$route['gefacebooktbulkscheduled'] = 'rest/publisher/Usersrest/gefacebooktbulkscheduled';
$route['facebookpagecatption'] = 'rest/publisher/Usersrest/facebookpagecatption';
$route['getinstagrambulkscheduled'] = 'rest/publisher/Usersrest/getinstagrambulkscheduled';
$route['deleteinstagrambulkpost'] = 'rest/publisher/Usersrest/instagrambulksceduleddelete';
$route['deletefacebookbulkpost'] = 'rest/publisher/Usersrest/facebookbulksceduleddelete';
$route['deletefacebookbulkpostall'] = 'rest/publisher/Usersrest/facebookbulksceduleddeleteall';

//RSS
$route['deletersspostall'] = 'rest/publisher/Usersrest/deletersspostall';
$route['shufflersspostall'] = 'rest/publisher/Usersrest/shufflersspostall';
$route['shufflefacebookposts'] = 'rest/publisher/Usersrest/shufflefacebookposts';
$route['shufflepinterestposts'] = 'rest/publisher/Usersrest/shufflepinterestposts';
// Publish now Rss
$route['publishNowFacebookPost'] = 'rest/publisher/Usersrest/publish_now_facebook_post';
$route['publishNowPinterestPost'] = 'rest/publisher/Usersrest/publish_now_pinterest_post';
$route['publishNowInstagramPost'] = 'rest/publisher/Usersrest/publish_now_instagram_post';
// Refresh RSS Posts
$route['refresh_rss_posts'] = 'rest/publisher/Usersrest/refresh_rss_posts';
// Queue posts
$route['shuffle_scheduled_posts'] = 'rest/publisher/Usersrest/shuffle_scheduled_posts';

$route['deletersspost'] = 'rest/publisher/Usersrest/deletersspost';
$route['getrssscheduled'] = 'rest/publisher/Usersrest/getrssscheduled';

$route['get_tiktok_rssscheduled'] = 'rest/publisher/Usersrest/get_tiktok_rssscheduled';
// load more rss posts
$route['loadmoreposts'] = 'rest/publisher/Usersrest/load_more_posts';
$route['getrssspublished'] = 'rest/publisher/Usersrest/getrssspublished';
$route['rssfeedonoff'] = 'rest/publisher/Usersrest/rssfeedonoff';
$route['tiktok_rss_feed_onoff'] = 'rest/publisher/Usersrest/tiktok_rss_feed_onoff';

// Shopify Automation On Off
$route['shopify_fb_page_automation_onoff'] = 'rest/publisher/Usersrest/shopify_fb_page_automation_onoff';
$route['shopify_auto_products_for_fb_pages'] = 'rest/publisher/Usersrest/shopify_auto_products_for_fb_pages';

$route['shopify_pinterest_automation_onoff'] = 'rest/publisher/Usersrest/shopify_pinterest_automation_onoff';
$route['shopify_auto_products_for_pinterest_boards'] = 'publisher/ChannelCrons/shopify_auto_products_for_pinterest_boards';

$route['shopify_fb_group_automation_onoff'] = 'rest/publisher/Usersrest/shopify_fb_group_automation_onoff';
$route['shopify_auto_products_for_fb_groups'] = 'publisher/ChannelCrons/shopify_auto_products_for_fb_groups';

$route['shopify_insta_automation_onoff'] = 'rest/publisher/Usersrest/shopify_insta_automation_onoff';
$route['shopify_auto_products_for_instagram'] = 'publisher/ChannelCrons/shopify_auto_products_for_instagram';


$route['update_page_timeslots_rss'] = 'rest/publisher/Usersrest/updatetimeslotsrss';
$route['update_tiktok_timeslots_rss'] = 'rest/publisher/Usersrest/updatetiktokrssslots';
$route['update_page_timeslots_auto'] = 'rest/publisher/Usersrest/updatetimeslotsauto';
$route['update_page_domains_auto'] = 'rest/publisher/Usersrest/upddomainsautoauto';

$route['rss_feed_engine'] = 'rest/publisher/Usersrest/rss_feed';
$route['tiktok_rss_feed_engine'] = 'rest/publisher/Usersrest/tiktok_rss_feed';
// Cronjob for fetching rss links for facebook pages
$route['rss_cronjob'] = 'rest/publisher/Usersrest/rss_cronjob';

$route['update_article'] = 'rest/publisher/Usersrest/update_article';
$route['delete_article'] = 'rest/publisher/Usersrest/delete_article';
$route['edit_article/(:any)'] = 'publisher/home/edit_article/$1';
$route['preview/(:any)'] = 'publisher/home/preview_article/$1';
$route['publishers/(:any)'] = 'publisher/home/preview_article/$1';

// YouTube
$route['update_youtube_timeslots_auto'] = 'rest/publisher/Usersrest/updateyoutubetimeslotsauto';
$route['duscountyoutubechannel'] = 'rest/publisher/Authrest/disconnectYoutubeChannel';
$route['disconnectyoutube'] = 'rest/publisher/Authrest/disconnectYoutube';

// TikTok
$route['tiktok/redirect'] = 'rest/publisher/Usersrest/tiktok_redirect';
$route['disconnecttiktok'] = 'rest/publisher/Authrest/disconnectTiktok';
$route['deletetiktok'] = 'rest/publisher/Authrest/deletetiktok';
$route['tiktok_acc_active'] = 'rest/publisher/Usersrest/tiktok_acc_active';
$route['tiktok_channel_slots'] = 'rest/publisher/Usersrest/tiktok_channel_slots';

// Threads
$route['threads/redirect'] = 'rest/publisher/Thread/redirect';
$route['threads/uninstall'] = 'rest/publisher/Thread/uninstall';
$route['threads/delete'] = 'rest/publisher/Thread/delete';

//Notifications
$route['mark_read'] = 'rest/publisher/Authrest/markreadNotification';

//Routes used for Angular
$route['publisher_dashboard'] = 'rest/publisher/Usersrest/dashboardwidgets';
$route['owner_dashboard'] = 'rest/publisher/Usersrest/ownerdashboardwidgets';

$route['publisher_profile_dashboard'] = 'rest/publisher/Usersrest/dashboardforProfile';
$route['rest_admin_dashboard'] = 'rest/publisher/Usersadmin/dashboardwidgets';
$route['update_rate_settings'] = 'rest/publisher/Usersadmin/updateGenrates';
$route['get_rate_settings'] = 'rest/publisher/Usersadmin/getGenrates';
$route['add_update_rate'] = 'rest/publisher/Usersadmin/setUpdateGenrates';
$route['get_adv_domains'] = 'rest/publisher/Usersadmin/getAdvDomains';
$route['update_assignadv_settings'] = 'rest/publisher/Usersadmin/updateGenassignAdv';
$route['add_update_assignadv_settings'] = 'rest/publisher/Usersadmin/setUpdateAdvDomains';
$route['user_salary'] = 'rest/publisher/Usersrest/userSalary';


##############################################
################ ADMIN ROUTES ################
##############################################
$route['admin'] = 'admin/Home';
$route['admin_dashboard'] = 'admin/Home/dashboard';
$route['admin_logout'] = 'admin/Home/logout';
$route['secure_login'] = 'admin/Home/signin';
$route['publishers-profiles'] = 'admin/Home/publishers';

##############

##Categories##
$route['category_list'] = 'admin/Home/listcategory';
##############


##Campaigns##
$route['campaigns_admin'] = 'admin/Home/campaigns';
$route['campaign_add'] = 'admin/Home/addcampaign';
$route['campaign_edit/(:any)'] = 'admin/Home/editcampaign/$1';
$route['campaign_list'] = 'admin/Home/listcampaign';
$route['getcampaigns_admin'] = 'rest/publisher/Usersadmin/get_campaigns';
##############

##Domains##
$route['domain_list'] = 'admin/Home/listdomain';
$route['domain_assign'] = 'admin/Home/assigndomain';
$route['domain_default'] = 'admin/Home/defaultdomain';
$route['domain_system'] = 'admin/Home/systemdomain';
##############

##Packages##
$route['packages_all'] = 'admin/Home/listpackages';
$route['packages_features'] = 'admin/Home/listfeatures';

##Articles-urls##
$route['articles_all'] = 'admin/Home/listArticles';
$route['article_domains'] = 'admin/Home/listArticledomains';
$route['article_categories'] = 'admin/Home/listArticleCategories';
##############

##Annoucements##
$route['announcements'] = 'admin/Home/Annoucements';
$route['annoucement_area'] = 'publisher/Home/annoucement_area';
##Notification##
$route['notifications_area'] = 'publisher/Home/notifications_area';
##Publishers##
$route['publisher_list'] = 'admin/Home/listpublisher';
$route['publisher_analytics'] = 'admin/Home/publisher_analytics';
$route['campaign_analytics'] = 'admin/Home/campaign_analytics';
$route['country_analytics'] = 'admin/Home/country_analytics';
$route['publisher_weekly'] = 'admin/Home/weeklypublisher';
$route['publisher_pay'] = 'admin/Home/paypublisher';
$route['direct_link'] = 'admin/Home/directlink';
##############
##Currency Rates ##
$route['currency_list'] = 'admin/Home/listcurrency';
##############
## ADMIN #####
$route['admin_add'] = 'admin/Home/addadmin';
##############
#DataMining#
$route['datathroughback'] = 'admin/DataMining/index';
##############
### Rest API##
##############
$route['admin_login_post'] = 'rest/admin/Auth/login';
$route['admin_getcountrywise'] = 'rest/publisher/Usersadmin/getcountrywise';
$route['admin_add_rest'] = 'rest/publisher/Usersadmin/addAdmin';
$route['admin_getarticles'] = 'rest/publisher/Usersadmin/getarticles';
$route['admin_publisharticle'] = 'rest/publisher/Usersadmin/publishArticle';
$route['admin_getarticle'] = 'rest/publisher/Usersadmin/getarticle';
$route['admin_articleapprove'] = 'rest/publisher/Usersadmin/articleapprove';
$route['admin_articlerework'] = 'rest/publisher/Usersadmin/articlerework';
##Categories##
$route['category_add_rest'] = 'rest/publisher/Usersadmin/addCategory';
$route['category_delete_rest'] = 'rest/publisher/Usersadmin/deleteCategory';
$route['category_edit_rest'] = 'rest/publisher/Usersadmin/editCategory';
##############
##Campaigns##
$route['campaign_add_rest'] = 'rest/publisher/Usersadmin/addCampaign';
$route['campaign_delete_rest'] = 'rest/publisher/Usersadmin/deleteCampaign';
$route['campaign_edit_rest'] = 'rest/publisher/Usersadmin/updateCampaign';
$route['campaign_get_meta'] = 'rest/publisher/Usersadmin/metaOfUrl';


##dashboard ##
$route['change_announce_view'] = 'rest/publisher/Usersrest/change_announce_view';

##############

## Packages 

$route['package_add_rest'] = 'rest/publisher/Usersadmin/addPackage';
$route['package_delete_rest'] = 'rest/publisher/Usersadmin/deletePackage';
$route['package_edit_rest'] = 'rest/publisher/Usersadmin/editPackage';
$route['get_package_features_rest'] = 'rest/publisher/Usersadmin/getPackageFeatures';
$route['package_features_edit_rest'] = 'rest/publisher/Usersadmin/updatePackageFeatures';

## Features
$route['feature_add_rest'] = 'rest/publisher/Usersadmin/addFeature';
$route['feature_delete_rest'] = 'rest/publisher/Usersadmin/deleteFeature';
$route['feature_edit_rest'] = 'rest/publisher/Usersadmin/editFeature';


###Domains##
$route['article_domain_add_rest'] = 'rest/publisher/Usersadmin/addDomainArticle';
$route['article_domain_delete_rest'] = 'rest/publisher/Usersadmin/deleteDomainArticle';
$route['article_domain_edit_rest'] = 'rest/publisher/Usersadmin/editDomainArticle';
$route['article_domain_list_rest'] = 'rest/publisher/Usersadmin/getArticleDomains';
$route['article_domain_cat_rest'] = 'rest/publisher/Usersadmin/wpcategories';



$route['domain_add_rest'] = 'rest/publisher/Usersadmin/addDomain';
$route['domain_delete_rest'] = 'rest/publisher/Usersadmin/deleteDomain';
$route['domain_edit_rest'] = 'rest/publisher/Usersadmin/editDomain';
$route['systemdomain_edit_rest'] = 'rest/publisher/Usersadmin/systemDomain';
$route['directlink_edit_rest'] = 'rest/publisher/Usersadmin/redirectLinksettings';
$route['default_domain_user_rest'] = 'rest/publisher/Usersadmin/userDefaultDomain';
$route['active_domain_user_rest'] = 'rest/publisher/Usersadmin/userActiveDomain';
$route['update_user_domains_rest'] = 'rest/publisher/Usersadmin/updateUserDomains';

##############

##Publisher##
$route['publisher_delete_rest'] = 'rest/publisher/Usersadmin/deletePublisher';


$route['publisher_edit_rest'] = 'rest/publisher/Usersadmin/editPublisher';
$route['publisher_pay_rest'] = 'rest/publisher/Usersadmin/payPublisher';

##############

##Reports##
$route['publisher_report_rest'] = 'rest/publisher/Usersadmin/publisherReport';
$route['campaigns_report_rest'] = 'rest/publisher/Usersadmin/campaignsReport';
$route['country_report_rest'] = 'rest/publisher/Usersadmin/countryReport';


###Rates#####
$route['country_edit_rest'] = 'rest/publisher/Usersadmin/editCountry';
#############
##############################################
############## END ADMIN ROUTES ##############
##############################################


##############################################
############## Webfeed urls     ##############
##############################################
$route['feed'] = 'rest/publisher/Recommended/webfeed';

$route['save_filter'] = 'rest/publisher/Usersrest/save_filter';


$route['translate_uri_dashes'] = FALSE;

######### ROLL MANAGEMENT ROUTES ####

$route['manage_roll'] = 'admin/home/roll_management';
$route['update_rolls'] = 'rest/publisher/Usersadmin/update_roles';


######## Article Wriring #####
$route['article_management'] = 'publisher/home/manage_article';
$route['edit_article/(:num)'] = 'publisher/home/edit_article';


######## Pinterest #####
// $route['pinterest'] = 'publisher/Home/pinterest_redirect';

$route['pinterest_callback'] = 'publisher/Home/get_pinterest_access_token';
$route['get_pinterest_boards'] = 'publisher/Home/get_pinterest_boards';

// create pin to pinterest board
// $route['create_pin'] = 'rest/publisher/Usersrest/create_pin';

// pinterst rss feed 
// $route['pinterest_rssfeed'] = 'publisher/Home/pinterest_rssfeed';
$route['save_default'] = 'rest/publisher/Usersrest/save_default';
$route['pinterest_rss_feed_engine'] = 'rest/publisher/Usersrest/pinterest_rssfeed';
$route['get_pinterest_rssscheduled'] = 'rest/publisher/Usersrest/get_pinterest_rssscheduled';
$route['get_pinterest_rssspublished'] = 'rest/publisher/Usersrest/get_pinterest_rssspublished';
$route['pinterest_rss_feed_onoff'] = 'rest/publisher/Usersrest/pinterest_rss_feed_onoff';
$route['update_board_timeslots_rss'] = 'rest/publisher/Usersrest/pinterest_rss_update_timeslots';
$route['shuffle_pinterest_rss_post_all'] = 'rest/publisher/Usersrest/shuffle_pinterest_rss_post_all';
$route['delete_pinterest_rss_post_all'] = 'rest/publisher/Usersrest/delete_pinterest_rss_post_all';
$route['delete_pinterest_rss_post'] = 'rest/publisher/Usersrest/delete_pinterest_rss_post';

$route['get_running_rss_status'] = 'rest/publisher/Usersrest/get_running_rss_status';
// Shopify Credentials Storing
$route['store_shopify_credntials'] = 'rest/publisher/Usersrest/store_shopify_credntials';
$route['disconnect_shopify_account'] = 'rest/publisher/Usersrest/disconnect_shopify_account';

//channels' timeslots
$route['fbpages_channel_slots'] = 'rest/publisher/Usersrest/fbpages_channel_slots';
$route['boards_channel_slots'] = 'rest/publisher/Usersrest/boards_channel_slots';
$route['ig_channel_slots'] = 'rest/publisher/Usersrest/ig_channel_slots';
$route['fbgroup_channel_slots'] = 'rest/publisher/Usersrest/fbgroup_channel_slots';
$route['youtube_channel_slots'] = 'rest/publisher/Usersrest/youtube_channel_slots';
$route['all_channels_slots'] = 'rest/publisher/Usersrest/all_channels_slots';

// channels' active from modal posting on/off
// $route['fbpages_channel_active']='rest/publisher/Usersrest/fbpages_channel_active';
// $route['boards_channel_active']='rest/publisher/Usersrest/boards_channel_active';

// get_channels_settings
$route['get_channels_settings'] = 'rest/publisher/Usersrest/get_channels_settings';

// fb_channel_active
$route['fb_channel_active'] = 'rest/publisher/Usersrest/fb_channel_active';
// board_channel_active
$route['board_channel_active'] = 'rest/publisher/Usersrest/board_channel_active';
// ig_channel_active
$route['ig_channel_active'] = 'rest/publisher/Usersrest/ig_channel_active';
// facebook group channel_active
$route['fbgroup_channel_active'] = 'rest/publisher/Usersrest/fbgroup_channel_active';
// youtube channel_active
$route['yt_channel_active'] = 'rest/publisher/Usersrest/yt_channel_active';

// channels bulkupload schedule
$route['save_channels_bulkupload'] = 'rest/publisher/Usersrest/create_channels_bulkupload';
// publish channels
$route['publish_channels'] = 'rest/publisher/Usersrest/publish_channels';
// get scheduled channels
$route['get_channels_scheduled'] = 'rest/publisher/Usersrest/get_channels_scheduled';
// refresh scheduled channels
$route['refresh_channels_scheduled'] = 'rest/publisher/Usersrest/refresh_channels_scheduled';
// load more scheduled channels
$route['load_more_channels_scheduled'] = 'rest/publisher/Usersrest/load_more_channels_scheduled';
// get published channels post
$route['get_published_channels_scheduled'] = 'rest/publisher/Usersrest/get_published_channels_scheduled';
// publish youtube video
$route['move_video_to_server'] = 'rest/publisher/Usersrest/move_video_to_server';
$route['upload_to_youtube'] = 'rest/publisher/Usersrest/upload_to_youtube';


//  channels bulkupload schedule delete all
$route['publishNowQueuedPost'] = 'rest/publisher/Usersrest/publish_now_queued_post';
$route['channel_bulk_scheduled_delete_all'] = 'rest/publisher/Usersrest/channel_bulk_scheduled_delete_all';
$route['channel_bulk_scheduled_delete'] = 'rest/publisher/Usersrest/channel_bulk_scheduled_delete';
$route['delete_youtube_queued_post'] = 'rest/publisher/Usersrest/delete_youtube_queued_post';
$route['bulk_channel_filter'] = 'rest/publisher/Usersrest/bulk_channel_filter';

$route['save_channels_to_link'] = 'rest/publisher/Usersrest/save_channels_to_link';
$route['publish_channels_to_link'] = 'rest/publisher/Usersrest/publish_channels_to_link';
$route['schedule_channels_to_link'] = 'rest/publisher/Usersrest/schedule_channels_to_link';

// cronjobs
$route['ChannelCrons'] = 'publisher/ChannelCrons/index';
// cronjob for publishing queued facebook posts
$route['channelfacebookpublish'] = 'publisher/ChannelCrons/facebookPublish';
// cronjob for publishing queued pinterest posts
$route['channelpinterestpublish'] = 'publisher/ChannelCrons/pinterestPublish';
// cronjob for publishing queued instagram posts
$route['channeligpublish'] = 'publisher/ChannelCrons/igPublish';
// cronjob for publishing queued tiktok posts
$route['channeltiktokpublish'] = 'publisher/ChannelCrons/tiktokPublish';
// cronjob for publishing queued facebook groups
$route['channelfbgroupspublish'] = 'publisher/ChannelCrons/facebookGroupPublish';
// cronjob for publishing queue youtube posts
$route['publishyoutubecronjob'] = 'publisher/ChannelCrons/publishYoutubeCronJob';

// cronjob for publishing rss facebook posts
$route['rssfbpublish'] = 'publisher/ChannelCrons/rssFbPublish';
// cronjob for publishing rss pinterest posts
$route['rsspinterestpublish'] = 'publisher/ChannelCrons/rssPinterestPublish';
// cronjob for publishing rss instagram posts
$route['rssigpublish'] = 'publisher/ChannelCrons/rssIgPublish';
// cronjob for publishing rss facebook group posts
$route['rssfbgrouppublish'] = 'publisher/ChannelCrons/rssFacebookGroupPublish';
// cronjob for publishing rss tiktok posts
$route['rsstiktokpublish'] = 'publisher/ChannelCrons/rssTikTokPublish';

// cronjob for fetching latest posts from rss links for facebook
$route['fetchrsslatestpostsfacebook'] = 'publisher/ChannelCrons/fetch_rss_latest_posts_facebook';
// cronjob for fetching latest posts from rss links for pinterest
$route['fetchrsslatestpostspinterest'] = 'publisher/ChannelCrons/fetch_rss_latest_posts_pinterest';
// cronjob for fetching latest posts from rss links for instagram
$route['fetchrsslatestpostsinstagram'] = 'publisher/ChannelCrons/fetch_rss_latest_posts_instagram';

// refresh_pinterest_accesstoken_cronjob
$route['refreshpinterestaccesstokencronjob'] = 'publisher/ChannelCrons/refresh_pinterest_accesstoken_cronjob';

// cronjob for fetching rss links for instagram
$route['rssigcronjob'] = 'publisher/ChannelCrons/rss_ig_cronjob';
// cronjob for fetching rss links for facebook group
$route['rssfbgroupcronjob'] = 'publisher/ChannelCrons/rssFacebookGroupCronjob';


// cronjob for making facebook posts entries into cron table
$route['addFacebookPostToCronTable'] = 'publisher/ChannelCrons/add_facebook_posts_to_cron_table';
// cronjob for facebook posts by API
$route['updateFacebookPostsAndAnalytics'] = 'publisher/ChannelCrons/get_fb_posts_by_api';
// cronjob for updating page and post insights
$route['updateFacebookPostsAndPageInsights'] = 'publisher/ChannelCrons/update_facebook_posts_analytics';
// cronjob for fetching and storing facebook page(s) daily insights
$route['updateFacebookPagesDailyInsights'] = 'publisher/ChannelCrons/update_facebook_pages_daily_insights';
// cronjob for refreshing facebook posts, posts insights and page insight
$route['updateFacebookAnalytics'] = 'publisher/ChannelCrons/update_facebook_analytics';
// cronjob for deleting posts prior to 3 months
$route['deletePreviousPosts'] = 'publisher/ChannelCrons/delete_previous_posts';
// cronjob for fethcing tiktok posts 
$route['tiktokAnalytics'] = 'publisher/ChannelCrons/tiktokAnalytics';

// cronjob for publishing facebook posts
$route['publishFacebookPosts'] = 'publisher/ChannelCrons/publish_facebook_posts';
// cronjob for publishing pinterest posts
$route['publishPinterestPosts'] = 'publisher/ChannelCrons/publish_pinterest_posts';
// cronjob for publishing tiktok posts
$route['publishTiktokPosts'] = 'publisher/ChannelCrons/publish_tiktok_posts';
// cronjob for publishing instagram posts
$route['publishInstagramPosts'] = 'publisher/ChannelCrons/publish_instagram_posts';

// cronjob for publishing queue posts (now)
$route['publishQueueNow'] = 'publisher/ChannelCrons/publish_queue_now';
// cronjob for publishing rss posts (now)
$route['publishRssNow'] = 'publisher/ChannelCrons/publish_rss_now';

// cronjob for refreshing rss feed
$route['refreshRssFeed'] = 'publisher/ChannelCrons/refresh_rss_feed';
// cronjob for fetching latest rss feed
$route['fetchRssFeed'] = 'publisher/ChannelCrons/fetch_rss_feed';
// cronjob for fetching past rss feed
$route['fetchPastRssFeed'] = 'publisher/ChannelCrons/fetch_past_rss_feed';
// cronjob for email sending
$route['emailSending'] = 'publisher/ChannelCrons/email_sending';

// instagram
$route['instagram_callback'] = 'rest/publisher/Usersrest/get_instagram_access_token';
$route['get_user_fb_pages'] = 'rest/publisher/Usersrest/get_user_fb_pages';
$route['get_user_ig_account_id'] = 'rest/publisher/Usersrest/get_user_ig_account_id';
$route['get_user_ig_account_details'] = 'rest/publisher/Usersrest/get_user_ig_account_details';

// google/youtube
$route['get_google_access_token'] = 'rest/publisher/Usersrest/get_google_access_token';
$route['fetch_youtube_categories'] = 'rest/publisher/Usersrest/fetch_youtube_categories';


// pinterest disconnect
$route['disconnectpinterest'] = 'rest/publisher/Authrest/disconnectPinterest';

// link preview - content planner
$route['link_preview'] = 'rest/publisher/Usersrest/link_preview';
$route['active_channels'] = 'rest/publisher/Usersrest/active_channels';
$route['recent_posts'] = 'rest/publisher/Usersrest/recent_posts';
$route['get_recent_posts'] = 'rest/publisher/Usersrest/get_recent_posts';
$route['page_insights'] = 'rest/publisher/Usersrest/page_insights';
$route['get_countires_data'] = 'rest/publisher/Usersrest/get_countires_data';
$route['get_cities_data'] = 'rest/publisher/Usersrest/get_cities_data';
$route['refresh_insights'] = 'rest/publisher/Usersrest/refresh_insights';
$route['check_insights_status'] = 'rest/publisher/Usersrest/check_insights_status';
$route['get_post_info'] = 'rest/publisher/Usersrest/get_post_info';
// short url routes
$route['short_urls'] = 'rest/publisher/Usersrest/short_urls';
$route['short_my_link'] = 'rest/publisher/Usersrest/short_my_link';
// save utm
$route['save_url_utm'] = 'rest/publisher/Usersrest/save_url_utm';
// delete utm
$route['delete_url'] = 'rest/publisher/Usersrest/delete_url';
// get utm
$route['url_tracks'] = 'rest/publisher/Usersrest/url_tracks';
// edit utm
$route['edit_url/(:any)'] = 'publisher/Home/edit_url/$1';
// update utm
$route['update_url/(:any)'] = 'rest/publisher/Usersrest/update_url/$1';
// change utm status
$route['track_status'] = 'rest/publisher/Usersrest/track_status';

// publish_ig_single_media
$route['publish_ig_single_media'] = 'rest/publisher/Usersrest/publish_ig_single_media';

// instagram RSS
$route['update_ig_timeslots_rss'] = 'rest/publisher/Usersrest/ig_rss_update_timeslots';
$route['get_ig_rssscheduled'] = 'rest/publisher/Usersrest/get_ig_rssscheduled';
$route['get_ig_rssspublished'] = 'rest/publisher/Usersrest/get_ig_rssspublished';
$route['ig_rss_feed_engine'] = 'rest/publisher/Usersrest/ig_rssfeed';
$route['ig_rss_feed_onoff'] = 'rest/publisher/Usersrest/ig_rss_feed_onoff';
$route['shuffle_ig_rss_post_all'] = 'rest/publisher/Usersrest/shuffle_ig_rss_post_all';
$route['delete_ig_rss_post_all'] = 'rest/publisher/Usersrest/delete_ig_rss_post_all';
$route['delete_tiktok_rss_post_all'] = 'rest/publisher/Usersrest/delete_tiktok_rss_post_all';
$route['delete_ig_rss_post'] = 'rest/publisher/Usersrest/delete_ig_rss_post';

// instagram disconnect
$route['disconnectinstagram'] = 'rest/publisher/Authrest/disconnectIg';

// facebook groups
$route['get_fbgroups_access_token'] = 'rest/publisher/Usersrest/get_fbgroups_access_token';
$route['get_facebook_groups'] = 'rest/publisher/Usersrest/get_facebook_groups';

// facebook groups RSS
$route['fb_group_rss_feed_engine'] = 'rest/publisher/Usersrest/fb_group_rssfeed';
$route['get_fb_group_rssscheduled'] = 'rest/publisher/Usersrest/get_fb_group_rssscheduled';
$route['get_fb_group_rssspublished'] = 'rest/publisher/Usersrest/get_fb_group_rssspublished';
$route['update_fb_group_timeslots_rss'] = 'rest/publisher/Usersrest/fb_group_rss_update_timeslots';
$route['fb_group_rss_feed_onoff'] = 'rest/publisher/Usersrest/fb_group_rss_feed_onoff';
$route['delete_fb_group_rss_post_all'] = 'rest/publisher/Usersrest/delete_fb_group_rss_post_all';
$route['shuffle_fb_group_rss_post_all'] = 'rest/publisher/Usersrest/shuffle_fb_group_rss_post_all';
$route['delete_fb_group_rss_post'] = 'rest/publisher/Usersrest/delete_fb_group_rss_post';
$route['disconnect_fb_groups'] = 'rest/publisher/Authrest/disconnect_fb_groups';

//facebook login
$route['get_facebook_access_token'] = 'rest/publisher/Usersrest/get_facebook_access_token';

// clear cron job errors 
$route['cron_job_error'] = 'rest/publisher/Authrest/clearcronjoberror';
// delete pages
$route['deletefbpage'] = 'rest/publisher/Authrest/deletefbpage';
$route['deletepinterestboard'] = 'rest/publisher/Authrest/deletepinterestboard';
$route['deleteinstaaccount'] = 'rest/publisher/Authrest/deleteinstaaccount';
$route['deletefbgroup'] = 'rest/publisher/Authrest/deletefbgroup';
$route['deleteyoutube'] = 'rest/publisher/Authrest/deleteyoutube';
