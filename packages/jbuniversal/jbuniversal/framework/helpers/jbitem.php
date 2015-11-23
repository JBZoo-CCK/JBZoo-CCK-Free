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

class JBItemHelper extends AppHelper
{
    /**
     * @var string
     */
    protected $_defaultAlign = 'left';

    /**
     * Get align for media position for item
     * @param Item   $item
     * @param string $layout
     * @return string
     */
    public function getMediaAlign(Item $item, $layout)
    {

        $paramName = str_replace('.' . $item->type . '.', '.', $layout);
        $paramName = str_replace('.', '_', $paramName);
        $paramName = 'template.' . $paramName . '_image_align';

        $align = $item->params->get($paramName, false);

        if ($align === false) {
            $align = $item->getApplication()->params->get('global.' . $paramName, $this->_defaultAlign);
        }

        return $align;
    }

    /**
     * Render HTML image form item by elementId
     * @param Item $item
     * @param $elementId
     * @param bool $isLink
     * @return string|null
     */
    public function renderImageFromItem(Item $item, $elementId, $isLink = false)
    {
        if (!$elementId) {
            return null;
        }

        $element = $item->getElement($elementId);
        if (JString::strtolower(get_class($element)) == 'elementjbimage') {

            return $element->render(array(
                'width'    => 50,
                'height'   => 50,
                'template' => 'itemlink',
                'display'  => 'first',
            ));

        } else if (JString::strtolower(get_class($element)) == 'elementimage') {

            return $element->render(array(
                'width'  => 50,
                'height' => 50,
            ));
        }

        return null;
    }
}