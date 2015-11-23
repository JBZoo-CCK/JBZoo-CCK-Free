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

class JBRouterHelper extends AppHelper
{

    /**
     * Filter link
     * @param string     $identifier
     * @param string     $value
     * @param JParameter $moduleParams
     * @param int        $mode
     * @return string
     */
    public function filter($identifier, $value, $moduleParams, $mode = 0)
    {
        $urlParams = array(
            'option'     => 'com_zoo',
            'controller' => 'search',
            'task'       => 'filter',
            'app_id'     => $moduleParams->get('application'),
            'Itemid'     => $moduleParams->get('menuitem'),
            'type'       => $moduleParams->get('type'),
            'limit'      => $moduleParams->get('limit', 10),
            'exact'      => 1,
        );

        if ($mode == 0) {
            $urlParams['e'][$identifier] = $value;

        } elseif ($mode == 1) {
            $urlParams['e']              = $this->app->jbrequest->getElements();
            $urlParams['e'][$identifier] = $value;

        } elseif ($mode == 2) {
            $urlParams['e'] = $this->app->jbrequest->getElements();
            unset($urlParams['e'][$identifier]);
        }

        return $this->_url($urlParams);
    }

    /**
     * Autocomplete link
     * @param array $params
     * @return string
     */
    public function autocomplete(array $params = array())
    {
        $urlParams = array(
            'option'     => 'com_zoo',
            'controller' => 'autocomplete',
            'task'       => 'index',
            'tmpl'       => 'raw',
        );

        $urlParams = array_merge($urlParams, $params);

        return 'index.php?' . http_build_query($urlParams);
    }

    /**
     * Element ajax call
     * @param string $identifier
     * @param int    $itemId
     * @param string $method
     * @param array  $params
     * @return string
     */
    public function element($identifier = null, $itemId = null, $method = 'ajax', array $params = array())
    {
        $linkParams = array(
            'option'     => 'com_zoo',
            'controller' => 'default',
            'task'       => 'callelement',
            'format'     => 'raw',
            'element'    => $identifier,
            'method'     => $method,
            'item_id'    => $itemId,
        );

        if (!empty($params)) {
            $linkParams['args'] = $params;
        }

        return $this->_url($linkParams, true);
    }

