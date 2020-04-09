<?php
namespace common\library;
use yii;
use yii\base\Component;
use common\models\Services;
//http://app-svr.rbss.com:7047/BC130/WS/RBA UAT/Page/Recruitment_Needs
class Navhelper extends Component{
    //read data-> pass filters as get params
    public function getData($service,$params=[]){
        # return true; //comment after dev or after testing outside Navision scope env
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;

        $url = new Services($service);

        $soapWsdl= $url->getUrl();
       // print '<pre>';
       // print_r(Yii::$app->session->get('IdentityPassword')); exit;

        $filter = [];
        if(sizeof($params)){
            foreach($params as $key => $value){
                $filter[] = ['Field' => $key, 'Criteria' =>$value];
            }
        }

        //exit(Yii::$app->navision->isUp($soapWsdl,$creds));
        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }
        //add the filter
        $results = Yii::$app->navision->readEntries($creds, $soapWsdl,$filter);


        //return array of object
        if(is_object($results->ReadMultiple_Result) && property_exists($results->ReadMultiple_Result, $service)){
            $lv =(array)$results->ReadMultiple_Result;
            return $lv[$service];
        }else{
            return $results;
        }

    }
    //create record(s)-----> post data
    public function postData($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];
        $post = Yii::$app->request->post();

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];
        $entryID = $service;
        foreach($data as $key => $value){
            if($key !=='_csrf-backend'){
                $entry->$key = $value;
            }

        }
//exit('lll');
        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        // $results = Yii::$app->navision->readEntries($creds, $soapWsdl,$filter);
        $results = Yii::$app->navision->addEntry($creds, $soapWsdl,$entry, $entryID);

        if(is_object($results)){
            $lv =(array)$results;

            return $lv[$service];
        }
        else{
            return $results;
        }

        /*print '<pre>'; print_r($results); exit;
        $lv =(array)$results;

        return $lv[$service];*/
    }
    //update data   -->post data
    public function updateData($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];
        $post = Yii::$app->request->post();

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];
        $entryID = $service;
        foreach($data as $key => $value){
            if($key !=='_csrf-backend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        // $results = Yii::$app->navision->readEntries($creds, $soapWsdl,$filter);
        $results = Yii::$app->navision->updateEntry($creds, $soapWsdl,$entry, $entryID);
        //add the filter so you don't display all loans to all and sundry.... just logic!!!
        if(is_object($results)){
            $lv =(array)$results;

            return $lv[$service];
        }
        else{
            return $results;
        }
    }
    //purge data --> pass key as get param
    public function deleteData($service,$key){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];
        $url = new Services($service);
        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $soapWsdl = $url->getUrl();
        $result = Yii::$app->navision->deleteEntry($creds, $soapWsdl, $key);
        //just return the damn object
        return $result;

    }

    //Generate Invoice
    public function GenerateInvoice($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-backend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->GenerateInvoice($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Create Customer
    public function CreateCustomer($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-backend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->CreateCustomer($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Leave Mgt

    public function SendLeaveApprovalRequest($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->SendLeaveRequestApproval($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Cancel leave approval request

    public function CancelLeaveApprovalRequest($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->CancelLeaveRequestApproval($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Approve Leave Request

    public function ApproveLeaveRequest($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanApproveLeaveApplication($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }



    //Reject Leave Application

    public function RejectLeaveRequest($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanRejectLeaveApplication($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }




    //Submit a Job Application

    public function SubmitJobApplication($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanCreateJobApplication($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

/*Generate Payslip*/


    public function IanGeneratePayslip($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanGeneratePayslip($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

//Generate P9

    public function IanGenerateP9($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanGenerateP9($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }


    //Submit AN Appraisal for Approval

    public function IanSendGoalSettingForApproval($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanSendGoalSettingForApproval($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Approve Goal setting of an Appraisal

    public function IanApproveGoalSetting($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanApproveGoalSetting($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }


    //Reject and Return Appraisal goal setting to appraisee

    public function IanSendGoalSettingBackToAppraisee($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanSendGoalSettingBackToAppraisee($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Send MY Appraisal for Approval

    public function IanSendMYAppraisalForApproval($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanSendMYAppraisalForApproval($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Approve MY Appraisal

    public function IanApproveMYAppraisal($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanApproveMYAppraisal($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Reject Mid Year Appraisal

    public function IanSendMYAppraisaBackToAppraisee($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanSendMYAppraisaBackToAppraisee($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Send End Year Appraisal for Approval

    public function IanSendEYAppraisalForApproval($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanSendEYAppraisalForApproval($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

//Approve End Year Appraisal

    public function IanApproveEYAppraisal($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanApproveEYAppraisal($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Reject End Year Appraisal

    public function IanSendEYAppraisaBackToAppraisee($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanSendEYAppraisaBackToAppraisee($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //send appraisal to peer 1

    public function IanSendEYAppraisalToPeer1($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanSendEYAppraisalToPeer1($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //send appraisal to peer 2

    public function IanSendEYAppraisalToPeer2($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanSendEYAppraisalToPeer2($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //send End Year Appraisal back to supervisor from peer

    public function IanSendEYAppraisaBackToSupervisorFromPeer($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanSendEYAppraisaBackToSupervisorFromPeer($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }

    //Send End-Year Appraisal to Agreement Level

    public function IanSendEYAppraisalToAgreementLevel($service,$data){
        $identity = \Yii::$app->user->identity;
        $username = (!Yii::$app->user->isGuest)? Yii::$app->user->identity->{'User ID'} : Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->session->has('IdentityPassword')? Yii::$app->session->get('IdentityPassword'):Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        $results = Yii::$app->navision->IanSendEYAppraisalToAgreementLevel($creds, $soapWsdl,$entry);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }


    /**Auxilliary methods for working with models */

    public function loadmodel($obj,$model){ //load object data to a model, e,g from service data to model

        if(!is_object($obj)){
            return false;
        }
        $modeldata = (get_object_vars($obj)) ;
        foreach($modeldata as $key => $val){
            if(is_object($val)) continue;
            $model->$key = $val;
        }

        return $model;
    }

    public function loadpost($post,$model){ // load form data to a model, e.g from html form-data to model


        $modeldata = (get_object_vars($model)) ;

        foreach($post as $key => $val){

            $model->$key = $val;
        }

        return $model;
    }
}


?>