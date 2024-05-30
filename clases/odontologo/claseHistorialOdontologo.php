<?php
class claseHistorialOdontologo{
    private $documentoPaciente;
    private $fechaOdontograma;
    private $idDiente;
    private $comentario;
    private $idProcedimiento;
    private $procedimiento;
    private $fecha;

    
    public function __construct(){
        $this->documentoPaciente="";
        $this->fechaOdontograma="";
        $this->idDiente="";
        $this->comentario="";
        $this->idProcedimiento="";
        $this->procedimiento="";
        $this->fecha="";

    }
    
    public function odontograma($documentoPaciente, $fechaOdontograma, $idDiente, $comentario) {
        $this->documentoPaciente= $documentoPaciente;
        $this->fechaOdontograma= $fechaOdontograma;
        $this->id_diente= $idDiente;
        $this->comentario= $comentario;
    }
    
    public function consultarOdontograma($documentoPaciente) {
        $this->documentoPaciente= $documentoPaciente;
    }
    
    public function insertarProcedimiento($idProcedimiento, $procedimiento, $fecha) {
        $this->documentoPaciente= $idProcedimiento;
        $this->documentoPaciente= $procedimiento;
        $this->documentoPaciente= $fecha;
    }
    
    function  getDocumentoPaciente(){
        return $this->documentoPaciente;
    } 
}
