<?php

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-socialmedia-bundle
 */

/**
 * Load language file(s).
 */
System::loadLanguageFile('tl_content');
Controller::loadDataContainer('tl_content');
Controller::loadDataContainer('tl_article');

/*
 * Table tl_socialmedia_elements
 */
$GLOBALS['TL_DCA']['tl_socialmedia_elements'] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'ptable' => 'tl_socialmedia',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid' => 'index',
            ],
        ],
    ],

    // List
    'list' => [
        'sorting' => [
            'mode' => 4,
            'fields' => ['sorting'],
            'panelLayout' => 'filter;sort,search,limit',
            'headerFields' => ['title'],
            'child_record_callback' => ['tl_socialmedia_elements', 'listElements'],
        ],
        'label' => [
            'fields' => ['title', 'type'],
            'format' => '%s',
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"',
            ],
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.gif',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"',
            ],
            'toggle' => [
                'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['toggle'],
                'attributes' => 'onclick="Backend.getScrollOffset();"',
                'haste_ajax_operation' => [
                    'field' => 'published',
                    'options' => [
                        [
                            'value' => '',
                            'icon' => 'invisible.svg',
                        ],
                        [
                            'value' => '1',
                            'icon' => 'visible.svg',
                        ],
                    ],
                ],
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
        ],
    ],

    // Palettes
    'palettes' => [
        '__selector__' => ['addImage', 'overwriteMeta'],
        'default' => '{title_legend},title;{image_legend:hide},addImage;{linkurl_legend:hide},url,target,linkTitle,embed,titleTexts,parameter;{expert_legend:hide},cssID;{publish_legend},published,start,stop',
    ],

    // Subpalettes
    'subpalettes' => [
        'addImage' => 'singleSRC,size,imagemargin,overwriteMeta',
        'overwriteMeta' => 'alt,imageTitle,caption',
    ],

    // Fields
    'fields' => [
        'title' => [
            'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['title'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'addImage' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['addImage'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'checkbox',
            'eval' => ['submitOnChange' => true],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'overwriteMeta' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['overwriteMeta'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['submitOnChange' => true, 'tl_class' => 'w50 clr'],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'size' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['size'],
            'exclude' => true,
            'inputType' => 'imageSize',
            'options' => $GLOBALS['TL_CROP'],
            'reference' => &$GLOBALS['TL_LANG']['MSC'],
            'eval' => ['rgxp' => 'digit', 'nospace' => true, 'helpwizard' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(64) NOT NULL default ''",
        ],
        'singleSRC' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
            'exclude' => true,
            'inputType' => 'fileTree',
            'eval' => ['filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'clr'],
            'load_callback' => [
                ['tl_content', 'setSingleSrcFlags'],
            ],
            'sql' => 'binary(16) NULL',
        ],
        'alt' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['alt'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'imageTitle' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['imageTitle'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'size' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['size'],
            'exclude' => true,
            'inputType' => 'imageSize',
            'reference' => &$GLOBALS['TL_LANG']['MSC'],
            'eval' => ['rgxp' => 'natural', 'includeBlankOption' => true, 'nospace' => true, 'helpwizard' => true, 'tl_class' => 'w50'],
            'options_callback' => function () {
                return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
            },
            'sql' => "varchar(64) NOT NULL default ''",
        ],
        'imagemargin' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['imagemargin'],
            'exclude' => true,
            'inputType' => 'trbl',
            'options' => $GLOBALS['TL_CSS_UNITS'],
            'eval' => ['includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(128) NOT NULL default ''",
        ],
        'caption' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['caption'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'allowHtml' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'url' => [
            'label' => &$GLOBALS['TL_LANG']['MSC']['url'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'fieldType' => 'radio'],
            'eval' => ['mandatory' => true, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'tl_class' => 'w50 wizard'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'target' => [
            'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['target'],
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'inputType' => 'select',
            'options_callback' => ['tl_socialmedia_elements', 'getTargetOptions'],
            'reference' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['options']['target'],
            'eval' => ['chosen' => true, 'includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(32) NOT NULL default ''",
        ],
        'titleText' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['titleText'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'linkTitle' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['linkTitle'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'embed' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['embed'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'parameter' => [
            'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['parameter'],
            'exclude' => true,
            'inputType' => 'socialmediaParameterOptionWizard',
            'eval' => ['tl_class' => 'clr long'],
            'sql' => 'blob NULL',
        ],
        'cssID' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['cssID'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['multiple' => true, 'size' => 2, 'tl_class' => 'w50 clr'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'published' => [
            'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['published'],
            'exclude' => true,
            'search' => true,
            'sorting' => true,
            'flag' => 1,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy' => true],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'start' => [
            'exclude' => true,
            'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['start'],
            'inputType' => 'text',
            'eval' => ['rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'],
            'sql' => "varchar(10) NOT NULL default ''",
        ],
        'stop' => [
            'exclude' => true,
            'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['stop'],
            'inputType' => 'text',
            'eval' => ['rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'],
            'sql' => "varchar(10) NOT NULL default ''",
        ],
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'pid' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'sorting' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
    ],
];

/**
 * Class tl_cascadingcontent_category.
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_socialmedia_elements extends Backend
{
    /**
     * __construct.
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * generateAlias.
     */
    public function getTargetOptions()
    {
        return array_keys(\Trilobit\SocialmediaBundle\Helper::getConfigData()['target']);
    }

    /**
     * listElements.
     *
     * @param mixed $arrRow
     */
    public function listElements($arrRow)
    {
        return $arrRow['title'];

        return $arrRow['title'].' <span style="color:#b3b3b3;padding-left:3px">['.$GLOBALS['TL_LANG']['tl_socialmedia_elements']['options']['target'][$arrRow['target']].']</span>';
    }
}
