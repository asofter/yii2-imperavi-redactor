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
class FontfamilyImperaviRedactorPluginAsset extends AssetBundle
{
    public $js = [
        'fontfamily.js'
    ];
    public $css = [

    ];
    public $depends = [
        'yii\imperavi\ImperaviRedactorAsset'
    ];
    public function init()
    {
        $this->sourcePath = __DIR__."/assets/plugins/fontfamily";
        parent::init();
    }
}