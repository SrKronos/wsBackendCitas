<?php
class Conexion{
    public static function Conectar(){
        $dsn = "base";
        $usuario ="dba";
        $clave = "clave";
        $driver = "SQL Anywhere 11";
        $rutaServidor = "localhost";
        $nombreBaseDeDatos = "base";
        //$conexion = odbc_connect("Driver={".$driver."};", $usuario, $clave);
        //$conexion = odbc_connect("Driver={".$driver."};",$dsn, $usuario, $clave);
        $conexion = odbc_connect($dsn, $usuario, $clave);
        //dblib:version=7.0;charset=UTF-8;host=domain.example.com;dbname=example;
        /*if(!$conexion){
            echo "Conexion Fallo";
        }else{
            echo "Conexion Exitosa!";
        }
        */
        //$link = new PDO('dblib:host='.$rutaServidor.';dbname='.$nombreBaseDeDatos, $usuario, $clave);
        //$link -> exec("set names utf8");
        return $conexion;
    }
}
