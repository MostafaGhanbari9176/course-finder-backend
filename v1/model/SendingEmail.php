<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 15-Mar-18
 * Time: 9:34 PM
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

class SendingEmail
{


    public static function sendEmailWithYahoo($email, $code)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 1;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'mahoorsoft1997@yahoo.com';                 // SMTP username
            $mail->Password = '9157474088';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            $mail->setFrom('mahoorsoft1997@yahoo.com', 'mahoorsoft1997');
            $mail->addAddress($email, 'user');     // Add a recipient
            $mail->isHTML(true);
            $mail->Subject = 'verify Code From My Training Courses';
            $mail->Body = self::htmlPage($code);
            if ($mail->send())
                return 1;
            else
                return 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    private static function htmlPage($code)
    {
        $html = "<html>
<body>
	<div style='background: blue'>
		<p style='color:white'>Your Code</p>
		<ul>
			<li style='color: aquamarine'>$code</li>
		</ul>
	</div>
</body>
</html>";
        return $html;
    }
}