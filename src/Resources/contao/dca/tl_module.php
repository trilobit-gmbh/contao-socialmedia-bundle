<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 */

// Palettes
use Trilobit\SocialmediaBundle\Helper;

$GLOBALS['TL_DCA']['tl_module']['palettes']['socialmedia'] = '{title_legend},name,headline,type;{config_legend},socialmedia;{template_legend:hide},socialmediaTpl,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

// Fields
$GLOBALS['TL_DCA']['tl_module']['fields']['socialmedia'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['socialmedia'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => [Helper::class, 'getModuleCategories'],
    'eval' => ['mandatory' => true, 'chosen' => true, 'tl_class' => 'clr w50'],
    'sql' => "int(10) unsigned NOT NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['socialmediaTpl'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['socialmediaTpl'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => [Helper::class, 'getModuleTemplates'],
    'eval' => ['chosen' => true, 'tl_class' => 'clr w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];
