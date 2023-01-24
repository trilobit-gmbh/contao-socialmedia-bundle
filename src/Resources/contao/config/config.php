<?php

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-socialmedia-bundle
 */

/**
 * Front end module.
 */
$GLOBALS['FE_MOD']['navigationMenu']['socialmedia'] = 'Trilobit\SocialmediaBundle\ModuleSocialmedia';

/*
 * Back end form fields
 */
$GLOBALS['BE_FFL']['socialmediaParameterOptionWizard'] = 'Trilobit\SocialmediaBundle\ParameterOptionWizard';

/*
 * Back end module
 */
$GLOBALS['BE_MOD']['trilobit']['socialmedia'] = [
    'tables' => ['tl_socialmedia', 'tl_socialmedia_elements'],
];

/*
 * Models
 */
$GLOBALS['TL_MODELS']['tl_socialmedia'] = 'Trilobit\SocialmediaBundle\SocialmediaModel';
$GLOBALS['TL_MODELS']['tl_socialmedia_elements'] = 'Trilobit\SocialmediaBundle\SocialmediaElementsModel';
