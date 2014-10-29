Imperavi Redactor 10.0.2 Widget For Yii2
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
