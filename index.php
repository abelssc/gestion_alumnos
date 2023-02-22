<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json");
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');

require $_SERVER["DOCUMENT_ROOT"]."/gestion_alumnos/config/dirs.php";
/*--===============================================
EN ESTE PRIMER BLOQUE OBTENDREMOS LOS DATOS DE LA PETICION:
**LA TABLA
**EL ID
**Y EL METODO DE LA PETICION 
=================================================*/
function obtenerDatosdelaURL(){
    ##Obtenemos la url /gestion_alumnos/tabla[/id]/
    $url_actual = parse_url($_SERVER["REQUEST_URI"]);
   
    ##Eliminamos las / al inicio y al final de la url: gestion_alumnos/tabla[/id]
    $ruta = trim($url_actual["path"], '/');
    
    ##Obtenemos los fragmentos de la ruta
    $fragmentos_de_ruta = explode("/", $ruta);
    $tabla = $fragmentos_de_ruta[1]??null; 
    $id = $fragmentos_de_ruta[2] ?? null;
    $tabla2=$fragmentos_de_ruta[3]??null;
    $id2=$fragmentos_de_ruta[4]??null;
  
    ##Obtenemos el metodo de la peticion
    $method= $_SERVER["REQUEST_METHOD"];

    return array(
        "tabla"=>$tabla,
        "id"=>$id,
        "tabla2"=>$tabla2,
        "id2"=>$id2,
        "method"=>$method
    );
}
$datosURL=obtenerDatosdelaURL();
/*--===============================================
EN EL RESTO DEL CODIGO:
**LLAMAREMOS AL CONTROLADOR
**EVALUAREMOS EL METODO DE ENVIO
**OBTENDREMOS EL JSON DE LA PETICION
**LLAMAREMOS A LA CLASE CORRESPONDIENTE
**IMPRIMIREMOS LA RESPUESTA EN JSON
=================================================*/

##INCLUIMOS EL CONTROLADOR PARA EL METODO ESPECIFICO
include(CONTROLLERS_PATH . $datosURL['method'] . '.php');


##EVALUAMOS EL METHODO DE ENVIO
if($datosURL['method']==="GET"){
    ##LLAMAMOS AL CONTROLADOR GET CON SU RESPECTIVA TABLA
    $class= new GetController($datosURL['tabla']);
    ##SI NO SE ENVIA TABLA EN LA URL SE HACE LLAMADO A TODA LA DATA
    if(isset($datosURL['tabla2'])){
        $get=array($datosURL['tabla']=>$datosURL['id'],$datosURL['tabla2']=>$datosURL['id2']);
        $class->getDataWithWhere($get);
        echo json_encode($class->getAllDataTables());
    }
    else if($datosURL['tabla']==="all"){
        $get=array($datosURL['tabla']=>$datosURL['id']);
        $class->getDataWithWhere($get);
        echo json_encode($class->getAllDataTables());
    }
    else{
        ##REALIZAMOS LA PETICION CON /RUTA[/ID]?
        echo (is_null($datosURL['id']))
        ? json_encode($class->getAll())
        : json_encode($class->getOne($datosURL['id']));
    }
}
else if($datosURL['method']==="POST"){
    $class = new PostController($datosURL['tabla']);
    $json = json_decode(file_get_contents('php://input'), true);
    echo json_encode($class->setJson($json));
}
else if($datosURL['method']==="PUT"){
    if(isset($datosURL['tabla2'])){
        $class = new PutController("notas");
        $get=array($datosURL['tabla']=>$datosURL['id'],$datosURL['tabla2']=>$datosURL['id2']);
        $class->updateDataWithWhere($get);
        $json = json_decode(file_get_contents('php://input'), true);
        $class->setJson($json);

        echo json_encode($class->putWhere());
    }else{
        $class = new PutController($datosURL['tabla']);
        $json = json_decode(file_get_contents('php://input'), true);
        $class->setJson($json);
        echo json_encode($class->put($datosURL['id']));
    }
}
else if($datosURL['method']==="DELETE"){
    $class = new DeleteController($datosURL['tabla']);
    echo json_encode($class->delete($datosURL['id']));
}
else{
    echo "metodo no permitido";
    exit;
}
