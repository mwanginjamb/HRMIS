<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Employeeappraisalkpi extends Model
{
    public $Key;
    public  $Line_No;
    public  $KRA_Line_No;
    public  $Appraisal_No;
    public  $Employee_No;
    public  $Objective;
    public  $Due_Date;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['Appraisal_No','Employee_No','Objective','Objective'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }
}