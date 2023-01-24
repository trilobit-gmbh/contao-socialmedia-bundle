<?php

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-socialmedia-bundle
 */

namespace Trilobit\SocialmediaBundle;

use Contao\Controller;
use Patchwork\Utf8;
use StringUtil;

/**
 * Class ModuleSocialmedia.
 */
class ModuleSocialmedia extends \Module
{
    /**
     * @var string
     */
    protected $strTemplate = 'mod_socialmedia';

    /**
     * @return string
     */
    public function generate()
    {
        if (TL_MODE === 'BE') {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### '.Utf8::strtoupper($GLOBALS['TL_LANG']['MOD']['socialmedia'][0]).' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * @param null $objData
     * @param null $objTemplate
     *
     * @return string|void
     */
    public static function generateElementImage($objData = null, $objTemplate = null)
    {
        if ('' === $objData->addImage) {
            return;
        }
        if ('' === $objData->singleSRC) {
            return;
        }
        $objFile = \FilesModel::findByUuid($objData->singleSRC);

        if (null === $objFile || !is_file(TL_ROOT.'/'.$objFile->path)) {
            return '';
        }

        $objData->singleSRC = $objFile->path;

        Controller::addImageToTemplate($objTemplate, $objData->row(), null, null, $objFile);
    }

    protected function compile()
    {
        $objItems = SocialmediaElementsModel::findPublishedByPid($this->socialmedia);

        if (null !== $objItems) {
            $strCustomTemplate = 'socialmedia_default';

            // custom template
            if ('' !== $this->socialmediaTpl) {
                $strCustomTemplate = $this->socialmediaTpl;
            }

            $strItems = '';

            while ($objItems->next()) {
                $strUrl = $objItems->url;
                $strParameter = self::generateParameter(deserialize($objItems->parameter, true));

                if ('mailto:' === substr($strUrl, 0, 7)) {
                    $strUrl = StringUtil::encodeEmail($strUrl);
                } else {
                    $strUrl = ampersand($strUrl);
                }

                $embed = explode('%s', $objItems->embed);

                $objTemplate = new \FrontendTemplate($strCustomTemplate);
                $objTemplate->setData($objItems->row());

                self::generateElementImage($objItems, $objTemplate);

                $objTemplate->url = $strUrl;
                $objTemplate->parameter = $strParameter;

                $objTemplate->title = $objItems->title;

                $objTemplate->href = $strUrl.$strParameter;
                $objTemplate->embed_pre = $embed[0];
                $objTemplate->embed_post = $embed[1];
                $objTemplate->link = ('' !== $objItems->linkTitle && null !== $objItems->linkTitle ? $objItems->linkTitle : $objItems->title);
                $objTemplate->target = '';

                if ($objItems->titleText) {
                    $objTemplate->linkTitle = StringUtil::specialchars($objItems->titleText);
                }

                // Override the link target
                if ($objItems->target) {
                    $objTemplate->target = ' target="_blank"';
                }

                $strItems .= $objTemplate->parse();
            }
        }

        $this->Template->items = $strItems;
    }

    /**
     * @param array $arrData
     *
     * @return string
     */
    protected function generateParameter($arrData = [])
    {
        if (empty($arrData)) {
            return '';
        }
        $strData = '';

        foreach ($arrData as $value) {
            if ('' === $strData) {
                $strData = '?';
            } else {
                $strData .= '&amp;';
            }

            $strData .= $value['value'].'='.$value['label'];
        }

        if ('?=' === $strData) {
            return '';
        }

        return $strData;
    }
}
