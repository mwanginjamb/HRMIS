<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Employeeappraisalkra extends Model
{
public $Line_No;
public $Appraisal_No;
public $Employee_No;
public $KRA;
public $Perfomance_Level;
public $Perfomance_Comment;
public $Appraisee_Self_Rating;
public $Appraiser_Rating;
public $Agreed_Rating;
public $Rating_Comments;
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
            'KRA' => 'Key Result Area'
        ];
    }
}