<?php
include("conexion.php");
//&& $_GET["datos"]=="all" && isset($_GET["desde"]) && $_GET["desde"]!="" && isset($_GET["hasta"]) && $_GET["hasta"]!="" 
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET, POST');
header('Access-Control-Allow-Headers:X-Requested-With');
header('Content-Type: application/json');
mb_internal_encoding('UTF-8');
static $fecha_actual = "";  
// Esto le dice a PHP que generaremos cadenas UTF-8

if(isset($_GET["doctor"]) && $_GET["doctor"]!=null && isset($_GET["fechaInicio"]) && $_GET["fechaInicio"]!=null && isset($_GET["fechaFinal"]) && $_GET["fechaFinal"]!=null ){
	pacientes($_GET["doctor"],$_GET["fechaInicio"],$_GET["fechaFinal"]);
}else if(isset($_GET["fechaInicio"]) && $_GET["fechaInicio"]!=null && isset($_GET["fechaFinal"]) && $_GET["fechaFinal"]!=null ){
	doctores($_GET["fechaInicio"],$_GET["fechaFinal"]);
}





function pacientes($doctor,$desde,$hasta){
	try 
	{
        $dsn = "arboledadb";
        $usuario ="dba";
        $clave = "proyecto2014";
        $conexion = odbc_connect($dsn, $usuario, $clave);    
	    $sql= "select distinct top 3 paciente,tipo,reserva_desde,reserva_hasta,comentario,doctor,codigo_doctor 
		from vmostrarcitas  where tipo='*CONSULTAS' AND codigo_doctor='".$doctor."' 
		AND reserva_desde>='".$desde."' AND reserva_hasta<='".$hasta."' 
		GROUP BY paciente,tipo,reserva_desde,reserva_hasta,comentario,doctor,codigo_doctor  ORDER BY reserva_desde ASC";
	    $result=odbc_exec($conexion,$sql)or die(exit("Error en odbc_exec"));
        while($myRow = odbc_fetch_array( $result )){ 
            $rows[] = $myRow;
        }
    
		$objeto = [];
		$cita = [];
		$final = [];
        foreach($rows as $row) {
			foreach($row as $key => $value) {
				$cita[$key] = utf8_encode($value);
			}
			array_push($objeto,$cita);
		}	
		echo json_encode($objeto);
	} 
	catch(PDOException $e) 
	{
		echo '<h1>Error al obtener citas.</h1><pre>', $e->getMessage(),'</pre>';
		//echo '[{"paciente":"","reserva_desde":"2020-01-01","reserva_hasta":"2020-01-01","comentario":""}]';
	}	
}

function doctores($fechaInicio,$fechaFinal){
	try 
	{
        $dsn = "arboledadb";
        $usuario ="dba";
        $clave = "proyecto2014";
        $conexion = odbc_connect($dsn, $usuario, $clave);
	   $sql= "select distinct top 6  codigo_doctor,doctor,especialidad from vmostrarcitas 
	   		WHERE reserva_desde>='".$fechaInicio."' 
			AND reserva_hasta<='".$fechaFinal."' 
			AND tipo='*CONSULTAS' group by codigo_doctor,doctor,especialidad 
			order by doctor ASC";
	   $result=odbc_exec($conexion,$sql)or die(exit("Error en odbc_exec"));
	   
        while($myRow = odbc_fetch_array( $result )){ 
            $rows[] = $myRow;
        }
    
		$objeto = [];
		$cita = [];
		$final = [];
        foreach($rows as $row) {
			foreach($row as $key => $value) {
				$cita[$key] = utf8_encode($value);
			}
			array_push($objeto,$cita);
		}	
		echo json_encode($objeto);
	} 
	catch(PDOException $e) 
	{
		echo '<h1>Error al obtener citas.</h1><pre>', $e->getMessage(),'</pre>';
		//echo '[{"codigo_doctor":"000","doctor":"-","especialidad":"-"}]';
	}	
}

function todos(){

	try 
	{
        $dsn = "arboledadb";
        $usuario ="dba";
        $clave = "proyecto2014";
        $conexion = odbc_connect($dsn, $usuario, $clave);
       // $sql= "select * from vmostrarcitas where reserva_desde>=".$_GET["desde"]." and reserva_hasta<=".$_GET["hasta"];
	    $sql= "select top 3 * from vmostrarcitas where tipo='*CONSULTAS' order by proforma DESC";
	    $result=odbc_exec($conexion,$sql)or die(exit("Error en odbc_exec"));
       // print odbc_result_all($result,"border=1");

        while($myRow = odbc_fetch_array( $result )){ 
            $rows[] = $myRow;//pushing into $rows array
        }
        
        //Now iterating complete array
    
        $objeto = [];
		$cita = [];

        
        foreach($rows as $row) {
                foreach($row as $key => $value) {
                    $dato = $value;
					$cita[$key] = $value;
                }
				array_push($objeto,$cita);
        }
        
		echo json_encode($objeto);
        //$out = array_values($rows);
	} 
	catch(PDOException $e) 
	{
		echo '<h1>Error al obtener citas.</h1><pre>', $e->getMessage()
				,'</pre>';
	}	
}
