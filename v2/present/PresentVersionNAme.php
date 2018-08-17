<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 17-Aug-18
 * Time: 2:59 PM
 */

require_once 'model/VersionName.php';

class PresentVersionNAme
{

    public static function getVersionNAme()
    {
        return (new VersionName())->getVersionNme();
    }

}