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
    static $masterMail = 'godhelot1@gmail.com';

    public static function sendVerifyCode($email, $code)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            // $mail->SMTPDebug = 1;                                 // Enable verbose debug output
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
            $mail->Body = self::VerifyCodehtmlPage($code);
            if ($mail->send())
                return 1;
            else
                return 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function sendFeedBackForMaster($feedBackText, $userId)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            //$mail->SMTPDebug = 1;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'mahoorsoft1997@yahoo.com';                 // SMTP username
            $mail->Password = '9157474088';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            $mail->setFrom('mahoorsoft1997@yahoo.com', 'mahoorsoft1997');
            $mail->addAddress(self::$masterMail, 'user');     // Add a recipient
            $mail->isHTML(true);
            $mail->Subject = 'FeedBack From My Training Courses';
            $mail->Body = self::feedBackHtmlPage($feedBackText, $userId);
            if ($mail->send())
                return 1;
            else
                return 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function sendRequestForMaster($text, $userId)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            //$mail->SMTPDebug = 1;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'mahoorsoft1997@yahoo.com';                 // SMTP username
            $mail->Password = '9157474088';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            $mail->setFrom('mahoorsoft1997@yahoo.com', 'mahoorsoft1997');
            $mail->addAddress(self::$masterMail, 'user');     // Add a recipient
            $mail->isHTML(true);
            $mail->Subject = 'Request From My Training Courses';
            $mail->Body = self::feedBackHtmlPage($text, $userId);
            if ($mail->send())
                return 1;
            else
                return 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    private static function feedBackHtmlPage($text, $userId)
    {
        return
            "<html>
<body style='direction:rtl'>
	<div style='background: #263238; height: 600px'>
		<p style='color:white; background: #384248; padding: 20px; font-size: 20px;'>دوره یاب</p>
		<p style='color:#41cdb0; padding-right:20px; text-align: right; font-size: 15px;'>بازخورد از کاربر :</p>
		<ul style='padding: 20px; padding-right:30px'>
			<li style='color: #ffcc00;font-size: 20px'>$userId</li>
			<li style='color: #ffcc00;font-size: 20px'>$text</li>
		</ul>
	</div>
</body>
</html>";
    }

    private static function VerifyCodehtmlPage($code)
    {
        $html = "<html>
<body style='direction:rtl'>
	<div style='background: #263238; height: 300px'>
		<p style='color:white; background: #384248; padding: 20px; font-size: 20px;'>دوره یاب</p>
		<p style='color:#41cdb0; padding-right:20px; text-align: right; font-size: 15px;'>کد زیرا در برنامه وارد کنید :</p>
		<ul style='padding: 20px; padding-right:30px'>
			<li style='color: #ffcc00;font-size: 20px'>$code</li>
		</ul>
	</div>
</body>
</html>";
        return $html;
    }
}