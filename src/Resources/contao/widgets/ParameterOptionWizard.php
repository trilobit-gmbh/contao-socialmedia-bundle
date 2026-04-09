<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 */

namespace Trilobit\SocialmediaBundle;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\Image;
use Contao\StringUtil;
use Contao\Widget;

/**
 * Class ParameterOptionWizard.
 */
class ParameterOptionWizard extends Widget
{
    /**
     * Submit user input.
     *
     * @var bool
     */
    protected $blnSubmitInput = true;

    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'be_widget';

    /**
     * Validate the input and set the value.
     */
    public function validate()
    {
        $mandatory = $this->mandatory;
        $options = $this->getPost($this->strName);

        // Check labels only (values can be empty)
        if (\is_array($options)) {
            foreach ($options as $key => $option) {
                // Unset empty rows
                if ('' === $option['label']) {
                    unset($options[$key]);
                    continue;
                }

                $options[$key]['label'] = trim($option['label']);
                $options[$key]['value'] = trim($option['value']);

                if ('' !== $options[$key]['label']) {
                    $this->mandatory = false;
                }

                // Strip double quotes (see #6919)
                if ('' !== $options[$key]['value']) {
                    $options[$key]['value'] = str_replace('"', '', $options[$key]['value']);
                }
            }
        }

        $options = array_values($options);
        $varInput = $this->validator($options);

        if (!$this->hasErrors()) {
            $this->varValue = $varInput;
        }

        // Reset the property
        if ($mandatory) {
            $this->mandatory = true;
        }
    }

    /**
     * Generate the widget and return it as string.
     *
     * @return string
     */
    public function generate()
    {
        // Make sure there is at least an empty array
        if (!\is_array($this->varValue) || !isset($this->varValue[0])) {
            $this->varValue = [['']];
        }

        $version = (method_exists(ContaoCoreBundle::class, 'getVersion') ? ContaoCoreBundle::getVersion() : VERSION);

        // Begin the table
        $buffer = '<table id="ctrl_'.$this->strId.'" class="tl_optionwizard">
  <thead>
    <tr>
      '.(version_compare($version, '5.7', '<')
            ? ''
            : '<th></th>'
        ).'
      <th>'.$GLOBALS['TL_LANG']['MSC']['ow_key'].'</th>
      <th>'.$GLOBALS['TL_LANG']['MSC']['ow_value'].'</th>
      <th></th>
    </tr>
  </thead>
  <tbody class="sortable">';

        // Add fields
        foreach ($this->varValue as $key => $value) {
            $buffer .= '
<tr>
    '.(version_compare($version, '5.7', '<')
        ? ''
        : '<td><button type="button" class="drag-handle" title="'.StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['move']).'">'.Image::getHtml('drag.svg').'</button></td>'
            ).'
    <td><input type="text" name="'.$this->strId.'['.$key.'][value]" id="'.$this->strId.'_value_'.$key.'" class="tl_text" value="'.StringUtil::specialchars($value['value'] ?? '').'"></td>
    <td><input type="text" name="'.$this->strId.'['.$key.'][label]" id="'.$this->strId.'_label_'.$key.'" class="tl_text" value="'.StringUtil::specialchars($value['label'] ?? '').'"></td>
    <td>
        <button type="button" data-command="copy" title="'.StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['ow_copy']).'">'.Image::getHtml('copy.svg').'</button>
        <button type="button" data-command="delete" title="'.StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['ow_delete']).'">'.Image::getHtml('delete.svg').'</button>
    '.(version_compare($version, '5.7', '<')
                            ? '<button type="button" class="drag-handle" title="'.StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['move']).'">'.Image::getHtml('drag.svg').'</button>'
                            : ''
            ).'
    </td>
</tr>';
        }

        return $buffer.'
  </tbody>
  </table>
  <script>Backend.optionsWizard("ctrl_'.$this->strId.'")</script>';
    }
}
