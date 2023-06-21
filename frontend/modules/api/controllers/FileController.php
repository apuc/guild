<?php

namespace frontend\modules\api\controllers;

use common\classes\Debug;
use common\models\File;
use frontend\modules\api\models\FileEntity;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class FileController extends ApiController
{
    public function verbs(): array
    {
        return [
            'upload' => ['post'],
            'attach' => ['post'],
        ];
    }

    /**
     *
     * @OA\Post(path="/file/upload",
     *   summary="Загрузить файл",
     *   description="Метод для загрузки файлов",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"File"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"uploadFile"},
     *          @OA\Property(
     *              property="uploadFile",
     *              type="file",
     *              description="Файл который необходимо загрузить",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Файла",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/FileExample"),
     *     ),
     *   ),
     * )
     *
     * @return array
     * @throws ServerErrorHttpException
     * @throws \yii\base\Exception
     */
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
                $fileModel->url = "/files/" . $md5[0] . $md5[1] . "/" . $md5[2] . $md5[3] . "/" . $md5 . '.' . $file->getExtension();
                $fileModel->type = $file->getExtension();
                $fileModel->{'mime-type'} = $file->type;

                if (!$fileModel->validate()) {
                    throw new ServerErrorHttpException(json_encode($fileModel->errors));
                }

                $fileModel->save();
                $savedFiles[] = $fileModel;
            }
        }

        return $savedFiles;
    }

    /**
     *
     * @OA\Post(path="/file/attach",
     *   summary="Прикрепить файл",
     *   description="Метод для прикрепления файлов",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"File"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"file_id", "entity_type", "entity_id"},
     *          @OA\Property(
     *              property="file_id",
     *              type="intager",
     *              example=232,
     *              description="Идентификатор файла",
     *          ),
     *          @OA\Property(
     *              property="entity_type",
     *              type="intager",
     *              example=2,
     *              description="Идентификатор типа сущности",
     *          ),
     *          @OA\Property(
     *              property="entity_id",
     *              type="intager",
     *              example=234,
     *              description="Идентификатор сущности",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="intager",
     *              example=1,
     *              description="Статус",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект прикрепления",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/FileEntity"),
     *     ),
     *   ),
     * )
     *
     * @return FileEntity
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionAttach()
    {
        $request = \Yii::$app->request->post();
        $file = File::findOne($request['file_id']);
        if (!$file) {
            throw new NotFoundHttpException('File bot found');
        }

        $fileEntity = new FileEntity();
        $fileEntity->load($request, '');

        if(!$fileEntity->validate()){
            throw new ServerErrorHttpException(json_encode($fileEntity->errors));
        }

        $fileEntity->save();

        return $fileEntity;
    }

}