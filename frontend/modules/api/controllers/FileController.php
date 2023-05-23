<?php

namespace frontend\modules\api\controllers;

use common\classes\Debug;
use common\models\File;
use yii\helpers\FileHelper;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class FileController extends ApiController
{
    public function verbs(): array
    {
        return [
            'upload' => ['post'],
        ];
    }

    public function actionUpload()
    {
        $uploads = UploadedFile::getInstancesByName("uploadFile");
        if (empty($uploads)) {
            throw new ServerErrorHttpException("Must upload at least 1 file in uploadFile form-data POST");
        }

        $savedFiles = [];
        foreach ($uploads as $file) {
            $md5 = md5($file->baseName);
            $path = \Yii::getAlias("@frontend/web/files/") . $md5[0] . $md5[1] . "/" . $md5[2] . $md5[3] . "/";
            if (!file_exists($path)) {
                FileHelper::createDirectory($path);
            }

            $path .= $md5 . '.' . $file->getExtension();
            $file->saveAs($path);

            if (!$file->hasError) {
                $fileModel = new File();
                $fileModel->name = $file->name;
                $fileModel->path = $path;
                $fileModel->url = "/files/". $md5[0] . $md5[1] . "/" . $md5[2] . $md5[3] . "/" . $md5 . '.' . $file->getExtension();
                $fileModel->type = $file->getExtension();
                $fileModel->{'mime-type'} = $file->type;

                if (!$fileModel->validate()){
                    throw new ServerErrorHttpException(json_encode($fileModel->errors));
                }

                $fileModel->save();
                $savedFiles[] = $fileModel;
            }
        }

        return $savedFiles;
    }

}