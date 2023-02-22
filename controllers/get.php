<?php
require MODELS_PATH . "get.php";

class GetController
{
    public $table;
    public $model;

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
    public function getWithWhere($getAssoc)
    {
        $cadena="";
        foreach ($getAssoc as $clave => $valor) {
            $cadena .= $clave . "=" . "'$valor'" . " and ";
        }
        $cadena=rtrim($cadena," and ");
        return $this->model->getData($cadena);
    }
    public function getDataAllTables(){
        $data=$this->model->getDataAllTables();
        //EL PROBLEMA DE ESTA DATA ES Q LOS VALORES DEL ARREGLO SON CADENAS JSON() POR ELLO DEBEMOS DECODIFICARLAS PARA VOLVERLAS A CODIFICAR
        return $data = array_map(function($item) {
            return array_map('json_decode', $item);
        }, $data);
       

    }
}
