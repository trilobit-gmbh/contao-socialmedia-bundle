<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Load language file(s)
 */
System::loadLanguageFile('tl_content');
Controller::loadDataContainer('tl_content');
Controller::loadDataContainer('tl_article');


/**
 * Table tl_socialmedia_elements
 */
$GLOBALS['TL_DCA']['tl_socialmedia_elements'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'             => 'Table',
        'ptable'                    => 'tl_socialmedia',
        'enableVersioning'          => true,
        'sql'                       => array
        (
            'keys' => array
            (
                'id'                => 'primary',
                'pid'               => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                  => 4,
            'fields'                => array('sorting'),
            'panelLayout'           => 'filter;sort,search,limit',
            'headerFields'          => array('title'),
            'child_record_callback' => array('tl_socialmedia_elements', 'listElements')
        ),
        'label' => array
        (
            'fields'                => array('title', 'type'),
            'format'                => '%s',
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'              => 'act=select',
                'class'             => 'header_edit_all',
                'attributes'        => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['edit'],
                'href'              => 'act=edit',
                'icon'              => 'edit.gif'
            ),
            'copy' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['copy'],
                'href'              => 'act=copy',
                'icon'              => 'copy.gif'
            ),
            'delete' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['delete'],
                'href'              => 'act=delete',
                'icon'              => 'delete.gif',
                'attributes'        => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'toggle' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['toggle'],
                'icon'              => 'visible.gif',
                'attributes'        => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback'   => array('tl_socialmedia_elements', 'toggleIcon')
            ),
            'show' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['show'],
                'href'              => 'act=show',
                'icon'              => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'              => array('addImage', 'overwriteMeta'),
        'default'                   => '{title_legend},title;{image_legend:hide},addImage;{linkurl_legend:hide},url,target,linkTitle,embed,titleTexts,parameter;{expert_legend:hide},cssID;{publish_legend},published,start,stop',
    ),

    // Subpalettes
    'subpalettes' => array
    (
        'addImage'                  => 'singleSRC,size,imagemargin,overwriteMeta',
        'overwriteMeta'             => 'alt,imageTitle,caption',
    ),

    // Fields
    'fields' => array
    (
        'title' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['title'],
            'exclude'               => true,
            'search'                => true,
            'inputType'             => 'text',
            'eval'                  => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                   => "varchar(255) NOT NULL default ''"
        ),
        'addImage' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_content']['addImage'],
            'exclude'               => true,
            'search'                => true,
            'inputType'             => 'checkbox',
            'eval'                  => array('submitOnChange'=>true),
            'sql'                   => "char(1) NOT NULL default ''"
        ),
        'overwriteMeta' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_content']['overwriteMeta'],
            'exclude'               => true,
            'inputType'             => 'checkbox',
            'eval'                  => array('submitOnChange'=>true, 'tl_class'=>'w50 clr'),
            'sql'                   => "char(1) NOT NULL default ''"
        ),
        'size' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_content']['size'],
            'exclude'               => true,
            'inputType'             => 'imageSize',
            'options'               => $GLOBALS['TL_CROP'],
            'reference'             => &$GLOBALS['TL_LANG']['MSC'],
            'eval'                  => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'singleSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory'=>true, 'tl_class'=>'clr'),
            'load_callback' => array
            (
                array('tl_content', 'setSingleSrcFlags')
            ),
            'sql'                     => "binary(16) NULL"
        ),
        'alt' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_content']['alt'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'imageTitle' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imageTitle'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'size' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
            'exclude'                 => true,
            'inputType'               => 'imageSize',
            'reference'               => &$GLOBALS['TL_LANG']['MSC'],
            'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'options_callback' => function ()
            {
                return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
            },
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'imagemargin' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagemargin'],
            'exclude'                 => true,
            'inputType'               => 'trbl',
            'options'                 => $GLOBALS['TL_CSS_UNITS'],
            'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(128) NOT NULL default ''"
        ),
        'caption' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_content']['caption'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'allowHtml'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'url' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['MSC']['url'],
            'exclude'               => true,
            'search'                => true,
            'inputType'             => 'text',
            'eval'                  => array('mandatory'=>true, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'fieldType'=>'radio'),
            'eval'                  => array('mandatory'=>true, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                   => "varchar(255) NOT NULL default ''"
        ),
        'target' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['target'],
            'exclude'               => true,
            'search'                => true,
            'filter'                => true,
            'inputType'             => 'select',
            'options_callback'      => array('tl_socialmedia_elements', 'getTargetOptions'),
            'reference'             => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['options']['target'],
            'eval'                  => array('chosen'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(32) NOT NULL default ''"
        ),
        'titleText' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_content']['titleText'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'linkTitle' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_content']['linkTitle'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'embed' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_content']['embed'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'parameter' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['parameter'],
            'exclude'               => true,
            'inputType'             => 'parameterOptionWizard',
            'eval'                    => array('tl_class'=>'clr w50'),
            'sql'                   => "blob NULL",
        ),
        'cssID' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_content']['cssID'],
            'exclude'               => true,
            'inputType'             => 'text',
            'eval'                  => array('multiple'=>true, 'size'=>2, 'tl_class'=>'w50 clr'),
            'sql'                   => "varchar(255) NOT NULL default ''"
        ),
        'published' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['published'],
            'exclude'               => true,
            'search'                => true,
            'sorting'               => true,
            'flag'                  => 1,
            'inputType'             => 'checkbox',
            'eval'                  => array('doNotCopy'=>true),
            'sql'                   => "char(1) NOT NULL default ''"
        ),
        'start' => array
        (
            'exclude'               => true,
            'label'                 => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['start'],
            'inputType'             => 'text',
            'eval'                  => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                   => "varchar(10) NOT NULL default ''"
        ),
        'stop' => array
        (
            'exclude'               => true,
            'label'                 => &$GLOBALS['TL_LANG']['tl_socialmedia_elements']['stop'],
            'inputType'             => 'text',
            'eval'                  => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                   => "varchar(10) NOT NULL default ''"
        ),
        'id' => array
        (
            'sql'                   => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'sql'                   => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
        (
            'sql'                   => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting' => array
        (
            'sql'                   => "int(10) unsigned NOT NULL default '0'",
        )
    )
);


/**
 * Class tl_cascadingcontent_category
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 */
class tl_socialmedia_elements extends Backend {

    /**
     * __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }


    /**
     * generateAlias
     */
    public function getTargetOptions()
    {
        return array_keys(\Trilobit\SocialmediaBundle\Helper::getConfigData()['target']);
    }


    /**
     * listElements
     */
    public function listElements($arrRow)
    {
        return $arrRow['title'];
        return $arrRow['title'] . ' <span style="color:#b3b3b3;padding-left:3px">[' . $GLOBALS['TL_LANG']['tl_socialmedia_elements']['options']['target'][$arrRow['target']] . ']</span>';
    }


    /**
     * toggleIcon
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
    }


    /**
     * toggleVisibility
     */
    public function toggleVisibility($intId, $blnVisible)
    {
        // Check permissions to edit
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        $objVersions = new Versions('tl_socialmedia_elements', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_socialmedia_elements']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_socialmedia_elements']['fields']['published']['save_callback'] as $callback)
            {
                $this->import($callback[0]);
                $blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_socialmedia_elements SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
            ->execute($intId);

        $objVersions->create();
        $this->log('A new version of record "tl_socialmedia_elements.id='.$intId.'" has been created'.$this->getParentEntries('tl_socialmedia_elements', $intId), 'tl_socialmedia_elements toggleVisibility()', TL_GENERAL);
    }
}