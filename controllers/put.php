<?php
require MODELS_PATH."put.php";
class PutController{
    public $table;
    public $model;
    public $sentence_put="";
    public $sentence_where="";

    function __construct($table)
    {
        $this->table=$table;
        $this->model=new PutModel($table);
    }
    public function setJson($json){
        foreach ($json as $key => $value) {
            $this->sentence_put.="$key = '$value', ";
        }
    }
    public function put($id){
        $this->sentence_put=rtrim($this->sentence_put,", ");

        $id=intval($id);
        if($id){
            return $this->model->put($id,$this->sentence_put);
        }
        else{
            return "ID NO PERMITIDO";
        }
    }
    public function updateDataWithWhere($upAssoc)
    {
        $cadena="";
        foreach ($upAssoc as $clave => $valor) {
            $cadena .= $clave . "_id=" . "'$valor'" . " and ";
        }
        $this->sentence_where="WHERE ". rtrim($cadena," and ");
    }
    public function putWhere(){
        $this->sentence_put=rtrim($this->sentence_put,", ");
        return $this->model->putWhere($this->sentence_put,$this->sentence_where);
    }
}

?>