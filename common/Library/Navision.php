<?php

namespace common\library;
use yii;
use yii\base\Component;
class Navision extends Component
{
    public function init()
    {
        parent::init();
    }
    public function isUp($url)
    {
        //Check if service is up
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


        //echo function_exists('curl_version');
        //return($httpcode);
        curl_close($ch);
        if(($httpcode == "200" ) || ( $httpcode == "302" )|| ( $httpcode == "401" )){
            return true;
        }else{
            return $httpcode;
        }
    }
    public function readEntries($credentials, $soapWsdl, $filter='')
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->ReadMultiple(['filter' => $filter, 'setSize' => 1000]);
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function addEntry($credentials, $soapWsdl, $Entry, $EntryID)
    {
        /* print '<pre>';
         print_r($Entry); exit;*/
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->Create([$EntryID => $Entry]);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }
    public function importcasuals($credentials, $soapWsdl, $Entry="",$EntryID)
    {
        /*print '<pre>';
        print_r($Entry); exit;*/
        $client = $this->createClient($credentials, $soapWsdl);
        /*print '<pre>';
        print_r($client); exit;*/

        try {
            $result = $client->ImportCasuals($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }
    public function ApprovalRequest($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->SendLeaveApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }
    public function ApproveDocument($credentials, $soapWsdl, $Entry){//Approve any requests
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->ApproveEntry($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }
    }

    public function RejectDocument($credentials, $soapWsdl, $Entry){//Reject any requests
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->RejectEntry($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }
    }
    /***Overtime send, cancel, approve, reject fxns***/

    public function sendOtApproval($credentials,$soapWsdl,$Entry){//send Document for approval
        $client = $this->createClient($credentials,$soapWsdl);
        try{
            $result = $client->SendOvertimeApproval($Entry);
            return $result;
        }catch(\SoapFault $e){
            return $e->getMessage();
        }
    }

    public function cancelOtApproval($credentials,$soapWsdl,$Entry){// cancel approval for sent doc
        $client = $this->createClient($credentials,$soapWsdl);
        try{
            $result = $client->CancelOverime($Entry);
            return $result;
        }catch(\SoapFault $e){
            return $e->getMessage();
        }
    }

    public function ApproveOt($credentials,$soapWsdl,$Entry){// Approve ot Document
        $client = $this->createClient($credentials,$soapWsdl);
        try{
            $result = $client->ApproveOvertime($Entry);
            return $result;
        }catch(\SoapFault $e){
            return $e->getMessage();
        }
    }

    public function RejectOt($credentials,$soapWsdl,$Entry){// Reject ot Document
        $client = $this->createClient($credentials,$soapWsdl);
        try{
            $result = $client->RejectOvertime($Entry);
            return $result;
        }catch(\SoapFault $e){
            return $e->getMessage();
        }
    }



    /*****End Overtime tings *************************/
    //Approve Docs ---by Branton on Nav Integrated by F.Njambi on Portal
    public function ApproveDoc($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->ApproveDocument($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }
    //Approve Request-->Test
    public function ApproveRequest($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->Approve($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }
    //Approval for training
    public function ApprovalTraining($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->SendTrainingapproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }
//Approval for recruitment

    public function ApprovalRecruitment($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->SendlRecruitmentApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }
    }

//Approval for store
    public function approval($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->SendStoreRequisitionApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }
    //imprestSurrender
    public function approvalSurrender($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->SendImrestApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }
    public function leaveapproval($credentials, $soapWsdl, $Entry)//send leave for approval
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->SendLeaveApproval($Entry);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }

    }

    public function cancelleaveapprovalrequest($credentials, $soapWsdl, $Entry)//cancels a submitted leave request
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->CancelLeaveApproval($Entry);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }
    }


