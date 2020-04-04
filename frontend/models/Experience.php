<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Experience extends Model
{
    public $Job_Application_No;
    public $Position;
    public $Job_Description;
    public $Institution;
    public $Period;
    public $Start_Date;
    public $End_Date;
    public $Key;
    public $Line_No;
    public $No_of_People_Reporting_to_You;  
    public $Reporting_To;

    public function rules()
    {
        return [
            [['From_Date','Institution','Position','Job_Description'],'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Job_Description' => 'Responsibilities',
            'No_of_People_Reporting_to_You' => 'No. of People Reporting To You',
            'Reporting_To' => 'Reporting To (Position)',
        ];
    }
}