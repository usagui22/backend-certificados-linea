<?php
namespace app\controllers;

use app\models\Evento;
use app\models\Unidad;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class EventoController extends Controller{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),[
                'verbs'=>[
                    'class'=> VerbFilter::class,
                    'actions'=>[
                        'crear-evento'=>['POST','GET'],
                        'editar-evento'=>['POST'],
                        'eliminar-evento'=>['POST','GET']
                    ],
                ],
            ]
        );        
    }
    public function actionCrearEvento(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $evento = new Evento();
        $valores =Yii::$app->request->getBodyParams();
        if(isset($valores)) {
            $evento->nombre=$valores['nombre'];
            $evento->id_unidad=$this->getIdxNombre([$valores['nombre']]);
            $evento->url_convocatoria=$valores['url_convocatoria'];            
            $evento->fecha_inicio=$valores['fecha_inicio'];
            $evento->registro_fin=$valores['registro_fin'];
            $evento->inicio_actividades=$valores['inicio_actividades'];
            $evento->fin_actividades=$valores['fin_actividades'];
            $evento->inicio_emision=$valores['inicio_emision'];
            $evento->fecha_fin=$valores['fecha_fin'];
            if($evento->validate()&&$evento->save()){
                return $evento;
            }else{
                return $evento->getErrors();
            }

        }

    }
    public function actionEditarEvento($id_cambiar){
        $evento =Evento::findOne($id_cambiar);
        $nuevo = Yii::$app->request->getBodyParams();
        if(isset($nuevo)){
            $evento->attributes=$nuevo;                        
            if($evento->save()){
                return $evento;
            }else{
                return $evento->getErrors();
            }            
        }
    }
    public function actionEliminarEvento($id_bor){
        return Evento::findOne($id_bor)->delete()?"eliminado":"Error al eliminar";
    }
    private function getIdxNombre($nombre){
        $id_encontrado=null;
        $unidad=Unidad::find()
        ->select("id_unidad")
        ->where(["nombre"=>$nombre])
        ->one();
        $buscar=$unidad?"encontrado":"unidad no existe";
        if ($buscar="encontrado") {
            $id_encontrado=$unidad['id_unidad'];
        }
        return $id_encontrado;
    }
}
