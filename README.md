Imperavi Redactor Widget For Yii2
=======================

Created for [Tourista](http://tourista.me)

`ImperaviRedactorWidget` is a wrapper for [Imperavi Redactor](http://imperavi.com/redactor/),
a high quality WYSIWYG editor.

Note that Imperavi Redactor itself is a proprietary commercial copyrighted software
but since Yii community bought OEM license you can use it for free with Yii.

Using model

```php
yii\imperavi\Widget::widget([
	// You can either use it for model attribute
	'model' => $my_model,
	'attribute' => 'my_field',

	// or just for input field
	'name' => 'my_input_name',

	// Some options, see http://imperavi.com/redactor/docs/
	'options' => [
		'toolbar' => false,
		'css' => 'wym.css',
	],
]);
```

Alternatively you can attach Redactor to already existing DOM element by calling:

```php
yii\imperavi\Widget::widget([
	// Some options, see http://imperavi.com/redactor/docs/
	'options' => [],
]);
```

The redactor plugins plugged in with packages of resources.

```php
yii\imperavi\Widget::widget([
	'options' => [
		'lang' => 'ru',
	],
	'plugins' => [
		'fullscreen',
		'clips'
	]
]);
```

Using upload actions

```
 1. Use your controller actions() method, e.g.:
    public function actions()
    {
        $path = "/files/".$this->module->id."/".$this->id."/".Yii::$app->user->id;
        return [
            'file-upload'    => [
                'class'         => 'yii\imperavi\actions\FileUpload',
                'uploadPath'    => Yii::getAlias('@app/web'.$path),
                'uploadUrl'     => $path
            ],
            'image-upload'    => [
                'class'         => 'yii\imperavi\actions\ImageUpload',
                'uploadPath'    => Yii::getAlias('@app/web'.$path),
                'uploadUrl'     => $path
            ],
            'image-list'    => [
                'class'         => 'yii\imperavi\actions\ImageList',
                'uploadPath'    => Yii::getAlias('@app/web'.$path),
                'uploadUrl'     => $path
            ],
        ];
    }
 2. Set upload options in your imperavi widget, e.g.:
    'fileUpload' => Url::toRoute(['file-upload', 'attr'=>'content']),
    'imageUpload' => Url::toRoute(['image-upload', 'attr'=>'content']),
    'imageGetJson' => Url::toRoute(['image-list', 'attr'=>'content']),
    'imageUploadErrorCallback'  => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
    'fileUploadErrorCallback'  => new \yii\web\JsExpression('function(json) { alert(json.error); }'),

 * You can also redefine action 'customRules' attribute for file validation.
```

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require asofter/yii2-imperavi-redactor "*"
```

or add

```
"asofter/yii2-imperavi-redactor": "*"
```

to the require section of your `composer.json` file.
