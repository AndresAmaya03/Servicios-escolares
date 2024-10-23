<div class="container is-fluid mb-6">
    <h1 class="title">Documentos</h1>
    <h2 class="subtitle">Documentos del expediente</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    require_once "./php/main.php";
    ?>
    <div class="columns">
        <div class="column">
            <?php
            $expediente_id = (isset($_GET['expediente_id'])) ? $_GET['expediente_id'] : 0;
            /*== Verificando expediente ==*/
            $check_expediente = conexion();
            $check_expediente = $check_expediente->query("SELECT * FROM expediente WHERE expediente_id='$expediente_id'");

            if ($check_expediente->rowCount() > 0) {

                $check_expediente = $check_expediente->fetch();
                $expediente_numero = $check_expediente['expediente_numero'];
                echo '
                        <h2 class="title has-text-centered">' . $check_expediente['expediente_numero'] . '</h2>
                        <h2 class="title has-text-centered">' . $check_expediente['expediente_descripcion'] . '</h2>
                    ';
                $check_expediente = null;

                ?>
                <div class="form-rest mb-6 mt-6"></div>

                <div class="columns">
                    <?php 
                    documentos($expediente_id,$expediente_numero,'Accreditación extraescolar 1','extraescolar1');
                    documentos($expediente_id,$expediente_numero,'Accreditación extraescolar 2','extraescolar2');
                    documentos($expediente_id,$expediente_numero,'Tutorias 1','tutorias1'); 
                    ?>
                </div>
                <hr>
                <div class="columns">
                    <?php 
                    documentos($expediente_id,$expediente_numero,'Tutorias 2','tutorias2');
                    documentos($expediente_id,$expediente_numero,'Liberacion servicio social','liberacionServicio');
                    documentos($expediente_id,$expediente_numero,'Liberación practicas profesionales','liberacionPracticas'); 
                    ?>
                </div>
                <hr>
                <div class="columns">
                    <?php 
                    documentos($expediente_id,$expediente_numero,'Liberación actividades complementarias','actividadesComplementarias');
                    documentos($expediente_id,$expediente_numero,'Credito complementario 4','credito4');
                    documentos($expediente_id,$expediente_numero,'Credito complementario 5','credito5'); 
                    ?>
                </div>
                <hr>
                <div class="columns">
                    <?php 
                    documentos($expediente_id,$expediente_numero,'Acreditación Ingles','ingles');
                    documentos($expediente_id,$expediente_numero,'Título','titulo');
                    documentos($expediente_id,$expediente_numero,'Cedula profesional','cedula');
                    ?>
                </div>
                <hr>
                <div class="columns">
                    <?php 
                    documentos($expediente_id,$expediente_numero,'Certificado de bachillerato','bachillerato');
                    documentos($expediente_id,$expediente_numero,'Certificado de licenciatura','licenciatura');
                    documentos($expediente_id,$expediente_numero,'Solicitud de inscripción','inscripcion'); 
                    ?>
                </div>
                <hr>
                <div class="columns">
                    <?php 
                    documentos($expediente_id,$expediente_numero,'Kardex de bachillerato','kardexBachillerato');
                    documentos($expediente_id,$expediente_numero,'Acta de nacimiento','actaNacimiento');
                    documentos($expediente_id,$expediente_numero,'CURP','curp'); 
                    ?>
                </div>
                <hr>
                <div class="columns">
                    <?php 
                    documentos($expediente_id,$expediente_numero,'Seguro Social','seguroSocial'); 
                    documentos($expediente_id,$expediente_numero,'Pago de inscripción','pagoInscripcion');
                    documentos($expediente_id,$expediente_numero,'Contrato de estudiante','contrato');
                    ?>
                </div>
                <hr>
                <div class="columns">
                    <?php 
                    documentos($expediente_id,$expediente_numero,'Carta de buena conducta','buenaConducta'); 
                    documentos($expediente_id,$expediente_numero,'Carta de mala conducta','malaConducta');
                    ?>
                </div>

                <?php

            } else {
                echo '<h2 class="has-text-centered title" >Seleccione un expediente</h2>';
            }

            ?><br>

            <?php
 
            ?>
        </div>

    </div>
</div>
<?php
function documentos($expediente_id,$expediente_numero,$titulo_documento,$documento_nombre_formulario){
    // Verifica si el archivo ya existe en el servidor
    $ruta_archivo = "./expedientes/" . $expediente_numero . "/".$expediente_numero."_" . $documento_nombre_formulario . ".pdf"; // Ajusta esta ruta según tu estructura de directorios
    $archivo_existe = file_exists($ruta_archivo);
    $nombre_archivo = $archivo_existe ? $documento_nombre_formulario.".pdf" : "PDF (MAX 3MB)"; // Mostrar nombre del archivo o mensaje predeterminado

    ?>
    
    <div class="column">
                        <form action="./php/doc_guardar.php" method="POST" class="FormularioAjax" autocomplete="off"
                            enctype="multipart/form-data">
                            <input type="hidden" name="sesion" required value="<?php echo $_SESSION['id']?>">
                            <h5 class="title is-5" style="text-align: center;"><?php echo $titulo_documento ?></h5>
                            <div class="file is-small" style="justify-content: center;">
                                <label class="file-label">
                                    <input type="hidden" name="expediente_id" value='<?php echo $expediente_id ?>'>
                                    <input type="hidden" name="documento_nombre" value=<?php echo $documento_nombre_formulario ?>>
                                    <input class="file-input" type="file" name="documento" accept=".pdf">
                                    <span class="file-cta">
                                        <span class="file-label">Documento</span>
                                    </span>
                                    <span class="file-name"><?php echo $nombre_archivo; ?></span>
                                    <button class="button is-info is-small" <?php echo $archivo_existe ? "disabled" : " "?>>
                                        <span>Subir</span>
                                    </button>
                                </label>
                            </div>
                        </form>
                        <div class="file is-small" style="margin: 20px; justify-content: center;">
                            <!--Formularios para ver y borrar documento-->
                            <?php $url = 'index.php?vista=doc_ver&expediente_id='.$expediente_id.'&documento_nombre='.$documento_nombre_formulario;
                            $disabled = $archivo_existe ? '' : 'disabled'; // Deshabilitar si no hay archivo
                            ?>
                                <a href= <?php echo $archivo_existe ? $url : '#'.' '.$disabled?>  class="button is-success is-small">Ver</a>
                            <form action="./php/doc_borrar.php" method="POST" class="FormularioAjax" autocomplete="off">
                                <input type="hidden" name="sesion" required value="<?php echo $_SESSION['id']?>">
                                <input type="hidden" name="expediente_id" value=<?php echo $expediente_id ?>>
                                <input type="hidden" name="documento_nombre" value=<?php echo $documento_nombre_formulario ?>>
                                <button class="button is-danger is-small" <?php echo $disabled ?>>
                                    <span>Borrar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php
}

?>