<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\eventoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Evento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_evento',
            'nombre_evento',
            'url_validacion:url',
            'id_unidad',
            'fecha_inicio',
            //'fecha_fin',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Evento $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_evento' => $model->id_evento]);
                 }
            ],
        ],
    ]); ?>


</div>
