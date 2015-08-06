<?php

namespace yii\imperavi;
use yii\web\AssetBundle;

class ImagemanagerImperaviRedactorPluginAsset extends AssetBundle
{
    public $js = [
        'imagemanager.js'
    ];
    public $css = [

    ];
    public $depends = [
        'yii\imperavi\ImperaviRedactorAsset'
    ];
    public function init()
    {
        $this->sourcePath = __DIR__."/assets/plugins/imagemanager";
        parent::init();
    }
}