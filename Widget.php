<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\imperavi-redactor;

use Yii;
use yii\helpers\Json;

/**
 * Imperavi Redactor Widget For Yii2 class file.
 *
 * @property array $plugins
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 * @author Alexander Yaremchuk <alwex10@gmail.com>
 *
 * @version 1.0
 *
 * @link https://github.com/asofter/yii2-imperavi-redactor
 * @link http://imperavi.com/redactor
 * @license https://github.com/yiiext/imperavi-redactor-widget/blob/master/license.md
 */

class Widget extends \yii\base\Widget
{
    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $options = [];
    /**
     * @var array the options for the underlying Bootstrap JS plugin.
     * Please refer to the corresponding [Imperavi Web page](http://imperavi.com/redactor/docs/)  for possible options.
     */
    public $clientOptions = [];

    /**
     * @var array
     */
    private $_plugins = array();

    /*
     * @var object model for active text area
     */
    public $model = null;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->selector = '#' . $this->getId();

        if (!is_null($this->model)) {
            echo Html::activeTextArea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textArea($this->name, $this->value, $this->options);
        }

        ImperaviRedactorAsset::register($this->getView());
    }

    /**
     * Register CSS and Script.
     */
    protected function registerClientScript()
    {
        // Append language file to script package.
       /* if (isset($this->options['lang']) && $this->options['lang'] !== 'en') {
            $this->package['js'][] = 'lang/' . $this->options['lang'] . '.js';
        }*/

        // Add assets url to relative css.
        /*if (isset($this->options['css'])) {
            if (!is_array($this->options['css'])) {
                $this->options['css'] = array($this->options['css']);
            }
            foreach ($this->options['css'] as $i => $css) {
                if (strpos($css, '/') === false) {
                    $this->options['css'][$i] = $this->getAssetsUrl() . '/' . $css;
                }
            }
        }*/

        // Insert plugins in options
        if (!empty($this->_plugins)) {
            $this->options['plugins'] = array_keys($this->_plugins);
        }

        /*
        $clientScript = Yii::app()->getClientScript();
        $selector = CJavaScript::encode($this->selector);
        $options = CJavaScript::encode($this->options);

        $clientScript
            ->addPackage(self::PACKAGE_ID, $this->package)
            ->registerPackage(self::PACKAGE_ID)
            ->registerScript(
                $this->id,
                'jQuery(' . $selector . ').redactor(' . $options . ');',
                CClientScript::POS_READY
            );

        foreach ($this->getPlugins() as $id => $plugin) {
            $clientScript
                ->addPackage(self::PACKAGE_ID . '-' . $id, $plugin)
                ->registerPackage(self::PACKAGE_ID . '-' . $id);
        }*/
    }

    /**
     * Registers a specific Imperavi plugin and the related events
     * @param string $name the name of the Imperavi plugin
     */
    protected function registerPlugin($name)
    {
        $view = $this->getView();

        ImperaviRedactorAsset::register($view);

        $id = $this->options['id'];

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
            $js = "jQuery('#$id').$name($options);";
            $view->registerJs($js);
        }

        if (!empty($this->clientEvents)) {
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }
            $view->registerJs(implode("\n", $js));
        }
    }

    /**
     * @param array $plugins
     */
    public function setPlugins(array $plugins)
    {
        foreach ($plugins as $id => $plugin) {
            if (!isset($plugin['baseUrl']) && !isset($plugin['basePath'])) {
                $plugin['baseUrl'] = $this->getAssetsUrl() . '/plugins/' . $id;
            }

            $this->_plugins[$id] = $plugin;
        }
    }

    /**
     * @return array
     */
    public function getPlugins()
    {
        return $this->_plugins;
    }
}