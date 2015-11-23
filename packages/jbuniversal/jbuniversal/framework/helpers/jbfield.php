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

class JBFieldHelper extends AppHelper
{
    /**
     * Render currency list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function currencyList($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $currencyList = $this->app->jbmoney->getCurrencyList();

        return $this->_renderList($currencyList, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render application list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function applicationList($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $appList = $this->app->table->application->all();

        $options = array();
        foreach ($appList as $app) {
            $options[$app->id] = $app->name;
        }

        return $this->_renderList($options, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render layout list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function layoutList($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $layoutName = str_replace('layout_', '', $this->_getAttr($node, 'name', ''));

        $path = JPath::clean(
            $this->app->path->path('jbtmpl:') . '/' .
                $this->app->jbenv->getTemplateName()
                . '/renderer'
                . '/' . $layoutName
        );

        $options = array('__auto__' => JText::_('JBZOO_LAYOUT_AUTOSELECT'));
        if (JFolder::exists($path)) {
            $files = JFolder::files($path, '^([-_A-Za-z0-9\.]*)\.php$', false, false, array('.svn', 'CVS'));
            foreach ($files as $tmpl) {
                $tmpl           = basename($tmpl, '.php');
                $options[$tmpl] = $tmpl;
            }
        }

        return $this->_renderList($options, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render submission layout list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function formLayoutList($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $application = $this->app->zoo->getApplication();

        $options = array(
            '' => JText::_('JBZOO_CART_SELECT_ORDER_FORM')
        );

        if ($application) {

            foreach ($application->getTypes() as $type) {

                $submissions = $this->app->type->layouts($type, 'submission');

                if (!empty($submissions)) {
                    foreach ($submissions as $submission) {
                        $options[$type->id . ':' . $submission->layout] = $type->name . ' / ' . $submission->name;
                    }
                }
            }
        }

        return $this->_renderList($options, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render email layout list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function emailLayoutList($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $application = $this->app->zoo->getApplication();

        $options = array(
            '' => JText::_('JBZOO_CART_SELECT_ORDER_FORM')
        );

        if ($application) {
            foreach ($application->getTypes() as $type) {

                $layouts = $this->app->type->layouts($type);

                if (!empty($layouts)) {
                    foreach ($layouts as $layout) {
                        if ($layout->get('layout')) {
                            $options[$layout->get('layout')] = $type->name . ' / ' . $layout->get('name');
                        }
                    }
                }
            }
        }

        return $this->_renderList($options, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render submission list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function submissionList($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $application = $this->app->zoo->getApplication();

        $options = array('' => JText::_('JBZOO_CART_SELECT_ORDER_FORM'));
        if ($application) {
            foreach ($application->getSubmissions() as $submission) {
                $options[$submission->id] = $submission->name;
            }
        }

        return $this->_renderList($options, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render layout list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function layoutListGlobal($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        return $this->_global('layoutList', $name, $value, $controlName, $node, $parent);
    }

    /**
     * Render typelist list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function types($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $options = array();

        $application = $this->app->zoo->getApplication();
        if ($application) {
            foreach ($application->getTypes() as $type) {
                $options[$type->id] = $type->name;
            }
        }

        return $this->_renderList($options, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render hidden timestamp
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function timestamp($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        return '<input type="hidden" name="' . $controlName . '[' . $name . ']" value="' . time() . '" />';
    }

    /**
     * Render hidden timestamp
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function select($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $optionList = array();
        foreach ($node->children() as $option) {
            $optionList[$this->_getAttr($option, 'value', '')] = JText::_((string)$option);
        }

        return $this->_renderList($optionList, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render boolean list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function bool($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $optionList = array(
            0 => 'JBZOO_NO',
            1 => 'JBZOO_YES',
        );

        return $this->_renderRadio($optionList, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render boolean list
     * TODO Move queries to models
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function menuItems_j25($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {

        $db = JFactory::getDbo();

        // Load the list of menu types
        $db->setQuery('SELECT menutype, title FROM #__menu_types ORDER BY title');
        $menuTypes = $db->loadObjectList();

        // load the list of menu items
        $db->setQuery('SELECT id, parent_id, title, menutype, type FROM #__menu WHERE published = "1" ORDER BY menutype, parent_id, ordering');
        $menuItems = $db->loadObjectList();

        // Establish the hierarchy of the menu
        $children = array();
        if ($menuItems) {
            // First pass - collect children
            foreach ($menuItems as $v) {
                $pt   = $v->parent_id;
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
        }

        // Second pass - get an indent list of the items
        $list = JHtml::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0);

        // Assemble into menutype groups
        $n = count($list);

        $groupedList = array();
        foreach ($list as $k => $v) {
            $groupedList[$v->menutype][] = & $list[$k];
        }

        // Assemble menu items to the array
        $options = array(
            '0' => JText::_('JOPTION_SELECT_MENU_ITEM')
        );

        foreach ($menuTypes as $type) {

            if (isset($groupedList[$type->menutype])) {

                $n = count($groupedList[$type->menutype]);
                for ($i = 0; $i < $n; $i++) {

                    $item = & $groupedList[$type->menutype][$i];

                    $options[$item->id] = $item->treename;
                }
            }

        }

        return $this->_renderList($options, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * TODO Move queries to models
     * Render boolean list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function menuItems_j3($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        require_once realpath(JPATH_ADMINISTRATOR . '/components/com_menus/helpers/menus.php');

        // Get the menu items.
        $items = MenusHelper::getMenuLinks();

        // Build the groups arrays.
        $options = array();
        foreach ($items as $menu) {
            foreach ($menu->links as $link) {
                $options[$link->value] = $link->text;
            }
        }


        return $this->_renderList($options, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render textarea
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function textarea($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $attrs = array(
            'name'        => $this->_getName($controlName, $name),
            'placeholder' => $this->_getAttr($node, 'placeholder', null),
            'class'       => $this->_getAttr($node, 'class', null),
            'rows'        => $this->_getAttr($node, 'rows', null),
            'cols'        => $this->_getAttr($node, 'cols', null),
        );

        return '<textarea ' . $this->app->jbhtml->buildAttrs($attrs) . '>' . $value . '</textarea>';
    }

    /**
     * Render links for payment system
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function paymentLinks($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $href = JUri::root() . 'administrator/index.php?' . http_build_query(array(
            'option'     => 'com_zoo',
            'tmpl'       => 'component',
            'controller' => 'jbtools',
            'task'       => 'paymentlinks',
            'app_id'     => $this->app->zoo->getApplication()->id,
        ));

        $link = '<a class="modal" href="' . $href . '" '
            . 'rel="{handler: \'iframe\', size: {x: 600, y: 500}, onClose: function() {}}">'
            . JText::_('JBZOO_SHOW_PAYMENTLINKS') . '</a>';

        return $link;
    }

    /**
     * Render element list
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    public function elementList($name, $value, $controlName, SimpleXMLElement $node, $parent)
    {

        $types = $this->_getAttr($node, 'types', '');

        if ($types) {
            $types = explode(',', $types);
        }

        $files = JFolder::files($this->app->path->path('jbtypes:'), '\.config');

        $optionList = array();
        foreach ($files as $file) {

            $json = JFile::read($this->app->path->path('jbtypes:' . $file));
            $data = json_decode($json, true);

            if (!$data) {
                continue;
            }

            foreach ($data['elements'] as $key => $element) {
                if (in_array($element['type'], $types)) {
                    $optionList[$key] = $data['name'] . ' - ' . $element['name'];
                }
            }

        }

        return $this->_renderList($optionList, $value, $this->_getName($controlName, $name), $node);
    }

    /**
     * Render radio params
     * @param array            $optionsList
     * @param string           $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @return mixed
     */
    protected function _renderRadio($optionsList, $value, $controlName, SimpleXMLElement $node)
    {
        $html = array();
        foreach ($optionsList as $key => $option) {
            $id         = uniqid('radio-');
            $attributes = array(
                'id'    => $id,
                'type'  => 'radio',
                'name'  => $controlName,
                'value' => $key
            );

            if ($key == $value) {
                $attributes = array_merge($attributes, array('checked' => 'checked'));
            }

            $html[] = '<input ' . $this->app->jbhtml->buildAttrs($attributes) . ' /> '
                . '<label ' . $this->app->jbhtml->buildAttrs(array('for' => $id)) . '>'
                . JText::_($option)
                . '</label>';
        }

        return implode(" \n", $html);
    }

