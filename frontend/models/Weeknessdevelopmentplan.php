<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Weeknessdevelopmentplan extends Model
{

public $Line_No;
public $Appraisal_No;
public $Employee_No;
public $Development_Plan;
public $Wekaness_Line_No;
public $Key;
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