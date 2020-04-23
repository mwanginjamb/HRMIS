<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use common\models\User;
use Yii;
use yii\base\Model;


class Appraisalcard extends Model
{

public $Key;
public $Appraisal_No;
public $Employee_No;
public $Employee_Name;
public $Level_Grade;
public $Job_Title;
public $Function_Team;
public $Appraisal_Period;
public $Goal_Setting_Start_Date;
public $Goal_Setting_End_Date;
public $Goal_Setting_Status;
public $Appraisal_Start_Date;
public $Created_By;
public $Supervisor_User_Id;
public $Employee_User_Id;
public $Supervisor_No;
public $MY_Appraisal_Status;
public $EY_Appraisal_Status;
public $Peer_1_Employee_No;
public $Peer_1_Employee_Name;
public $Peer_2_Employee_No;
public $Peer_2_Employee_Name;
public $MY_End_Date;
public $EY_Start_Date;
public $EY_End_Date;
public $Employee_Appraisal_KRAs;
public $Training_Plan;
public $Employee_Appraisal_Competence;
public $Learning_Assesment_Competenc;

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'MY_End_Date' => 'Mid Year Appraisal End Date',
            'EY_End_Date' => 'End Year Appraisal End Date',
            'EY_Start_Date' =>  'End Year Start Date',
            'EY_Appraisal_Status' => 'End Year Appraisal Status',
            'MY_Appraisal_Status' => 'Mid Year Appraisal Status'


        ];
    }

    public function getKPI($KRA_Line_No){
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKPI'];
        $filter = [
            'Appraisal_No' => $this->Appraisal_No,
            'KRA_Line_No' => $KRA_Line_No
        ];

        $kpas = Yii::$app->navhelper->getData($service, $filter);
        return $kpas;
    }

    public function getAppraisalbehaviours($Category_Line_No){
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalBehaviours'];
        $filter = [
            'Appraisal_Code' => $this->Appraisal_No,
            'Category_Line_No' => $Category_Line_No
        ];

        $behaviours = Yii::$app->navhelper->getData($service, $filter);
        return $behaviours;
    }

    public function getCareerdevelopmentstrengths($Goal_Line_No){
        $service = Yii::$app->params['ServiceName']['CareerDevStrengths'];
        $filter = [
            'Appraisal_Code' => $this->Appraisal_No,
            'Goal_Line_No' => $Goal_Line_No
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);
        return $result;
    }

    public function getWeaknessdevelopmentplan($Wekaness_Line_No){
        $service = Yii::$app->params['ServiceName']['WeeknessDevPlan'];
        $filter = [
            'Appraisal_Code' => $this->Appraisal_No,
            'Wekaness_Line_No' => $Wekaness_Line_No
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);
        return $result;
    }


    //get supervisor status

    public function isSupervisor($Employee_User_Id,$Supervisor_User_Id)
    {

        $user = Yii::$app->user->identity->getId();

        return ($user == $Supervisor_User_Id);

    }


}