<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Lista de usuarios</h2>
</div>

<div class="container pb-6 pt-6">

    <?php # INCORPORACIÓN DE ARCHIVOS PRINCIPALES PARA CARGAR LA LISTA DE USARIOS #
        require_once "./php/main.php";

        # ELIMINAR USUARIO #
        if(isset($_GET['user_id_del'])) {
            require_once ".php/usuario_eliminar.php";
        }

        if(!isset($_GET['page'])) {
            $pagina=1;
        }else {
            $pagina=(int)$_GET['page'];
            if($pagina<=1) {
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=user_list&page=";
        $registros=10; # REGISTROS POR PÁGINA #
        $busqueda="";

        # PAGINADOR USUARIO #
        require_once "./php/usuario_lista.php";
    ?>
    
</div>