//recruitment  approval for any request
    public function send_request_approval($credentials, $soapWsdl, $Entry)//send leave for approval
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->SendApprovalRequests($Entry);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }

    }

    //Cancel approval for any request
    public function cancel_request_approval($credentials, $soapWsdl, $Entry)//send leave for approval
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->CancelApprovalRequests($Entry);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }

    }
//Add casuals
    public function insertcasual($credentials, $soapWsdl, $Entry){
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->FnInsertCasualEmployees($Entry);
            ini_set('soap.wsdl_cache_ttl', 1);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }
    }

//Add Casuals transactions
    public function insert_casuals_transaction($credentials, $soapWsdl, $Entry){
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->FnInsertCasualEmployeeDailyTrans($Entry);
            ini_set('soap.wsdl_cache_ttl', 1);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }
    }


//Get last casual entry
    public function last_casual_entry($credentials, $soapWsdl, $Entry=""){
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->FnGetTheLastEntryEmployees();
            ini_set('soap.wsdl_cache_ttl', 1);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }
    }

    //Get last casual daily entry


    public function last_daily_entry($credentials, $soapWsdl, $Entry=""){
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->FnGetLastEntryEmployeeDaily();
            ini_set('soap.wsdl_cache_ttl', 1);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }
    }
//send recall notification
    public function send_recall_note($credentials, $soapWsdl, $Entry){
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->FnSendRecallNotifications($Entry);
            ini_set('soap.wsdl_cache_ttl', 1);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }
    }
//validate recall days
    public function validate_recall_days($credentials, $soapWsdl, $Entry){
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->FnValidateRecallDays($Entry);
            ini_set('soap.wsdl_cache_ttl', 1);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }
    }

//Get leave balances
    public function get_leave_balance($credentials, $soapWsdl, $Entry){
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->GetLeaveBalance($Entry);
            ini_set('soap.wsdl_cache_ttl', 1);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }
    }
//Get leaves for recall
    public function get_recall_leaves($credentials, $soapWsdl, $Entry){
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->FnGetLeavesToRecall($Entry);
            ini_set('soap.wsdl_cache_ttl', 1);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }
    }
