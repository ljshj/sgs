<?php
///error_reporting(E_PARSE);

$tp = $_GET['tp'];

if($tp==2){
error_reporting(E_ALL);
}else{
error_reporting(E_PARSE);
}



include("../lib/connect_db.inc.php"); 

include("../lib/lib.inc.php");

//include("../lib/lib.inc2.php");

include("../lib/lib.sgs.php");   
include("../lib/seguridad.inc.php");   




function version(){
  $query= "SELECT  valor 
			FROM cms_configuracion 
			WHERE configuracion LIKE 'version' ";
     $result= cms_query($query)or die (error($query,mysql_error(),$php));
     if(!list($version) = mysql_fetch_row($result)){
	 	$version="No identificada";
	 
	 }else{
	 $version = str_replace("<a href=\"index.php?accion=licencia\">","",$version);
	 $version = str_replace("</a>","",$version);
	 }
return $version;
}
	  
	  




function info_base($DATABASE){

 $tables = mysql_list_tables( $DATABASE );					//conexion con la base de datos
		 
		while( $line = mysql_fetch_row($tables) ){
		$tablas_actuales++;
		
		$tabla = $line[0];
		
		    $sql = "SELECT * FROM $tabla";
  			$qry = cms_query($sql)or die (error($query,mysql_error(),$php));
   			$num_campos= mysql_num_fields($qry);
			
			$tot_campos = $tot_campos+$num_campos;
		
			}	
			
		
		
		
		
		
		
		$info_bd ="  <table width=\"600\"  border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
                       <tr >
                         <td class=\"textos\"  align=\"left\" class=\"textos\">Cantidad de tablas $tablas_actuales</td>
                         </tr>
						 <tr><td class=\"textos\"  align=\"left\" class=\"textos\">Campos totales de la base $tot_campos</td></tr> 
                   	</table>";
			

	return $info_bd;

}






function alter($tabla,$campo,$tipo){


switch ($tipo) {
     case 'int':
         $create ="ALTER TABLE $tabla ADD $campo INT NULL ";
         break;
	 case 'date':
         $create ="ALTER TABLE $tabla ADD $campo date NOT NULL default '0000-00-00' ";
         break;
    case 'string':
         $create ="ALTER TABLE $tabla ADD $campo varchar(255) NOT NULL ";
        
         break;
	 case 'blob':
         $create ="ALTER TABLE $tabla ADD $campo TEXT NOT NULL ";
        
         break;
		 
		  
   	default:
	 $create ="ALTER TABLE $tabla ADD $campo varchar(255) NOT NULL ";
	 
       
 }
 
 return $create;

}



