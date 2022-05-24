<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Integrante */

$this->title = 'Update Integrante: ' . $model->id_integrante;
$this->params['breadcrumbs'][] = ['label' => 'Integrantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_integrante, 'url' => ['view', 'id_integrante' => $model->id_integrante]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="integrante-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
