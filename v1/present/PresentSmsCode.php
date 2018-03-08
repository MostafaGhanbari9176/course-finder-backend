<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 12/17/2017
 * Time: 3:17 PM
 */




require_once 'model/SmsCode.php';

class PresentSmsCode
{

    public static function creatAndSaveSmsCode($phone)
    {
        if (((new SmsCode())->getCounter($phone)) < 3) {
            $model = new SmsCode();
            $result = $model->saveSmsCode($phone, rand(100000, 999999));
            if (stripos($phone, "@") >= 0) {
                echo "$phone";
                self::sendEmail($phone);
            }
        } else
            $result = 0;
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function sendEmail($email)
    {
//
////        require_once('class.phpmailer.php');
//        $mail = new PHPMailer(true);
//        $mail->IsSMTP();
//        try {
//            $mail->Host = "smtp.gmail.com"; // آدرس SMTP سایت گوگل
//            $mail->SMTPAuth = true;                  // استفاده از SMTP authentication
//            $mail->SMTPSecure = "tls";                 // استفاده از پروتکل امن
//            $mail->Port = 587;                   // درگاه خروجی سرویس ایمیل گوگل
//            $mail->Username = "godhelot1@gmail.com"; // نام کاربری حساب گوگل
//            $mail->Password = "104603415204";        // کلمه عبور حساب گوگل
////            $mail->AddReplyTo('yourname@example.com', 'Your Name'); // افزودن پاسخ به ارسال کننده
//            $mail->AddAddress($email . "", 'User Name'); // تنظیم آدرس گیرنده ایمیل
////            $mail->SetFrom('yourname@example.com', 'Your Name'); // تنظیم قسمت ارسال کننده ایمیل
//            $mail->Subject = 'PHPMailer تست'; // موضوع ایمیل
//            $mail->AltBody = 'برنامه شما از این ایمیل پشتیبانی نمی کند، برای دیدن آن، لطفا از برنامه دیگری استفاده نمائید'; // متنی برای کاربرانی که نمی توانند ایمیل را به درستی مشاهده کنند
//            $mail->CharSet = 'UTF-8'; // یونیکد برای زبان فارسی
//            $mail->ContentType = 'text/html'; // استفاده از html
//            $mail->MsgHTML('<html>
//<body>
//این یک <font color="#CC0000">تست</font> است!
//</body>
//</html>'); // متن پیام به صورت html
//            //$mail->AddAttachment('images/phpmailer.gif'); // ضمیمه کردن فایل
//            $mail->Send(); // ارسال
//            echo "پیام با موفقیت ارسال شد\n";
//        } catch (phpmailerException $e) {
//            echo $e->errorMessage(); // پیام خطا از phpmailer
//        } catch (Exception $e) {
//            echo $e->getMessage(); // سایر خطاها
//        }
    }

    public static function checkedSmsCode($phone, $code)
    {
        $model = new SmsCode();
        $getCode = $model->getSmsCode($phone);
        if ($getCode == $code) {
            return true;
        } else {
            return false;
        }
    }
}