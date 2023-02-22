<?php
require MODELS_PATH . "get.php";

class GetController
{
    public $table;
    public $model;
    public $sentence_where="";

    function __construct($table)
    {
        $this->table = $table;
        $this->model = new GetModel($this->table);
    }
    /*--===============================================
    FUNCIONES PARA EL ENVIO DE LA DATA
    =================================================*/
    public function getAll()
    {
        return $this->model->getAll();
    }
    public function getOne($id)
    {
        return $this->model->getOne($id);
    }
    public function getDataWithWhere($getAssoc)
    {
        $cadena="";
        foreach ($getAssoc as $clave => $valor) {
            $cadena .= $clave[0] . ".id=" . "'$valor'" . " and ";
        }
        $this->sentence_where="WHERE ". rtrim($cadena," and ");
    }
    public function getAllDataTables(){
        $data=$this->model->getAllDataTables($this->sentence_where);
        //EL PROBLEMA DE ESTA DATA ES Q LOS VALORES DEL ARREGLO SON CADENAS JSON() POR ELLO DEBEMOS DECODIFICARLAS PARA VOLVERLAS A CODIFICAR
        
        return $data = array_map(function($item) {
            return array_map('json_decode', $item);
        }, $data);
       
    }
}
