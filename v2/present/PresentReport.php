<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 14-Mar-18
 * Time: 1:15 PM
 */
require_once 'model/Report.php';

class PresentReport
{

    public static function saveAReport($signText, $reportText, $spamId, $spamerId, $reporterAc)
    {
        $res = array();
        $message = array();
        $model = new Report();
        $reporterId = (new User())->getPhoneByAc($reporterAc);
        if (strlen($reporterId) != 0)
            $model->saveAReport($signText, $reportText, $spamId, $spamerId, $reporterId);
        $message['code'] = 1;
        $res[] = $message;
        return json_encode($res);
    }
}