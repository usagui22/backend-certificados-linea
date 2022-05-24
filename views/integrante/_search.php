<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\integranteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="integrante-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_integrante') ?>

    <?= $form->field($model, 'id_usuario') ?>

    <?= $form->field($model, 'id_evento') ?>

    <?= $form->field($model, 'id_tipo_valoracion') ?>

    <?= $form->field($model, 'tipo_integrante') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
