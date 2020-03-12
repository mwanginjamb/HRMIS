<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Referee extends Model
{
    public $Key;
    public $Application_No;
    public $First_Name;
    public $Middle_Name;
    public $Last_Name;
    public $Instituition;
    public $Position;
    public $Email;
    public $Phone_No;
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