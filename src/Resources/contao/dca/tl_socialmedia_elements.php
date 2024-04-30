<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 */

/*
 * Load language file(s).
 */

use Contao\BackendUser;
use Contao\Controller;
use Contao\DC_Table;
use Contao\System;

System::loadLanguageFile('tl_content');
Controller::loadDataContainer('tl_content');
Controller::loadDataContainer('tl_article');

/*
 * Table tl_socialmedia_elements
 */
$GLOBALS['TL_DCA']['tl_socialmedia_elements'] = [
    // Config
    'config' => [
        'dataContainer' => DC_Table::class,
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
            'child_record_callback' => [Trilobit\SocialmediaBundle\Helper::class, 'listElements'],
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
                'attributes' => 'onclick="if (!confirm(\''.(isset($GLOBALS['TL_LANG']['MSC']['deleteConfirm']) ? $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] : '').'\')) return false; Backend.getScrollOffset();"',
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
        'addImage' => 'singleSRC,size,overwriteMeta',
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
            'label' => &$GLOBALS['TL_LANG']['MSC']['imgSize'],
            'inputType' => 'imageSize',
            'reference' => &$GLOBALS['TL_LANG']['MSC'],
            'eval' => ['rgxp' => 'natural', 'includeBlankOption' => true, 'nospace' => true, 'helpwizard' => true, 'tl_class' => 'w50 clr'],
            'options_callback' => static function() {
                return System::getContainer()->get('contao.image.sizes')->getOptionsForUser(BackendUser::getInstance());

                return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
            },
            'sql' => "varchar(128) COLLATE ascii_bin NOT NULL default ''",
        ],
        'singleSRC' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
            'exclude' => true,
            'inputType' => 'fileTree',
            'eval' => ['filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'clr'],
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
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'target' => [
            'label' => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['target'],
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'inputType' => 'select',
            'options_callback' => [Trilobit\SocialmediaBundle\Helper::class, 'getTargetOptions'],
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
