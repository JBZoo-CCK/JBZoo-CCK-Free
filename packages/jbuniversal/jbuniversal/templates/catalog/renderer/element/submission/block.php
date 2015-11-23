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

$params = $this->app->data->create($params);

// add tooltip
$tooltip = '';
if ($params->get('show_tooltip') && ($description = $element->config->get('description'))) {
	$tooltip = ' class="hasTip" title="'.$description.'"';
}

// create label
$label  = '<strong'.$tooltip.'>';
$label .= $params->get('altlabel') ? $params->get('altlabel') : $element->config->get('name');
$label .= '</strong>';

// create error
$error = '';
if (@$element->error) {
    $error = '<p class="error-message">'.(string) $element->error.'</p>';
}

// create class attribute
$class = 'element element-'.$element->getElementType().($params->get('first') ? ' first' : '').($params->get('last') ? ' last' : '').($params->get('required') ? ' required' : '').(@$element->error ? ' error' : '');

$element->loadAssets();

?>
<div class="<?php echo $class; ?>">
	<?php echo $label.'<div>'.$element->renderSubmission($params).$error.'</div>'; ?>
</div>