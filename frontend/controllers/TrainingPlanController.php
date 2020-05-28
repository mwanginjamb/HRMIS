<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Trainingplan;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Leave;
use yii\web\Response;
use kartik\mpdf\Pdf;

class TrainingPlanController extends Controller
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
                        'roles' => ['@'],
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
                'only' => ['getexperience'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex(){

        return $this->render('index');

    }

    public function actionCreate($Appraisal_No,$Employee_No){

        $model = new Trainingplan() ;
        $service = Yii::$app->params['ServiceName']['TrainingPlan'];


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Trainingplan'],$model)  ){



            $model->Appraisal_No = $Appraisal_No;
            $model->Employee_No = $Employee_No;
            $result = Yii::$app->navhelper->postData($service,$model);

            /*if(is_object($result)){
                Yii::$app->session->setFlash('success','Training Plan Line Added Successfully',true);
                return $this->redirect(['appraisal/view','Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_No]);

            }else{
                Yii::$app->session->setFlash('error','Error Adding Training Plan Line: '.$result,true);
                return $this->redirect(['appraisal/view','Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_No]);

            }*/

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success">Training Plan Line Added Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Adding Training Plan Line : '.$result.'</div>'];
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
        $model = new Trainingplan() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['TrainingPlan'];
        $filter = [
            'Line_No' => Yii::$app->request->get('Line_No'),
            'Employee_No' => Yii::$app->request->get('Employee_No'),
            'Appraisal_No' => Yii::$app->request->get('Appraisal_No')
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);
        $ratings = $this->getAppraisalrating();
        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Trainingplan'],$model) ){
            $result = Yii::$app->navhelper->updateData($service,$model);

            //Yii::$app->recruitment->printrr($result);
           /* if(!empty($result)){
                Yii::$app->session->setFlash('success','Training Plan Line Updated Successfully',true);
                return $this->redirect(['appraisal/view','Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_No]);
            }else{
                Yii::$app->session->setFlash('error','Error Updating Training Plan Line: '.$result,true);
                return $this->redirect(['appraisal/view','Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_No]);
            }*/

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success">Training Plan Line Updated Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Updating Training Plan Line : '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'ratings' => ArrayHelper::map($ratings,'Rating','Rating_Description')
            ]);
        }

        return $this->render('update',[
            'model' => $model,
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['experience'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        if(!is_string($result)){
            Yii::$app->session->setFlash('success','Work Experience Purged Successfully .',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Purging Work Experience: '.$result,true);
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

    public function actionGetexperience(){
        $service = Yii::$app->params['ServiceName']['experience'];
        $experience = \Yii::$app->navhelper->getData($service);

        $result = [];
        $count = 0;
        foreach($experience as $exp){
          if(!empty($exp->Job_Application_No) && !empty($exp->Position)){
              ++$count;
              $link = $updateLink =  '';


              $updateLink = Html::a('Update Experience',['update','Line'=> $exp->Line_No ],['class'=>'update btn btn-outline-info btn-xs']);

              $link = Html::a('Remove Experience',['delete','Key'=> $exp->Key ],['class'=>'btn btn-outline-warning btn-xs']);




              $result['data'][] = [
                  'index' => $count,
                  'Key' => $exp->Key,
                  'Position' => $exp->Position,
                  'Job_Description' => $exp->Job_Description,
                  'Institution' => !empty($exp->Institution)? $exp->Institution : '',
                  'Update_Action' => $updateLink,
                  'Remove' => $link
              ];
          }

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



    public function getAppraisalrating(){
        $service = Yii::$app->params['ServiceName']['AppraisalRating'];
        $filter = [
        ];

        $ratings = \Yii::$app->navhelper->getData($service,$filter);
        return $ratings;
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

    public function loadtomodel($obj,$model){

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
}