<?php

class claseRegistroPersona{
    private $documento;
    private $tipo_documento;
    private $nombre;
    private $apellido;
    private $fecha_nacimiento;
    private $telefono;
    private $correo;
    private $direccion;
    private $contrasena;
    private $rol;

    
    public function __construct(){
        $this->documento="";
        $this->tipo_documento="";
        $this->nombre="";
        $this->apellido="";
        $this->fecha_nacimiento="";
        $this->telefono="";
        $this->correo="";
        $this->direccion="";
        $this->contrasena="";
        $this->rol="";
    }
    
    public function persona($documento, $tipo_documento, $nombre, $apellido, $fecha_nacimiento, $telefono, $correo, $direccion, $contrasena) {
        $this->documento= $documento;
        $this->tipo_documento= $tipo_documento;
        $this->nombre= $nombre;
        $this->apellido= $apellido;
        $this->fecha_nacimiento= $fecha_nacimiento;
        $this->telefono= $telefono;
        $this->correo= $correo;
        $this->direccion= $direccion;
        $this->contrasena= $contrasena;
    }
    
    public function editarPaciente($documento, $tipo_documento, $nombre, $apellido, $fecha_nacimiento, $telefono, $correo, $direccion, $contrasena) {
        $this->doc= $documento;
        $this->tipo_documento= $tipo_documento;
        $this->nombre= $nombre;
        $this->apellido= $apellido;
        $this->fecha_nacimiento= $fecha_nacimiento;
        $this->telefono= $telefono;
        $this->correo= $correo;
        $this->direccion= $direccion;
        $this->contrasena= $contrasena;
    }

    function  getDocumento(){
        return $this->documento;
    }
    
    function getTipo_documento(){
        return $this->tipo_documento;
    }
    
    function getNombre(){
        return $this->nombre;
    }
    
    function getApellido(){
        return $this->apellido;
    }
    
    function getFecha_nacimiento(){
        return $this->fecha_nacimiento;
    }
    
    function getTelefono(){
        return $this->telefono;
    }
    
    function getCorreo(){
        return $this->correo;
    }
    
    function getDireccion(){
        return $this->direccion;
    }
    
    function getContrasena(){
        return $this->contrasena;
    }
    
    function getRol(){
        return $this->rol;
    }
    
    function getid_cita(){
        return $this->id_cita;
    }
} 
