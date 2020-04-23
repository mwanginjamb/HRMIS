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

$this->title = 'Add Weakness Development Plan Line';
$this->params['breadcrumbs'][] = ['label' => 'KRA Evaluation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->Employee_No = Yii::$app->request->get('Employee_No');
$model->Appraisal_No = Yii::$app->request->get('Appraisal_No');
$model->Wekaness_Line_No = Yii::$app->request->get('Wekaness_Line_No');
$model->isNewRecord = true;
?>
<div class="leave-document-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
