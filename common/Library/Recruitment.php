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


class Recruitment extends Component
{
    public function absoluteUrl(){
        return \yii\helpers\Url::home(true);
    }

    function currentCtrl($ctrl){
        $controller = Yii::$app->controller->id;

        if(is_array($ctrl) && in_array($controller,$ctrl) ) {
            return true;
        }else if($controller == $ctrl ){
            return true;
        }else{
            return false;
        }
    }

    public function currentaction($ctrl,$actn){//modify it to accept an array of controllers as an argument--> later please
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;

        if($controller == $ctrl && is_array($actn) && in_array($action, $actn)) {
            return true;
        }
        else if(is_array($ctrl) && in_array($controller,$ctrl) ){
            return true;
        }
        else if($controller == $ctrl && $action == $actn){
            return true;
        }else{
            return false;
        }
    }

    public function getProfileID(){
        if(Yii::$app->session->has('HRUSER')){            
            $hruser = Hruser::findByUsername(Yii::$app->session->get('HRUSER')->username);
            return $hruser->profileID;
        } else if(!Yii::$app->user->isGuest && !Yii::$app->session->has('HRUSER')){
            $srvc = Yii::$app->params['ServiceName']['employeeCard'];
            $filter = [
                'No' => Yii::$app->user->identity->employee[0]->No
            ];
            $Employee = Yii::$app->navhelper->getData($srvc,$filter);

            return !empty($Employee[0]->ProfileID)?$Employee[0]->ProfileID: false;
        }else{
            return null;
        }
    }

    public function getRequisitionID($Job_ID){
        $service = Yii::$app->params['ServiceName']['RequisitionEmployeeList'];

        $filter = [
            'Job_ID' => $Job_ID
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result)){//RETURNS AN EMPTY object if the filter result fails
            return null;
        }
        return $result[0]->Requisition_No;

    }

/* Checking is various profile setups exists for an applicant */


    public function hasProfile($profileID){
          if(Yii::$app->session->has('HRUSER')){
                    //update a HRUser
                    $hruser = Hruser::findByUsername(Yii::$app->session->get('HRUSER')->username);
                    $profileID = $hruser->profileID ;
                   
                   if(!empty($profileID)){
                    return true;
                   }else{
                    return false;
                   }
                }else{

                    //check if an identity is guest, then check for ProfileID 
                    if(!Yii::$app->user->isGuest){
                        $srvc = Yii::$app->params['ServiceName']['employeeCard'];
                        $filter = [
                            'No' => Yii::$app->user->identity->employee[0]->No
                        ];
                        $Employee = Yii::$app->navhelper->getData($srvc,$filter);

                        if(!empty($Employee[0]->ProfileID)){
                            return true;
                        }else{
                            return false;
                        }
                       
                    }else{ //if for some reason this check is called by a guest ,return false;
                        return false;
                    }
                   


                }
    }

    //check for experience

    public function hasExperience($profileID){
         $service = Yii::$app->params['ServiceName']['experience'];
         $filter = [
            'Job_Application_No' => $profileID
         ];

         $result = Yii::$app->navhelper->getData($service,$filter);
         if(is_object($result)){//RETURNS AN EMPTY object if the filter result has null property object
            return false;
        }else{ // returns an array of objects
            return true;
        }
    }

    //check for academic qualifications

    public function hasAcademic($profileID){
         $service = Yii::$app->params['ServiceName']['qualifications'];
         $filter = [
            'Employee_No' => $profileID
         ];

         $result = Yii::$app->navhelper->getData($service,$filter);
         if(is_object($result)){//RETURNS AN EMPTY object if the filter result has null property object
            return false;
        }else{ // returns an array of objects
            return true;
        }
    }

    //check for professional qualification

    public function hasProfessional($profileID){
         $service = Yii::$app->params['ServiceName']['qualifications'];

         //FILTER FOR PROFESSIONAL QUALIFICATIONS
         $filter = [
            'Employee_No' => $profileID
         ];

         $result = Yii::$app->navhelper->getData($service,$filter);
         if(is_object($result)){//RETURNS AN EMPTY object if the filter result has null property object
            return false;
        }else{ // returns an array of objects
            return true;
        }
    }

    //check for languages

    public function hasLanguages($profileID){

         $service = Yii::$app->params['ServiceName']['applicantLanguages'];
         $filter = [
            'Applicant_No' => $profileID
         ];

         $result = Yii::$app->navhelper->getData($service,$filter);
         if(is_object($result)){//RETURNS AN EMPTY object if the filter result has null property object
            return false;
        }else{ // returns an array of objects
            return true;
        }

    }

    //check for referees

    public function hasReferees($profileID){

        $service = Yii::$app->params['ServiceName']['referees'];
         $filter = [
            'Application_No' => $profileID
         ];

         $result = Yii::$app->navhelper->getData($service,$filter); 
         if(is_object($result)){//RETURNS AN EMPTY object if the filter result has null property object
            return false;
        }else{ // returns an array of objects
            return true;
        }

    }

    //Show Job Responsibility Specifications / children

    public function Responsibilityspecs($resp){
        $service = Yii::$app->params['ServiceName']['JobResponsibilities'];
        $filter = [
            'Responsibility' => $resp
        ];

        $results = Yii::$app->navhelper->getData($service, $filter);

        $html  = '<td class="child"><table class="table table-info table-hover">';

        if(!is_string($results) && !is_object($results)){

            foreach($results as $spec){

                $html .= '<tr>

                            <td>'.$spec->Specifaction.'</td>

                        </tr>';

            }
        }

        $html .='</table></td>';

        return $html;
    }

    public function Requirementspecs($req){
        $service = Yii::$app->params['ServiceName']['JobRequirements'];
        $filter = [
            'Requirement_ID' => $req
        ];

        $results = Yii::$app->navhelper->getData($service, $filter);

        $html  = '<td class="child"><table class="table table-info table-hover">';

        if(!is_string($results) && !is_object($results)){

            foreach($results as $spec){

                $html .= '<tr>

                            <td>'.$spec->Requirement_Specifiaction.'</td>

                        </tr>';

            }
        }

        $html .='</table></td>';

        return $html;
    }
}