<?php

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-socialmedia-bundle
 */

namespace Trilobit\SocialmediaBundle;

use Model;

/**
 * Class SocialmediaElementsModel.
 */
class SocialmediaElementsModel extends Model
{
    /**
     * $strTable.
     */
    protected static $strTable = 'tl_socialmedia_elements';

    /**
     * @param $intPid
     * @param array $arrOptions
     *
     * @return mixed
     */
    public static function findPublishedByPid($intPid, array $arrOptions = [])
    {
        $t = static::$strTable;
        $arrColumns = ["$t.pid=?"];

        if (isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN) {
            $time = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'".($time + 60)."') AND $t.published='1'";
        }

        if (!isset($arrOptions['order'])) {
            $arrOptions['order'] = "$t.sorting";
        }

        return static::findBy($arrColumns, $intPid, $arrOptions);
    }
}
