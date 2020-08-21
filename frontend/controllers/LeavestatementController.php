<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 2:53 PM
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

use frontend\models\Leave;
use yii\web\HttpException;
use yii\web\Response;
use kartik\mpdf\Pdf;

class LeavestatementController extends Controller
{

    public function beforeAction($action) {
        $this->enableCsrfValidation = ($action->id !== "index"); // <-- here
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
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
                'only' => ['getleaves'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex(){

        $service = Yii::$app->params['ServiceName']['PortalReports'];

        //Yii::$app->recruitment->printrr(ArrayHelper::map($payrollperiods,'Date_Opened','desc'));

            $data = [
                'employeeNo' => Yii::$app->user->identity->{'Employee No_'}
             ];
            $path = Yii::$app->navhelper->IanGenerateLeaveStatementReport($service,$data);

        if(!is_file($path['return_value'])){
            //throw new HttpException(404,"Resouce Not Found: ".$path['return_value']);
            return $this->render('index',[
                'report' => false,
                'message' => strlen($path['return_value'])?$path['return_value']: 'Report Cannot be Found.'
            ]);
        }

            $binary = file_get_contents($path['return_value']);
            $content = chunk_split(base64_encode($binary));
            //delete the file after getting it's contents --> This is some house keeping
            unlink($path['return_value']);

           // Yii::$app->recruitment->printrr($path);
            return $this->render('index',[
                'report' => true,
                'content' => $content
            ]);



    }





}