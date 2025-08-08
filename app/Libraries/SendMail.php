<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load composer's autoloader
require 'vendor/autoload.php';
class SendMail{
	private $mail;
		function __construct() {
			$this->mail = new PHPMailer(true);                              // Passing `true` enables exceptions
			$this->mail->SMTPDebug = 0;                                 // Enable verbose debug output
			$this->mail->isSMTP();                                      // Set mailer to use SMTP
			$this->mail->Host = "email-smtp.eu-west-1.amazonaws.com"; // be sure this matches your server! can be found in the smtp settings from step 2
			//$this->mail->Host = "email-smtp.us-east-1.amazonaws.com"; // be sure this matches your server! can be found in the smtp settings from step 2
			$this->mail->SMTPAuth = true;                               // Enable SMTP authentication
			//$this->mail->Username = "AKIAJATOTJWNKJHPWASQ"; // your SMTP username from step 2!
			$this->mail->Username = "AKIAIE4RYUEIYB4OEZHQ"; // your SMTP username from step 2!
			//$this->mail->Password = "AjpVFBMp8V+g/L0d2YbxXAqqBFMgZu79PmkY+sRfI77q"; // your SMTP password from step 2!
			$this->mail->Password = "BCw5TIJEfS3sjgJE3SkDuvKdC01qlmYfBwPlbBLunTEo"; // your SMTP password from step 2!
			$this->mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$this->mail->Port = 587;
			/*
			https://stackoverflow.com/questions/25129659/phpmailer-use-dkim
			https://dkimcore.org/tools/key/1531821563-aa324c8578d35a14d0cfcf82f52064a6/
			https://dkimcore.org/tools/key/1531821563-aa324c8578d35a14d0cfcf82f52064a6/
			https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/examples/DKIM_gen_keys.phps
			*/
			/*This should be the same as the domain of your From address
			$mail->DKIM_domain = 'easy2investment.com';
			//See the DKIM_gen_keys.phps script for making a key pair -
			//here we assume you've already done that.
			//Path to your private key:
			$mail->DKIM_private = 'dkim_private.pem';
			//Set this to your own selector
			$mail->DKIM_selector = 'phpmailer';
			//Put your private key's passphrase in here if it has one
			$mail->DKIM_passphrase = '';
			//The identity you're signing as - usually your From address
			$mail->DKIM_identity = $mail->From;
			//Suppress listing signed header fields in signature, defaults to true for debugging purpose
			$this->mailer->DKIM_copyHeaderFields = false;*/
		}
	
	function send_mail($data){
		//print_r($data);die;
		//'Easy2Investment Verification'
	
		                         // Passing `true` enables exceptions
		try {
			//Recipients
			//$data['from'] = "Zu0072010@gmail.com";
			$this->mail->setFrom($data['from'],$data['from_message']);
			$this->mail->addAddress($data['to']);     // Add a recipient
			
			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		   // $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			//Content
			$this->mail->isHTML(true);                                  // Set email format to HTML
			$this->mail->Subject = $data['title'];
			$this->mail->Body    = '<!doctype html><html>
      <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?=$title?></title>
        <style>
          img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%; }

          body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%; }

