<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Qualification extends Model
{
    public $Key;
    public $Employee_No;
    public $Qualification_Code;
    public $From_Date;
    public $To_Date;
    public $Description;
    public $Institution_Company;
    public $Comment;



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