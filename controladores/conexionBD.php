<?php

class conexionBD {
    private $mySQLI;
    private $sql;
    private $result;
    private $filasAfectadas;
    private $datos;
  
    public function abrir() {
        $this->mySQLI = mysqli_connect("localhost:3306", "root", "", "bd_odontologia");
        if(mysqli_connect_error()){
            return 0;
        }else{
            return 1;
        }
    }
    
    public function consultar($sql) {
        $this->sql =$sql;
        $conec = $this->mySQLI;
        $this->result = mysqli_query($conec, $sql);
        $this->filasAfectadas = $this->mySQLI->affected_rows;
    }
    
    public function obtenerResult() {
        return $this->result;
    }
    
    public function obtenerFilasAfectadas(){
        return $this->filasAfectadas;
    }
    
    public function confirmarDatos() {
        return $this->datos;
    }
    public function cerrar() {
        $this ->mySQLI->close();
    }
}
