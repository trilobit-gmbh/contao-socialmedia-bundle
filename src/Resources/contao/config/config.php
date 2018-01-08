<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Front end module
 */
$GLOBALS['FE_MOD']['navigationMenu']['socialmedia'] = 'Trilobit\SocialmediaBundle\ModuleSocialmedia';


/**
 * Back end form fields
 */
$GLOBALS['BE_FFL']['socialmediaParameterOptionWizard'] = 'Trilobit\SocialmediaBundle\ParameterOptionWizard';


/**
 * Back end module
 */
$GLOBALS['BE_MOD']['trilobit']['socialmedia'] = array
(
    'tables' => array('tl_socialmedia', 'tl_socialmedia_elements'),
);

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_socialmedia']          = 'Trilobit\SocialmediaBundle\SocialmediaModel';
$GLOBALS['TL_MODELS']['tl_socialmedia_elements'] = 'Trilobit\SocialmediaBundle\SocialmediaElementsModel';