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

App::getInstance('zoo')->loader->register('ElementRepeatable', 'elements:repeatable/repeatable.php');

class ElementJBSelectCascade extends ElementRepeatable implements iRepeatSubmittable
{
    protected $_maxLevel = null;
    protected $_uniqid = '';
    protected $_itemList = array();
    protected $_listNames = array();

    /**
     * Element constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_uniqid = uniqid();

        $this->registerCallback('ajaxGetList');
    }

    /**
     * @param array $params
     * @return bool|int
     */
    protected function _hasValue($params = array())
    {
        $values = $this->_getSearchData();
        return !empty($values);
    }

    /**
     * Get search data
     * @return null|string
     */
    protected function _getSearchData()
    {
        $result = $this->_getValuesList();
        return (empty($result) ? null : implode("\n", $result));
    }

    /**
     * @return string
     */
    protected function _edit()
    {
        $values = $this->_getValuesList();

        $itemList  = $this->_itemList;
        $deepLevel = $deepLevelCheck = 0;

        $html = array();
        for ($i = 0; $i <= $this->_maxLevel; $i++) {

            $value = isset($values[$i]) ? $values[$i] : null;

            $attrs = array(
                'class'      => 'jbselect-' . $i,
                'name'       => $this->getControlName('list-' . $i),
                'list-order' => $i,
                'disabled'   => 'disabled',
                'id'         => 'jbselect-' . $i . '-' . $this->_uniqid,
            );

            $html[] = '<div>';
            $html[] = '<label for="' . $attrs['id'] . '">' . $this->_listNames[$i] . '</label><br/>';
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

            if (isset($this->_itemList[$value]) && !empty($this->_itemList[$value])) {
                $tmpItems = $this->_itemList[$value];
            }

            $html[] = '</select></div>';
        }

        $wrapperAtts = array(
            'uniqid' => $this->_uniqid,
            'class'  => 'jbcascadeselect',
        );

        return '<div ' . $this->app->jbhtml->buildAttrs($wrapperAtts) . '>'
                . implode(" ", $html)
                . '</div>';
    }

    /**
     * Render submission
     * @param array $params
     * @return string|void
     */
    public function _renderSubmission($params = array())
    {
        return $this->_edit();
    }

    /**
     * Render submission
     * @param array $params
     * @return string
     */
    public function renderSubmission($params = array())
    {
        $html = parent::renderSubmission($params);
        $this->app->jbassets->initSelectCascade();
        $this->app->jbassets->initJBCascadeSelect($this->_uniqid, $this->_itemList);

        return '<div class="jbcascadeselect-wrapper jbcascadeselect-' . $this->_uniqid . '">' . $html . '</div>';
    }

    /**
     * Validate submission
     * @param JSONData $value
     * @param array    $params
     * @return array
     */
    public function _validateSubmission($value, $params)
    {
        $this->_getValuesList();

        $result = array();
        for ($i = 0; $i <= $this->_maxLevel; $i++) {

            $validator = $this->app->validator->create('string', array('required' => $params->get('required')));
            $tmpVal    = $value->get('list-' . $i);

            $result['list-' . $i] = $validator->clean($tmpVal);
        }

        return $result;
    }

    /**
     * Load item list from ajax request
     * @param array $params
     * @return int
     */
    public function ajaxGetList(array $params = array())
    {
        $this->_getValuesList();
        jexit(json_encode($this->_itemList));
    }

    /**
     * Render one row of element
     * @param array $params
     * @return string
     */
    protected function _render($params = array())
    {
        $valueList = $this->_getValuesList();
        if ('last' == $params->get('template', 'default')) {
            $valueList = array(end($valueList));
        }

        return $this->app->element->applySeparators($params->get('separated_values_by'), $valueList);
    }

    /**
     * Render
     * @param array $params
     */
    public function render($params = array())
    {
        $result = array();
        $params = $this->app->data->create($params);

        switch ($params->get('display', 'all')) {
            case 'all':
                foreach ($this as $self) {
                    $result[] = $this->_render($params);
                }
                break;
            case 'first':
                $this->seek(0);
                $result[] = $this->_render($params);
                break;
            case 'all_without_first':
                $this->seek(1);
                while ($this->valid()) {
                    $result[] = $this->_render($params);
                    $this->next();
                }
                break;
        }

        return $this->app->element->applySeparators($params->get('separated_by'), $result);
    }

    /**
     * Render element
     * @param array $params
     * @return string
     */
    public function edit($params = array())
    {
        $html = parent::edit($params);
        $this->app->jbassets->initSelectCascade();
        $this->app->jbassets->initJBCascadeSelect($this->_uniqid, $this->_itemList);

        return '<div class="jbcascadeselect-wrapper jbcascadeselect-' . $this->_uniqid . '">' . $html . '</div>';
    }

    /**
     * Get clear values list
     * @return array
     */
    protected function _getValuesList()
    {
        // init internal vars
        if (is_null($this->_maxLevel)) {

            $itemList = $this->app->jbselectcascade->getItemList(
                $this->config->get('select_names', ''),
                $this->config->get('items', '')
            );

            $this->_itemList  = $itemList['items'];
            $this->_maxLevel  = $itemList['maxLevel'];
            $this->_listNames = $itemList['names'];

        }

        // get values
        $result = array();
        for ($i = 0; $i <= $this->_maxLevel; $i++) {
            $value = JString::trim($this->get('list-' . $i, ''));
            if (!empty($value)) {
                $result[] = $value;
            }
        }

        return $result;
    }

}
