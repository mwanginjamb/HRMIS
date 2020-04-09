<?php
use kartik\mpdf\Pdf;
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'HRMIS',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlsrv:server=FRANCIS\FRANC;database=AAS',
            'username' => 'mwangi',
            'password' => 'mwangi123',
            'charset' => 'utf8',
        ],
        'nav' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlsrv:server=FRANCIS\FRANC;database=Africa academy of sciences',
            'username' => 'Njambi',
            'password' => 'njambi123',
            'charset' => 'utf8',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => ['/plugins/jquery/jquery.js'],
                ]
            ]
        ],
        'navision' => [
            'class' => 'common\Library\Navision',
        ],
        'navhelper' => [
            'class' => 'common\Library\Navhelper',
        ],
        'recruitment' => [
            'class' => 'common\Library\Recruitment'
        ],
        'dashboard' => [
            'class' => 'common\Library\Dashboard'
        ],
        'pdf' => [
            'class' => Pdf::classname(),
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_STRING, //Pdf::DEST_ BROWSER,
            'filename' => 'meeting.pdf',//needs a component returning a user name
            'methods' => [
                'SetHeader' => ['AAS - HRMIS || '],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
            'cssInline' => 'h1,h2,h3,table{font-family: font-family: Cambria, Georgia, serif; text-align: center; padding:5px},
            .borderless td, .borderless th,thead tr,tbody tr{border: 1px solid #fff;font-size:12px},
            thead th{background-color: #003971;color: #fff;text-align:center;vertical-align:middle;},
            tbody td{background-color: #eeeeee;}, 
            .details{border:2px solid #2A3F54 ;},/*blue border*/
            h3{  },
            td.mail-label {
                border: 0.5px solid #8e3822;
                border-radius: 5px;
                //text-align: center;
                vertical-align: middle;
                display:table-cell;
                padding-left: 15px;
                margin:10px;
            }
            ',

            // refer settings section for all configuration options
        ],
    ],

];
