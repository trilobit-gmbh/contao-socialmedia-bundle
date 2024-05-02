<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 */

namespace Trilobit\SocialmediaBundle;

use Contao\Date;
use Contao\Model;

/**
 * Class SocialmediaElementsModel.
 */
class SocialmediaElementsModel extends Model
{
    /**
     * $strTable.
     */
    protected static $strTable = 'tl_socialmedia_elements';

    public static function findPublishedByPid($intPid, array $arrOptions = [])
    {
        $t = static::$strTable;
        $arrColumns = ["$t.pid=?"];

        if (!static::isPreviewMode($arrOptions)) {
            $time = Date::floorToMinute();
            $arrColumns[] = "$t.published=1 AND ($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'$time')";
        }

        $arrColumns[] = "$t.tstamp!=0";

        /*
        if (isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN) {
            $time = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'".($time + 60)."') AND $t.published='1'";
        }
        */

        if (!isset($arrOptions['order'])) {
            $arrOptions['order'] = "$t.sorting";
        }

        return static::findBy($arrColumns, $intPid, $arrOptions);
    }
}
