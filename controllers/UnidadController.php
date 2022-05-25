<?php
namespace app\controllers;

use app\models\Unidad;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class UnidadController extends Controller{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        
                        'crear-unidad' => ['POST'],
                        'editar-unidad'=>['POST'],
                        'eliminar-unidad'=>['POST','GET']
                    ],
                ],
            ]
        );
    }

    public function actionCrearUnidad(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $unidad =new Unidad();
        $datos=Yii::$app->request->getBodyParams();
        if(isset($unidad)){
            $unidad->attributes=$datos;
            if($unidad->validate()&&$unidad->save()){
                return $unidad;
            }else{
                return $unidad->getErrors();
            }
        }
    }

    public function actionEditarUnidad($id_ed){
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $unidad=Unidad::findOne($id_ed);
        $nuevosdatos =Yii::$app->request->getBodyParams();
        if(isset($nuevosdatos)){
            $unidad->attributes=$nuevosdatos;
            if($unidad->validate()){
                $unidad->save();
                return $unidad;
            }else{
                return $unidad->getErrors();
            }
        }    
        
    }

    public function actionEliminarUnidad($id_eli){
        return Unidad::findOne($id_eli)?"eliminado":"error unidad no existe";
    }
}
