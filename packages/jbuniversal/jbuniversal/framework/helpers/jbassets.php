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

class JBAssetsHelper extends AppHelper
{
    /**
     * @var JDocumentHTML
     */
    protected $_document = null;

    /**
     * @var int
     */
    protected $_isCaching = null;

    /**
     * Constructor
     * @param $app
     */
    public function __construct($app)
    {
        parent::__construct($app);
        $this->_document  = JFactory::getDocument();
        $this->_isCaching = $this->app->jbcache->isEnabled();
    }

    /**
     * Set application styles files
     * @param string $alias
     */
    public function setAppCss($alias)
    {
        $this->_include(array(
            'jbassets:css/jbzoo.css',
            'jbassets:css/jbzoo.' . $alias . '.css'
        ), 'css');
    }

    /**
     * Add script and styles for back-end
     */
    public function admin()
    {
        $this->jQuery();
        $this->_include(array('jbassets:css/admin.css',), 'css');
        $this->_include(array('jbassets:js/admin.js'), 'js');
    }

    /**
     * Set application JavaScript files
     * @param string $alias
     */
    public function setAppJS($alias)
    {
        $this->jQuery();
        $this->_include(array(
            'jbassets:js/jbzoo.js',
            'jbassets:js/jbzoo.' . $alias . '.js'
        ), 'js');
    }

    /**
     * Init filter assets
     * @param $alias
     */
    public function filter($alias = 'default')
    {
        $this->jQuery();
        $this->_include(array(
            'jbassets:js/jbzoo.js',
            'jbassets:js/jbzoo.filter.js',
            'jbassets:js/jbzoo.filter.' . $alias . '.js'
        ), 'js');

        $this->_include(array(
            'jbassets:css/jbzoo.css',
            'jbassets:css/jbzoo.filter.css',
            'jbassets:css/jbzoo.filter.' . $alias . '.css'
        ), 'css');
    }

    /**
     * Init filter assets
     * @param $alias
     */
    public function filterprops($alias = 'default')
    {
        $this->jQuery();
        $this->_include(array(
            'jbassets:js/jbzoo.js',
            'jbassets:js/jbzoo.filter.js',
            'jbassets:js/jbzoo.filter.' . $alias . '.js'
        ), 'js');

        $this->_include(array(
            'jbassets:css/jbzoo.css',
            'jbassets:css/jbzoo.filter.css',
            'jbassets:css/jbzoo.filter.' . $alias . '.css'
        ), 'css');
    }

    /**
     * Init filter autocomplete
     */
    public function filterAutocomplete()
    {
        $this->jQuery();

        $this->_include(array(
            'jbassets:css/libraries.css'
        ), 'css');

        $this->_include(array(
            'jbassets:js/jquery.autocomplete.min.js'
        ), 'js');
    }

    /**
     * Include jQuery UI lib
     */
    public function jQueryUI()
    {
        $this->jQuery();

        $this->_include(array(
            'libraries:jquery/jquery-ui.custom.min.js'
        ), 'js');

        $this->_include(array(
            'libraries:jquery/jquery-ui.custom.css',
        ), 'css');
    }

    /**
     * Include fancybox lib
     */
    public function fancybox()
    {
        $this->jQuery();

        $this->_include(array(
            'jbassets:css/libraries.css'
        ), 'css');

        $this->_include(array(
            'jbassets:js/jquery.mousewheel.min.js',
            'jbassets:js/jquery.easing.min.js',
            'jbassets:js/jquery.fancybox.min.js'
        ), 'js');
    }

    /**
     * Include table sorter lib
     */
    public function tablesorter()
    {
        $this->jQuery();

        $this->_include(array(
            'jbassets:css/libraries.css'
        ), 'css');

        $this->_include(array(
            'jbassets:js/jquery.tablesorter.min.js'
        ), 'js');
    }

    /**
     * Include chosen lib
     */
    public function chosen()
    {
        $this->jQuery();

        $this->_include(array(
            'jbassets:css/libraries.css'
        ), 'css');

        $this->_include(array(
            'jbassets:js/jquery.chosen.min.js'
        ), 'js');
    }

    /**
     * Include datepicker lib
     */
    public function datepicker()
    {
        $this->jQueryUI();

        $this->_include(array(
            'libraries:jquery/plugins/timepicker/timepicker.js'
        ), 'js');

        $this->_include(array(
            'libraries:jquery/plugins/timepicker/timepicker.css',
        ), 'css');
    }

