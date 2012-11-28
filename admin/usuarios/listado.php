<?php

	
	
	$aColumns = array('nombre','email','id_perfil','estado');
	$aColumnsBD = array('nombre','email','id_perfil','estado','id_usuario','login','paterno','materno','apellido','razon_social');
	
	
	$id_perfil_conect = perfil($id_sesion);
	//verificamos que quien este viendo este modulo no sea admin
	
	

	$sIndexColumn = "id_usuario";

	/* DB table to use */
	$sTable = "usuario";
	
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}else{
		$sLimit= "LIMIT 0,20";
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
	
		for ( $icont=0 ; $icont<count($aColumnsBD) ; $icont++ )
		{	
			switch ($icont) {
                 case 0:
                     
					     $query= "SELECT id_usuario  
                                FROM  usuario
                                WHERE nombre like '%".$_GET['sSearch']."%' or paterno like '%".$_GET['sSearch']."%'";
                          $result= mysql_query($query)or die (error($query,mysql_error(),$php));
                           while (list($id_usuario_list) = mysql_fetch_row($result)){
                     				$lista_id .="$id_usuario_list,";		   
                     		 }
							 $lista_id = elimina_ultimo_caracter($lista_id);
					 			if($lista_id!=""){
					 				$sWhere .= " id_usuario in ($lista_id) OR ";
					 			}
					  
					 
					 
					
                     break;
           
               	case 3:	
				
					$sWhere .= " email like '%".$_GET['sSearch']."%' or ";
				
						 
							 
					break;
			       break;
           
				default:
            	// $sWhere .= $aColumnsBD[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
            	 
                   
             }
			// echo "dfgdsfsd $i<br>";
			
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere = " AND ( $sWhere ) ";
	}
	//echo $sWhere." wrwrwrw <br>";
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumnsBD) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = " ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumnsBD[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	//$_GET['id_responsable']= 501;
	
	$_GET['estado']= trim($_GET['estado']);
		if(isset($_GET['estado']) and $_GET['estado']!="" and $_GET['estado']!="#"){
	
		 	$sWhere .= " AND estado = '".$_GET['estado']."' ";
	 		
		}
	
	$_GET['id_perfil']= trim($_GET['id_perfil']);
		if(isset($_GET['id_perfil']) and $_GET['id_perfil']!="" and $_GET['id_perfil']!="#"){
	
		 	$sWhere .= " AND id_perfil  = '".$_GET['id_perfil']."' ";
	 		
		}

	

	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumnsBD))."
		FROM   $sTable
		WHERE 1 $sWhere_perfiles
		$sWhere
		$sOrder
		$sLimit
	";
	
	
	
	
	
	
	$rResult = mysql_query( $sQuery ) or die(mysql_error()." linea 167<br>$sQuery");
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() 
	";
	$rResultFilterTotal = mysql_query( $sQuery ) or die(mysql_error()." linea 173<br>$sQuery");
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
		WHERE 1 $sWhere_perfiles
		";
	$rResultTotal = mysql_query( $sQuery ) or die(mysql_error()." linea 182<br>$sQuery");
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	

		$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iTotal,
		"aaData" => array()
		);
		

	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$cont_r++;
		$row = array();
		//echo "--".count($aColumns)." rrr<br>";

		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
	
			switch ($i) {
                 case 0:
				 	
						$aRow[$aColumnsBD[$i]]= $aRow[$aColumnsBD[$i]]." ". $aRow[$aColumnsBD[7]];
						 $aRow[$aColumnsBD[$i]]=trim($aRow[$aColumnsBD[$i]]);
						 
						 if($aRow[$aColumnsBD[$i]]==""){
						 $aRow[$aColumnsBD[$i]]=$aRow[$aColumnsBD[9]];
						 }
						 
                   		
                     break;
            	
            	  case 2:
				  	$id_perfil_u= $aRow[$aColumnsBD[$i]];
				 	 $query= "SELECT perfil
	     	           FROM  usuario_perfil
	     	           where id_perfil ='$id_perfil_u'";
	     	     	$result3= cms_query($query)or die (error($query,mysql_error(),$php));
	     	    	list($perfil) = mysql_fetch_row($result3);
			
							$aRow[$aColumnsBD[$i]] =$perfil;  
					break;
            	
				
				case 3:
				$estado =$aRow[$aColumnsBD[$i]];
				$id_user_u=$aRow[$aColumnsBD[4]];
				if($estado==0 ){
	       			
	   				 $link_activo ="<div id=\"v_$id_user_u\"  >
							<img style=\"cursor: pointer;  cursor: hand;\" onclick=\"ObtenerDatos('index.php?accion=$accion&act=77&id_user=$id_user_u&axj=1','v_$id_user_u');\" src=\"images/ciculo_warring.gif\" border=\"0\" alt=\"Usuario creado pero con su cuenta aun desactiva. click para Desactivar Permanentemente\">
					  </div>";
	    
	 				 }elseif($estado==1){
	  	
	  					 $link_activo ="<div id=\"v_$id_user_u\" >
	   					<img style=\"cursor: pointer;  cursor: hand;\" onclick=\"ObtenerDatos('index.php?accion=$accion&act=77&id_user=$id_user_u&axj=1','v_$id_user_u');\" src=\"images/ciculo_ok.gif\" border=\"0\" alt=\"Usuario activo. Click para Desactivar\">
						</div>";
	
	 				 }elseif($estado==2){
	  	
	   					 $link_activo ="<div id=\"v_$id_user_u\" >
						<img style=\"cursor: pointer;  cursor: hand;\" onclick=\"ObtenerDatos('index.php?accion=$accion&act=77&id_user=$id_user_u&axj=1','v_$id_user_u');\" src=\"images/minus_circle.gif\"  border=\"0\" alt=\"Cuenta Bloqueada. Click para Activar Cuenta\">
                       </div>";
	
					}  
					
				
				$aRow[$aColumnsBD[$i]]=$link_activo;
				break;
	 
               	default:
            	 
            	 
                   
             }
			 
			$aRow[$aColumnsBD[$i]] =trim($aRow[$aColumnsBD[$i]]);
			if($aRow[$aColumnsBD[$i]]==""){
				$aRow[$aColumnsBD[$i]]="&nbsp;";
			}
			 
		 $row[] = $aRow[$aColumnsBD[$i]];
			 
		}
		
	
		
		
		$row[]="<a href=\"index.php?accion=$accion&act=1&id_user=$id_user_u\"><img src=\"images/edit.gif\" alt=\"Borrar\" border=\"0\"></a>";
		$row[]="<a href=\"javascript:confirmar('Esta seguro de eliminar razon111','?accion=$accion&act=3&id_user=$id_user_u')\">
		  <img src=\"images/del.gif\" alt=\"Borrar\" border=\"0\"></a>";
		
		
		//$row[] = $aRow[5];
		
	$output['aaData'][] = $row;
	}		
		
			/*
	 * Output
	 */

		//$output['aaData'][] = $row;

	require_once("lib/json.php");

		$json = new Services_JSON;

		echo $json->encode($output);

	
		
	
?>