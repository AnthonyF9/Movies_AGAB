<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include_once('./vendor/autoload.php');

$mail = new PHPMailer;                              // Passing `true` enables exceptions
try {
     //Server settings
     $mail->SMTPDebug = 0;                                 // Enable verbose debug output
     $mail->isSMTP();                                      // Set mailer to use SMTP
     $mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers
     $mail->SMTPAuth = true;                               // Enable SMTP authentication
     $mail->Username = 'guy.de.bergahel@gmail.com';                 // SMTP username
     $mail->Password = 'guiguii1';                           // SMTP password
     $mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
     $mail->Port = 465;                                    // TCP port to connect to

      //Recipients
     $mail->setFrom('guy.de.bergahel@gmail.com', 'Mailer');
     $mail->addAddress('guy.de.bergahel@gmail.com', 'Joe User');     // Add a recipient
      //$mail->addAddress('ellen@example.com');               // Name is optional
   //$mail->addReplyTo('info@example.com', 'Information');
     //$mail->addCC('cc@example.com');
     //$mail->addBCC('bcc@example.com');
   $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );
      //Attachments
      //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Modifier votre mot de passe pour "Movies_AGAB"';
      $mail->Body    = 'http://localhost/projet/3-08dec2017/Movies_AGAB/modif-password.php?mail=' . $mailBDD . '&token=' . $tokenBDD;
      //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      $mail->From = $mail->Username;
      $mail->send();
      echo 'Message has been sent';
  } catch (Exception $e) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
  }
    // //------------------Lignes à ajuster-------------------------------------------
    // $mail->Username = 'guy.de.bergahel@gmail.com';               // SMTP username
    // $mail->Password = 'guiguii1';                                // SMTP password
    // $mail->addAddress('guy.de.bergahel@gmail.com', 'Joe User');  // Add a recipient
    // $mail->FromName = 'inscription-connexion';
    // $mail->Subject = 'Modifier votre mot de passe pour "inscription-connexion"';
    // $mail->Body    = 'http://localhost/projet/3-06dec2017/inscription-connexion/modif-password.php?mail=' . $mailBDD . '&token=' . $tokenBDD;
    // //------------------Lignes de config-------------------------------------------
    // $mail->Host = 'ssl://smtp.gmail.com';                 // Specify main and backup SMTP servers
    // $mail->Port = 465;                                    // TCP port to connect to
    // $mail->isHTML(true);                                  // Set email format to HTML
    // $mail->SMTPAuth = true;                               // Enable SMTP authentication
    //
    // //Server settings
    // // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    // // $mail->isSMTP();                                      // Set mailer to use SMTP
    // $mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers
    // $mail->SMTPAuth = true;                               // Enable SMTP authentication
    // $mail->Username = 'guy.de.bergahel@gmail.com';            // SMTP username
    // $mail->Password = 'guiguii1';                           // SMTP password
    // $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    // $mail->Port = 465;                                    // TCP port to connect to
    // $mail->From = $mail->Username;

    // //Recipients
    // $mail->setFrom('guy.de.bergahel@gmail.com', 'Mailer');
    // $mail->addAddress('guy.de.bergahel@gmail.com', 'Joe User');     // Add a recipient
    // // $mail->addAddress('ellen@example.com');               // Name is optional
    // // $mail->addReplyTo('info@example.com', 'Information');
    // // $mail->addCC('cc@example.com');
    // // $mail->addBCC('bcc@example.com');
    //
    // //Attachments
    // // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    //
    // //Content
    // $mail->isHTML(true);                                  // Set email format to HTML
    // $mail->Subject = 'Hello';
    // $mail->Body    = 'http://localhost/projet/3-06dec2017/inscription-connexion/modif-password.php?mail=' . $mailBDD . '&token=' . $tokenBDD;
    // $mail->AltBody = '';
    //
    // $mail->send();
    // echo 'Message has been sent';
// } catch (Exception $e) {
//     echo 'Message could not be sent.';
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// }
?>