    /**
     * Include datepicker lib
     */
    public function nivoslider()
    {
        $this->jQuery();

        $this->_include(array(
            'jbassets:js/jquery.nivo.slider.min.js'
        ), 'js');

        $this->_include(array(
            'jbassets:css/libraries.css'
        ), 'css');
    }

    /**
     * Include jQuery framework
     */
    public function jQuery()
    {
        static $isAdded;

        if (!isset($isAdded)) {
            $isAdded = true;
            $this->_include(array('libraries:jquery/jquery.js'), 'js');
        }
    }

    /**
     * Include basket script
     */
    public function basket()
    {
        $this->jQuery();
        $this->_include(array('jbassets:js/jquery.basket.min.js'), 'js');
    }

    /**
     * Include jQuery compare
     */
    public function jQueryCompare()
    {
        $this->jQuery();
        $this->_include(array('jbassets:js/jquery.compare.min.js'), 'js');
    }

    /**
     * Init jbzoo compare
     */
    public function initJBCompare()
    {
        static $isAdded;

        $this->jQuery();
        $this->jQueryCompare();

        if (!isset($isAdded)) {
            $isAdded = true;
            $this->addScript('jQuery(function($){ $(".jbzoo .jsJBZooCompare").JBCompareButtons(); });');
        }
    }

    /**
     * Include jQuery favorite
     */
    public function jQueryFavorite()
    {
        $this->_include(array('jbassets:js/jquery.favorite.min.js'), 'js');
    }

    /**
     * Init jbzoo favorite
     */
    public function initJBFavorite()
    {
        static $isAdded;

        $this->jQuery();
        $this->jQueryFavorite();

        if (!isset($isAdded)) {
            $isAdded = true;
            $this->addScript('jQuery(function($){ $(".jbzoo .jsJBZooFavorite").JBFavoriteButtons(); });');
        }
    }

    /**
     * Assets for payment page
     */
    public function payment()
    {

    }

