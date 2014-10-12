<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\imperavi;
use yii\web\AssetBundle;


class VideoImperaviRedactorPluginAsset extends AssetBundle
{
    public $sourcePath = '@yii/imperavi/assets/plugins/video';

    public $js = [
        'video.js',
    ];

    public $css = [

    ];
    public $depends = [
        'yii\imperavi\ImperaviRedactorAsset'
    ];

}