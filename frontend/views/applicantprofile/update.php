<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:31 PM
 */


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AgendaDocument */

$this->title = 'Update Applicant: ' . $model->No;
$this->params['breadcrumbs'][] = ['label' => 'Update Leave', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->No, 'url' => ['view', 'id' => $model->No]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="agenda-document-update">

    <div class="row">
        <div class="col-md-12">


                    <?php

                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">';
                        echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }else if(Yii::$app->session->hasFlash('error')){
                        print ' <div class="alert alert-danger alert-dismissable">
                                            ';
                        echo Yii::$app->session->getFlash('error');
                        print '</div>';
                    }
                    ?>


        </div>
    </div>



    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'religion' => $religion
    ]) ?>

</div>