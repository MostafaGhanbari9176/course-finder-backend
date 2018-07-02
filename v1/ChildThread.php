<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 02-Jul-18
 * Time: 6:51 AM
 */

 class ChildThread extends Thread{
    function run(){
        (new SendingEmail())->sendRequestForMaster('ثبت دوره ایی با کد : ' ,"assssssssssssssssss");
    }
}