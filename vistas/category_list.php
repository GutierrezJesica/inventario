<div class="container is-fluid mb-6">
    <h1 class="title">Categorías</h1>
    <h2 class="subtitle">Lista de categoría</h2>
</div>

<div class="container pb-6 pt-6">

<?php # INCORPORACIÓN DE ARCHIVOS PRINCIPALES PARA CARGAR LA LISTA DE CATEGORIA #
        require_once "./php/main.php";

        # ELIMINAR CATEGORIA #
        if(isset($_GET['category_id_del'])) {
            require_once "./php/usuario_eliminar.php";
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
        $url="index.php?vista=category_list&page=";
        $registros=10; # REGISTROS POR PÁGINA #
        $busqueda="";

        # PAGINADOR CATEGORIA #
        require_once "./php/categoria_lista.php";
    ?>


</div>