if(mysql_select_db($DATABASE, $DB)){

$respaldo_sql = $_GET['respaldo_sql'];



$actualiza = $_GET['actualiza'];	
$insertbd = $_GET['insertbd'];	






//include("lib/lib.inc.php");
include("lib/lib.inc2.php");

$info_base = info_base($DATABASE);
$version_sgs = version();
	
	/*************************************************************************************************************/
	
		if($actualiza=="" and $insertbd=="" and $respaldo_sql==""){
	
	
		
 echo  "<html>
<head>
<title>Script de Actualización - Sistema de Gestión de Solicitudes 1.03</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
</head>

<script language = \"javascript\">
var peticion = false; 
if (window.XMLHttpRequest) {
      peticion = new XMLHttpRequest();
      } else if (window.ActiveXObject) {
            peticion = new ActiveXObject(\"Microsoft.XMLHTTP\");
}


function ObtenerDatos(datos,divID) { 
if(peticion) {
     var obj = document.getElementById(divID); 
     peticion.open(\"GET\", datos); 
     peticion.onreadystatechange = function()  { 
          if (peticion.readyState == 4) { 
               obj.innerHTML = peticion.responseText; 
          }
		   if (peticion.readyState == 1) { 
               obj.innerHTML = \"Actualizando Estructura<img src=images/ajax-loader.gif  border=0>\";
          } 
     } 
peticion.send(null); 
	}
}




</script>


<link href=\"../css/actualiza.css\" rel=\"stylesheet\" type=\"text/css\" />
<body bgcolor=\"#FFFFFF\" text=\"#000000\">

<link href=\"../css/sitio.css\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"../css/deuman.css\" rel=\"stylesheet\" type=\"text/css\" />
<style>
  .textos{
	margin: 6px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 2px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 0.9em;
	font-weight: normal;

 }
</style>



<script src=\"../js/jquery/jquery.js\" type=\"text/javascript\"></script>
<script src=\"../js/jquery/jquery.metadata.js\" type=\"text/javascript\"></script>
<script src=\"../js/jquery/jquery.validate.js\" type=\"text/javascript\"></script>
<script src=\"../js/jquery/cmxforms.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\" src=\"js/deuman.js\"></script>
<script src=\"../js/jquery/plugin/jtip.js\" type=\"text/javascript\"></script>


  <table width=\"650\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" class=\"cuadro_light\">
    <tr>
      <td class=\"textos\"  align=\"center\"><h1>Actualizaci&oacute;n de Estructura de Base de Datos Generica de 
	  Sgs a SGS 1.03</h1></td>
      </tr>
	  <td class=\"textos\"  align=\"center\" class=\"textos_rojo\"><b>Aviso:</b>Antes de ejecutar la actualización, le recordamos realizar un respaldo de la base de datos. Puede respaldar de forma r&aacute;pida 
	  <a href=\"index.php?respaldo_sql=ok\">aqu&iacute;</a><br><br></td>
	  <td class=\"textos\"  align=\"center\" class=\"textos\"></td>
	  	  <tr><td class=\"textos\"  align=\"center\" class=\"textos\"><h2>Nombre de la Base de Datos a modificar: <strong>\"$DATABASE\"</strong></h2></td></tr>
	  <tr><td class=\"textos\"  align=\"center\" class=\"textos\">Informaci&oacute;n actual presente en la base de datos</td></tr> 
	  <tr><td class=\"textos\"  align=\"center\"><div id=\"destacado\">$info_base</div></td></tr> 
	  
	   
		 <tr><td class=\"textos\"  align=\"center\" class=\"textos\"><div id=\"contenido2\"></div> </td></tr>  
	  <tr><td class=\"textos\"  align=\"center\" class=\"textos\"><div id=\"contenido\">Para realizar el proceso de actualización  haga clic 
	  <a href=\"#\" style=\"cursor: pointer;  cursor: hand;\" onclick=\"ObtenerDatos('index.php?actualiza=ok','contenido');\">aqu&iacute;</a></div> 
	  </td></tr> 
	  <tr><td align=\"center\" class=\"textos\">&nbsp;</td></tr> 


	</table><br>
	 <table width=\"300\"  border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"tabla_rojo\">
        <tr>
          <td align=\"center\" class=\"textos\">&nbsp;</td>
          </tr>
    	</table>

 
</body>
</html>";

		/*<tr><td class=\"textos\"  align=\"left\" class=\"textos\">Atenci&oacute;n : Pasos a seguir con esta actualizaci&oacute;n</td></tr> 
	  <tr><td class=\"textos\"  align=\"left\" class=\"textos\">1 - Este software no actualiza los <strong>archivos</strong> de la aplicaci&oacute;n de SGS para eso  
	  es necesario que descargue la &uacute;ltima actualizaci&oacute;n del SGS desde <a href=\"http://www.gobforge.gob.cl/projects/sgs20285\" target=\"_blank\">aqu&iacute;</a></td></tr> 
	*/
	}elseif($insertbd=="" and $respaldo_sql==""){
		
		
		
		
		

	$fp=fopen("tablas.txt","r");
    
    
    
    while ($linea=fgets($fp,1024))
          {
		  
		  $caracteres_lines = strlen($linea);
          $aux=explode(",", $linea);
    
          $tabla    = trim($aux[0]);
          $num_campos    = trim($aux[1]);
    	  
		  $sql = "SELECT * FROM $tabla";
  			if($qry = cms_query($sql)){
			 $num_filas = mysql_num_fields($qry);
			
		 if($num_filas!=$num_campos){
		//echo "-- $tabla txt - $num_campos   tabla - $num_filas<br>";
		$diferencia = $num_campos - $num_filas;
		//$cont_campos_tabla=2;
		$a=0;
		$b=2;
		while($a<$num_campos){
		$campo_txt_aux = trim($aux[$b]);
		 $aux3=explode("#", $campo_txt_aux);
		$campo_txt =  trim($aux3[0]);
		$tipo_campo_txt =  trim($aux3[1]);
		//echo "$a $campo_txt <br>";
		$a++;
		$b++;
			
			$cont_a=0;
			$campo_ok="ok";
			while ($cont_a<$num_filas){
			
				$nom_campo = mysql_field_name($qry,$cont_a);	
				$tipo      = mysql_field_type($qry,$cont_a);
				//echo "&nbsp;&nbsp;&nbsp;&nbsp; $campo_txt --> $nom_campo<br>";
				if($campo_txt==$nom_campo){
					$campo_ok="no";
				}
				$cont_a++;
			}
			if($campo_ok=="ok"){
			//echo "-------Campo creado $campo_txt $tipo<br>";
			$alter =alter($tabla,$campo_txt,$tipo_campo_txt);
			$campos2 .="$campo_txt , ";

 cms_query($alter);
			
			}
		 	//echo "<br><br><br>";
		
		  }
		  $campos2 = elimina_ultimo_caracter($campos2);
		$lista_campos .="<tr><td class=\"textos\"  align=\"left\" class=\"textos\" title=\"Se agregaron los sig campos $campos2\" >Tabla \"$tabla\" tiene una diferencia de $diferencia campos, Tabla actualizada.</td></tr> ";
		 
		 }
	
			
			}else{
		 $link = "http://www.2r.cl/sgs/tablag.php?tabla=$tabla";
		
		 $fp2=fopen("$link","r");
		 
		 $create = fgets($fp2,1024);
		 
		 $create = str_replace(",)",")",$create);

 cms_query($create)or die (error($query,mysql_error(),$php));
		// echo $create." tt<br>";
		  $lista_actualizacion .= "<tr><td class=\"textos\"  align=\"center\" class=\"textos\">
		  $create </td></tr> 
		  <tr><td class=\"textos\"  align=\"left\" class=\"textos\"> 
		 <div id=\"destacado\"><font color=\"#FF0000\">La tabla \"$tabla\" no existia, se ha creado<br></font></div></td></tr>$lista_campos ";
		
		 }
   			
	
 			
		
		}	
				  	   
			$contenido = "  <table width=\"600\"  border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
                              	<tr><td class=\"textos\"  align=\"center\" class=\"textos\"><br><br>Ahora solo falta actualizar algunas tablas de la Base de datos 
								 </td></tr> 
								 <tr><td class=\"textos\"  align=\"center\" class=\"textos\">Desea actualizar la base de datos<br><br></td></tr> 
								 <tr><td class=\"textos\"  align=\"left\" class=\"textos\"> 
								   <table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
                                     <tr >
                                       <td class=\"textos\"  align=\"center\">
									   <a href=\"#\" style=\"cursor: pointer;  cursor: hand;\" onclick=\"ObtenerDatos('index.php?insertbd=ok','contenido');\"><div id=\"boton\">SI</div></a></td>
                                       <td class=\"textos\"  align=\"center\">
									   <a href=\"index.php\"><div id=\"boton2\">NO</div></a>
									   </td>
                                       </tr>
                                 	</table>
								 </td></tr> 
								 <tr><td class=\"textos\"  align=\"center\" class=\"textos\">Esto es opcional si lo desea puede actualizar 
								 manualmente la base de datos, tomando la informaci&oacute;n del archivo 
								 <a href=\"insert.sql\">insert.sql</a><br><br></td></tr> 
								 
								 $lista_actualizacion
								$lista_campos
								
                          	</table>";
		
    	echo $contenido ;
  }elseif($respaldo_sql=="ok"){
	
	include("../admin/respaldar/bakup.php");
	}
			
$insertbd = $_GET['insertbd'];
	if($insertbd=="ok" and $respaldo_sql==""){
	
	$fp=fopen("insert.sql","r");
    
    
    
    while ($linea=fgets($fp,300000))
          {
     		$linea = trim($linea);
			$prm_cart= substr($linea,0,1);
			$linea = nl2br($linea);
			if($prm_cart !="#" and strlen($linea)>1){ cms_query($linea) or die("2: Error en $linea a la base de datos");
			 $consultas++;
			}
	 			
                   
    		}
	
	$info_estructura= info_base($DATABASE);
	$contenido = "  <table width=\"100%\"  border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
                      <tr>
                        <td class=\"textos\"  align=\"left\"><div id=\"destacado\">Se han generado los cambios necesarios</div></td>
                        </tr>
						<tr><td class=\"textos\"  align=\"left\" class=\"textos\">
						<div id=\"destacadofin\" align=\"center\">El proceso se ha completado exitosamente :-)</div></td></tr> 
						<tr><td class=\"textos\"  align=\"center\" class=\"textos\">Estructura Final de la Base de Datos </td></tr> 
						<tr><td class=\"textos\"  align=\"center\" class=\"textos\">$info_estructura</td></tr> 
                  	</table>";
					
					echo $contenido ;
	
	include("../lib/correos.inc.php");
	$url=$_SERVER['HTTP_REFERER']; 
	$ip= $_SERVER['REMOTE_ADDR'];
	//gestiondesolicitudes@minsegpres.gov.cl
	$destinatario ="rrosende@minsegpres.gov.cl";
	$asunto = "instalación exitosa";
	$cuerpo ="Url de la instalación $url <br> \n";
	
	cms_mail($destinatario,$asunto,$cuerpo,$headers);
	
	   }
	}else{

	
 echo  "<html>
<head>
<title>Script de Actualización - Sistema de Gestión de Solicitudes 1.022</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
</head>

<script language = \"javascript\">
var peticion = false; 
if (window.XMLHttpRequest) {
      peticion = new XMLHttpRequest();
      } else if (window.ActiveXObject) {
            peticion = new ActiveXObject(\"Microsoft.XMLHTTP\");
}


function ObtenerDatos(datos,divID) { 
if(peticion) {
     var obj = document.getElementById(divID); 
     peticion.open(\"GET\", datos); 
     peticion.onreadystatechange = function()  { 
          if (peticion.readyState == 4) { 
               obj.innerHTML = peticion.responseText; 
          }
		   if (peticion.readyState == 1) { 
               obj.innerHTML = \"Actualizando Estructura<img src=images/ajax-loader.gif  border=0>\";
          } 
     } 
peticion.send(null); 
	}
}




</script>


<link href=\"css/actualiza.css\" rel=\"stylesheet\" type=\"text/css\" />
<body bgcolor=\"#FFFFFF\" text=\"#000000\">


  <table width=\"700\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\">
    <tr>
      <td class=\"textos\"  align=\"center\"><h1>Aun no se Configura la conección a la base de datos</h1></td>
      </tr>
	  <tr><td class=\"textos\"  align=\"center\" class=\"textos\">Recuerde configurar</td></tr> 
	  <tr><td class=\"textos\"  align=\"left\" class=\"textos\">
	  HOST_NAME=\"localhost\"; // por lo general es localhost puede ser otra configuracion pero depende del server 
	<br>DB_USERNAME=\"usuario de base de datos\";  //usuarios con permisos en la base
	<br>DB_PASSWORD=\"contrase&ntilde;a\"; //pass del usuario
	<br>DATABASE=\"nombre de base de datos\"; //nombre de la base de datos  </td></tr> 
	</table>


</body>
</html>";
}


?>
