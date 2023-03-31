<?php

class ConexionModel{

    protected $conexion;

    public function connect(){
        $this->conexion = mysqli_connect("localhost","root","","foursevenplay");
        // if(mysqli_connect_errno()){
        //     echo "BD ERROR CONECTION".mysqli_connect_error();
        // }
        // else
        //     echo "CCONECTION SUCCESSFULLY";
    }

    public function disconnect()
    {
         $data = mysqli_close($this->conexion);
         return $data;
    }
    public function query(String $query)
    {
        $data = mysqli_query($this->conexion,$query);
        return $data;
    }


}

?>
