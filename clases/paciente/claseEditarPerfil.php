<?php
class claseEditarPerfil{
    private $documento;
    private $nombre;
    private $apellido;
    private $fecha_nacimiento;
    private $correo;
    private $telefono;
    private $direccion;

    
    public function __construct(){
        $this->documento="";
        $this->nombre="";
        $this->apellido="";
        $this->fecha_nacimiento="";
        $this->correo="";
        $this->telefono="";
        $this->direccion="";
        
    }
    
    public function consultarInfoPerfil($documento) {
        $this->documentoPersona= $documento;
    }
    
    public function editarPersona($documento, $nombre, $apellido, $fecha_nacimiento, $telefono, $correo, $direccion) {
        $this->documento= $documento;
        $this->nombre= $nombre;
        $this->apellido= $apellido;
        $this->fecha_nacimiento= $fecha_nacimiento;
        $this->telefono= $telefono;
        $this->correo= $correo;
        $this->direccion= $direccion;
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