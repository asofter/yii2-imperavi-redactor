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
 * @since 1.4
 */
class TextdirectionImperaviRedactorPluginAsset extends AssetBundle
{
    public $js = [
        'textdirection.js'
    ];
    public $css = [

    ];
    public $depends = [
        'yii\imperavi\ImperaviRedactorAsset'
    ];
    public function init()
    {
        $this->sourcePath = __DIR__."/assets/plugins/textdirection";
        parent::init();
    }
}