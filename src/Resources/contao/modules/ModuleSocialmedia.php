<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 */

namespace Trilobit\SocialmediaBundle;

use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\CoreBundle\File\Metadata;
use Contao\FilesModel;
use Contao\FrontendTemplate;
use Contao\Module;
use Contao\StringUtil;
use Contao\System;

/**
 * Class ModuleSocialmedia.
 */
class ModuleSocialmedia extends Module
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
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### '.strtoupper($GLOBALS['TL_LANG']['MOD']['socialmedia'][0]).' ###';
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
    protected function generateElementImage($objData = null, $objTemplate = null)
    {
        if ('' === $objData->addImage) {
            return;
        }

        if ('' === $objData->singleSRC) {
            return;
        }

        $objModel = FilesModel::findByUuid($objData->singleSRC);

        $rootDir = System::getContainer()->getParameter('kernel.project_dir');
        if (null === $objModel || !is_file($rootDir.'/'.$objModel->path)) {
            return '';
        }

        $rowData = $objData->row();

        $createMetadataOverwriteFromRowData = static function(bool $interpretAsContentModel) use ($rowData) {
            if ($interpretAsContentModel) {
                // This will be null if "overwriteMeta" is not set
                return (new ContentModel())->setRow($rowData)->getOverwriteMetadata();
            }

            // Manually create metadata that always contains certain properties (BC)
            return new Metadata([
                Metadata::VALUE_ALT => $rowData['alt'] ?? '',
                Metadata::VALUE_TITLE => $rowData['imageTitle'] ?? '',
                Metadata::VALUE_URL => System::getContainer()->get('contao.insert_tag.parser')->replaceInline($rowData['imageUrl'] ?? ''),
                'linkTitle' => (string) ($rowData['linkTitle'] ?? ''),
            ]);
        };

        $figureBuilder = System::getContainer()->get('contao.image.studio')->createFigureBuilder();

        $figureBuilder
            ->fromFilesModel($objModel)
            ->setMetadata($createMetadataOverwriteFromRowData(true))
        ;

        $figure = $figureBuilder
            ->setSize($objData->size)
            ->enableLightbox((bool) ($rowData['fullsize'] ?? false))
            ->buildIfResourceExists()
        ;
        $figure->applyLegacyTemplateData($objTemplate, [], $rowData['floating'] ?? null, false);
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
                $strParameter = $this->generateParameter(StringUtil::deserialize($objItems->parameter, true));

                if ('mailto:' === substr($strUrl, 0, 7)) {
                    $strUrl = StringUtil::encodeEmail($strUrl);
                } else {
                    $strUrl = StringUtil::ampersand($strUrl);
                }

                $embed = explode('%s', $objItems->embed);

                $objTemplate = new FrontendTemplate($strCustomTemplate);
                $objTemplate->setData($objItems->row());

                $this->generateElementImage($objItems, $objTemplate);

                $data = StringUtil::deserialize($objItems->cssID, true);

                $objTemplate->url = $strUrl;
                $objTemplate->parameter = $strParameter;
                $objTemplate->title = $objItems->title;
                $objTemplate->href = $strUrl.$strParameter;
                $objTemplate->embed_pre = $embed[0] ?? '';
                $objTemplate->embed_post = $embed[1] ?? '';
                $objTemplate->link = ('' !== $objItems->linkTitle && null !== $objItems->linkTitle ? $objItems->linkTitle : $objItems->title);
                $objTemplate->target = '';
                $objTemplate->class = trim($strCustomTemplate.' '.($data[1] ?? ''));
                $objTemplate->cssID = !empty($data[0]) ? ' id="'.$data[0].'"' : '';

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
     * @return string
     */
    protected function generateParameter(array $arrData = [])
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
