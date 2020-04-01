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

class P9Controller extends Controller
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
        $p9years = $this->getP9years();
        $service = Yii::$app->params['ServiceName']['PortalReports'];

        //Yii::$app->recruitment->printrr(ArrayHelper::map($payrollperiods,'Date_Opened','desc'));
        if(Yii::$app->request->post()){

            $data = [
                'p9Year' =>Yii::$app->request->post('p9year'),
                'employeeNo' => Yii::$app->user->identity->{'Employee No_'}
             ];
            $path = Yii::$app->navhelper->IanGenerateP9($service,$data);
            if(!is_file($path['return_value'])){
                //throw new HttpException(404,"Resouce Not Found: ".$path['return_value']);
                return $this->render('index',[
                    'report' => false,
                    'p9years' => ArrayHelper::map($p9years,'Year','desc'),
                    'message' => $path['return_value']
                ]);
            }
            $binary = file_get_contents($path['return_value']); //fopen($path['return_value'],'rb');
            $content = chunk_split(base64_encode($binary));
            //delete the file after getting it's contents --> This is some house keeping
            unlink($path['return_value']);

           // Yii::$app->recruitment->printrr($path);
            return $this->render('index',[
                'report' => true,
                'content' => $content,
                'p9years' => ArrayHelper::map($p9years,'Year','desc')
            ]);
        }

        return $this->render('index',[
            'report' => false,
            'p9years' => ArrayHelper::map($p9years,'Year','desc')
        ]);

    }

    public function getP9years(){
        $service = Yii::$app->params['ServiceName']['P9YEARS'];

        $periods = \Yii::$app->navhelper->getData($service);
        krsort( $periods);//sort  keys in descending order
        $res = [];
        foreach($periods as $p){
            $res[] = [
                'Year' => $p->Year,
                'desc' => $p->Year
            ];
        }
        return $res;
    }



}