//shortlist
    public function shortlist($credentials, $soapWsdl, $Entry){
        $client = $this->createClient($credentials, $soapWsdl);
        try
        {
            $result = $client->ShortListApplicants($Entry);
            ini_set('soap.wsdl_cache_ttl', 1);
            return $result;
        } catch (\SoapFault $e)
        {
            return $e->getMessage();
        }
    }

    public function approvalx($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->Payslipx($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //aprroval for purchase requisition

    public function Purchaseapproval($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->SendPurchaseRequisitionApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

//Aprroval for imprest
    public function imprest($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->SendImrestApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }
    }
    public function readEntry($credentials, $soapWsdl, $filter = '')
    {


        //try
        //{
        $client = $this->createClient($credentials, $soapWsdl);
        //var_dump($client); exit;
        try {
            //$result = $client->ReadMultiple(['filter' => [], 'setSize' => 1]);
            $result = $client->ReadMultiple(['filter' => $filter, 'setSize' => 1]);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }
        //}
        //catch (yii\base\ErrorException $e) {
        //  return $e->getMessage();
        //}

    }

    public function updateEntry($credentials, $soapWsdl, $Entry, $EntryID)
    {
        $client = $this->createClient($credentials, $soapWsdl);

        try {
            $result = $client->Update([$EntryID => $Entry]);
            //ini_set('soap.wsdl_cache_ttl', 1);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }
    }

    public function updateMultiple($credentials, $soapWsdl, $Entry, $EntryID)
    {
        $client = $this->createClient($credentials, $soapWsdl);

        try {
            $result = $client->UpdateMultiple([$EntryID => $Entry]);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }
    }

    public function deleteEntry($credentials, $soapWsdl, $key)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            //$result = $client->Delete($WhereArray);
            $result = $client->Delete(['Key' => $key]);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }
    }


    //RBSS Sale invoice code unit
    public function GenerateInvoice($credentials, $soapWsdl, $Entry){//Approve any requests
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->CreateInvoice($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }
    }

//RBSS Create customer

    public function CreateCustomer($credentials, $soapWsdl, $Entry){//Approve any requests
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->CreateCustomer($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }
    }



    //IANSOFT LEAVE MGT

    public function SendLeaveRequestApproval($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendLeaveApplicationForApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    public function CancelLeaveRequestApproval($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanCancelLeaveApplicationForApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    public function IanApproveLeaveApplication($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanApproveLeaveApplication($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    public function IanRejectLeaveApplication($credentials, $soapWsdl, $Entry)
    {
        //$result =  $client->Create([$EntryID => $Entry]);
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanRejectLeaveApplication($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //Call Job Application CodeUnit

    public function IanCreateJobApplication($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanCreateJobApplication($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //Payslip report

    public function IanGeneratePayslip($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanGeneratePayslip($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }


    //Generate P9 report

    public function IanGenerateP9($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanGenerateP9($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }
    /** PERFOMANCE MANAGEMENT FUNCTIONS ON APPRAISAL WORKFLOW CODEUNIT */
    //send Appraisal for approval

    public function IanSendGoalSettingForApproval($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendGoalSettingForApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //Approve set Goals

    public function IanApproveGoalSetting($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanApproveGoalSetting($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //Reject Appraisal and send it back to appraisee


    public function IanSendGoalSettingBackToAppraisee($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendGoalSettingBackToAppraisee($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //Send Mid Year Appraisal for Approval

    public function IanSendMYAppraisalForApproval($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendMYAppraisalForApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //Approve Mid Year Appraisal

    public function IanApproveMYAppraisal($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanApproveMYAppraisal($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //Send Mid Year Appraisal back to Appraisee (A Rejection)

    public function IanSendMYAppraisaBackToAppraisee($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendMYAppraisaBackToAppraisee($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //Send End Year Appraisal for Approval

    public function IanSendEYAppraisalForApproval($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendEYAppraisalForApproval($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }


    //Approve End Year Appraisal

    public function IanApproveEYAppraisal($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanApproveEYAppraisal($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //Send End Year Appraisal back to Appraisee (Rejection)

    public function IanSendEYAppraisaBackToAppraisee($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendEYAppraisaBackToAppraisee($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //send End Year Appraisal to Peer1

    public function IanSendEYAppraisalToPeer1($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendEYAppraisalToPeer1($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //send End Year Appraisal to Peer2

    public function IanSendEYAppraisalToPeer2($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendEYAppraisalToPeer2($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //send appraisal to supervisor from peers

    public function IanSendEYAppraisaBackToSupervisorFromPeer($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendEYAppraisaBackToSupervisorFromPeer($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }

    //Send Appraisal to Agreement Level

    public function IanSendEYAppraisalToAgreementLevel($credentials, $soapWsdl, $Entry)
    {
        $client = $this->createClient($credentials, $soapWsdl);
        try {
            $result = $client->IanSendEYAppraisalToAgreementLevel($Entry);
            return $result;
        } catch (\SoapFault $e) {
            return $e->getMessage();
        }

    }






    //Navision Critical Functions

    private function createClient($credentials, $soapWsdl)
    {

        if (!defined('USERPWD'))
            define('USERPWD', "$credentials->UserName:$credentials->PassWord");
        try {
            $opts = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                )
            );
            $oPtions = [
                'soap_version' => SOAP_1_2,
                'connection_timeout' => 180,
                'login' => $credentials->UserName,
                'password' => $credentials->PassWord,

                'trace' => 1,
                'stream_context' => stream_context_create($opts)
            ];

            $context = stream_context_create([
                'ssl' => [
                    // set some SSL/TLS specific options
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]);

            $options = array("login" => $credentials->UserName,
                "password" => $credentials->PassWord,
                "features" => SOAP_SINGLE_ELEMENT_ARRAYS,
                "stream_context" => $context);

            //$client = new \SoapClient($soapWsdl, $options);
            // we unregister the current HTTP wrapper
            stream_wrapper_unregister('http');
            // we register the new HTTP wrapper //'\\common\\components\\NTLMStream'
            stream_wrapper_register('http', '\\common\\library\\NTLMStream') or die("Failed to register protocol");


            $client = new NTLMSoapClient($soapWsdl, $options);


            return $client;
        } catch (\Exception $e) {
            throw new \yii\web\HttpException(503, 'Service unavailable:'.$e);
            //return $e->getMessage();
        }
        return false;
    }

}

/**va
 * Extend the native soap class to support NTLM authentication
 **/
class NTLMSoapClient extends \SoapClient
{
    function __doRequest($request, $location, $action, $version, $one_way = NULL)
    {
        $headers = array(
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: text/xml; charset=utf-8',
            'SOAPAction: "' . $action . '"',
        );

        $this->__last_request_headers = $headers;
        $ch = curl_init($location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, USERPWD);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $response = @curl_exec($ch);

        return $response;

    }

    function __getLastRequestHeaders()
    {
        return implode("\n", $this->__last_request_headers) . "\n";
    }
}

/**
 * create new streamwrappers to overrride default http wrapper
 **/
class NTLMStream
{
    private $path;
    private $mode;
    private $options;
    private $opened_path;
    private $buffer;
    private $pos;

    /**
     * Open the stream
     *
     * @param unknown_type $path
     * @param unknown_type $mode
     * @param unknown_type $options
     * @param unknown_type $opened_path
     * @return unknown
     */
    public function stream_open($path, $mode, $options, $opened_path)
    {
        $this->path = $path;
        $this->mode = $mode;
        $this->options = $options;
        $this->opened_path = $opened_path;
        $this->createBuffer($path);
        return true;
    }

    /**
     * Close the stream
     *
     */
    public function stream_close()
    {
        curl_close($this->ch);
    }

    /**
     * Read the stream
     *
     * @param int $count number of bytes to read
     * @return content from pos to count
     */
    public function stream_read($count)
    {
        if (strlen($this->buffer) == 0) {
            return false;
        }
        $read = substr($this->buffer, $this->pos, $count);
        $this->pos += $count;
        return $read;
    }

    /**
     * write the stream
     *
     * @param int $count number of bytes to read
     * @return content from pos to count
     */
    public function stream_write($data)
    {
        if (strlen($this->buffer) == 0) {
            return false;
        }
        return true;
    }

    /**
     *
     * @return true if eof else false
     */
    public function stream_eof()
    {
        return ($this->pos > strlen($this->buffer));
    }

    /**
     * @return int the position of the current read pointer
     */
    public function stream_tell()
    {
        return $this->pos;
    }

    /**
     * Flush stream data
     */
    public function stream_flush()
    {
        $this->buffer = null;
        $this->pos = null;
    }

    /**
     * Stat the file, return only the size of the buffer
     *
     * @return array stat information
     */
    public function stream_stat()
    {
        $this->createBuffer($this->path);
        $stat = array(
            'size' => strlen($this->buffer),
        );
        return $stat;
    }

    /**
     * Stat the url, return only the size of the buffer
     *
     * @return array stat information
     */
    public function url_stat($path, $flags)
    {
        $this->createBuffer($path);
        $stat = array(
            'size' => strlen($this->buffer),
        );
        return $stat;
    }

    /**
     * Create the buffer by requesting the url through cURL
     *
     * @param unknown_type $path
     */
    private function createBuffer($path)
    {
        if ($this->buffer) {
            return;
        }
        $this->ch = curl_init($path);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($this->ch, CURLOPT_USERPWD, USERPWD);
        $this->buffer = curl_exec($this->ch);

        $this->pos = 0;
    }
}
