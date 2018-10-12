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
 * Class SocialmediaModel.
 */
class SocialmediaModel extends Model
{
    /**
     * $strTable.
     */
    protected static $strTable = 'tl_socialmedia';

    /**
     * @param $intId
     * @param array $arrOptions
     *
     * @return mixed
     */
    public static function findPublishedById($intId, array $arrOptions = [])
    {
        $t = static::$strTable;
        $arrColumns = ["$t.id=?"];

        if (isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN) {
            $time = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'".($time + 60)."') AND $t.published='1'";
        }

        return static::findOneBy($arrColumns, $intId, $arrOptions);
    }
}
