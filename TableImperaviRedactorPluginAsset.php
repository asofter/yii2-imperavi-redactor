<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\imperavi;
use yii\web\AssetBundle;


class TableImperaviRedactorPluginAsset extends AssetBundle
{
    public $js = [
        'table.js',
    ];

    public $css = [

    ];
    public $depends = [
        'yii\imperavi\ImperaviRedactorAsset'
    ];
    public function init()
    {
        $this->sourcePath = __DIR__."/assets/plugins/table";
        parent::init();
    }
}