<?php
/**
 * ImageUpload class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace yii\imperavi\actions;

/**
 * Image upload controller action.
 * See FileUpload docs.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class ImageUpload extends FileUpload
{
    /**
     * @inheritdoc
     */
    public $customRules = [
        [['file'], 'image', 'notImage' => 'Not an image', 'skipOnError' => false, 'skipOnEmpty' => false, 'maxSize' => 10000000]
    ];
}