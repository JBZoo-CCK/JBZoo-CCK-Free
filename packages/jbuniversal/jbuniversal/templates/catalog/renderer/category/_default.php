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

$this->app->jbdebug->mark('layout::category::start');

// set vars
$category   = $vars['object'];
$title      = $this->app->string->trim($vars['params']->get('content.category_title',    ''));
$subTitle   = $this->app->string->trim($vars['params']->get('content.category_subtitle', ''));
$image      = $this->app->jbimage->get('category_image', $vars['params']);

if (!$title) {
    $title = $category->name;
}

?>
<?php if ((int)$vars['params']->get('template.category_show', 1)) : ?>
    <div class="category rborder alias-<?php echo $category->alias;?>">

        <h1 class="title"><?php echo $title; ?></h1>

        <?php if ((int)$vars['params']->get('template.category_subtitle', 1) && !empty($subTitle)) : ?>
            <h2 class="subtitle"><?php echo $subTitle; ?></h2>
        <?php endif; ?>


        <?php if ((int)$vars['params']->get('template.category_image', 1) && $image['src']) : ?>
            <div class="image-full align-<?php echo $vars['params']->get('template.category_image_align', 'left');?>">
                <img src="<?php echo $image['src']; ?>" <?php echo $image['width_height']; ?>
                     title="<?php echo $category->name; ?>" alt="<?php echo $category->name; ?>" />
            </div>
        <?php endif; ?>


        <?php if ((int)$vars['params']->get('template.category_teaser_text', 1)
                && $vars['params']->get('content.category_teaser_text', '')) :
        ?>
            <div class="description-teaser">
                <?php echo $vars['params']->get('content.category_teaser_text', ''); ?>
            </div>
        <?php endif; ?>


        <?php if ((int)$vars['params']->get('template.category_text', 1) && $category->description) : ?>
            <div class="description-full"><?php echo $category->getText($category->description); ?></div>
        <?php endif; ?>

        <div class="clr clear"></div>

    </div>

<?php else: ?>
    <div class="alias-<?php echo $category->alias;?>">
        <h1 class="title"><?php echo $title; ?></h1>
    </div>

<?php endif; ?>

<?php
$this->app->jbdebug->mark('layout::category::finish');