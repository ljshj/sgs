<?php

$sql_tc = "select distinct tabla from tab_camp";
$result = cms_query($sql_tc) or die("$MSG_DIE - No Resulto $sql_tc");
array ($tbl_check);

$i=0;
while (list($tabla2) = mysql_fetch_row($result))
{
	$tbl_check[$i] = $tabla2;
	$i++;
}

$tables = mysql_list_tables( $DATABASE );
$contenido = 
	'
		<table width="100%" border="0">
			<tr>
				<td align="left" width="200"><b>Tabla</b></td>
				<td align="center" width="15"><b>Check</b></td>
				<td>&nbsp;</td>
			</tr>
		';
		
while( $line = mysql_fetch_row( $tables ) )
{
	$contenido .= '
			<tr>
				<td align="left" width="200" >'.$line[0].'</td>
				<td align="center" width="15"><input name="tabla[]" type="checkbox" value="'.$line[0].'"'; 
				
		for($i = 0; $i < sizeof($tbl_check); $i++)
		{
			if ($tbl_check[$i] == $line[0]) 
			{
				$contenido .= ' checked ';
			}
		}			
				
		$contenido .= '/></td>
		<td>&nbsp;</td>
		</tr>';
		
}
$contenido .= '
		</table>
		<br />
		<input name="btoTab" type="submit" value="Siguiente >>" />
		<input name="btnsig" type="hidden" value="tablas" />
	';

 
$btnsig = $_POST['btnsig'];

switch ($btnsig)
{	
	case "tablas":
		$tabla = $_POST['tabla'];
		
		$qry_d = "delete from tab_busqueda";

 cms_query($qry_d) or die("$MSG_DIE - QR-Problemas al insertar $qry_d");
		
		for($contar = 0; $contar < sizeof($tabla); $contar++)
		{
			$qry_insert = "insert into tab_busqueda (tabla) VALUES ('".$tabla[$contar]."')";
			$result_insert = cms_query($qry_insert) or die("$MSG_DIE - QR-Problemas al insertar $qry_insert");
		}

		$sql_accion = "select accion, descrip_php_esp from acciones";
		$result_accion = cms_query($sql_accion) or die("$MSG_DIE - No Resulto $sql_accion");
		
		while (list($accion, $descrip_php_esp) = mysql_fetch_row($result_accion))
		{
			$lista_acciones .= '<option>'.$descrip_php_esp.'</option><br />';
		}

		$Sql = "select tabla from tab_busqueda";
		$result = cms_query($Sql) or die("$MSG_DIE - No Resulto $Sql");
 
	    $contenido = '
		<table width="386" border="1">'; 
	 
		while (list($tabla) = mysql_fetch_row($result))
		{ 
			$contenido .= '
			<tr>
				<td colspan="2" align="left"><strong>Tabla : '.$tabla.'</strong></td>
				<td>
					<select name="'.$tabla.'">
						<option>Seleccione Acccion</option>
						'.$lista_acciones.'
				  	</select>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="left" ><strong>Seleccione Campo :</strong></td>
			</tr>';
			 $fields = mysql_list_fields( $DATABASE, $tabla);
			 $columns = mysql_num_fields( $fields );
			 for ($i = 0; $i < $columns; $i++) 
			 {
				$nomField = mysql_field_name( $fields, $i );
				if (substr($nomField,0,2) != "id")
				{
					$tc = $tabla.'-'.$nomField;
					$contenido .= '
					  <tr>
						<td>&nbsp;</td>
						<td><strong>'.$nomField.'</strong></td>
						<td>
							<input name="columna[]" type="checkbox" value="'.$tc.'" />
						</td>
					  </tr>';
				}
			 }	   
		}
			$contenido .= '
		</table>
		<br />
		<input name="btoCamp" type="submit" value="Siguiente >>" />
		<input name="btnsig" type="hidden" value="campos" />
		';
	break;	
	case "campos":
	
		$Sql = "select tabla from tab_busqueda";
		$result = cms_query($Sql) or die("$MSG_DIE - No Resulto $Sql");
		
		$i = 0;
		while (list($tabla_accion) = mysql_fetch_row($result))
		{ 
			$i = $i + 1;
			$accion = $_POST[$tabla_accion];

			$qry_update = "update tab_busqueda set accion = '".$accion."' where tabla = '".$tabla_accion."'";

 cms_query($qry_update) or die("$MSG_DIE - QR-Problemas al actualizar $qry_update");
		}
		
		$columna = $_POST['columna'];
	
		$qry_d = "delete from tab_camp";

 cms_query($qry_d) or die("$MSG_DIE - QR-Problemas al insertar $qry_d");
	
		for($contar = 0; $contar < sizeof($columna); $contar++)
		{
			$elements = explode("-", $columna[$contar]);
			$tabla = $elements[0];
			$campo = $elements[1];
		
			$qry_insert = "insert into tab_camp (tabla, campo) VALUES ('".$tabla."', '".$campo."')";
			$result_insert = cms_query($qry_insert) or die("$MSG_DIE - QR-Problemas al insertar $qry_insert"); 	
		}
		$contenido = "<br /><br /><br /><div alig='center'>Tablas para la Busqueda Escojidas</div>";
	break;
}
?> 




  

