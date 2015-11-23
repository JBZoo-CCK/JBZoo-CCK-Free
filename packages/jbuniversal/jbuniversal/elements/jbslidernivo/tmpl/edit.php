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

$id = 'elements[' . $element . ']';
?>

<div id="<?php echo $id; ?>">

    <div class="row">
        <?php echo $this->app->html->_(
        'control.selectdirectory', $directory, false, 'elements[' . $element . '][value]', $value
    ); ?>
    </div>

</div>