          table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%; }
            table td {
              font-family: sans-serif;
              font-size: 14px;
              vertical-align: top; }

          

          .body {
            background-color: #f6f6f6;
            width: 100%; }

         
          .container {
            display: block;
            Margin: 0 auto !important;
          
            max-width: 580px;
            padding: 10px;
            width: 580px; }

         
          .content {
            box-sizing: border-box;
            display: block;
            Margin: 0 auto;
            max-width: 580px;
            padding: 10px; }

        
          .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%; }

          .wrapper {
            box-sizing: border-box;
            padding: 20px; }

          .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
          }

          .footer {
            clear: both;
            Margin-top: 10px;
            text-align: center;
            width: 100%; }
            .footer td,
            .footer p,
            .footer span,
            .footer a {
              color: #999999;
              font-size: 12px;
              text-align: center; }

          h1,
          h2,
          h3,
          h4 {
            color: #000000;
            font-family: sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
            Margin-bottom: 30px; }

          h1 {
            font-size: 35px;
            font-weight: 300;
            text-align: center;
            text-transform: capitalize; }

          p,
          ul,
          ol {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            Margin-bottom: 15px; }
            p li,
            ul li,
            ol li {
              list-style-position: inside;
              margin-left: 5px; }

          a {
            color: #3498db;
            text-decoration: underline; }

          .btn {
            box-sizing: border-box;
            width: 100%; }
            .btn > tbody > tr > td {
              padding-bottom: 15px; }
            .btn table {
              width: auto; }
            .btn table td {
              background-color: #ffffff;
              border-radius: 5px;
              text-align: center; }
            .btn a {
              background-color: #ffffff;
              border: solid 1px #3498db;
              border-radius: 5px;
              box-sizing: border-box;
              color: #3498db;
              cursor: pointer;
              display: inline-block;
              font-size: 14px;
              font-weight: bold;
              margin: 0;
              padding: 5px 10px;
              text-decoration: none;
              text-transform: capitalize; }

          .btn-primary table td {
            background-color: #3498db; }

          .btn-primary a {
            background-color: #3498db;
            border-color: #3498db;
            color: #ffffff; }

          
          .last {
            margin-bottom: 0; }

          .first {
            margin-top: 0; }

          .align-center {
            text-align: center; }

          .align-right {
            text-align: right; }

          .align-left {
            text-align: left; }

          .clear {
            clear: both; }

          .mt0 {
            margin-top: 0; }

          .mb0 {
            margin-bottom: 0; }

          .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0; }

          .powered-by a {
            text-decoration: none; }

          hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            Margin: 20px 0; }

         
          @media only screen and (max-width: 620px) {
            table[class=body] h1 {
              font-size: 28px !important;
              margin-bottom: 10px !important; }
            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
              font-size: 16px !important; }
            table[class=body] .wrapper,
            table[class=body] .article {
              padding: 10px !important; }
            table[class=body] .content {
              padding: 0 !important; }
            table[class=body] .container {
              padding: 0 !important;
              width: 100% !important; }
            table[class=body] .main {
              border-left-width: 0 !important;
              border-radius: 0 !important;
              border-right-width: 0 !important; }
            table[class=body] .btn table {
              width: 100% !important; }
            table[class=body] .btn a {
              width: 100% !important; }
            table[class=body] .img-responsive {
              height: auto !important;
              max-width: 100% !important;
              width: auto !important; }}

          
          @media all {
            .ExternalClass {
              width: 100%; }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
              line-height: 100%; }
            .apple-link a {
              color: inherit !important;
              font-family: inherit !important;
              font-size: inherit !important;
              font-weight: inherit !important;
              line-height: inherit !important;
              text-decoration: none !important; }
            .btn-primary table td:hover {
              background-color: #34495e !important; }
            .btn-primary a:hover {
              background-color: #34495e !important;
              border-color: #34495e !important; } }

        </style>
      </head>
      <body class="">
        <table border="0" cellpadding="0" cellspacing="0" class="body">
          <tr>
            <td>&nbsp;</td>
            <td class="container">
              <div class="content">

                <!-- START CENTERED WHITE CONTAINER -->
                <table class="main">

                  <!-- START MAIN CONTENT AREA -->
                  <tr>
                    <td class="wrapper">
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>
                            <p>Dear ' . $data['name'] . ',</p>
                            <p>' . $data['title'] . '</p>
                            <p>' . $data['text'] . '</p>
                            <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                              <tbody>
                                <tr>
                                  <td align="left">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                      <tbody>
                                        <tr>
                                          <td> ' . $data['link'] . '</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <p>We look forward to seeing you there. </p>
                            <br />
                            <p>Best Regards,</p><p><b>Team Adublisher</b></p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>

               </table>
         <div class="footer">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td class="content-block">
                       
                        <br /> Need Help ? <a href="http://www.adublisher.com">Get In Touch</a>.
                      </td>
                    </tr>
                   
                  </table>
                </div>
              
              </div>
            </td>
            <td>&nbsp;</td>
          </tr>
        </table></body>
    </html>';
	
			/*
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			//More headers
			$headers .= 'From: <noreply@easy2investment.com>' . "\r\n";
		
			$mail_status= mail($data['to'],$data['subject'], $data['message'], $headers);
			*/
			if(!$this->mail->Send()) {
			//if($mail_status) {
				return false;
			}
			else {
				return true;
			}
				
		} catch (Exception $e) {
			return false;
			//echo 'Message could not be sent. Mailer Error: ', $this->mail->ErrorInfo;
		}

	}
	public function test_mail(){

			//Recipients
			$data['from'] = "Zu0072010@gmail.com";
			$data['from_message'] = "Zubair";
			//$data['to'] = "shahbazbsit16@gmail.com";
			$data['to'] = "zubair.kwe@gmail.com";
			$this->mail->setFrom($data['from'],$data['from_message']);
			$this->mail->addAddress($data['to']);     // Add a recipient
			
			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		   // $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			//Content
			$this->mail->isHTML(true);                                  // Set email format to HTML
			$this->mail->Subject = "test";
			$this->mail->Body    = "test";
	
			/*
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			//More headers
			$headers .= 'From: <noreply@easy2investment.com>' . "\r\n";
		
			$mail_status= mail($data['to'],$data['subject'], $data['message'], $headers);
			*/
			$this->mail->Send();
		
	}
}

?>
	