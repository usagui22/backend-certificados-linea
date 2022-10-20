<?php
namespace app\controllers;

use app\models\Documento;
use app\models\Evento;
use app\models\Plantilla;
use app\models\Usuario;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class DocumentoController extends Controller{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'crear-documento' => ['POST'],
                        'actualizar-documento'=>['POST'],
                        'eliminar-documento'=>['POST']
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
    public function actionCrearDocumentoAdmin(){
        $documento = new Documento();
        $nuevoDatos=Yii::$app->request->getBodyParams();
        
        if(isset($nuevoDatos)){
            $documento->attributes=$nuevoDatos;
            $documento->nombre_integrante=$this->selectIntegrante($nuevoDatos['nombre_integrante']);
            $documento->id_evento=$this->selectEvento($nuevoDatos['evento']);
            $documento->id_plantilla=$this->selectPlantilla($nuevoDatos['plantilla']);
            if($documento->validate() && $documento->save()){
                return $documento;
            }else{
                return $documento->getErrors();
            }
        }
    }
    // public function actionCrearDocumento()
    // {
    //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //     $documento = new Documento();
    //     $params=Yii::$app->request->getBodyParams();        
    //     $clave="crypt";
    //     //$this->ruleta(5);        
    //     //$clave=crypt();
    //     if (isset($params)) {
    //         $documento['nombre_integrante']=$params['nombre_integrante'];
    //         $documento['hash']=Yii::$app->getSecurity()->generatePasswordHash($clave);
    //         //$documento['hash']=sha1($clave);
    //         //$documento['fecha_confirmacion']=preguntarEstado();
    //         // $documento['id_tipo_documento']=$this->selectTipo($params['nombre_documento']);
    //         $documento['nota_valoracion']=$params['nota_valoracion'];            
    //         $documento['id_evento']=$this->selectEvento($params['nombre']);
    //         $documento['id_plantilla']=$this->selectPlantilla($params['nombre']);
    //         $documento['path']='http://'.$_SERVER['HTTP_HOST'].'/'.$this->generarPath($params['file']);

    //         if ($documento->validate()&&$documento->save()) {
    //             return $documento;
              
    //         }else {
    //             return $documento->getErrors();
    //             }
    //     }          
    // }

    public function actionActualizarDocumento($id_ac)
    {
        $documento = Documento::findOne($id_ac);        
        
        if(isset($documento)){
            $documento->tipo_documento=Yii::$app->request->getBodyParam('tipo_documento');
            if($documento->validate()){
                $documento->save();
                return $documento;        
            }else{
                return $documento->getErrors();
            }
        }        
        
    }

    public function actionEliminarDocumento()
    {        
        $id_doc_eli=Yii::$app->request->getBodyParam('id');
        return Documento::findOne($id_doc_eli)->delete()?"eliminado exitosamente":"id no encontrado";
    }

    private function selectEvento($nameEvento){
        $id_res=null;
        $evento=Evento::find()
        ->select('id_evento')
        ->where(['nombre' => $nameEvento])
        ->one();
        $id_res=$evento['id_evento'];
        return $id_res;
    }
    private function selectIntegrante($nameIntegrante){
        $id=null;
        $integrante=Usuario::find()
        ->select('id_usuario')
        ->where(['nombres'+'apellido paterno'+'apellido_materno'=>$nameIntegrante])
        ->one();
        $id=$integrante['id'];
        return $id;
    }

    private function selectPlantilla($namePlantilla)
    {   
        $id_encontrado=null;
        $tipo=Plantilla::find()
        ->select('id_plantilla')
        ->where(['nombre'=>$namePlantilla])
        ->one();
        $id_encontrado = $tipo['id_plantilla'];
        return $id_encontrado;
    }
    // private function ruleta($vueltas){
    //     $claveRes=null;  
    //     $banco="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    //     if($vueltas>=1){
    //         for($v=1;$v<=$vueltas;$v++){
    //             $claveRes=str_shuffle($banco);
    //         }
    //     }
    //     return $claveRes;
    // }
    

    public function actionCompartirArchivo($doc){        
        $link_doc=null;
        if(isset($doc)){            
            $doc=base64_decode($doc);            
            $key=$this->generarToken(10);            
            // $file->saveAs('archivos/' . $file->baseName . '.' . $file->extension);
            // $link_doc=UploadedFile::getInstance($doc,'file');            
            // $link_doc= \Yii::$app->basePath."/certificates/"."?doc=$doc&key=".$key; 

            //almacenar en carpeta con llave de validacion y hash, generar link de descarga externa
        }
        return $link_doc;
    }
    
    public function generarPath($doc){
        $archivo_validado=null;        
        if(file_exists($doc)){
            $archivo_validado=$this->generarHash($doc);
            $ruta = "documents/certificates/" . "_" .$this->generarToken(5).$archivo_validado;
        }
        return $ruta;
    }    
    
    private function generarToken($tam){
        $cadena="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $token=null;
        for ($r=0; $r < $tam; $r++) { 
            $token.=$cadena[rand(0,62)];
        }
        return $token;
    }

    public function actionListarDocumento(){
        $documentos=Documento::find()->all();
        return $documentos;               
    }

    public function actionSincronizar($ci_usuario,$notaEvento,$codSis){
        $buscarCuenta=Usuario::findOne($ci_usuario);
        $msjeror="";
        if($buscarCuenta->ci==$ci_usuario){
            $buscarCuenta->nota_valoracion=$notaEvento;
            if($buscarCuenta->validate()){
                $buscarCuenta->save();
            }else{
                $msjeror="no se encuentra el usuario ";
            }
        }else{
            $buscarCuenta=Usuario::findOne($codSis);
            if($buscarCuenta->codsis==$codSis){
                $buscarCuenta->nota_valoracion=$notaEvento;                
                $buscarCuenta->save();            
                
            }else{
                $msjeror="El usuario no existe, se solicita una cuenta";
            }
        }
        return $msjeror;
    }
    
//generar un hash a partir del nuevo documento ingresado
    public function actionValidarHash(){
        $documento=new Documento();
        $documento->id_documento=$_POST['id_documento'];
        $baseFront=$_POST['certificado'];
        $basePhp = explode(',', $baseFront);
        $file = base64_decode($basePhp[1]);
        $path = "documentos/certificados/".time();
        file_put_contents($path, $file);
        
        $documento->url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$path;
        
        if(!$documento->save()){
            $response = [
                "isOk"=>false,
                "documento"=>$documento->getErrors()            
            ];
        } else {
            $response = [
                "isOk"=>true,
                "documento"=>$documento,
            ];

        }

    }
    public function actionListarParticipante(){
        $participante=Usuario::find()
        ->select(["id","nombres","apellido_paterno","apellido_materno"])
        ->where(["id_rol"=>2])
        ->all();
        return $participante;
    }
    public function actionListarEvento(){
        $eventos=Evento::find()
        ->select(["id_evento","nombre"])
        ->all();
        return $eventos;
    }
    // public function actionSubirNotas(){
    //     $inputFile='uploads/documents_file.xlsx';
    //     try {
    //         $inputFileType=\PHPExcel_IOFactory::identify($inputFile);
    //         $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
    //         $objPHPExcel=$objReader->load($inputFile);
    //     } catch (Exception $e) {
    //         die('Error');
    //     }
    //     $sheet = $objPHPExcel->getSheet(0);
    //     //$highestRow =$sheet->getSheetRow();
    //     //$highestColumn=$sheet->getSheetColumn();

    //     // for($row=1;$row<=$highestRow;$row++){
    //     //     $rowData=$sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
    //     //     if($row ==1){
    //     //         continue;
    //     //     }            
    //     // }

    // }  
    public function actionGetDocumento(){
        $valorDoc=Documento::find()
        ->count();
        return $valorDoc;
    }
    public function actionGetPlantilla(){
        $id_p=Yii::$app->request->getBodyParam('id_plantilla');
        $plantilla=Plantilla::find($id_p)->one();
        if(isset($plantilla)){
            return $plantilla;
        }else{
            return null;
        }    
    }

    public function actionValidarQr(){
        $datos_Integrante=Yii::$app->request->getBodyParams();        
        $documento=Documento::findOne($datos_Integrante['id']);
        $fechaValida=$datos_Integrante['fecha_confirmacion'];
        if(!is_null($fechaValida)){            
            $documento->hash=$this->generateHashDoc();
            if($documento->save()){
                return $documento;
            }else{
                return $documento->getErrors();
            }
        }
        return "Error la fecha esta vacia";
    }
    // public function actionVerDocumento(){
    //     $id_fondo=Yii::$app->request->getBodyParam('plantilla');
    //     $imagen=Plantilla::find($id_fondo)->one()->getAttribute('plantilla');
    // }
    public function actionGetPlantillaDecode(){
        $nom_pla=Yii::$app->request->getBodyParam('plantilla');
        $img_plantilla=Plantilla::find()->one()->getAttribute($nom_pla);
        $img_fondo=base64_decode($img_plantilla);
        if(!isset($img_fondo)){
            return $img_fondo;
        }else{
            return "no se encuentra imagen";
        }        
    }
}