<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TipoValoracion */

$this->title = $model->id_tipo_valoracion;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Valoracions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tipo-valoracion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_tipo_valoracion' => $model->id_tipo_valoracion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_tipo_valoracion' => $model->id_tipo_valoracion], [
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
            'id_tipo_valoracion',
            'nota_valoracion',
            'estado_valoracion',
        ],
    ]) ?>

</div>
