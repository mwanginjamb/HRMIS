<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Careerdevelopmentplan extends Model
{
public $Key;
public $Line_No;
public $Appraisal_No;
public $Employee_No;
public $Career_Development_Goal;
public $Estimate_Start_Date;
public $Estimate_End_Date;
public $Duration;
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