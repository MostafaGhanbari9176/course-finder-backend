<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 13-Mar-18
 * Time: 12:58 PM
 */
require_once 'model/Subscribe.php';

class PresentSubscribe
{
    public static function haveASubscription($ac)
    {
        $have = 0;
        $phone = (new User())->getPhoneByAc($ac);
        $subs = new Subscribe();
        $resuelt = $subs->getByUserId($phone);
        while ($row = $resuelt->fetch_assoc()) {
            if ($row['user_id'] == $phone) {
                $have = 1;
                break;
            }
        }
      //  return $have;
        return 1;
    }

}