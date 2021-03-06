<?php
include("../lib/connect_db.inc.php");
include("../lib/lib.inc.php");
include("../lib/lib.inc2.php");

include("../lib/seguridad.inc.php");
//include("../lib/lib.inc.php");
//include("../lib/lib.inc2.php");

// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"id_region"=>"regiones",
"id_comuna"=>"comunas"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; 
$opcionSeleccionada=$_GET["opcion"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{
	$tabla=$listadoSelects[$selectDestino];

	$consulta=cms_query("SELECT id_comuna, comuna FROM $tabla WHERE id_region='$opcionSeleccionada'") or die(mysql_error());
	
		
	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' >";
	//echo "<option value='0'>Seleccione Comuna</option>";
	while($registro=mysql_fetch_row($consulta))
	{
	
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		//$registro[1]=htmlentities($registro[1]);
		//$registro[1]=acentos($registro[1]);
		// Imprimo las opciones del select
		echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
	}			
	echo "</select>";

}
?>