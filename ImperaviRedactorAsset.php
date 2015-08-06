<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\imperavi;
use Yii;
use yii\web\AssetBundle;

/**
 * @author Alexander Yaremchuk <alwex10@gmail.com>
 * @since 2.0.1
 */
class ImperaviRedactorAsset extends AssetBundle
{
    public $js = [
        'redactor.js'
    ];
    public $css = [
        'redactor.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init() {

        $this->sourcePath = __DIR__."/assets";
        $appLanguage = strtolower(substr(Yii::$app->language , 0, 2)); //First 2 letters

        if($appLanguage != 'en')
            $this->js[] = 'lang/' . $appLanguage . '.js';

        parent::init();
    }
}
