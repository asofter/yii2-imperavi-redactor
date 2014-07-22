<?php
/**
 * File class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace yii\imperavi\models;

use yii\base\Model;

/**
 * Uploads and validates Imperavi widget files.
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class File extends Model
{
    /**
     * @var string owner model attribute name.
     */
    public $ownerAttribute;
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
     * @var UploadedFile uploaded file.
     */
    public $file;

    /**
     * @var array custom file validation rules.
     */
    public $customRules = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return $this->customRules;
    }

    /**
     * Uploads file, creates folders.
     */
    public function afterValidate()
    {
        $attributePath = $this->getDirPath();
        if (!is_dir($attributePath) && !mkdir($attributePath, $this->permissions, true)) {
            return $this->addError('file', 'Could not create folder "' . $attributePath . '". Make sure it is writable.');
        }
        $path = $attributePath . DIRECTORY_SEPARATOR . $this->getFileName();
        if (file_exists($path) || !$this->file->saveAs($path)) {
            return $this->addError('file', 'Could not save file or file exists: "' . $path . '".');
        }
    }

    /**
     * @return string upload folder path.
     */
    public function getDirPath()
    {
        return $this->uploadPath . DIRECTORY_SEPARATOR . strtolower((string) $this->ownerAttribute);
    }

    /**
     * @return string upload folder external url.
     */
    public function getDirUrl()
    {
        return $this->uploadUrl . '/' . strtolower((string) $this->ownerAttribute) . '/';
    }

    /**
     * @return string uploaded file name.
     */
    public function getFileName()
    {
        return $this->sanitizeFilename($this->file->name);
    }

    /**
     * Prepares file name for storing.
     * @param string $name file name.
     * @return string file name.
     * @author Jani Mikkonen <janisto@php.net>
     */
    protected function sanitizeFilename($name)
    {
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