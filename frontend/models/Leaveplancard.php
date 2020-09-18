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


class Leaveplancard extends Model
{

public $Key;
public $Plan_No;
public $Employee_No;
public $Employee_Name;
public $Global_Dimension_1_Code;
public $Global_Dimension_1_Name;
public $Global_Dimension_2_Code;
public $Global_Dimension_2_Name;
public $Leave_Calender_Code;
public $Leave_Calendar_Description;
public $Leave_Calendar_Start_Date;
public $Leave_Calendar_End_Date;
public $Status;
public $Leave_Plan_Line;

    public function __construct(array $config = [])
    {
        return $this->getLines($this->Plan_No);
    }

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Department Code',
            'Global_Dimension_2_Code' => 'Branch Code',

        ];
    }

    public function getLines($Plan_No){
        $service = Yii::$app->params['ServiceName']['Leave__Plan__Line'];
        $filter = [
            'Plan_No' => $Plan_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        $this->Leave_Plan_Line = $lines;

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