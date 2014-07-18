<?php

namespace yii\imperavi\actions;

use yii\base\Action;
use \yii\web\UploadedFile;
use \Yii;
use \yii\web\HttpException;

/**
 * Redactor widget file upload action.
 *
 * @param string $attr Model attribute
 * @throws HttpException
 */
class FileUpload extends Action {

    public $uploadPath;
    public $uploadUrl;
    public $uploadCreate = false;
    public $permissions = 0774;

    public function run($attr) {
        $name = strtolower($this->controller->id);
        $attribute = strtolower((string) $attr);
        if (!$file = UploadedFile::getInstanceByName('file')) {
            throw new HttpException(500, json_encode(
                array('error' => 'Could not upload file.')
            ));
        }
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
        $attributePath = $this->uploadPath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $attribute;
        $fileName = $this->sanitizeFilename($file->name);
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
            'filename' => $fileName,
        );
        echo json_encode($data);
        exit;
    }

    protected function sanitizeFilename($name) {
        // char replace table found at: http://www.php.net/manual/en/function.strtr.php#98669
        $replaceChars = array(
            'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f'
        );
        $name = strtr($name, $replaceChars);
        // convert & to "and", @ to "at", and # to "number"
        $name = preg_replace(array('/[\&]/', '/[\@]/', '/[\#]/'), array('-and-', '-at-', '-number-'), $name);
        $name = preg_replace('/[^(\x20-\x7F)]*/', '', $name); // removes any special chars we missed
        $name = str_replace(' ', '-', $name); // convert space to hyphen
        $name = str_replace('\'', '', $name); // removes apostrophes
        $name = preg_replace('/[^\w\-\.]+/', '', $name); // remove non-word chars (leaving hyphens and periods)
        $name = preg_replace('/[\-]+/', '-', $name); // converts groups of hyphens into one
        return strtolower($name);
    }
}
