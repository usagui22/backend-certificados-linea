<?php
namespace app\controllers;

use app\models\Plantilla;
use Codeception\Template\Upgrade4;
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
                        'eliminar-plantilla'=>['POST']
                    ],
                ],
            ]
        );
    }
    public function beforeAction($action)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT');
            Yii::$app->end();
        }
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
    //crear plantilla
    public function actionCrearPlantilla(){
        $plantilla=new Plantilla();
        $msjCliente=null;
        $datosRecibidos=Yii::$app->request->getBodyParams();
        if(isset($datosRecibidos)){
            $plantilla->nombre=$datosRecibidos['nombre'];
            $plantilla->descripcion=$datosRecibidos['descripcion'];

            $r=\Yii::$app->basePath;
            $filename=$plantilla->nombre;
            $plantilla->file=UploadedFile::getInstanceByName('plantilla');

            //$rutaImagen=$r."templates/".$filename.time().'.'.$plantilla->file->extension;
            //$plantilla->plantilla="templates/".$filename.time().'.'.$plantilla->file->extension;
            $plantilla->plantilla=base64_encode($plantilla->file);
            if($plantilla->validate() && $plantilla->save()){                
                if(!is_null($r."/templates/".$filename))
                    //$plantilla->file->saveAs($r."/templates/".$filename.time().'.'.$plantilla->file->extension);
                $msjCliente=['estado'=>'ok','plantilla'=>$plantilla->id_plantilla];                                
            }else{
                $msjCliente=['estado'=>'Error','plantilla'=>$plantilla->getErrors()];
            }
        }
        return $msjCliente;
    }
    
    //editar plantilla
    public function actionEditarPlantilla($id_editar){
        $plantilla =Plantilla::findOne($id_editar);
        $atributosCambiar=Yii::$app->request->getBodyParams();
        $msj=null;
        
        if(isset($atributosCambiar)){
            
            if($plantilla->attributes!=$atributosCambiar){
                $plantilla->nombre=$atributosCambiar['nombre'];
                $plantilla->descripcion=$atributosCambiar['descripcion'];                
                $plantilla->file=UploadedFile::getInstanceByName('plantilla');
                $rutaFile=\Yii::$app->basePath."/templates/".$plantilla->nombre.time().'.'.$plantilla->file->extension;
                $rutaPlan="templates/".$plantilla->nombre.time().'.'.$plantilla->file->extension;
                $rutaExist=\Yii::$app->basePath."/templates/".$plantilla->nombre;
                $plantilla->plantilla=$rutaPlan;
                    if($plantilla->validate() && $plantilla->save()){
                        if(!is_null($rutaExist))
                        $plantilla->file->saveAs($rutaFile);
                        $msj=['estado'=>'ok','plantilla'=>$plantilla];
                    }else{
                        $msj=['estado'=>'Bad Atributes','plantilla'=>$plantilla->getErrors()];
                    }
            }else{
                if($plantilla->nombre==$atributosCambiar['nombre'] && $plantilla->descripcion==$atributosCambiar['descripcion']){
                    $plantilla->file=UploadedFile::getInstanceByName('plantilla');
                    $rutaFile=\Yii::$app->basePath."/templates/".$plantilla->nombre.time().'.'.$plantilla->file->extension;
                    $rutaPlan="templates/".$plantilla->nombre.time().'.'.$plantilla->file->extension;
                    $rutaExist=\Yii::$app->basePath."/templates/".$plantilla->nombre;
                    $plantilla->plantilla=$rutaPlan;
                    if($plantilla->validate() && $plantilla->save()){
                        if(!is_null($rutaExist))
                        $plantilla->file->saveAs($rutaFile);
                        $msj=['estado'=>'ok','plantilla'=>$plantilla];
                    }else{
                        $msj=['estado'=>'bad File','plantilla'=>$plantilla->getErrors()];
                    }
                }else{
                    if($plantilla->nombre!=$atributosCambiar['nombre'] && $plantilla->descripcion!=$atributosCambiar['descripcion']){
                        $plantilla->nombre=$atributosCambiar['nombre'];
                        $plantilla->descripcion=$atributosCambiar['descripcion'];
                        if($plantilla->validate() && $plantilla->save()){                     
                            $msj=['estado'=>'ok','plantilla'=>$plantilla];
                        }else{
                            $msj=['estado'=>'bad Name and bad Description','plantilla'=>$plantilla->getErrors()];
                        }
                    }else{

                        if($plantilla->descripcion==$atributosCambiar['descripcion']){
                            $plantilla->nombre=$atributosCambiar['nombre'];
                            if($plantilla->validate() && $plantilla->save()){                     
                                $msj=['estado'=>'ok','plantilla'=>$plantilla];
                            }else{
                                $msj=['estado'=>'bad Name','plantilla'=>$plantilla->getErrors()];
                            }
                        }else{
                            $plantilla->descripcion=$atributosCambiar['descripcion'];
                            if($plantilla->validate() && $plantilla->save()){                        
                                $msj=['estado'=>'ok','plantilla'=>$plantilla];
                            }else{
                                $msj=['estado'=>'bad Description','plantilla'=>$plantilla->getErrors()];
                            }
                        }
                    }
                }
            }
        }
        return $msj;
    }

    // public function actionEliminarPlantilla($id_eli){
    //     return Plantilla::findOne($id_eli)->deleteAll()?print_r("eliminado"):print_r("Error id incorrecto");
    // }  
    public function actionEliminarPlantilla(){
        $id_plE=Yii::$app->request->getBodyParam('id');
        $plantillaEliminar=Plantilla::findOne($id_plE);
        return $plantillaEliminar->delete()?"eliminado":"no existe plantilla";
    }  

    public function actionListarPlantillas(){
        return Plantilla::find()->all();
    }
    public function actionGetPlantilla($id_get){
                 
            $error=null;           
            if(Plantilla::find()->where('=','id_plantilla',$id_get)){
                if(Plantilla::findOne($id_get)){
                    $plantillaSeleccionada=Plantilla::findOne($id_get);
                    $error=['msj'=>'ok','plantilla'=>$plantillaSeleccionada];
                }else{
                    $error=['msj'=>'La plantilla seleccionada no tiene informacion','plantilla'=>null];
                }            
            }else{
                $error=['msj'=>'La plantilla seleccionada no existe','plantilla'=>null];
            }
            return $error;     
        
    }
    public function actionPlantillasExpositor(){
        $valorExpositor=
        Plantilla::find()        
        ->where(["nombre"=>"expositor"])
        ->count();
        return $valorExpositor;
    }
    public function actionPlantillasParticipacion(){
        $valorParticipacion= Plantilla::find()
        ->where(["nombre"=>"participacion"])
        ->count();
        return $valorParticipacion;
    }
    public function actionPlantillasAprobacion(){
        $valorAprobacion= Plantilla::find()
        ->where(["nombre"=>"aprobacion"])
        ->count();
        return $valorAprobacion;
    }
}