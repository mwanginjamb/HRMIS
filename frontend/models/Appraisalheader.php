<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Appraisalheader extends ActiveRecord
{


    public static function tableName()
    {
        return Yii::$app->params['CompanyNameStripped'].'Appraisal Header ';
    }


    public static function getDb(){
        return Yii::$app->nav;
    }


}