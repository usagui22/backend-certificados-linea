<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Unidad */

$this->title = 'Update Unidad: ' . $model->id_unidad;
$this->params['breadcrumbs'][] = ['label' => 'Unidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_unidad, 'url' => ['view', 'id_unidad' => $model->id_unidad]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="unidad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
