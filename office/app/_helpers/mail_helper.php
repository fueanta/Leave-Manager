<?php

  $send_mails = true;

	$mail_host = "mail.ebsbd.com"; // mail.ebsbd.com
	$mail_user = "info@boighor.com"; // info@boighor.com
	$mail_pass = "ebs786"; // ebs786

	$sent_from_address = "no-reply@ebsbd.com";
	$sent_from_title = "EBS BD LTD";

  // the responsibility of this function is to send mails to the mail_users with specific messages sent to its parameter
  function send_mail( $send_to, $subject, $message ) {
    global $send_mails, $mail_host, $mail_user, $mail_pass, $sent_from_address, $sent_from_title;
    
    // echo $mail_host . ' ' . $mail_user . ' ' . $mail_pass . ' ' .  $sent_from_address . ' ' . $sent_from_title . ' ' . $send_to . ' ' . $subject . ' ' . $message;
    
    if ( $send_mails ) {
      date_default_timezone_set('Asia/Dhaka');
      require_once 'mailer/PHPMailerAutoload.php';
      
      //Create a new PHPMailer instance
      $mail = new PHPMailer;
      //Tell PHPMailer to use SMTP
      $mail->isSMTP();
      //Enable SMTP debugging
      // 0 = off (for production use)
      // 1 = client messages
      // 2 = client and server messages
      $mail->SMTPDebug = 0;
      //Ask for HTML-friendly debug output
      $mail->Debugoutput = 'html';
      //Set the hostname of the mail server
      $mail->Host = $mail_host;
      //Set the SMTP port number - likely to be 25, 465 or 587
      $mail->Port = 25;
      //Whether to use SMTP authentication
      $mail->SMTPAuth = true;
      //Username to use for SMTP authentication
      $mail->Username = $mail_user;
      //Password to use for SMTP authentication
      $mail->Password = $mail_pass;
      //Set who the message is to be sent from
      $mail->setFrom($sent_from_address, $sent_from_title);
      //Set an alternative reply-to address
      $mail->addReplyTo($sent_from_address, $sent_from_title);
      //Set who the message is to be sent to
      $mail->addAddress($send_to);
      //Message will be in html format
      $mail->IsHTML(true);
      //Set the subject line
      $mail->Subject = $subject;
      //Set mail content
      $mail->Body =  $message;

      if ( $mail->send() ) {
        return true;
      } else {
        die('Mail could not be sent!');
      }
    } else {
      sleep(3.2);
    }
  }

  function prepare_html_message( $content , $link ) {
    return
      '
      <html>
        <head><head>
        <body>
          <h3>'. $content .'</h3>
          <a href="' . $link . '">Follow this link</a>
        </body>
      </html>
      ';
  }