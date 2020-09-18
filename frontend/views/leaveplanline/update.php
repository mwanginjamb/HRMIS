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

$this->title = 'Update Leave Plan Line.';

$model->Start_Date = (date('Y',strtotime($model->Start_Date)) == '0001')?$model->Start_Date = date('Y-m-d'):$model->Start_Date;
$model->End_Date = (date('Y',strtotime($model->End_Date)) == '0001')?$model->End_Date = date('Y-m-d'):$model->End_Date;

?>
<div class="agenda-document-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form',[
        'model' => $model,
    ]) ?>

</div>
