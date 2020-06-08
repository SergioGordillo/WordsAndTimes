<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Mayo 2020 Todo Curso</title>
</head>
<body>

<?php

    require_once "classConexion.php";
    require_once "daoPalabra.php";
    require_once "palabra.php";


    session_start(); //Inicio la sesión

    if(!isset($_SESSION['palabras'])){
        $_SESSION['palabras']=array(); // Si la sesión no está iniciada, la seteo con un array 
    }

    function palabraRepetida($array, $palabra){ //Función que me permite saber si una palabra está en un array
	
        for($i = 0; $i < count($array); $i++){
            
            $valor = $array[$i]; //Así cojo el valor de array[i];
            if($valor->__GET("Palabra") === $palabra){ //Comparo la palabra del array (de las sesiones) con la palabra del texto
                return true;
            } //Si coincide devuelvo true y sino devuelvo false
            
        }
        return false;
    }


    if(isset($_POST['insertar'])){ //Si está seteado insertar, recojo los datos de las palabras

        $texto=$_POST['textarea']; //Cojo las palabras 

        $palabras=explode(" ",$texto); //Separo el texto en palabras mediante el método explode

        foreach ($palabras as $key => $palabra) { //Recorro las palabras del texto
            
            if(trim($palabra) !== ""){ //Trim quita los espacios a la palabra por delante y por detrás y, por tanto, si es distinto de vacío entra
                if(!palabraRepetida($_SESSION['palabras'], trim(strtoupper($palabra) ) ) ) { //Si la palabra no está en las palabras de la sesión

                    $nuevaPalabra = new Palabra(); //Creo una nueva palabra
                    //Como no tengo constructores, tengo que setear los valores
                    $nuevaPalabra->__SET("Palabra", trim(strtoupper($palabra)));
                    $nuevaPalabra->__SET("Veces", 1);

                    array_push($_SESSION['palabras'], $nuevaPalabra); //Inserto el objeto nuevaPalabra en la sesión
                } else { //Si la palabra si está en las palabras de la sesión. Con el foreach y el if sólo sé si dicha palabra está repetida o no, pero necesito acceder al índice para poder setearle las veces. Por tanto:

                    for($i = 0; $i < count($_SESSION['palabras']); $i++){
                    
                        if(trim(strtoupper($palabra)) === $_SESSION['palabras'][$i]->__GET("Palabra")){ //Si la palabra que está en el textarea y ya sé que está en las variables de sesión es igual que la palabra que estoy recorriendo con índice x dentro del array de las variables de sesión 
                            
                            // $_SESSION['palabras'][$i]->setVeces($_SESSION['palabras'][$i]->getVeces() + 1);

                            $_SESSION['palabras'][$i]->__SET("Veces", $_SESSION['palabras'][$i]->__GET("Veces") + 1);
                        }
                    }

                }
                
            }
        }
    }else if (isset($_POST['vaciar'])){

        unset($_SESSION['palabras']); //Destruyo los datos almacenados en la sesión

    } else if (isset($_POST['volcar'])){

        //Tendré en primer lugar que ver si x palabra se encuentra en la BBDD o no
        //Si se encuentra, actualizo, en caso contrario, inserto

        $daoPalabra=new daoPalabra("examen"); //Me conecto a la BBDD

        foreach ($_SESSION['palabras'] as $key => $palabra) {

            if($daoPalabra->Existe($palabra)){ //Si la palabra existe en la BBDD

                $daoPalabra->Actualizar($palabra); //Procedo a actualizar la palabra en la BBDD

            } else { //En caso de que la palabra no exista en la BBDD

                $daoPalabra->Insertar($palabra); //Procedo a insertar la palabra en la BBDD

            }

            
        }

        echo "Has realizado las operaciones solicitadas en la BBDD."; 

    }else if(isset($_POST['ordenar'])){ //Si he seleccionado ordenar

        $texto=$_POST['textarea']; //Cojo las palabras 

        $palabras=explode(" ",$texto); //Separo el texto en palabras mediante el método explode

        if(isset($_POST['selectordenar'])){

            $orden=$_POST['selectordenar']; 

            if($orden=="ascendente"){
                natcasesort($palabras); //Con la función natcasesort ordeno las palabras de forma alfabética de forma insensible a mayúsculas y minúsculas
            } else if($orden=="descendente"){
                print_r("Has seleccionado ordenar de forma descendente");
                natcasesort($palabras); //Con la función natcasesort ordeno las palabras de forma alfabética de forma insensible a mayúsculas y minúsculas
                $palabras=array_reverse($palabras); //Invierto el array, ya que tiene que estar ordenado de forma descendente. Array_reverse necesita guardar el resultado en una variable, a diferencia de natcasesort.
                
            } else if ($orden==-1){
                print_r("Tienes que seleccionar una forma de ordenar el texto"); 
            }





        }

    } else if(isset($_POST['mostrar'])){

        print_r($_SESSION['palabras']);


    }



?>


<form method="POST" name="formulario" action="<?php $_SERVER['PHP_SELF']?>">

<label for="textarea">Inserte el contenido del texto</label>
<br><br>
<textarea name="textarea" rows="20" cols="50">
<?php
    if(isset($palabras)){
        foreach ($palabras as $key => $value) {
            print_r($value." "); 
        }
    }
?>

</textarea>

<br><br>
<label for="selectordenar"> Seleccione cómo quiere ordenar </label>
<select name="selectordenar" id="selectordenar">
    <option value="-1">Seleccione cómo quiere ordenar</option>
    <option value="ascendente">Orden Ascendente</option>
    <option value="descendente">Orden Descendente</option>
</select>
<br><br>
<input type="submit" value="Ordenar" name="ordenar"> 
<!-- El valor es lo que muestro y el name lo que recojo -->
<input type="submit" value="Insertar" name="insertar">
<input type="submit" value="Vaciar" name="vaciar">
<input type="submit" value="Volcar" name="volcar">
<input type="submit" value="Mostrar" name="mostrar">


</form>
    
</body>
</html>

