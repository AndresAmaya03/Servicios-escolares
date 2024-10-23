<div class="container is-fluid mb-6">
    <h1 class="title">Expedientes</h1>
    <h2 class="subtitle">Lista de expedientes</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar categoria #
        if(isset($_GET['exp_id_del'])){
            require_once "./php/exp_eliminar.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=exp_list&page="; /* <== */
        $registros=15;
        $busqueda="";

        # Paginador expediente #
        require_once "./php/exp_lista.php";
    ?>
</div>