    /**
     * Init jqueryui autocomplete
     */
    public function jbimagePopup()
    {
        static $isAdded;

        $this->jQuery();
        $this->fancybox();

        if (!isset($isAdded)) {
            $isAdded = true;
            $this->addScript('jQuery(function($){
                $("a.jbimage-link[rel=jbimage-popup], a.jbimage-gallery").fancybox({
                    "helpers" : {
                        "title"  : { type : "outside" },
                        "buttons": { position:"top" },
                        "thumbs" : { width :80, height:80 }
                    }
                });
            });');
        }
    }

    /**
     * Height fix for items columns
     */
    public function heightFix()
    {
        static $isAdded;

        $this->jQuery();

        if (!isset($isAdded)) {
            $isAdded = true;
            $this->addScript('jQuery(function($){
                setTimeout(function(){
                    var maxHeight = tmpHeight = 0;
                    $(".jbzoo .items .column").each(function(n, obj){
                        var tmpHeight = parseInt($(obj).height(), 10);
                        if (maxHeight < tmpHeight) {
                            maxHeight = tmpHeight;
                        }
                    }).css({height:maxHeight});

                    var maxHeight = tmpHeight = 0;
                    $(".jbzoo .subcategories .column").each(function(n, obj){
                        var tmpHeight = parseInt($(obj).height(), 10);
                        if (maxHeight < tmpHeight) {
                            maxHeight = tmpHeight;
                        }
                    }).css({height:maxHeight});

                    var maxHeight = tmpHeight = 0;
                    $(".jbzoo .related-items .column").each(function(n, obj){
                        var tmpHeight = parseInt($(obj).height(), 10);
                        if (maxHeight < tmpHeight) {
                            maxHeight = tmpHeight;
                        }
                    }).css({height:maxHeight});
                }, 300);
            });');
        }
    }

    /**
     * Add to script
     */
    public function addRootUrl()
    {
        static $isAdded;
        if (!isset($isAdded)) {
            $isAdded = true;
            $this->addVar('JB_URL_ROOT', JURI::root());
        }
    }

    /**
     * Add global variable to javascript
     * @param $varName
     * @param $value
     */
    public function addVar($varName, $value)
    {
        $this->addScript('var ' . $varName . ' = ' . json_encode($value) . ';');
    }

    /**
     * Init select cascade
     */
    public function initSelectCascade()
    {
        $this->_include(array('jbassets:js/jquery.jbselectcascade.js'), 'js');
    }

    /**
     * Init script for JBCascadeSelect
     * @param string $uniqid
     * @param string $itemList
     */
    public function initJBCascadeSelect($uniqid, $itemList)
    {
        static $isAdded;
        $this->jQuery();

        if (!isset($isAdded)) {
            $isAdded = array();
        }

        if (!isset($isAdded[$uniqid])) {

            $this->addScript('jQuery(function($){
                $(".jbcascadeselect-wrapper.jbcascadeselect-' . $uniqid . '").JBCascadeSelect({
                    "items": ' . json_encode($itemList) . ',
                    "uniqid" : "' . $uniqid . '"
                });
            });');

            $isAdded[$uniqid] = true;
        }
    }

    /**
     * Init jqueryui autocomplete
     */
    public function initAutocomplete()
    {
        static $isAdded;

        $this->jQuery();
        $this->jQueryUI();

        if (!isset($isAdded)) {
            $isAdded = true;
            $this->addScript('jQuery(function($){
                $(".jbzoo .jsAutocomplete").each(function (n, obj) {
                    var $input = $(obj);
                    $input.autocomplete({
                        minLength: 2,
                        source: function( request, response ) {
                            var term = request.term;
                            lastXhr = $.getJSON("' . $this->app->jbrouter->autocomplete() . '",
                                {
                                    "name"  : $input.attr("name"),
                                    "value" : term,
                                    "app_id": $(".jbzoo .jsApplicationId").val(),
                                    "type"  : $(".jbzoo .jsItemType").val()
                                },
                                function(data, status, xhr) {
                                    $input.removeClass("ui-autocomplete-loading");
                                    response(data);
                                }
                            );
                        }
                    });
                });
            })');
        }
    }

    /**
     * jQuery accordion lib init
     */
    public function jqueryAccordion()
    {
        static $isAdded;

        $this->jQuery();
        $this->jQueryUI();

        if (!isset($isAdded)) {
            $isAdded = true;
            $this->addScript('jQuery(function($){
                $(".jbzoo .jsAccordion").each(function(n, obj){
                    var $obj = $(obj),
                        id   = "accordion-" + n;
                    $obj.attr("id", id);
                    $("#" + id).accordion({
                        heightStyle: "content"
                    });
                });
            })');
        }
    }

    /**
     * Init price widget
     */
    public function initJBPrice()
    {
        static $isAdded;

        $this->jQuery();
        $this->_include(array('jbassets:js/jquery.jbzooprice.min.js'), 'js');

        if (!isset($isAdded)) {
            $isAdded = true;
            $this->addScript('jQuery(function($){ $(".jbzoo .jsPrice").JBZooPrice(); });');
        }
    }

    /**
     * Add script to document
     * @param string $script
     */
    public function addScript($script)
    {
        if (!$this->app->jbrequest->isAjax()) {
            $this->_document->addScriptDeclaration("\n" . $script);
        }

    }

    /**
     * Get site root URL
     * @return string
     */
    public function _getRoot()
    {
        static $root;

        if (!isset($root)) {
            $jUri = JURI::getInstance();
            $root = $jUri->getScheme() . '://' . $jUri->getHost() . '/';
            $root = '/';
        }

        return $root;
    }

    /**
     * Include files to document
     * @param array $files
     * @param       $type
     */
    protected function _include(array $files, $type)
    {
        static $includedFiles;

        if (!isset($includedFiles)) {
            $includedFiles = array();
        }

        if (count($files) && !$this->app->jbrequest->isAjax()) {
            foreach ($files as $file) {

                $isExternal = strpos($file, 'http') !== false;

                $filePath = $file;
                if (!$isExternal) {
                    $fullPath = $this->app->path->path($file);
                    $filePath = $this->app->path->url($file);
                }

                if ($filePath) {

                    if (!$isExternal) {
                        $filePath = $filePath . '?ver=' . date("Ymd", filemtime($fullPath));
                        $filePath = $this->_getRoot() . $this->app->path->relative($filePath);
                    }

                    if ($type == 'css') {
                        $this->_document->addStylesheet($filePath);

                    } elseif ($type == 'js') {
                        $this->_document->addScript($filePath);
                    }

                }
            }
        }
    }
}
