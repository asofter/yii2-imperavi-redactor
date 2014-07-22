<?php
/**
 * ImageList class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace yii\imperavi\actions;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\imperavi\models\File;
use yii\web\Response;

/**
 * Gets uploaded files list.
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class ImageList extends Action
{
    /**
     * @var string folder path to store uploaded files.
     */
    public $uploadPath;

    /**
     * @var string url to get file list from.
     */
    public $uploadUrl;

    /**
     * @var array file type to search for.
     */
    public $fileOptions = ['fileTypes' => ['gif', 'png', 'jpg', 'jpeg', 'tif', 'bmp']];

    /**
     * Gets image list.
     * @param string $attr owner attribute name.
     * @return array list or error.
     */
    public function run($attr)
    {
        $result = array();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new File();
        $model->setAttributes([
            'ownerAttribute'=> $attr,
            'uploadUrl'     => $this->uploadUrl,
            'uploadPath'    => $this->uploadPath,
        ], false);
        $path = $model->getDirPath();
        $url = $model->getDirUrl();

        if (file_exists($path)) {
            foreach (FileHelper::findFiles($path, $this->fileOptions) as $file) {
                $result[] = array(
                    'thumb' => $url . basename($file),
                    'image' => $url . basename($file),
                );
            }
        }
        return $result;
    }
}
