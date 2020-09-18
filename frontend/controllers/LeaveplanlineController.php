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
use frontend\models\Leaveplanline;
use frontend\models\Weeknessdevelopmentplan;
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

class LeaveplanlineController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index','create','update','delete','view'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','create','update','delete','view'],
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
                'only' => ['uu'],
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

    public function actionCreate($Plan_No){
       $service = Yii::$app->params['ServiceName']['Leave__Plan__Line'];

        if(Yii::$app->request->get('Plan_No') && !Yii::$app->request->post()){
                $model = new Leaveplanline() ;                
                $model->Plan_No = $Plan_No;
                $model->Leave_Code = 'Annual';
                $model->Employee_Code = Yii::$app->user->identity->Employee[0]->No;                
                Yii::$app->navhelper->postData($service, $model);

        }
        

        if(Yii::$app->request->post() && Yii::$app->request->post()['Leaveplanline'] ){


            $refresh = Yii::$app->navhelper->getData($service,['Line_No' => Yii::$app->request->post()['Leaveplanline']['Line_No']]);

            $data = [
                'Key' => $refresh[0]->Key,
                'Start_Date' => Yii::$app->request->post()['Leaveplanline']['Start_Date'],
                'End_Date' => Yii::$app->request->post()['Leaveplanline']['End_Date']
            ];

            $result = Yii::$app->navhelper->updateData($service,$data);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            // return $model;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success">Leave Plan Line Created Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Creating Leave Plan Line: '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }


    }


    public function actionUpdate(){
        $model = new Leaveplanline() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['Leave__Plan__Line'];
        $filter = [
            'Line_No' => Yii::$app->request->get('Line_No'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Leaveplanline'],$model) ){

            $refresh = Yii::$app->navhelper->getData($service,['Line_No' => Yii::$app->request->post()['Leaveplanline']['Line_No']]);
            $model->Key = $refresh[0]->Key;

            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success">Leave Plan Line Updated Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Updating Leave Plan Line: '.$result.'</div>'];
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
        $service = Yii::$app->params['ServiceName']['Leave__Plan__Line'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionSetstartdate(){
        $model = new Leaveplanline();
        $service = Yii::$app->params['ServiceName']['Leave__Plan__Line'];

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No')
        ];
        $line = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($line)){
            Yii::$app->navhelper->loadmodel($line[0],$model);
            $model->Key = $line[0]->Key;
            $model->Start_Date = date('Y-m-d',strtotime(Yii::$app->request->post('Start_Date')));

        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    public function actionSetenddate(){
        $model = new Leaveplanline();
        $service = Yii::$app->params['ServiceName']['Leave__Plan__Line'];

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No')
        ];
        $line = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($line)){
            Yii::$app->navhelper->loadmodel($line[0],$model);
            $model->Key = $line[0]->Key;
            $model->End_Date = date('Y-m-d',strtotime(Yii::$app->request->post('End_Date')));
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;
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