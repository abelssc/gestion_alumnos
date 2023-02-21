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
}
