<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Facebook App details
| -------------------------------------------------------------------
|
| To get an facebook app details you have to be a registered developer
| at http://developer.facebook.com and create an app for your project.
|
|  facebook_app_id               string   Your facebook app ID.
|  facebook_app_secret           string   Your facebook app secret.
|  facebook_login_type           string   Set login type. (web, js, canvas)
|  facebook_login_redirect_url   string   URL tor redirect back to after login. Do not include domain.
|  facebook_logout_redirect_url  string   URL tor redirect back to after login. Do not include domain.
|  facebook_permissions          array    The permissions you need.
|  facebook_graph_version        string   Set Facebook Graph version to be used. Eg v2.6
|  facebook_auth_on_load         boolean  Set to TRUE to have the library to check for valid access token on every page load.
*/

// $config['facebook_app_id']              = '129993831045741';
$config['facebook_app_id'] = '1262896354847218';

// $config['facebook_app_secret']          = 'eb62894e3f449c51971aca89fdc217ea';
$config['facebook_app_secret'] = '33c33582e27e4d4fa22f0f677062af1f';

$config['facebook_login_type'] = 'web';

$config['facebook_login_redirect_url'] = SITEURL . 'facebook_callback';

$config['facebook_login_redirect_url_addpage'] = SITEURL . 'facebook_addpage';

$config['facebook_permissions'] = [
    'email',
    'public_profile',
    'pages_manage_metadata',
    'pages_manage_posts',
    'pages_read_engagement',
    'pages_show_list',
    'business_management',
    'pages_manage_engagement',
    'pages_read_user_content',
    'read_insights',
    'pages_manage_ads'
];

$config['instagram_permissions'] = [
    'email',
    'public_profile',
    // 'pages_show_list',
    // 'pages_read_engagement',
    // 'pages_manage_posts',
    // 'pages_manage_engagement',
    // 'pages_read_user_content',
    'business_management',
    'read_insights',
    'instagram_basic',
    'instagram_manage_insights',
    'instagram_content_publish',
    'instagram_manage_comments',
];

$config['facebook_graph_version'] = 'v23.0';

$config['facebook_auth_on_load'] = TRUE;

