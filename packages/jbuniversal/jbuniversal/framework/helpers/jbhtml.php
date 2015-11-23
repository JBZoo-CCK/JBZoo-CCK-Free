<?php
/**
 * JBZoo is universal CCK, application for YooTheme Zoo component
 * @package     JBZoo
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com
 * @license     http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class JBHTMLHelper extends AppHelper {
    /**
     * Render option list
     * @param        $data
     * @param        $name
     * @param null   $attribs
     * @param null   $selected
     * @param bool   $idtag
     * @param bool   $translate
     * @return string
     */
    public function radio(
        $data,
        $name,
        $attribs = null,
        $selected = null,
        $idtag = false,
        $translate = false
    )
    {
        if (empty($data)) {
            return null;
        }

        $attribs = $this->_buildAttrs($attribs);

        return $this->_list('radio', $data, $name, $attribs, $selected, $idtag, $translate);
    }

    /**
     * Render checkbox list
     * @param        $data
     * @param        $name
     * @param null   $attribs
     * @param null   $selected
     * @param bool   $idtag
     * @param bool   $translate
     * @return string
     */
    public function checkbox(
        $data,
        $name,
        $attribs = null,
        $selected = null,
        $idtag = false,
        $translate = false
    )
    {
        if (empty($data)) {
            return null;
        }

        if ($idtag) {
            $attribs['id'] = $idtag;
        }

        $attribs = $this->_buildAttrs($attribs);

        return $this->_list('checkbox', $data, $name, $attribs, $selected, $idtag, $translate);
    }

    /**
     * Render select list
     * @param      $data
     * @param      $name
     * @param null $attribs
     * @param null $selected
     * @param bool $idtag
     * @param bool $translate
     * @return string
     */
    public function select(
        $data,
        $name,
        $attribs = null,
        $selected = null,
        $idtag = false,
        $translate = false
    )
    {
        if (empty($data)) {
            return null;
        }

        if ($idtag) {
            $attribs['id'] = $idtag;
        }

        if (isset($attribs['multiple']) && $attribs['multiple'] == 'multiple') {
            $name = $name . '[]';
        }

        $attribs = $this->_buildAttrs($attribs);

        return $this->app->html->_('zoo.genericlist', $data, $name, $attribs, 'value', 'text', $selected, $idtag, $translate);
    }

    /**
     * Render text field
     * @param      $name
     * @param null $value
     * @param null $attribs
     * @param null $idtag
     * @return string
     */
    public function text($name, $value = null, $attribs = null, $idtag = null)
    {
        if ($idtag) {
            $attribs['id'] = $idtag;
        }

        $attribs = $this->_buildAttrs($attribs);

        if (strpos($attribs, 'jsAutocomplete') !== false) {

            $this->app->jbassets->jqueryui();
            $this->app->jbassets->initAutocomplete();
        }

        return $this->app->html->_('control.text', $name, $value, $attribs);
    }

    /**
     * Render hidden field
     * @param      $name
     * @param null $value
     * @param null $attribs
     * @param null $idtag
     * @return string
     */
    public function hidden($name, $value = null, $attribs = null, $idtag = null)
    {
        if ($idtag) {
            $attribs['id'] = $idtag;
        }

        $attribs = $this->_buildAttrs($attribs);
        $value   = $this->cleanAttrValue($value);

        return '<input type="hidden" name="' . $name . '" ' . $attribs . ' value="' . $value . '" />';
    }

    /**
     * Render calendar element
     * @param       $name
     * @param null  $value
     * @param null  $attribs
     * @param null  $idtag
     * @param array $params
     * @return string
     */
    public function calendar($name, $value = null, $attribs = null, $idtag = null, $params = array())
    {
        if ($idtag) {
            $attribs['id'] = $idtag;
        }

        $params['dateFormat'] = trim($params['dateFormat']);

        $this->app->jbassets->jqueryui();
        $this->app->jbassets->addScript('jQuery(function($){
            $("#' . $idtag . '").datepicker(' . json_encode($params) . ');
        });');

        return $this->text($name, $value, $attribs, $idtag);
    }

    /**
     * Render jQueryUI slider
     * @param array  $params
     * @param string $value
     * @param string $name
     * @param string $idtag
     * @return string
     */
    public function slider($params, $value = '', $name = '', $idtag = '')
    {
        if (!empty($value)) {
            $value = explode('/', $value);
        } else {
            $value = array($params['min'], $params['max']);
        }

        $this->app->jbassets->jqueryui();
        $this->app->jbassets->addScript('jQuery(function($){
            $("#' . $idtag . '-wrapper").removeAttr("slide");
            $("#' . $idtag . '-wrapper")[0].slide = null;
            $("#' . $idtag . '-wrapper").slider({
                "range" : true,
                "min"   : ' . ((float)$params['min'] ? (float)$params['min'] : 0) . ',
                "max"   : ' . ((float)$params['max'] ? (float)$params['max'] : 10000) . ',
                "step"  : ' . ((float)$params['step'] ? (float)$params['step'] : 100) . ',
                "values": [' . (float)$value['0'] . ', ' . (float)$value['1'] . '],
                "slide" : function(event,ui) {
                    $("#' . $idtag . '-value").val(ui.values[0] + "/" + ui.values[1]);
                    $("#' . $idtag . '-value-0").html(ui.values[0]);
                    $("#' . $idtag . '-value-1").html(ui.values[1]);
                }
            });
		    $("#' . $idtag . '-value").val(' . (float)$value['0'] . '+ "/" +' . (float)$value['1'] . ');
        });');

        return '<div id="' . $idtag . '-wrapper"> </div>' . "\n"
                . '<span id="' . $idtag . '-value-0" class="slider-value-0">' . (float)$value['0'] . '</span>' . "\n"
                . '<span id="' . $idtag . '-value-1" class="slider-value-1">' . (float)$value['1'] . '</span>' . "\n"
                . '<input type="hidden" id="' . $idtag . '-value" name="' . $name . '" />' . "\n";
    }

    /**
     * Render option list
     * @param        $data
     * @param        $name
     * @param null   $attribs
     * @param null   $selected
     * @param bool   $idtag
     * @param bool   $translate
     * @return string
     */
    public function buttonsJqueryUI(
        $data,
        $name,
        $attribs = null,
        $selected = null,
        $idtag = false,
        $translate = false
    )
    {
        if (isset($attribs['multiple'])) {
            $html = $this->checkbox($data, $name, $attribs, $selected, $idtag, $translate);

        } else {
            $html = $this->radio($data, $name, $attribs, $selected, $idtag, $translate);
        }

        $this->app->jbassets->jqueryui();
        $this->app->jbassets->addScript('jQuery(function($){
            $("#' . $idtag . '-wrapper' . '").buttonset();
        });');

        return '<div id="' . $idtag . '-wrapper">' . $html . '</div>';
    }

    /**
     * Render chosen
     * @param      $data
     * @param      $name
     * @param null $attribs
     * @param null $selected
     * @param bool $idtag
     * @param bool $translate
     * @return string
     */
    public function selectChosen(
        $data,
        $name,
        $attribs = null,
        $selected = null,
        $idtag = false,
        $translate = false
    )
    {
        $this->app->jbassets->chosen();

        $this->app->jbassets->addScript('jQuery(function($){
            $("#' . $idtag . '").chosen();
        });');

        return $this->select($data, $name, $attribs, $selected, $idtag, $translate);
    }

    /**
     * Select cascade
     * @param array  $selectInfo
     * @param string $name
     * @param array  $selected
     * @param array  $attribs
     * @param bool   $idtag
     * @return string
     */
    public function selectCascade(
        $selectInfo,
        $name,
        $selected = array(),
        $attribs = null,
        $idtag = false)
    {
        $itemList  = $selectInfo['items'];
        $maxLevel  = $selectInfo['maxLevel'];
        $listNames = $selectInfo['names'];

        $uniqId         = uniqid();
        $deepLevelCheck = $deepLevel = 0;

        $html = array();
        for ($i = 0; $i <= $maxLevel; $i++) {

            $value = isset($selected[$i]) ? $selected[$i] : null;

            $attrs = array(
                'class'      => 'jbselect-' . $i,
                'name'       => $name . '[]',
                'list-order' => $i,
                'disabled'   => 'disabled',
                'id'         => 'jbselect-' . $i . '-' . $uniqId,
            );

            $html[] = '<div>';
            $html[] = '<label for="' . $attrs['id'] . '">' . $listNames[$i] . '</label>';
            $html[] = '<select ' . $this->app->jbhtml->buildAttrs($attrs) . '>';
            $html[] = '<option value=""> - </option>';

            if ($deepLevelCheck == $deepLevel) {
                $deepLevelCheck++;
                foreach ($itemList as $key => $item) {
                    if ($value == $key) {
                        $html[] = '<option value="' . $key . '" selected="selected">' . $key . '</option>';
                    } else {
                        $html[] = '<option value="' . $key . '">' . $key . '</option>';
                    }
                }
            }

            if (isset($itemList[$value])) {
                $itemList = $itemList[$value];
                $deepLevel++;
            }

            if (isset($selectInfo['items'][$value]) && !empty($selectInfo['items'][$value])) {
                $tmpItems = $selectInfo['items'][$value];
            }

            $html[] = '</select></div>';
        }

        $this->app->jbassets->initSelectCascade();
        $this->app->jbassets->initJBCascadeSelect($uniqId, $selectInfo['items']);

        $attribs['class'][] = 'jbcascadeselect';

        return '<div class="jbcascadeselect-wrapper jbcascadeselect-' . $uniqId . '">'
                . '<div ' . $this->app->jbhtml->buildAttrs($attribs) . '>'
                . implode(" ", $html)
                . '</div></div>';
    }

    /**
     * Generates an HTML checkbox/radio list.
     * @param   string   $inputType    Type of html input element
     * @param   array    $data         An array of objects
     * @param   string   $name         The value of the HTML name attribute
     * @param   string   $attribs      Additional HTML attributes for the <select> tag
     * @param   string   $selected     The name of the object variable for the option text
     * @param   boolean  $idtag        Value of the field id or null by default
     * @param   boolean  $translate    True if options will be translated
     * @param   boolean  $isLabelWrap  True if options wrappeed label tag
     * @return  string HTML for the select list
     */
    private function _list($inputType, $data, $name, $attribs = null, $selected = null, $idtag = false,
                           $translate = false, $isLabelWrap = false
    )
    {
        reset($data);

        if (is_array($attribs)) {
            $attribs = $this->_buildAttrs($attribs);
        }

        $idText = $idtag ? $idtag : $name;

        if ($inputType == 'checkbox') {
            $name = $name . '[]';
        }

        $html = array();
        foreach ($data as $obj) {

            $value = $obj->value;
            $text  = $translate ? JText::_($obj->text) : $obj->text;
            $id    = (isset($obj->id) ? $obj->id : null);

            $extra = array(
                'value' => $value,
                'name'  => $name,
                'type'  => $inputType,
                'id'    => $idText . $value,
            );

            if (is_array($selected)) {

                foreach ($selected as $val) {

                    if ($value == $val) {
                        $extra['checked'] = 'checked';
                        break;
                    }
                }

            } else {
                if ((string)$value == (string)$selected) {
                    $extra['checked'] = 'checked';
                }
            }

            $extraLabel = array(
                'for'   => $extra['id'],
                'class' => $inputType . '-lbl',
            );

            if ($isLabelWrap) {
                $html[] = '<label ' . $this->_buildAttrs($extraLabel) . '>'
                        . '<input ' . $this->_buildAttrs($extra) . ' />'
                        . $text . '</label>';

            } else {
                $html[] = '<input ' . $this->_buildAttrs($extra) . ' />'
                        . '<label ' . $this->_buildAttrs($extraLabel) . '>' . $text . '</label>';

            }

        }

        return implode("\n\t", $html);
    }

    /**
     * Build attrs
     * @param $attrs
     * @return null|string
     */
    public function buildAttrs($attrs)
    {
        return $this->_buildAttrs($attrs);
    }

    /**
     * Build attrs
     * TODO: Remove method, replace to public
     * @param $attrs
     * @return null|string
     */
    protected function _buildAttrs($attrs)
    {
        $result = ' ';

        if (is_string($attrs)) {
            $result .= $attrs;

        } elseif (!empty($attrs)) {
            foreach ($attrs as $key => $param) {

                $param = (array)$param;
                $value = $this->cleanAttrValue(implode(' ', $param));

                if (!empty($value) || $value == '0' || $key == 'value') {
                    $result .= ' ' . $key . '="' . $value . '"';
                }
            }
        }

        return JString::trim($result);
    }

    /**
     * Clear attribute value
     * @param string $value
     * @return string
     */
    public function cleanAttrValue($value)
    {
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        $value = JString::trim($value);
        return $value;
    }
}