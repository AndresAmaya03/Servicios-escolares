<div style="display: flex; justify-content: space-between;">
    <a href="index.php?vista=home">
        <img src="./img/ith.jpg" width="120" height="120">
    </a>
    <a href="index.php?vista=home">
        <img class="image" src="./img/logoTECNM.jpg" width="280" height="120">
    </a>
</div>
<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Usuarios</a>

                <div class="navbar-dropdown">
                    <a href="index.php?vista=user_new" class="navbar-item">Nuevo</a>
                    <a href="index.php?vista=user_list" class="navbar-item">Lista</a>
                    <a href="index.php?vista=user_search" class="navbar-item">Buscar</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Expedientes</a>

                <div class="navbar-dropdown">
                    <a href="index.php?vista=exp_new" class="navbar-item">Nuevo</a>
                    <a href="index.php?vista=exp_list" class="navbar-item">Lista</a>
                    <a href="index.php?vista=exp_search" class="navbar-item">Buscar</a>
                    <a href="index.php?vista=generar_tabla" class="navbar-item">Generar tabla</a>
                </div>
            </div>

        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>"
                        class="button is-primary is-rounded">
                        Mi cuenta
                    </a>

                    <a href="index.php?vista=logout" class="button is-link is-rounded">
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>