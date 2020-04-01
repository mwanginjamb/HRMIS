<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Learningassessmentcompetence extends Model
{
public $Line_No;
public $Employee_No;
public $Appraisal_No;
public $Training_Action;
public $Due_Date;
public $Learning_Hours;
public $Status_Mid_Year;
public $Status_End_Year;
public $Comments;
public $Key;
public $isNewRecord;

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }
}