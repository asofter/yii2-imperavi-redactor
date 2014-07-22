<?php
/**
 * FileUpload class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace yii\imperavi\actions;

use yii\base\Action;
use yii\imperavi\models\File;
use yii\web\Response;
use \yii\web\UploadedFile;

/**
 * Uploads Imperavi widget files.
 *
 * @Usage:
 *
 * 1. Attach these actions in your controller actions() method, e.g.:
 *     public function actions()
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
 * 2. Set upload options in your imperavi widget, e.g.:
 *
    'fileUpload' => Url::toRoute(['file-upload', 'attr'=>'content']),
    'imageUpload' => Url::toRoute(['image-upload', 'attr'=>'content']),
    'imageGetJson' => Url::toRoute(['image-list', 'attr'=>'content']),
    'imageUploadErrorCallback'  => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
    'fileUploadErrorCallback'  => new \yii\web\JsExpression('function(json) { alert(json.error); }'),
 *
 * * You can also redefine action 'customRules' attribute for file validation.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class FileUpload extends Action
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
     * @var integer upload folder permissions.
     */
    public $permissions = 0774;

    /**
     * @var array file validation rules (see yii\base\Model::rules() description)
     */
    public $customRules = [
        [['file'], 'file', 'skipOnError' => false, 'skipOnEmpty' => false, 'maxSize' => 10000000,
           'types' => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip', 'tar', 'gz', 'mp3',
               'wav', 'mid', 'xml', 'json', 'csv', 'txt', 'odt', 'psd']]
    ];

    /**
     * Disables csrf post validation.
     */
    public function init()
    {
        $this->controller->enableCsrfValidation = false;
        parent::init();
    }

    /**
     * Uploads file.
     * @param string $attr Owner model attribute name.
     * @return array json response.
     */
    public function run($attr)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new File();
        $model->setAttributes([
            'ownerAttribute'=> $attr,
            'uploadUrl'     => $this->uploadUrl,
            'uploadPath'    => $this->uploadPath,
            'permissions'   => $this->permissions,
            'customRules'   => $this->customRules,
            'file'          => UploadedFile::getInstanceByName('file')
        ], false);

        return $model->validate()
            ? ['filelink' => $model->getDirUrl() . $model->getFileName(), "filename" => $model->getFileName()]
            : $this->error($model->firstErrors);
    }

    /**
     * Returns error.
     * @param string $message error message.
     * @return array error message.
     */
    protected function error($message)
    {
        return array('error' => is_array($message) ? reset($message) : $message);
    }
}