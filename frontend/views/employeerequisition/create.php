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

$this->title = 'New Leave Application';
$this->params['breadcrumbs'][] = ['label' => 'Employee Requisition ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'New Requisition', 'url' => ['create']];
?>
<div class="leave-document-create">

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
