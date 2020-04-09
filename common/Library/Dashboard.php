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


    /*Get Number of job vacancies available*/

    public function getVacancies(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [
            'No_of_Posts' => '>0',
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
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



}