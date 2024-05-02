<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 */

/*
 * Front end module.
 */

use Trilobit\SocialmediaBundle\ModuleSocialmedia;
use Trilobit\SocialmediaBundle\ParameterOptionWizard;
use Trilobit\SocialmediaBundle\SocialmediaElementsModel;
use Trilobit\SocialmediaBundle\SocialmediaModel;

$GLOBALS['FE_MOD']['navigationMenu']['socialmedia'] = ModuleSocialmedia::class;

/*
 * Back end form fields
 */
$GLOBALS['BE_FFL']['socialmediaParameterOptionWizard'] = ParameterOptionWizard::class;

/*
 * Back end module
 */
$GLOBALS['BE_MOD']['trilobit']['socialmedia'] = [
    'tables' => ['tl_socialmedia', 'tl_socialmedia_elements'],
];

/*
 * Models
 */
$GLOBALS['TL_MODELS']['tl_socialmedia'] = SocialmediaModel::class;
$GLOBALS['TL_MODELS']['tl_socialmedia_elements'] = SocialmediaElementsModel::class;
