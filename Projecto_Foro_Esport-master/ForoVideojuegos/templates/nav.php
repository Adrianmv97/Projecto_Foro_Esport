<nav class="navbar-expand-lg navbar-light bg-light">
    <div class="col px-md-5">
        <a class="navbar-brand" href="index.php">
            <img src="https://placeholder.com/wp-content/uploads/2018/10/placeholder.com-logo1.jpg" width="300" height="80" alt="logo del foro">
        </a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse col" id="navbarToggleExternalContent">
        <div class="col px-md-5">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active p-4">
                    <a class="btn btn-lg btn-primary" href="index.php">Inicio</a>
                </li>
            </ul>
        </div>
        <div class="col px-md-5">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active p-4">
                    <a class="btn btn-lg btn-primary" href="foro.php">Foro</a>
                </li>
            </ul>
        </div>
        <div class="col px-md-5">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active p-4">
                    <a class="btn btn-lg btn-primary" href="creadores.php">Creadores</a>
                </li>
        </div>
        <?php
        if (isset($_SESSION['idUsuario'])) {
            if ($_SESSION['idUsuario'] == 1) {
                echo "<div class='col px-md-5'>";
                echo "<ul class='navbar-nav mr-auto'>";
                echo "<li class='nav-item active p-4'>";
                echo "<a class='btn btn-lg btn-primary' href='herramientaAdministrativa.php'>Herramienta de administracion</a>";
                echo "</li>";
                echo "</div>";
            }
        }
        ?>
    </div>
</nav>