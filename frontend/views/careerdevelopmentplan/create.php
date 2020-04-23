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

$this->title = 'Add Career Development plan Line';
$this->params['breadcrumbs'][] = ['label' => 'Career Dev Plan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->Employee_No = Yii::$app->request->get('Employee_No');
$model->Appraisal_No = Yii::$app->request->get('Appraisal_No');
$model->isNewRecord = true;
?>
<div class="leave-document-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
