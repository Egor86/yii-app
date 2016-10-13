<?php
namespace common\helpers;

use Yii;
use yii\web\UploadedFile;
use \yii\web\HttpException;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;

class Upload
{
    public static $UPLOADS_DIR = 'data';

    public static function file(UploadedFile $fileInstance, $alias, $dir = '',  $namePostfix = true)
    {
        $fileName = Upload::getUploadPath($dir, $alias) . DIRECTORY_SEPARATOR . Upload::getFileName($fileInstance, $namePostfix);

        if(!$fileInstance->saveAs($fileName)){
            throw new HttpException(500, 'Cannot upload file "'.$fileName.'". Please check write permissions.');
        }
        return Upload::getLink($fileName, $alias);
    }

    static function getUploadPath($dir, $alias)
    {
        $uploadPath = $alias.DIRECTORY_SEPARATOR.self::$UPLOADS_DIR.($dir ? DIRECTORY_SEPARATOR.$dir : '');
        if(!FileHelper::createDirectory($uploadPath)){
            throw new HttpException(500, 'Cannot create "'.$uploadPath.'". Please check write permissions.');
        }
        return $uploadPath;
    }

    static function getLink($fileName, $alias)
    {
        return str_replace('\\', '/', str_replace($alias, '', $fileName));
    }

    static function getFileName($fileInstanse, $namePostfix = true)
    {
        $baseName = str_ireplace('.'.$fileInstanse->extension, '', $fileInstanse->name);
        $fileName =  StringHelper::truncate(Inflector::slug($baseName), 32, '');
        if($namePostfix || !$fileName) {
            $fileName .= ($fileName ? '-' : '') . substr(uniqid(md5(rand()), true), 0, 10);
        }
        $fileName .= '.' . $fileInstanse->extension;

        return $fileName;
    }
}