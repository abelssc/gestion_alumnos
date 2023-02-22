<?php
require CONFIG_PATH . "conexion.php";
class GetModel
{
    public $table;
    public $dbh;

    public function __construct($table)
    {
        $this->table = $table;
        $this->dbh = Conexion::getConexion();
    }

    public  function getAll()
    {
        $stmt = $this->dbh->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public  function getOne($id)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM $this->table WHERE id='$id'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getData($cadena)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM $this->table WHERE $cadena");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllDataTables($sentence_where)
    {
        $stmt = $this->dbh->prepare("
        SELECT 
            JSON_OBJECT(
                'id',a.id,
                'nombres', a.nombres,
                'apellidos', a.apellidos,
                'sexo', a.sexo,
                'fecha_nacimiento', a.fecha_nacimiento
            ) AS 'alumnos',
            JSON_OBJECT(
                'id',c.id,
                'nombre', c.nombre,
                'descripcion', c.descripcion
            ) AS 'cursos',
            JSON_OBJECT(
                'practica1', n.practica1,
                'practica2', n.practica2,
                'practica3', n.practica3,
                'parcial', n.parcial,
                'final', n.final,
                'promedio_final', ROUND(((n.practica1+n.practica2+n.practica3)/3+n.parcial+n.final*2)/4,0)
            ) AS 'notas'
        FROM alumnos a
        JOIN notas n ON a.id = n.alumno_id
        JOIN cursos c ON n.curso_id = c.id
        $sentence_where
        ");
        $stmt->execute();
        //DEVUELVE LOS VALORES EN FORMATO JSON, TENEMOS Q DECODIFICARLO
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
