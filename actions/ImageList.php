<?php

namespace yii\imperavi\actions;

use yii\base\Action;

/**
 * Redactor widget image list action.
 *
 * @param string $attr Model attribute
 */
class ImageList extends Action {

    public $uploadPath;
    public $uploadUrl;

    public function run($attr) {
        $name = strtolower($this->controller->id);
        $attribute = strtolower((string) $attr);

        if ($this->uploadPath === null) {
            $path = \Yii::$app->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads';
            $this->uploadPath = realpath($path);
            if ($this->uploadPath === false) {
                exit;
            }
        }
        if ($this->uploadUrl === null) {
            $this->uploadUrl = \Yii::$app->request->baseUrl . '/uploads';
        }

        $attributePath = $this->uploadPath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $attribute;
        $attributeUrl = $this->uploadUrl . '/' . $name . '/' . $attribute . '/';
        
        $files = \yii\helpers\FileHelper::findFiles($attributePath, array('fileTypes' => array('gif', 'png', 'jpg', 'jpeg')));
        $data = array();
        if ($files) {
            foreach ($files as $file) {
                $data[] = array(
                    'thumb' => $attributeUrl . basename($file),
                    'image' => $attributeUrl . basename($file),
                );
            }
        }
        echo json_encode($data);
        exit;
    }

}
