<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\unidadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unidad-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_unidad') ?>

    <?= $form->field($model, 'nombre_unidad') ?>

    <?= $form->field($model, 'abreviatura_unidad') ?>

    <?= $form->field($model, 'telefono_unidad') ?>

    <?= $form->field($model, 'pagina_referencia_unidad') ?>

    <?php // echo $form->field($model, 'correo_contacto_unidad') ?>

    <?php // echo $form->field($model, 'telefono_alternativo_unidad') ?>

    <?php // echo $form->field($model, 'ubicacion_unidad') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
