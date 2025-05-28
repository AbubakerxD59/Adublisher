<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

$route['default_controller'] = 'publisher/Home';
$route['404_override'] = '';



####### before login #######
$route['signup'] = 'publisher/Home/signup';
$route['signin'] = 'publisher/Home/signin';
$route['terms'] = 'publisher/Home/terms';
$route['privacy'] = 'publisher/Home/privacy';
$route['termsfb'] = 'publisher/Home/termsfb';
$route['forgot'] = 'publisher/Home/forgot';
##############################################
################ Publisher ROUTES ################
##############################################


$route['dashboard'] = 'publisher/Home/dashboard';
$route['facebook_callback'] = 'publisher/Home/redirect';
$route['fbautoposting'] = 'publisher/Autoposting/index';
$route['dailysceduler'] = 'publisher/Autoposting/dailysceduler';





$route['widget_area'] = 'publisher/Home/widgetArea';
$route['payment_method'] = 'publisher/Home/paymentmethod';
$route['add_paymentmethod'] = 'publisher/Home/add_paymentmethod';
$route['campaigns'] = 'publisher/Home/campaigns'; 
$route['facebook'] = 'publisher/Home/facebook'; 
$route['logout'] = 'publisher/Home/logout'; 
$route['update_profile'] = 'publisher/Home/editprofile'; 
$route['upload_changes']='publisher/Home/uploadchanges';
$route['update_password'] = 'publisher/Home/changepassword'; 
$route['change_domain'] = 'publisher/Home/changedomain'; 
$route['traffic'] = 'publisher/Home/trafficsummary'; 
$route['earning'] = 'publisher/Home/earningsummary'; 
$route['createarticles'] = 'publisher/Home/create_article';
$route['ref/(:any)/(:any)']   = 'publisher/Traffic/index/$1/$2';


$route['test'] = 'publisher/Home/testing'; 

############## REST ############

$route['domainchange'] = 'rest/publisher/Auth/changedomain';
$route['resetpass']    = 'rest/publisher/Changepass/resetpass';
 
$route['facebook_posting'] = 'rest/publisher/Auth/pagePosting';
$route['publisher_login'] = 'rest/publisher/Auth/users/';
$route['getcountrywisepublisher'] = 'rest/publisher/Auth/getcountrywise'; 
$route['disconnectfacebook'] = 'rest/publisher/Auth/disconnectFacebook'; 
$route['disconnectfacebookpage'] = 'rest/publisher/Auth/disconnectFacebookPage'; 
$route['deletefacebookpost'] = 'rest/publisher/Auth/disconnectFacebookPost'; 
$route['updatefacebookpost'] = 'rest/publisher/Auth/updateFacebookPost'; 

$route['getcommingposts'] = 'rest/publisher/Auth/commingPosts'; 
$route['updateuseractivehours'] = 'rest/publisher/Auth/updateUserActiveHours'; 


$route['getcampaigns'] = 'rest/publisher/Auth/get_campaigns'; 
$route['changepass'] = 'rest/publisher/Changepass/pass/'; 
$route['updateprofile'] = 'rest/publisher/Updateprofile/profile/'; 
$route['user_exists_ajax'] = 'publisher/Home/user_exists_ajax/'; 

$route['updatepageautopost'] = 'rest/publisher/Auth/activeAutoPost/'; 
$route['updatepageautopostquantity'] = 'rest/publisher/Auth/quantityAutoPost/'; 
$route['individual_country_click']='rest/publisher/Auth/specific_country_click/';
$route['campaignwise']='rest/publisher/auth/campaignwise';
$route['get_roles']='rest/admin/users/users_roles';
$route['get_gmt_status']='rest/publisher/users/gmt_status';

$route['edit_announcement']='rest/admin/users/edit_announcement';
$route['delete_announcement']='rest/admin/users/delete_announcement';
$route['create_announcement']='rest/admin/users/create_announcement';
$route['top_users']='rest/admin/users/top_users';
$route['save_article']='rest/publisher/users/create_article';
$route['update_article'] = 'rest/publisher/users/update_article';
$route['delete_article'] = 'rest/publisher/users/delete_article';
$route['edit_article/(:any)']   = 'publisher/home/edit_article/$1';
$route['preview/(:any)']   = 'publisher/home/preview_article/$1';
//Notifications
$route['mark_read'] = 'rest/publisher/Auth/markreadNotification';

//Routes used for Angular
$route['publisher_dashboard'] = 'rest/publisher/Users/dashboardwidgets';
$route['rest_admin_dashboard'] = 'rest/admin/Users/dashboardwidgets';


##############################################
################ ADMIN ROUTES ################
##############################################
$route['admin'] = 'admin/Home';
$route['admin_dashboard'] = 'admin/Home/dashboard';
$route['admin_logout']   = 'admin/Home/logout';
$route['secure_login']   = 'admin/Home/signin';

##############

##Categories##
$route['category_list']   = 'admin/Home/listcategory';
##############


##Campaigns##

$route['campaigns_admin']   = 'admin/Home/campaigns';
$route['campaign_add']   = 'admin/Home/addcampaign';
$route['campaign_edit/(:any)']   = 'admin/Home/editcampaign/$1';
$route['campaign_list']   = 'admin/Home/listcampaign';
$route['getcampaigns_admin'] = 'rest/admin/Users/get_campaigns'; 
##############

