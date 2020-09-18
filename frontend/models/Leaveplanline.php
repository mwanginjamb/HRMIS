<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Leaveplanline extends Model
{

public $Key;
public $Line_No;
public $isNewRecord;
public $Plan_No;
public $Employee_Code;
public $Leave_Code;
public $Leave_Type_Description;
public $Leave_Balance;
public $Start_Date;
public $End_Date;
public $Days_Planned;
public $Holidays;
public $Weekend_Days;
public $Total_No_Of_Days;

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