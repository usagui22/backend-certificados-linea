<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Integrante */

$this->title = $model->id_integrante;
$this->params['breadcrumbs'][] = ['label' => 'Integrantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="integrante-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_integrante' => $model->id_integrante], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_integrante' => $model->id_integrante], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_integrante',
            'id_usuario',
            'id_evento',
            'id_tipo_valoracion',
            'tipo_integrante',
        ],
    ]) ?>

</div>
