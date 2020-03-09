<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/6/2020
 * Time: 12:36 AM
 */

namespace frontend\models;

use yii\base\Model;

class Job extends Model
{
public $Key;
public $Job_ID;
public $Job_Title;
public $Job_Purpose;
public $Job_Dimension;
public $Position_Reporting_to;
public $Position_Reporting_Name;
public $Global_Dimension_1_Code;
public $Global_Dimension_2_Code;
public $Grade;
public $Status;
public $No_of_Requirements;
public $No_of_Responsibilities;
public $Hr_Job_Resposibilities;
public $Job_Requirements;

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