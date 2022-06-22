<?php
namespace app\controllers;

use app\models\Plantilla;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class PlantillaController extends Controller{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'crear-plantilla' => ['POST','GET'],
                        'actualizar-plantilla'=>['POST'],
                        'borrar-plantilla'=>['POST','GET']
                    ],
                ],
            ]
        );
    }
    public function actionCrearPlantilla(){
        $plantilla=new Plantilla();
        $msg=null;
        $datos=Yii::$app->request->getBodyParams();
        $img=UploadedFile::getInstance($plantilla,'plantilla');
        if(isset($datos)){
            
            $plantilla->nombre=$datos['nombre'];
            $plantilla->descripcion=$datos['descripcion'];
            $plantilla->plantilla='http://'.$_SERVER['HTTP_HOST'].'/'.$this->guardarImagen($img);
            if($plantilla->validate()&& $plantilla->save()){
                $msg=["guardado"=>true,"plantilla"=>$plantilla];
            }else{
                $msg=["guardado"=>false,"plantilla"=>$plantilla->getErrors()];
            }
        }
        return $msg;
    }

    public function actionEditarPlantilla($id_plantilla){
        $plantilla=Plantilla::findOne($id_plantilla);
        $nuevosDatos=Yii::$app->request->getBodyParams();
        if($plantilla->validate()){
            $plantilla->attributes=$nuevosDatos;
            if($plantilla->validate()&&$plantilla->save()){
                return $plantilla;
            }else{
                return $plantilla->getErrors();
            }
        }
    }

    public function actionEliminarPlantilla($id_plan){
        return Plantilla::findOne($id_plan)->delete()?print_r("eliminado"):print_r("Error id incorrecto");
    }

    public function guardarImagen($img){
        $ruta=null;
        if(file_exists($img)){
            print_r($img);
            exit();
            $ruta="/documents/images/"."_".$img;            
        }
        return $ruta;
    }
}