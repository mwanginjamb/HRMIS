<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/10/2020
 * Time: 2:27 PM
 */

namespace common\library;
use yii;
use yii\base\Component;
use common\models\Hruser;


class Dashboard extends Component
{

    public function getStaffCount(){
        $service = Yii::$app->params['ServiceName']['employees'];
        $filter = [];
        $result = Yii::$app->navhelper->getData($service,$filter);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result fails
            return false;
        }
        return count($result);
    }

    /*My Rejected Approval Requests*/

    public function getRejectedApprovals(){
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Sender_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Rejected'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter results to false
            return 0;
        }
        return count($result);
    }

    /* My Approved Requests */

    public function getApprovedApprovals(){
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Sender_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Approved'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    /* Get Pending Approvals */

    public function getOpenApprovals(){
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Sender_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Open'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }



    /*Request I have approved*/

    public function getSuperApproved(){
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Approver_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Approved'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }


    /* Requests I have Rejected */

    public function getSuperRejected(){
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Approver_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Rejected'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    /* My Pending approval*/

    public function getSuperPending(){
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Approver_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Open'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }


    /*Get Number of job vacancies available*/

    public function getVacancies(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [
            'No_of_Posts' => '>0',

        ];
        $res = [];
        $result = Yii::$app->navhelper->getData($service,$filter);
        foreach($result as $req){
            $RequisitionType = Yii::$app->recruitment->getRequisitionType($req->Job_ID);
            if(($req->No_of_Posts >= 0 && !empty($req->Job_Description) && !empty($req->Job_ID)) && ($RequisitionType == 'Internal' || $RequisitionType == 'Both' ) ) {
                $res[] = $req->Job_Description;
            }
        }

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($res);
    }

    /*Get Staff on Leave*/

    public function getOnLeave(){
        $service = Yii::$app->params['ServiceName']['activeLeaveList'];
        $filter = [];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    //Get Number of Job Applications made by an AAS  employee

    public function getInternalapplications(){
        if(!Yii::$app->user->isGuest){
            $srvc = Yii::$app->params['ServiceName']['employeeCard'];
            $filter = [
                'No' => Yii::$app->user->identity->employee[0]->No
            ];
            $Employee = Yii::$app->navhelper->getData($srvc,$filter);
            if(empty($Employee[0]->ProfileID)){
                return 0;
            }
            $profileID = $Employee[0]->ProfileID;

        }else{ //if for some reason this check is called by a guest ,return false;
            return 0;
        }

        $service = Yii::$app->params['ServiceName']['HRJobApplicationsList'];
        $filter = [
            'Applicant_No' => $profileID
        ];
        $result = \Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the result is false
            return 0;
        }
        return count($result);

    }



}