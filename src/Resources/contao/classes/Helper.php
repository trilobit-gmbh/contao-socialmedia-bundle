<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 */

namespace Trilobit\SocialmediaBundle;

use Contao\Backend;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Helper.
 */
class Helper extends Backend
{
    /**
     * @return string
     */
    public static function getVendowDir()
    {
        return \dirname(__DIR__);
    }

    public static function getConfigData()
    {
        $strYml = file_get_contents(self::getVendowDir().'/../config/config.yml');

        return Yaml::parse($strYml)['trilobit_socialmedia']['socialmedia'];
    }

    public function getModuleTemplates()
    {
        return $this->getTemplateGroup('socialmedia_');
    }

    /**
     * @return array
     */
    public function getModuleCategories()
    {
        $arrItems = [];
        $objItems = $this->Database->execute('SELECT id, title FROM tl_socialmedia ORDER BY title');

        while ($objItems->next()) {
            $arrItems[$objItems->id] = $objItems->title;
        }

        return $arrItems;
    }

    public function getTargetOptions()
    {
        return array_keys(self::getConfigData()['target']);
    }

    /**
     * listElements.
     */
    public function listElements(array $arrRow)
    {
        return $arrRow['title']
            .(isset($arrRow['target']) && !empty($arrRow['target'])
                ? ' <span style="color:#b3b3b3;padding-left:3px">['
                .($GLOBALS['TL_LANG']['tl_socialmedia_elements']['options']['target'][$arrRow['target']] ?? '')
                .']</span>'
                : ''
            );
    }
}
