<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombres_usuario')->textInput() ?>

    <?= $form->field($model, 'apellido_paterno_usuario')->textInput() ?>

    <?= $form->field($model, 'apellido_materno_usuario')->textInput() ?>

    <?= $form->field($model, 'genero_usuario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_nacimiento_usuario')->textInput() ?>

    <?= $form->field($model, 'lugar_nacimiento_usuario')->textInput() ?>

    <?= $form->field($model, 'ubicacion_actual_usuario')->textInput() ?>

    <?= $form->field($model, 'ocupacion_usuario')->textInput() ?>

    <?= $form->field($model, 'correo_usuario')->textInput() ?>

    <?= $form->field($model, 'correo_alternativo_usuario')->textInput() ?>

    <?= $form->field($model, 'telefono_usuario')->textInput() ?>

    <?= $form->field($model, 'celular_usuario')->textInput() ?>

    <?= $form->field($model, 'ci_usuario')->textInput() ?>

    <?= $form->field($model, 'lugar_expedito_ci_usuario')->textInput() ?>

    <?= $form->field($model, 'imagen_usuario')->textInput() ?>

    <?= $form->field($model, 'estado_civil_usuario')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
