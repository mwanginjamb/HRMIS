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

$this->title = 'Update Leave: ' . $model->Application_No;
$this->params['breadcrumbs'][] = ['label' => 'Update Leave', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Application_No, 'url' => ['view', 'id' => $model->Application_No]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="agenda-document-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'leaveTypes' => $leaveTypes,
        'relievers' => $relievers
    ]) ?>

</div>
