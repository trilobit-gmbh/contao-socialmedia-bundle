<?php

/**
 * Load language file(s)
 */
System::loadLanguageFile('tl_article');


/**
 * Table tl_socialmedia
 */
$GLOBALS['TL_DCA']['tl_socialmedia'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'           => 'Table',
        'ctable'                  => array('tl_socialmedia_elements'),
        'enableVersioning'        => true,
        'switchToEdit'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id'              => 'primary',
                'pid'             => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                => 1,
            'fields'              => array('title'),
            'flag'                => 1,
            'panelLayout'         => 'search,limit',
        ),
        'label' => array
        (
            'fields'              => array('title'),
            'format'              => '%s',
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'            => 'act=select',
                'class'           => 'header_edit_all',
                'attributes'      => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_socialmedia']['edit'],
                'href'            => 'table=tl_socialmedia_elements',
                'icon'            => 'edit.gif'
            ),
            'editheader' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_socialmedia']['editheader'],
                'href'            => 'act=edit',
                'icon'            => 'header.gif'
            ),
            'copy' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_socialmedia']['copy'],
                'href'            => 'act=copy',
                'icon'            => 'copy.gif'
            ),
            'cut' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_socialmedia']['cut'],
                'href'            => 'act=paste&amp;mode=cut',
                'icon'            => 'cut.gif'
            ),
            'delete' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_socialmedia']['delete'],
                'href'            => 'act=delete',
                'icon'            => 'delete.gif',
                'attributes'      => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'toggle' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_socialmedia']['toggle'],
                'icon'            => 'visible.gif',
                'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => array('tl_socialmedia', 'toggleIcon')
            ),
            'show' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_socialmedia']['show'],
                'href'            => 'act=show',
                'icon'            => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'            => array(),
        'default'                 => '{title_legend},title;{publish_legend},published,start,stop',
    ),

    // Subpalettes
    'subpalettes' => array(),

    // Fields
    'fields' => array
    (
        'title' => array
        (
            'label'               => &$GLOBALS['TL_LANG']['tl_socialmedia']['title'],
            'exclude'             => true,
            'inputType'           => 'text',
            'eval'                => array('mandatory' => true, 'maxlength' => 255, 'tl_class'=>'w50'),
            'sql'                 => "varchar(200) NOT NULL default ''"
        ),
        'cssID' => array
        (
            'label'               => &$GLOBALS['TL_LANG']['tl_article']['cssID'],
            'exclude'             => true,
            'inputType'           => 'text',
            'eval'                => array('multiple'=>true, 'size'=>2, 'tl_class'=>'w50 clr'),
            'sql'                 => "varchar(255) NOT NULL default ''"
        ),
        'published' => array
        (
            'label'               => &$GLOBALS['TL_LANG']['tl_socialmedia']['published'],
            'exclude'             => true,
            'search'              => true,
            'sorting'             => true,
            'flag'                => 1,
            'inputType'           => 'checkbox',
            'eval'                => array('doNotCopy'=>true),
            'sql'                 => "char(1) NOT NULL default ''"
        ),
        'start' => array
        (
            'label'               => &$GLOBALS['TL_LANG']['tl_socialmedia']['start'],
            'exclude'             => true,
            'inputType'           => 'text',
            'eval'                => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                 => "varchar(10) NOT NULL default ''"
        ),
        'stop' => array
        (
            'label'               => &$GLOBALS['TL_LANG']['tl_socialmedia']['stop'],
            'exclude'             => true,
            'inputType'           => 'text',
            'eval'                => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                 => "varchar(10) NOT NULL default ''"
        ),
        'id' => array
        (
            'sql'                 => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'sql'                 => "int(10) unsigned NOT NULL default '0'",
        ),
        'tstamp' => array
        (
            'sql'                 => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting' => array
        (
            'sql'                 => "int(10) unsigned NOT NULL default '0'",
        ),
    )
);


/**
 * Class tl_socialmedia
 */
class tl_socialmedia extends Backend
{

    /**
     * tl_socialmedia constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }


    /**
     * @param $row
     * @param $href
     * @param $label
     * @param $title
     * @param $icon
     * @param $attributes
     * @return string
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
     * @param $intId
     * @param $blnVisible
     */
    public function toggleVisibility($intId, $blnVisible)
    {
        // Check permissions to edit
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        $objVersions = new Versions('tl_socialmedia', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_socialmedia']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_socialmedia']['fields']['published']['save_callback'] as $callback)
            {
                $this->import($callback[0]);
                $blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_socialmedia SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
            ->execute($intId);

        $objVersions->create();
        $this->log('A new version of record "tl_socialmedia.id='.$intId.'" has been created'.$this->getParentEntries('tl_socialmedia', $intId), 'tl_socialmedia toggleVisibility()', TL_GENERAL);
    }
}