<?php
namespace app\controllers;

use app\models\Evento;
use app\models\Unidad;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Week;
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

    public function actionCrearEvento(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $evento = new Evento();
        $valores =Yii::$app->request->getBodyParams();
        $msj="";
        if(isset($valores)) {
            $evento->nombre=$valores['nombre'];
            $evento->id_unidad=$this->getIdxNombre([$valores['nombre_unidad']]);
            $evento->url_convocatoria=$valores['url_convocatoria'];            
            $evento->fecha_inicio=$valores['fecha_inicio'];
            $evento->registro_fin=$valores['registro_fin'];
            $evento->inicio_actividades=$valores['inicio_actividades'];
            $evento->fin_actividades=$valores['fin_actividades'];
            $evento->inicio_emision=$valores['inicio_emision'];
            $evento->fecha_fin=$valores['fecha_fin'];
            if($evento->validate()&&$evento->save()){
                $msj=["ok"=>true,"evento"=>$evento];
            }else{
                $msj=["ok"=>false,"evento"=>$evento->getErrors()];
            }

        }
        return $msj;
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
    public function actionEliminarEvento(){
        $id_bor=Yii::$app->request->getBodyParam('id');
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
//listar eventos con el nombre de la unidad en vez del identificador
    public function actionListarEventos(){
        $eventos=Evento::find()                
        ->all();             
        return $eventos;
    }

    public function verNombre($id_uni){
        $nombre=Unidad::findOne($id_uni);
        return $nombre;
    }
    public function actionGetEvento($id_editar){
        return Evento::findOne($id_editar);
    }
    public function actionEventosFinalizados(){        
        $contEveFin=0;
        $tam=Evento::find()->count();
        $eventosFinalizados=null;
        for ($i=1; $i <=$tam; $i++) { 
            $evento=Evento::findOne($i);                 
            if($this->verificarFecha($evento->fecha_fin)==true){                
                $contEveFin++;                
            }else{
                $i++;
            }
        }
        //return $eventosFinalizados=['numeroEventos'=>$contEveFin,'evento'=>$evento];        
        return $contEveFin;
    }
    public function actionEventosEnCurso(){
        $conEveC=0;
        $tam=Evento::find()->count();
        for($j=1;$j<=$tam;$j++){
            $evento=Evento::findOne($j);                 
            if($this->verificarFecha($evento->fecha_fin)!=true){                
                $conEveC++;                
            }else{
                $j++;
            }
        }
        return $conEveC;
    }
    private function verificarFecha($fecha){
        $fechaActual=time();
        //strtotime(date("d-m-Y"));
        $siEs=false;
        if($fecha<=$fechaActual){
            $siEs=true;
        }        
        return $siEs;
    }
    
}
