<?php

 $contenido .="<table width=\"400\" border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
                            <tr>
                              <td align=\"center\" class=\"textos\">Mail nombre <b>$nombre_mailing </b></td>
                            </tr>
                           $titulo_subjet
							 <tr>
                              <td align=\"center\" class=\"textos\">&nbsp;</td>
                            </tr>
							<tr>
                              <td align=\"center\" class=\"textos\">T&iacute;tulo del Contenido</td>
                            </tr>
							<tr>
                              <td align=\"center\" class=\"textos\">
							  
							     <textarea name=\"titulo_c\" cols=\"60\" rows=\"3\" class=\"textos\" ></textarea></td>
                            </tr>
							<tr>
                              <td align=\"center\" class=\"textos\">Bajada del Contenido</td>
                            </tr>
							<tr>
                              <td align=\"center\" class=\"textos\">
							  
							     <textarea name=\"bajada_c\" cols=\"60\" rows=\"3\" class=\"textos\" ></textarea></td>
                            </tr>
							<tr>
							<tr>
                              <td align=\"center\" class=\"textos\">Contenido</td>
                            </tr>
							<tr>
                              <td align=\"center\" class=\"textos\">
							  
							     <textarea name=\"texto_html\" cols=\"60\" rows=\"7\" class=\"textos\" ></textarea></td>
                            </tr>
                              <tr>
                              <td align=\"center\" class=\"textos\">
                               <input type=\"file\" name=\"imagen\" class=\"textos\"> 
								</td>		
								 </tr>		
								   <tr>
			   <td align=\"left\"  class=\"textos\">
			   Link de Imagen  (ejm: http://www.epsi.cl)</td>
              </tr>
			  <tr>
			   <td align=\"left\"  class=\"textos\">
			   <input type=\"text\" name=\"link\" value=\"http://www.epsi.cl\" size=\"40\"></td>
              </tr>
								 <tr>
                              <td align=\"center\" class=\"textos\">
                                &nbsp;
								
								<input type=\"hidden\" name=\"id_mailing\" value=\"$id_mailing\">
								<input type=\"hidden\" name=\"id_tipo\" value=\"$predefinido\">
								</td>		
								 </tr>					      

							<tr>
                              <td align=\"center\" class=\"textos\">
							  <input name=\"Submit\" type=\"image\" value=\"Enviar\" src=\"images/bot_aceptar.gif\">
                              &nbsp;&nbsp;<a href=\"index.php?id_usuario=$id_usuario&user=$user&accion=$accion\"><img src=\"images/bot_crear.gif\" border=\"0\" alt=\"\"></a>
                                </td>  
                            </tr>
							
							<tr>
                              <td align=\"center\" class=\"textos\"></td>
                            </tr>
                          </table>
						  
						  ";



?>