<?php
class claseEditarPerfil{
    private $documentoPersona;
    private $nombre;
    private $apellido;
    private $fecha_nacimiento;
    private $correo;
    private $telefono;
    private $direccion;

    
    public function __construct(){
        $this->documentoPersona="";
        $this->nombre="";
        $this->apellido="";
        $this->fecha_nacimiento="";
        $this->correo="";
        $this->telefono="";
        $this->direccion="";
        
    }
    
    public function consultarInfoPerfil($documentoPersona) {
        $this->documentoPersona= $documentoPersona;
    }
    
    public function guardarInfoPerfil($documentoPersona, $nombre, $apellido, $fecha_nacimiento, $correo, $telefono, $direccion) {
        $this->documentoPersona= $documentoPersona;
        $this->documentoPersona= $nombre;
        $this->documentoPersona= $apellido;
        $this->documentoPersona= $fecha_nacimiento;
        $this->documentoPersona= $correo;
        $this->documentoPersona= $telefono;
        $this->documentoPersona= $direccion;
    }
    
    function  getDocumentoPersona(){
        return $this->documentoPersona;
    }
    
    function  getNombre(){
        return $this->nombre;
    }
    
    function  getApellido(){
        return $this->apellido;
    }
    
    function  getFecha_nacimiento(){
        return $this->fecha_nacimiento;
    }
    
    function  getCorreo(){
        return $this->correo;
    }
    
    function  getTelefono(){
        return $this->telefono;
    }
    
    function  getDireccion(){
        return $this->direccion;
    }
}