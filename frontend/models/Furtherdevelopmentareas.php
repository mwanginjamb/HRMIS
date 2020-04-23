<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Furtherdevelopmentareas extends Model
{
public $Line_No;
public $Appraisal_No;
public $Employee_No;
public $Weakness;
public $isNewRecord;
public $Key;

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'Weakness' => 'Further Development Area'
        ];
    }
}