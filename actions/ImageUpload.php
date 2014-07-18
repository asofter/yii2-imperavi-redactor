<?php

namespace yii\imperavi\actions;

use yii\base\Action;
use \yii\web\UploadedFile;
use \yii\web\HttpException;

/**
 * Redactor widget image upload action.
 *
 * @param string $attr Model attribute
 * @throws HttpException
 */
class ImageUpload extends Action 
{
    public $uploadPath;
    public $uploadUrl;
    public $uploadCreate = false;
    public $permissions = 0774;

    public function run($attr) 
    {
        $name = strtolower($this->controller->id);
        $attribute = strtolower((string) $attr);

        if ($this->uploadPath === null) {
            $path = \Yii::$app->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads';
            $this->uploadPath = realpath($path);
            if ($this->uploadPath === false && $this->uploadCreate === true) {
                if (!mkdir($path, $this->permissions, true)) {
                    throw new HttpException(500, json_encode(
                        array('error' => 'Could not create upload folder "' . $path . '".')
                    ));
                }
            }
        }
        if ($this->uploadUrl === null) {
            $this->uploadUrl = \Yii::$app->request->baseUrl . '/uploads';
        }

        // Make Yii think this is a AJAX request.
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';

        $file = UploadedFile::getInstanceByName('file');
        if ($file instanceof UploadedFile) {
            $attributePath = $this->uploadPath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $attribute;
            if (!in_array(strtolower($file->extension), array('gif', 'png', 'jpg', 'jpeg'))) {
                throw new HttpException(500, json_encode(
                    array('error' => 'Invalid file extension ' . $file->extension . '.')
                ));
            }
            $fileName = trim(md5($attribute . time() . uniqid(rand(), true))) . '.' . $file->extension;
            if (!is_dir($attributePath)) {
                if (!mkdir($attributePath, $this->permissions, true)) {
                    throw new HttpException(500, json_encode(
                        array('error' => 'Could not create folder "' . $attributePath . '". Make sure "uploads" folder is writable.')
                    ));
                }
            }
            $path = $attributePath . DIRECTORY_SEPARATOR . $fileName;
            if (file_exists($path) || !$file->saveAs($path)) {
                throw new HttpException(500, json_encode(
                    array('error' => 'Could not save file or file exists: "' . $path . '".')
                ));
            }
            $attributeUrl = $this->uploadUrl . '/' . $name . '/' . $attribute . '/' . $fileName;
            $data = array(
                'filelink' => $attributeUrl,
            );
            echo json_encode($data);
            exit;
        } else {
            throw new HttpException(500, json_encode(
                    array('error' => 'Could not upload file.')
            ));
        }
    }

}
