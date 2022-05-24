<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\unidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unidads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unidad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Unidad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_unidad',
            'nombre_unidad',
            'abreviatura_unidad',
            'telefono_unidad',
            'pagina_referencia_unidad',
            //'correo_contacto_unidad',
            //'telefono_alternativo_unidad',
            //'ubicacion_unidad',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Unidad $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_unidad' => $model->id_unidad]);
                 }
            ],
        ],
    ]); ?>


</div>
