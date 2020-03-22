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
    public $From_Date;
    public $To_Date;
    public $Key;
    public $Line_No;
    public $Reporting_To; //Not added to Nav 
    public $Direct_Reports;

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
            'Direct_Reports' => 'No. of People Reporting To You',
            'Reporting_To' => 'Reporting To (Position)',
        ];
    }
}