    /**
     * Render layout list
     * @param string           $method
     * @param string           $name
     * @param string|array     $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @param SimpleXMLElement $parent
     * @return mixed
     */
    protected function _global($method, $name, $value, $controlName, SimpleXMLElement $node, $parent)
    {
        $this->app->document->addScript('fields:global.js');

        $id     = uniqid('listglobal-');
        $global = $parent->getValue((string)$name) === null;

        $html   = array();
        $html[] = '<div class="global list">';
        $html[] = '<input id="' . $id . '" type="checkbox"' . ($global ? ' checked="checked"' : '') . ' />';
        $html[] = '<label for="' . $id . '">' . JText::_('Global') . '</label>';
        $html[] = '<div class="input">';
        $html[] = call_user_func_array(
            array($this, $method),
            array($name, $value, $controlName, $node, $parent)
        );
        $html[] = '</div></div>';

        return implode("\n ", $html);
    }

    /**
     * Render list params
     * @param array            $optionsList
     * @param string           $value
     * @param string           $controlName
     * @param SimpleXMLElement $node
     * @return mixed
     */
    protected function _renderList($optionsList, $value, $controlName, SimpleXMLElement $node)
    {
        $attributes = array();
        if ($this->_getAttr($node, 'multiple', '0') == '1') {
            $attributes['multiple'] = 'multiple';
            $attributes['size']     = $this->_getAttr($node, 'size', '10');
            $controlName .= '[]';
        }

        $attributes['class'] = $this->_getAttr($node, 'class', 'inputbox');

        $options = $this->app->html->listOptions($optionsList);

        return $this->app->html->genericList($options, $controlName, $attributes, 'value', 'text', $value);
    }

    /**
     * @param SimpleXMLElement $node
     * @param string           $attrName
     * @param mixed            $default
     * @return bool|string
     */
    protected function _getAttr(SimpleXMLElement $node, $attrName, $default = null)
    {
        $result = $node->attributes()->{$attrName};

        if ($result) {
            return (string)$result;
        }

        return $default;
    }

    /**
     * Get name
     * @param $controlName
     * @param $name
     * @return string
     */
    protected function _getName($controlName, $name)
    {
        return $controlName . '[' . $name . ']';
    }
}
