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

$this->title = 'New Leave Recall';
$this->params['breadcrumbs'][] = ['label' => 'Leaves ', 'url' => ['leave/index']];
$this->params['breadcrumbs'][] = ['label' => 'Leave Recall List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'New Leave Recall', 'url' => ['create']];
$this->params['breadcrumbs'][] = '';
?>
<div class="leave-document-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'leaves' => $leaves,
        'employees' => $employees,

    ]) ?>

</div>
