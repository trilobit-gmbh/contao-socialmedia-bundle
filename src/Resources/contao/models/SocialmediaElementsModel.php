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
 * Class SocialmediaElementsModel
 * @package Trilobit\SocialmediaBundle
 */
class SocialmediaElementsModel extends Model
{
    /**
     * $strTable
     */
    protected static $strTable = 'tl_socialmedia_elements';


    /**
     * @param $intPid
     * @param array $arrOptions
     * @return mixed
     */
    public static function findPublishedByPid($intPid, array $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.pid=?");

        if (isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN)
        {
            $time = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
        }

        if (!isset($arrOptions['order']))
        {
            $arrOptions['order'] = "$t.sorting";
        }

        return static::findBy($arrColumns, $intPid, $arrOptions);
    }

}