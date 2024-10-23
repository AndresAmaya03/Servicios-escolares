<?php
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";

	if(isset($busqueda) && $busqueda!=""){

		$consulta_datos="SELECT * FROM expediente WHERE expediente_numero LIKE '%$busqueda%' OR expediente_descripcion LIKE '%$busqueda%' ORDER BY expediente_numero ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(expediente_id) FROM expediente WHERE expediente_numero LIKE '%$busqueda%' OR expediente_descripcion LIKE '%$busqueda%'";

	}else{

		$consulta_datos="SELECT * FROM expediente ORDER BY expediente_numero ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(expediente_id) FROM expediente";
		
	}

	$conexion=conexion();

	$datos = $conexion->query($consulta_datos);
	$datos = $datos->fetchAll();

	$total = $conexion->query($consulta_total);
	$total = (int) $total->fetchColumn();

	$Npaginas =ceil($total/$registros);

	$tabla.='
	<div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                	<th>#</th>
                    <th>Expediente</th>
                    <th>Descripción</th>
                    <th>Documentos</th>
                    <th colspan="5">Opciones</th>
                </tr>
            </thead>
            <tbody>
	';

	if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){
			$tabla.='
				<tr class="has-text-centered" >
					<td>'.$contador.'</td>
                    <td>'.$rows['expediente_numero'].'</td>
                    <td>'.substr($rows['expediente_descripcion'],0,40).'</td>
                    <td>
                        <a href="index.php?vista=docs_exp&expediente_id='.$rows['expediente_id'].'" class="button is-link is-rounded is-small">Ver documentos</a>
                    </td>
                    <td>
                        <a href="index.php?vista=exp_update&exp_id_up='.$rows['expediente_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&exp_id_del='.$rows['expediente_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
					<td>
						<form action="./php/guardar_cejilla_individual.php" method="POST" >
						<input type="hidden" name="expediente_id" value="'.$rows['expediente_id'].'">
						<p class="has-text-centered">
						<button type="submit" class="button is-info is-rounded is-small">Generar cejilla</button>
						</p>
						</form>
                    </td>
					<td>
						<form action="./php/guardar_lomo_de_carpeta.php" method="POST" >
						<input type="hidden" name="expediente_id" value="'.$rows['expediente_id'].'">
						<p class="has-text-centered">
						<button type="submit" class="button is-info is-rounded is-small">Generar lomo <br>de carpeta</button>
						</p>
						</form>
                    </td>
					<td>
						<form action="./php/guardar_caratula_del_expediente.php" method="POST" >
						<input type="hidden" name="expediente_id" value="'.$rows['expediente_id'].'">
						<p class="has-text-centered">
						<button type="submit" class="button is-info is-rounded is-small">Generar caratula <br>del expediente</button>
						</p>
						</form>
                    </td>
                </tr>
            ';
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		if($total>=1){
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="5">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
		}else{
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="5">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}


	$tabla.='</tbody></table></div>';

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando categorías <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}