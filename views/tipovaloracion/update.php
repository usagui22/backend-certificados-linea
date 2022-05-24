<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoValoracion */

$this->title = 'Update Tipo Valoracion: ' . $model->id_tipo_valoracion;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Valoracions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_tipo_valoracion, 'url' => ['view', 'id_tipo_valoracion' => $model->id_tipo_valoracion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-valoracion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
