<?php
/*
 *  CONFIGURE EVERYTHING HERE
 */

require 'codeigniter-phpmailer-master/third_party/phpmailer/PHPMailerAutoload.php';

// an email address that will be in the From field of the email.
$fromEmail = 'hackerpoulette@becode.com';
$fromName = 'Hacker Poulette';

// an email address that will receive the email with the output of the form
$sendToEmail = 'rodriguezgeoffrey.becode@gmail.com';
$sendToName = 'Shujin';

// subject of the email
$subject = 'New message from contact form';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Name', 'surname' => 'Surname', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message'); 

// message that will be displayed when everything is OK :)
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

/*
 *  LET'S DO THE SENDING
 */

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailTextHtml = "<style type='text/css'>body {font-family: Roboto, sans-serif; font-size: 13px; }</style>";
    $emailTextHtml .= "<body>";
    $emailTextHtml .= "<h1>You have a new message from your contact form</h1><hr>";
    $emailTextHtml .= "<table>";
    $emailTextHtml .= "<tr><th>Some custom message</th><td>$_POST[name]</td>";
    $emailTextHtml .= "<tr><th>Some custom stuff</th><td>$_POST[surname]</td>";
    $emailTextHtml .= "<tr><th>...</th><td>....</td>";
    $emailTextHtml .= "</table>";
    $emailTextHtml .= "<p>Have a nice day,<br>Best,<br>Ondrej</p>";
    $emailTextHtml .= "</body>";

    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email 
        if (isset($fields[$key])) {
            $emailTextHtml .= "<tr><th>$fields[$key]</th><td>$value</td></tr>";
        }
    }

    // All the neccessary headers for the email.
    $mail = new PHPMailer;

    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($sendToEmail, $sendToName); // you can add more addresses by simply adding another line with $mail->addAddress();
    $mail->addReplyTo($from);

    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->msgHTML($emailTextHtml); // this will also create a plain-text version of the HTML email, very handy

    if(!$mail->send()) {
        throw new \Exception('I could not send the email.' . $mail->ErrorInfo);
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    $emailTextHtml .= "</table><hr>";
    $emailTextHtml .= "<p>Have a nice day,<br>Best,<br>Ondrej</p>";
    // Send email
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}
