<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 5/11/2020
 * Time: 5:12 AM
 */

namespace frontend\controllers;

use frontend\models\Coverletter;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class CoverletterController extends Controller
{
    public function actionUpload()
    {
        $model = new Coverletter();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}