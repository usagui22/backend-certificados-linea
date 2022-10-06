<?php
namespace app\controllers;

use app\models\Rol;
use app\models\Unidad;
use app\models\Usuario;
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

    public function actionVerUnidades(){
         $unidad=Unidad::find()->all();
         return $unidad;
    }

    public function actionCrearUnidad(){
        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $unidad =new Unidad();
        $msj=null;
        $datos=Yii::$app->request->getBodyParams();
        if(isset($unidad)){
            
            $unidad->attributes=$datos;

            if($unidad->validate() && $unidad->save()){                
                 $msj=["guardado"=>true,"unidad"=>$unidad];
            }else{
                 $msj=["guardado"=>false, "unidad"=>$unidad->getErrors()];
            }
        }else{
            $msj="no han llegado datos a la base de datos";
        }

        return $msj;
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

    public function actionEliminarUnidad(){
        $unidadELiminar=Yii::$app->request->getBodyParam('id_eli');
        return Unidad::findOne($unidadELiminar)->delete()?"eliminado":"error unidad no existe";
    }

    public function actionListarResponsables(){
        $usuarios =  Usuario::find()
        ->select(["nombres", "apellido_paterno","apellido_materno"])
        ->where(["id_rol" =>1])
        //->where("id_rol = 1")
        // ->andWhere(rol=="RSP")
        ->all();

        // foreach($usuarios as $u){
        //     $u->rol->rol;
        // }    
        return $usuarios;
    }

    public function actionEncargado(){
        $params = Yii::$app->request->getBodyParams();
        $unidad = Unidad::findOne($params["id_unidad"]);
        if($unidad){
            $unidad["encargado"] = $params["id_encargado"];
            if($unidad->save()){
                return [
                    "status" => true,
                    "msg" => "Encargado registrado con éxito"
                ];
            }
        }

        return [
            "status" => false,
            "msg" => "Error al registrar el encargado"
        ];
    }

    public function actionCambiarResponsable($id_resp,$id_uni){
        $unidad=Unidad::findOne($id_uni);
        $usuario=Usuario::findOne($id_resp);
        $msj="";

        if($unidad){
            if($usuario->id_rol=='2'){
                $usuario->id_rol='1';
                $unidad->responsable=$id_resp; 
                $unidad->save();
                $usuario->save();               
                $msj="La unidad cambio el responsable";
            }else{
                $msj="El usuario no puede ser responsable de unidad";
            }
        }else{
            $msj="El identificador no es el correcto";
        }
        return $msj;
    }
    public function actionGetUnidad($id_editar){             
        $error=null;           
        if(Unidad::find()->where('=','id_unidad',$id_editar)){
            if(Unidad::findOne($id_editar)){
                $unidadSeleccionada=Unidad::findOne($id_editar);
                $error=['msj'=>'ok','unidad'=>$unidadSeleccionada];
            }else{
                $error=['msj'=>'La unidad seleccionada no tiene informacion','unidad'=>null];
            }            
        }else{
            $error=['msj'=>'La unidad seleccionada no existe','unidad'=>null];
        }
        return $error;     
    }
    public function actionListarUsuario(){
        $lista=Usuario::find()
        ->select(['id', 'nombres', 'apellido_paterno','apellido_materno','ci','id_rol'])
        ->all();        
        return $lista;
    }

    public function actionUnidadesRegistradas(){
        $unidadesRegistradas=Unidad::find()->count();
        return $unidadesRegistradas;
    }
}


