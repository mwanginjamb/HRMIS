<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Language extends Model
{
    public $Key;
    public $Applicant_No;
    public $Language_Description;
    public $Read;
    public $Write;
    public $Speak;
    public $Line_No;


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