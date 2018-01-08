<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Trilobit\SocialmediaBundle;

use Model;

/**
 * Class SocialmediaModel
 * @package Trilobit\SocialmediaBundle
 */
class SocialmediaModel extends Model
{
    /**
     * $strTable
     */
    protected static $strTable = 'tl_socialmedia';


    /**
     * @param $intId
     * @param array $arrOptions
     * @return mixed
     */
    public static function findPublishedById($intId, array $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.id=?");

        if (isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN)
        {
            $time = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
        }

        return static::findOneBy($arrColumns, $intId, $arrOptions);
    }
}