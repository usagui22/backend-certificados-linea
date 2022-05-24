<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Evento */

$this->title = 'Update Evento: ' . $model->id_evento;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_evento, 'url' => ['view', 'id_evento' => $model->id_evento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