##Domains##
$route['domain_list']   = 'admin/Home/listdomain';
$route['domain_assign'] = 'admin/Home/assigndomain';
$route['domain_default'] = 'admin/Home/defaultdomain';
$route['domain_system'] = 'admin/Home/systemdomain';
##############



##Articles-urls##
$route['articles_all']   = 'admin/Home/listArticles';
$route['article_domains'] = 'admin/Home/listArticledomains';
$route['article_categories'] = 'admin/Home/listArticleCategories';
##############

##Annoucements##
$route['announcements']='admin/Home/Annoucements';
$route['annoucement_area']='publisher/Home/annoucement_area';
##Notification##
$route['notifications_area']='publisher/Home/notifications_area';
##Publishers##
$route['publisher_list']     = 'admin/Home/listpublisher';
$route['publisher_analytics']   = 'admin/Home/publisher_analytics';
$route['campaign_analytics']   = 'admin/Home/campaign_analytics';
$route['country_analytics']   = 'admin/Home/country_analytics';
$route['publisher_weekly']   = 'admin/Home/weeklypublisher';
$route['publisher_pay']   = 'admin/Home/paypublisher';
$route['direct_link']   = 'admin/Home/directlink';


##############


##Currency Rates ##
$route['currency_list']     = 'admin/Home/listcurrency';
##############

## ADMIN #####
$route['admin_add']     = 'admin/Home/addadmin';
##############


#DataMining#
$route['datathroughback']     = 'admin/DataMining/index';


##############
### Rest API##
##############
$route['admin_login_post'] = 'rest/admin/Auth/login';

$route['admin_getcountrywise'] = 'rest/admin/Users/getcountrywise';
$route['admin_add_rest'] = 'rest/admin/Users/addAdmin';
$route['admin_getarticles'] = 'rest/admin/Users/getarticles';
$route['admin_publisharticle'] = 'rest/admin/Users/publishArticle';

$route['admin_getarticle'] = 'rest/admin/Users/getarticle';
$route['admin_articleapprove'] = 'rest/admin/Users/articleapprove';
$route['admin_articlerework'] = 'rest/admin/Users/articlerework';




##Categories##
$route['category_add_rest'] = 'rest/admin/Users/addCategory';
$route['category_delete_rest'] = 'rest/admin/Users/deleteCategory';
$route['category_edit_rest'] = 'rest/admin/Users/editCategory';
##############

##Campaigns##
$route['campaign_add_rest'] = 'rest/admin/Users/addCampaign';
$route['campaign_delete_rest'] = 'rest/admin/Users/deleteCampaign';
$route['campaign_edit_rest'] = 'rest/admin/Users/updateCampaign';
$route['campaign_get_meta'] = 'rest/admin/Users/metaOfUrl';


##dashboard ##
$route['change_announce_view'] = 'rest/publisher/users/change_announce_view';

##############

###Domains##
$route['article_domain_add_rest'] = 'rest/admin/Users/addDomainArticle';
$route['article_domain_delete_rest'] = 'rest/admin/Users/deleteDomainArticle';
$route['article_domain_edit_rest'] = 'rest/admin/Users/editDomainArticle';
$route['article_domain_list_rest'] = 'rest/admin/Users/getArticleDomains';
$route['article_domain_cat_rest'] = 'rest/admin/Users/wpcategories';



$route['domain_add_rest'] = 'rest/admin/Users/addDomain';
$route['domain_delete_rest'] = 'rest/admin/Users/deleteDomain';
$route['domain_edit_rest'] = 'rest/admin/Users/editDomain';
$route['systemdomain_edit_rest'] = 'rest/admin/Users/systemDomain';
$route['directlink_edit_rest'] = 'rest/admin/Users/redirectLinksettings';
$route['default_domain_user_rest'] = 'rest/admin/Users/userDefaultDomain';
$route['active_domain_user_rest'] = 'rest/admin/Users/userActiveDomain';
$route['update_user_domains_rest'] = 'rest/admin/Users/updateUserDomains';

##############

##Publisher##
$route['publisher_delete_rest'] = 'rest/admin/Users/deletePublisher';
$route['publisher_edit_rest'] = 'rest/admin/Users/editPublisher';
$route['publisher_pay_rest'] = 'rest/admin/Users/payPublisher';

##############

##Reports##
$route['publisher_report_rest'] = 'rest/admin/Users/publisherReport';
$route['campaigns_report_rest'] = 'rest/admin/Users/campaignsReport';
$route['country_report_rest'] = 'rest/admin/Users/countryReport';


###Rates#####
$route['country_edit_rest'] = 'rest/admin/Users/editCountry';
#############
##############################################
############## END ADMIN ROUTES ##############
##############################################


##############################################
############## Webfeed urls     ##############
##############################################
$route['feed'] = 'rest/publisher/Recommended/webfeed';

$route['save_filter'] = 'rest/publisher/Users/save_filter';


$route['translate_uri_dashes'] = FALSE;

######### ROLL MANAGEMENT ROUTES ####

$route['manage_roll']='admin/home/roll_management';
$route['update_rolls']='rest/admin/users/update_roles';


######## Article Wriring #####
$route['article_management']='publisher/home/manage_article';
$route['edit_article/(:num)']='publisher/home/edit_article';





