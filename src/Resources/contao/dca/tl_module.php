<?php

/**
 * Table tl_module
 */

// Palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['socialmedia'] = '{title_legend},name,headline,type;{config_legend},socialmedia;{template_legend:hide},socialmediaTpl,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

// Fields
$GLOBALS['TL_DCA']['tl_module']['fields']['socialmedia'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_module']['socialmedia'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('tl_module_socialmedia', 'getCategories'),
    'eval'             => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'clr w50'),
    'sql'              => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['socialmediaTpl'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_module']['socialmediaTpl'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('tl_module_socialmedia', 'getTemplates'),
    'eval'             => array('chosen'=>true, 'tl_class'=>'clr w50'),
    'sql'              => "varchar(64) NOT NULL default ''"
);


/**
 * Class tl_module_socialmedia
 */
class tl_module_socialmedia extends Backend
{

    /**
     * tl_module_socialmedia constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }


    /**
     * @return array
     */
    public function getTemplates()
    {
        return $this->getTemplateGroup('socialmedia_');
    }


    /**
     * @return array
     */
    public function getCategories()
    {
        $arrItems = array();
        $objItems = $this->Database->execute("SELECT id, title FROM tl_socialmedia ORDER BY title");

        while ($objItems->next())
        {
            $arrItems[$objItems->id] = $objItems->title;
        }

        return $arrItems;
    }
}
