<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 1:57 PM
 */

namespace frontend\models;


use yii\base\Model;

class Leave extends Model
{
public $Key;
public $Employee_No;
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
public $Leave_Application_Lines1;
public $Posted;

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
            'Key' => 'Key',
            'Employee_No' => 'Employee No.',
            'Employee_Name' => 'Employee Name',
            'Department_Code' => 'Department Code',
            'Application_No' => 'Application No',
            'Application_Date' => 'Application Date',
            'User_ID' => 'User ID',
            'Leave_Code' => 'Leave Type',
            'Start_Date' => 'Start Date',
            'End_Date' => 'End Date',
            'Days_Applied' => 'Days Applied',
            'Leave_balance' => 'Leave balance',
            'Half_Day_on_Start_Date' => 'Half Day Start Date',
            'Half_Day_on_End_Date' => 'Half Day End Date',
            'Total_No_Of_Days' => 'Total No Of Days',
            'Holidays' => 'Holidays',
            'Weekend_Days' => 'Weekend Days',
            'Days' => 'Days',
            'Balance_After' => 'Balance After',
            'Return_Date' => 'Return Date',
            'Reporting_Date' => 'Reporting Date',
            'Leave_Status' => 'Leave Status',
            'Comments' => 'Comments',
            'Supervisor_Code' => 'Supervisor Code',
            'Reliever' => 'Reliever',
            'Reliever_Name' => 'Reliever Name',
            'Approval_Status' => 'Approval Status',
            'Leave_Application_Lines1' => 'Leave_Application_Lines1',
        ];
    }

}