<?php
  /**
   * Controller
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2020
   * @version $Id: controller.php, v1.00 2020-02-05 10:12:05 gewa Exp $
   */
  define("_WOJO", true);
  require_once("../../init.php");

  $action = Validator::post('action');

  /* == Actions == */
  switch ($action):
      /* == Admin Login == */
      case "adminLogin":
          App::Auth()->login($_POST['username'], $_POST['password']);
      break;
	  
      /* == Admin Password Reset == */
      case "aResetPass":
          App::Admin()->passReset();
      break;

      /* == User Login == */
      case "userLogin":
          App::Auth()->login($_POST['username'], $_POST['password']);
      break;
	  
      /* == User Password Reset == */
      case "uResetPass":
          App::Front()->passReset();
      break;

      /* == Pass Reset == */
      case "password":
          App::Front()->passwordChange();
      break;
	  
      /* == Register == */
      case "register":
          App::Front()->Registration();
      break;

      /* == Contact == */
      case "contact":
          App::Front()->processContact();
      break;

      /* == News == */
      case "news":
          App::Front()->News();
      break;
	  
      /* == Update Profile == */
      case "profile":
	      if(!App::Auth()->is_User())
			  exit;
          App::Front()->updateProfile();
      break;
	  
      /* == Select Membership == */
      case "buyMembership":
	     // if(!App::Auth()->is_User())
		//	  exit;
          App::Front()->buyMembership();
      break;

      /* == Select Gateway == */
      case "selectGateway":
	    // if(!App::Auth()->is_User())
		//	  exit;
          App::Front()->selectGateway();
      break;

      /* == Apply Coupon == */
      case "getCoupon":
	      if(!App::Auth()->is_User())
			  exit;
          App::Front()->getCoupon();
      break;
	  
  endswitch;

  /* Get Invoice */
  if (isset($_GET['getInvoice'])):
	  if(!App::Auth()->is_User())
		  exit;
      if($row = Users::getUserInvoice(Filter::$id)):
		  $tpl = App::View(BASEPATHMM . 'view/front/snippets/'); 
		  $tpl->row = $row;
		  $tpl->user = Auth::$userdata;
		  $tpl->core = App::Core();
		  $tpl->template = 'invoice.tpl.php'; 
		  $title = Validator::sanitize($row->title, "alpha");
		  
          require_once (BASEPATHMM . 'lib/mPdf/vendor/autoload.php');
		  $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
          $mpdf->SetTitle($title);
          $mpdf->WriteHTML($tpl->render());
          $mpdf->Output($title . ".pdf", "D");
          exit;
	  else:
	      exit;
	  endif;
  endif;

  /* == File Download == */
  if (isset($_GET['token'])):
	  if(!App::Auth()->is_User())
		  exit;
	  $token = Validator::Sanitize($_GET['token'], "alphanumeric", 16);
	  if($row = Db::run()->first(Content::fTable, null, array("token" => $token))):
		  if (!file_exists(App::Core()->file_dir . $row->name) || !is_file(App::Core()->file_dir . $row->name)) :
			  Debug::addMessage('errors', "file error", "File does not exist. Make sure you specified correct file name.", 'session');
			  Url::redirect(Url::url('/dashboard/downloads', "?error=1"));
			  exit;
		  else:
			  File::download(App::Core()->file_dir . $row->name, $row->name);
		  endif;
	  else:
		  Url::redirect(Url::url('/dashboard/downloads', "?error=2"));
	  endif;
	  echo $token;
  endif;
	  
  /* == Clear Session Temp Queries == */
  if (isset($_GET['ClearSessionQueries'])):
      App::Session()->remove('debug-queries');
	  App::Session()->remove('debug-warnings');
	  App::Session()->remove('debug-errors');
	  print 1;
  endif;