<?php

require_once("palabra.php");
require_once("classConexion.php");

class daoPalabra extends Conexion { //Esta clase hereda de Conexión.

    public function Insertar($palabra) //Función que me permite insertar palabra
	           {  //Por un lado hago la consulta y por otro lado le paso los parámetros, que me los coge vía GET del objeto palabra que recibe como parámetro
			      $consulta="insert into palabras values (:Palabra, 
	                            			              :Veces)";
												

                  $param=array(":Palabra"=>$palabra->__GET("Palabra"),
				               ":Veces"=>$palabra->__GET("Veces")
							   );     								
										

                  $this->ConsultaSimple($consulta,$param); //Ejecuto la consulta
				  
				 		   
               }
               
    public function Actualizar($palabra) //Función que me permite actualizar palabras
	           { //Por un lado hago la consulta y por otro lado le paso los parámetros, que me los coge vía GET del objeto palabra que recibe como parámetro
                  
                $consulta="select Veces from palabras WHERE Palabra=:Palabra"; //Select para ver en la BBDD cuántas veces está x palabra
                
                $param=array(
                    ":Palabra"=>$palabra->__GET("Palabra") //Cojo la palabra para el WHERE
                );

                $this->Consulta($consulta,$param); //Ejecuto la consulta
              
                $veces = $this->datos[0]["Veces"]; //Dame las veces que me has guardado en el array datos

                $consulta="update palabras set Veces=:Veces 
                                                       
									where Palabra=:Palabra     "; 	//Sentencia SQL para actualizar las veces				  

                  $param=array(":Palabra"=>$palabra->__GET("Palabra"),
				               ":Veces"=>$palabra->__GET("Veces") + $veces //$palabra es la palabra de la sesión y veces las veces que esa palabra tiene en la BBDD
							   );    

                  $this->ConsultaSimple($consulta,$param); 	//Ejecuto el update	   
			   }


    public function Existe($palabra){ //Función que me permite ver si existe una palabra en la BBDD o no

				   
            $consulta="select * from palabras where Palabra=:Palabra"; //Construyo la consulta SQL

            $param=array(":Palabra"=>$palabra->__GET("Palabra")); //Esta consulta sí lleva un parámetro, la palabra

            $this->Consulta($consulta,$param); //Ejecuto la consulta

            $existe=false;
          
            if (count($this->datos) > 0 )         //Si la palabra está en la BBDD
            {
               $existe=true;  //Y seteo a $existe el valor true
            }

            return $existe; //Devuelvo el valor

    }

}

?>