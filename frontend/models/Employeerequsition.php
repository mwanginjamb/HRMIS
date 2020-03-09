<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/28/2020
 * Time: 3:24 PM
 */

namespace frontend\models;

use yii\base\Model;

class Employeerequsition extends Model
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
    public $Closing_Date;
    public $Nature_of_Employment;
    public $No_of_Job_Applications;
    public $Advertised;

    public function rules()
    {
        return [
            [['Job_ID','Employment_Type','Required_Positions','Requisition_Type'],'required'],
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