<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Language;
use yii\web\Response;
use kartik\mpdf\Pdf;

class LanguageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index'],
                        'allow' => true,
                        //'roles' => ['@'],
                        'matchCallback' => function($rule,$action){
                            return (Yii::$app->session->has('HRUSER') || !Yii::$app->user->isGuest);
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['getlanguage'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex(){
        if(Yii::$app->session->has('mode') && Yii::$app->session->get('mode') == 'external'){
            $this->layout = 'external';
        }
        return $this->render('index');

    }

    public function actionCreate(){

        $model = new Language();
        $service = Yii::$app->params['ServiceName']['applicantLanguages'];

        if(Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Language'],$model)){

            $model->Applicant_No = Yii::$app->recruitment->getProfileID();

            $result = Yii::$app->navhelper->postData($service,$model);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Language Added Successfully',true);
                return $this->redirect(['index']);

            }else{

                Yii::$app->session->setFlash('error','Error Adding Language: '.$result,true);
                return $this->redirect(['index']);

            }

        }//End Saving experience

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,


            ]);
        }

        return $this->render('create',[

            'model' => $model,


        ]);
    }


    public function actionUpdate(){
        $service = Yii::$app->params['ServiceName']['applicantLanguages'];
        $filter = [
            'Line_No' => Yii::$app->request->get('Line'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);
        $Expmodel = new Language();
        //load nav result to model
        $model = $this->loadtomodel($result[0],$Expmodel);

        if(Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Language'],$model)){
            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!empty($result)){
                Yii::$app->session->setFlash('success','Language Updated Successfully',true);
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('error','Error Updating Language: '.$result,true);
                return $this->redirect(['index']);
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,

            ]);
        }

        return $this->render('update',[
            'model' => $model,

        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['applicantLanguages'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        if(!is_string($result)){
            Yii::$app->session->setFlash('success','Language Purged Successfully .',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Purging Language: '.$result,true);
            return $this->redirect(['index']);
        }
    }

    public function actionView($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];
        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();

        $filter = [
            'Application_No' => $ApplicationNo
        ];

        $leave = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $leaveModel = new Leave();
        $model = $this->loadtomodel($leave[0],$leaveModel);


        return $this->render('view',[
            'model' => $model,
            'leaveTypes' => ArrayHelper::map($leaveTypes,'Code','Description'),
            'relievers' => ArrayHelper::map($employees,'No','Full_Name'),
        ]);
    }


    public function actionApprovalRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->SendLeaveApprovalRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave request sent for approval Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error sending leave request for approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    public function actionCancelRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->CancelLeaveApprovalRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave Approval Request Cancelled Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Cancelling Leave Approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    /*Data access functions */

    public function actionLeavebalances(){

        $balances = $this->Getleavebalance();

        return $this->render('leavebalances',['balances' => $balances]);

    }

    public function actionGetlanguage(){
        $service = Yii::$app->params['ServiceName']['applicantLanguages'];
        $filter = ['Applicant_No' => \Yii::$app->recruitment->getProfileID()];
        $languages = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $count = 0;
        foreach($languages as $lang){

            ++$count;
            $link = $updateLink =  '';


            $updateLink = Html::a('<i class="fa fa-edit"></i>',['update','Line'=> $lang->Line_No ],['class'=>'update btn btn-outline-info btn-xs']);

            $link = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $lang->Key ],['class'=>'btn btn-outline-warning btn-xs','data' => [
                'confirm' => 'Are you sure you want to delete this record?',
                'method' => 'post',
            ]]);

            $read = Html::checkbox('read', $lang->Read);
            $write =  Html::checkbox('write', $lang->Write);
            $speak =  Html::checkbox('speak', $lang->Speak);



            $result['data'][] = [
                'index' => $count,
                'Key' => $lang->Key,
                'Applicant_No' => !empty($lang->Applicant_No)?$lang->Applicant_No:'',
                'Language_Description' => !empty($lang->Language_Description)?$lang->Language_Description:'',
                'Read' => $read,
                'Write' => $write,
                'Speak' => $speak,
                'Action' => $updateLink.' | '.$link,
                //'Remove' => $link
            ];
        }

        return $result;
    }

    public function actionReport(){
        $service = Yii::$app->params['ServiceName']['expApplicationList'];
        $leaves = \Yii::$app->navhelper->getData($service);
        krsort( $leaves);//sort by keys in descending order
        $content = $this->renderPartial('_historyreport',[
            'leaves' => $leaves
        ]);

        //return $content;
        $pdf = \Yii::$app->pdf;
        $pdf->content = $content;
        $pdf->orientation = Pdf::ORIENT_PORTRAIT;

        //The trick to returning binary content
        $content = $pdf->render('', 'S');
        $content = chunk_split(base64_encode($content));

        return $content;
    }

    public function actionReportview(){
        return $this->render('_viewreport',[
            'content'=>$this->actionReport()
        ]);
    }

    public function Getleavebalance(){
        $service = Yii::$app->params['ServiceName']['leaveBalance'];
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];

        $balances = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];

        //print '<pre>';
        // print_r($balances);exit;

        foreach($balances as $b){
            $result = [
                'Key' => $b->Key,
                'Annual_Leave_Bal' => $b->Annual_Leave_Bal,
                'Maternity_Leave_Bal' => $b->Maternity_Leave_Bal,
                'Paternity' => $b->Paternity,
                'Study_Leave_Bal' => $b->Study_Leave_Bal,
                'Compasionate_Leave_Bal' => $b->Compasionate_Leave_Bal,
                'Sick_Leave_Bal' => $b->Sick_Leave_Bal
            ];
        }

        return $result;

    }



    public function getLeaveTypes($gender = 'Female'){
        $service = Yii::$app->params['ServiceName']['leaveTypes'];
        $filter = [
            'Gender' => $gender,
            'Gender' => 'Both'
        ];

        $leavetypes = \Yii::$app->navhelper->getData($service,$filter);
        return $leavetypes;
    }

    public function getCountries(){
        $service = Yii::$app->params['ServiceName']['Countries'];

        $res = [];
        $countries = \Yii::$app->navhelper->getData($service);
        foreach($countries as $c){
            if(!empty($c->Name))
                $res[] = [
                    'Code' => $c->Code,
                    'Name' => $c->Name
                ];
        }

        return $res;
    }

    public function getReligion(){
        $service = Yii::$app->params['ServiceName']['Religion'];
        $filter = [
            'Type' => 'Religion'
        ];
        $religion = \Yii::$app->navhelper->getData($service, $filter);
        return $religion;
    }

    public function loadtomodel($obj,$model){//load an empty model with resource data

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

    public function loadpost($post,$model){ // load model with form data


        $modeldata = (get_object_vars($model)) ;

        foreach($post as $key => $val){

           $model->$key = $val;
        }

        return $model;
    }
}