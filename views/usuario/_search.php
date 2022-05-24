<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\usuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_usuario') ?>

    <?= $form->field($model, 'nombres_usuario') ?>

    <?= $form->field($model, 'apellido_paterno_usuario') ?>

    <?= $form->field($model, 'apellido_materno_usuario') ?>

    <?= $form->field($model, 'genero_usuario') ?>

    <?php // echo $form->field($model, 'fecha_nacimiento_usuario') ?>

    <?php // echo $form->field($model, 'lugar_nacimiento_usuario') ?>

    <?php // echo $form->field($model, 'ubicacion_actual_usuario') ?>

    <?php // echo $form->field($model, 'ocupacion_usuario') ?>

    <?php // echo $form->field($model, 'correo_usuario') ?>

    <?php // echo $form->field($model, 'correo_alternativo_usuario') ?>

    <?php // echo $form->field($model, 'telefono_usuario') ?>

    <?php // echo $form->field($model, 'celular_usuario') ?>

    <?php // echo $form->field($model, 'ci_usuario') ?>

    <?php // echo $form->field($model, 'lugar_expedito_ci_usuario') ?>

    <?php // echo $form->field($model, 'imagen_usuario') ?>

    <?php // echo $form->field($model, 'estado_civil_usuario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
