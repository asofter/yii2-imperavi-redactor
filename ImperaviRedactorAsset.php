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
    public $language;
    public $sourcePath = '@yii/imperavi/assets';
    public $js = [
        'redactor.js'
    ];
    public $css = [
        'redactor.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function registerAssetFiles($view) {
        $appLanguage = strtolower(substr(Yii::$app->language , 0, 2)); //First 2 letters

        //check if the language configured or use appLanguage instead
        $language = $this->language ? $this->language : $appLanguage;
        $languageJs = 'lang/' . $language . '.js';
        if($language != 'en'){
            $this->js[] = $languageJs;
        }
        
        parent::registerAssetFiles($view);
    }
}
