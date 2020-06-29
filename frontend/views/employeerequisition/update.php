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

$this->title = 'Update Requisition: ' . $model->Requisition_No;
$this->params['breadcrumbs'][] = ['label' => 'Employee Requsitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Update Employee Requisition', 'url' => ['update', 'Requisition_No' => $model->Requisition_No]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="agenda-document-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'jobs' => $jobs,
        'requestReasons' => $requestReasons,
        'employmentTypes' => $employmentTypes,
        'priority' => $priority,
        'requisitionType' => $requisitionType
    ]) ?>

</div>
