<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:29 PM
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AgendaDocument */

$this->title = 'Add Applicant Profile';
$this->params['breadcrumbs'][] = ['label' => 'New Leave Recall', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-document-create">

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

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'religion' => $religion

    ]) ?>

</div>
