<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

$BASEPATHMM = "http://adublisher.test/" ;

define("BASEPATHMM", $BASEPATHMM);

$site_url = "http://adublisher.test/";

// APP CONSTANTS
defined('SITEURL') || define('SITEURL', $_SERVER['REMOTE_ADDR'] === "127.0.0.1" ? 'http://adublisher.test/' : 'https://www.adublisher.com/');
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
