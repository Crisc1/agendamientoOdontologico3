<?php
class claseCitasOdontologo{
    private $idProfesional;
    
    public function __construct(){
        $this->idProfesional="";     
    }
    
    public function consultarAgendas($IdProfesional) {
        $this->idProfesional= $IdProfesional;
    }
    
    
    function  getIdProfesional(){
        return $this->idProfesional;
    } 
}
