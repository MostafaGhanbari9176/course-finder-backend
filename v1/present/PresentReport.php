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

    public static function saveAReport($signText, $reportText, $spamId, $spamerAc, $reporterAc)
    {
        $model = new Report();
        $spamerId = (new User())->getPhoneByAc($spamerAc);
        $reporterId = (new User())->getPhoneByAc($reporterAc);
        $rezult = $model->saveAReport($signText, $reportText, $spamId, $spamerId, $reporterId);
        $res = array();
        $message = array();
        $message['code'] = $rezult;
        $res[] = $message;
        return json_encode($res);
    }
}