<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/4/2020
 * Time: 12:06 PM
 */

namespace frontend\models;

use yii\base\Model;

class LeaveRecall extends Model
{

    public $Key;
    public $Employee_No;
    public $Leave_No_To_Recall;
    public $Days_To_Recall;
    public $Employee_Name;
    public $Department_Code;
    public $Application_No;
    public $Application_Date;
    public $User_ID;
    public $Leave_Code;
    public $Start_Date;
    public $End_Date;
    public $Days_Applied;
    public $Leave_balance;
    public $Half_Day_on_Start_Date;
    public $Half_Day_on_End_Date;
    public $Total_No_Of_Days;
    public $Holidays;
    public $Weekend_Days;
    public $Days;
    public $Balance_After;
    public $Return_Date;
    public $Reporting_Date;
    public $Leave_Status;
    public $Comments;
    public $Supervisor_Code;
    public $Reliever;
    public $Reliever_Name;
    public $Approval_Status;
    public $Recall_No;

    public function rules()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [

        ];
    }

}