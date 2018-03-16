<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 16-Mar-18
 * Time: 3:16 PM
 */
require_once 'model/MahoorAppData.php';

class PresentAppData
{

    public static function getAppData()
    {
        $model = new MahoorAppData();
        $resuelt = $model->getAppData();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $appData = array();
            $appData['appName'] = $row['app_name'];
            $appData['pictureId'] = $row['picture_id'];
            $appData['url'] = $row['url'];
            $res[] = $appData;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $comment = array();
            $comment['empty'] = 1;
            $res[] = $comment;
            return json_encode($res);
        }
    }
}