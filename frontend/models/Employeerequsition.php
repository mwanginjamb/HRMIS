<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/28/2020
 * Time: 12:22 AM
 */



namespace frontend\models;


use yii\base\Model;

class Employeerequisition extends Model
{
    public $Key;
    public $Requisition_No;
    public $Requisition_Date;
    public $Requestor;
    public $Job_ID;
    public $Job_Description;
    public $Job_Grade;
    public $Reason_For_Request;
    public $Employment_Type;
    public $Priority;
    public $Vacant_Positions;
    public $Required_Positions;
    public $Global_Dimension_2_Code;
    public $Requisition_Type;
    public $Approval_Status;
    public $Completion_Status;
    public $Any_Additional_Information;
    public $Reason_for_Request_Other;

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