<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\tipoDocumentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-documento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_tipo_documento') ?>

    <?= $form->field($model, 'nombre_documento') ?>

    <?= $form->field($model, 'descripcion_tipo_documento') ?>

    <?= $form->field($model, 'plantilla_tipo_documento') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
