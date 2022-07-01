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
        //$file = base64_decode($basePhp[1]);
        //$img=UploadedFile::getInstance($plantilla,'plantilla');
        $img_plan=$_POST['plantilla'];
        $c_img=explode(',',$img_plan);
        $img=base64_decode($c_img[1]);
        if(isset($datos)){
            
            $plantilla->nombre=$datos['nombre'];
            $plantilla->descripcion=$datos['descripcion'];
            $plantilla->plantilla='http://'.$_SERVER['HTTP_HOST'].'/'.$this->guardarImagen($img, $datos['nombre']);
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

    public function guardarImagen($img,$nombre){
        $ruta=null;
        if(isset($img)){           
            $ruta="/documents/plantillas/".$nombre.$img;   
            file_put_contents($ruta,$img);
        }
        return $ruta;
    }
}