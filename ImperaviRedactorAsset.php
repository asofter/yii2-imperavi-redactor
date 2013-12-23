<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\imperavi;
use yii\web\AssetBundle;

/**
 * @author Alexander Yaremchuk <alwex10@gmail.com>
 * @since 1.0
 */
class ImperaviRedactorAsset extends AssetBundle
{
    public $sourcePath = '@yii/imperavi/assets';
    public $js = [
        'redactor.js',
        //'lang/es.js'
    ];
    public $css = [
        'redactor.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
