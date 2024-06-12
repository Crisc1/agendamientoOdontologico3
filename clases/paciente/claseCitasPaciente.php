<?php  

class claseCitasPaciente{
    private $idProfesional;
    private $documento;
    private $idTratamiento;
    private $fecha;
    private $hora;
    private $idConsultorio;
    private $idCita;
    
    public function __construct(){
        $this->idProfesional="";
        $this->documento="";
        $this->idTratamiento="";
        $this->fecha="";
        $this->hora="";
        $this->idConsultorio="";
        $this->idCita="";
        
    }
    
    public function agendarCita($idProfesional, $documento, $idTratamiento, $fecha, $hora, $idConsultorio) {
            $this->idProfesional= $idProfesional;
            $this->documento= $documento;
            $this->idTratamiento= $idTratamiento;
            $this->fecha= $fecha;
            $this->hora= $hora;
            $this->idConsultorio= $idConsultorio;
        }
        
    public function consultarCitasPaciente($documento) {
        $this->documento= $documento;
    }
    
    public function consultarCitasCalificar($documento) {
        $this->documento= $documento;
    }
    
    function  getIdProfesional(){
        return $this->idProfesional;
    } 

    function  getDocumento(){
        return $this->documento;
    } 
    
    function  getIdTratamiento(){
        return $this->idTratamiento;
    } 
    
    function  getFecha(){
        return $this->fecha;
    } 
    
    function  getHora(){
        return $this->hora;
    } 
    
    function  getIdConsultorio(){
        return $this->idConsultorio;
    } 
    
    function  getIdCita(){
        return $this->idCita;
    } 
}
