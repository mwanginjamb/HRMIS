<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Model;


class Employee extends ActiveRecord
{
    public static function tableName()
    {
        return Yii::$app->params['CompanyNameStripped'].'Employees HR ';
    }

    public static function getDb(){
        return Yii::$app->nav;
    }
}