    /**
     * Compare link
     * @param int    $menuItemid
     * @param string $layout
     * @param string $itemType
     * @param int    $appId
     * @return string
     */
    public function compare($menuItemid, $layout = 'v', $itemType = null, $appId = null)
    {
        $itemType = ($itemType) ? $itemType : $this->app->jbrequest->get('type');
        $appId    = ($appId) ? $appId : (int)$this->app->jbrequest->get('app_id');

        $linkParams = array(
            'option'     => 'com_zoo',
            'controller' => 'compare',
            'task'       => 'compare',
            'app_id'     => (int)$appId,
            'type'       => $itemType,
            'layout'     => $layout,
            'Itemid'     => (int)$menuItemid,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Favorite link
     * @param int    $menuItemid
     * @param int    $appId
     * @return string
     */
    public function favorite($menuItemid, $appId = null)
    {
        $appId = ($appId) ? $appId : (int)$this->app->jbrequest->get('app_id');

        $linkParams = array(
            'option'     => 'com_zoo',
            'controller' => 'favorite',
            'task'       => 'favorite',
            'app_id'     => (int)$appId,
            'Itemid'     => (int)$menuItemid,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Favorite remove item link
     * @param int $itemId
     * @param int $appId
     * @return string
     */
    public function favoriteRemoveItem($itemId, $appId = null)
    {
        $appId = ($appId) ? $appId : (int)$this->app->jbrequest->get('app_id');

        $linkParams = array(
            'option'     => 'com_zoo',
            'controller' => 'favorite',
            'task'       => 'remove',
            'app_id'     => (int)$appId,
            'item_id'    => (int)$itemId,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Url for clear compare items
     * @param      $menuItemid
     * @param null $itemType
     * @param null $appId
     * @return string
     */
    public function compareClear($menuItemid, $itemType = null, $appId = null)
    {
        $itemType = ($itemType) ? $itemType : $this->app->jbrequest->get('type');
        $appId    = ($appId) ? $appId : (int)$this->app->jbrequest->get('app_id');

        $linkParams = array(
            'option'      => 'com_zoo',
            'controller'  => 'compare',
            'task'        => 'clear',
            'app_id'      => (int)$appId,
            'type'        => $itemType,
            'Itemid'      => (int)$menuItemid,
            'back_itemid' => (int)$menuItemid,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Get url to basket
     * @param int  $menuItemid
     * @param null $appId
     * @return string
     */
    public function basket($menuItemid, $appId = null)
    {
        $appId = ($appId) ? $appId : (int)$this->app->jbrequest->get('app_id');

        $linkParams = array(
            'option'     => 'com_zoo',
            'controller' => 'basket',
            'task'       => 'index',
            'app_id'     => (int)$appId,
            'Itemid'     => (int)$menuItemid,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Get url to success order
     * @param int  $menuItemid
     * @param null $appId
     * @return string
     */
    public function basketSuccess($menuItemid, $appId = null)
    {
        $appId = ($appId) ? $appId : (int)$this->app->jbrequest->get('app_id');

        $linkParams = array(
            'option'     => 'com_zoo',
            'controller' => 'basket',
            'task'       => 'index',
            'app_id'     => (int)$appId,
            'Itemid'     => (int)$menuItemid,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Get url to success order
     * @param $menuItemid
     * @param $appId
     * @param $itemId
     * @return string
     */
    public function basketPayment($menuItemid, $appId, $itemId)
    {
        $appId = ($appId) ? $appId : (int)$this->app->jbrequest->get('app_id');

        $linkParams = array(
            'option'     => 'com_zoo',
            'controller' => 'payment',
            'task'       => 'index',
            'app_id'     => (int)$appId,
            'Itemid'     => (int)$menuItemid,
            'order_id'   => $itemId,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Get url to basket
     * @param int $appId
     * @return string
     */
    public function basketDelete($appId = null)
    {
        $appId = ($appId) ? $appId : (int)$this->app->jbrequest->get('app_id');

        $linkParams = array(
            'option'     => 'com_zoo',
            'controller' => 'basket',
            'task'       => 'delete',
            'app_id'     => (int)$appId,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Get url to basket clear action
     * @param int $appId
     * @return string
     */
    public function basketClear($appId = null)
    {
        $appId = ($appId) ? $appId : (int)$this->app->jbrequest->get('app_id');

        $linkParams = array(
            'option'     => 'com_zoo',
            'controller' => 'basket',
            'task'       => 'clear',
            'app_id'     => (int)$appId,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Get url to basket quantity action
     * @param int $appId
     * @return string
     */
    public function basketQuantity($appId = null)
    {
        $appId = ($appId) ? $appId : (int)$this->app->jbrequest->get('app_id');

        $linkParams = array(
            'option'     => 'com_zoo',
            'controller' => 'basket',
            'task'       => 'quantity',
            'app_id'     => (int)$appId,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Get item url for back-end
     * @param Item $item
     * @return string
     */
    public function adminItem(Item $item)
    {
        $linkParams = array(
            'option'     => $this->app->component->self->name,
            'controller' => 'item',
            'changeapp'  => $item->application_id,
            'task'       => 'edit',
            'cid[]'      => $item->id,
        );

        return $this->_url($linkParams, true, JURI::root() . 'administrator/index.php');
    }

    /**
     * Link to auth
     * @param null $return
     * @return string
     */
    public function auth($return = null)
    {
        $linkParams = array(
            'option' => 'com_users',
            'task'   => 'login',
            'return' => $return,
        );

        return $this->_url($linkParams, true);
    }

    /**
     * Get url by params
     * @param array  $params
     * @param bool   $zooRoute
     * @param string $base
     * @return string
     */
    private function _url(array $params = array(), $zooRoute = false, $base = 'index.php')
    {
        foreach ($params as $key => $param) {
            if (is_null($param)) {
                unset($params[$key]);
            }
        }

        if ($zooRoute) {
            return $this->app->link($params, false);
        } else {
            return JRoute::_($base . '?' . http_build_query($params), true);
        }
    }
}
