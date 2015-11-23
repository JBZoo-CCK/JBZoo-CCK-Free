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

// create label
$label = '';
if (isset($params['showlabel']) && $params['showlabel']) {
    $label = ($params['altlabel']) ? $params['altlabel'] : $element->getConfig()->get('name');
    $labelTag = isset($params['labelTag']) ? $params['labelTag'] : 'strong';

    $labelClass = array(
        'element-label',
        'element-label-' . $element->getElementType()
    );

    $label = '<' . $labelTag . ' class="' . implode(' ', $labelClass) . '"> ' . $label . '</' . $labelTag . '> ';
}

// check tag name
$tag = isset($params['tag']) ? $params['tag'] : 'div';

// create class attribute
if (!isset($classes)) {
    $classes = array();
}

// basic element classes
$classes = array_merge(
    $classes,
    array(
        'element-' . $element->getElementType(),
        str_replace('.', '-', $layout)
    )
);

// is first element in position
if ($params['first']) {
    $classes[] = 'first';
}

// is last element in position
if ($params['last']) {
    $classes[] = 'last';
}

// custom classes
if (isset($params['class']) && $params['class']) {
    $classes[] = $params['class'];
}

// add clear after html
$clear = '';
if (isset($params['clear']) && $params['clear']) {
    $clear = '<div class="clear clr"></div>';
}

// render result HTML
echo '<' . $tag . ' class="' . implode(' ', $classes) . '">'
    . $label
    . ' ' . $element->render($params)
    . '</' . $tag . '>'
    . "\n" . $clear;
