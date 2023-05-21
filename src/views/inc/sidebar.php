<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="?view=home">
            <h3 class="text-light">Inventario</h3>
        </a>

        <div class="offcanvas offcanvas-start bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title text-light">Módulos</h5>
                <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="?view=ingreso">Ingresar Activos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=egreso">Retirar Activos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=cerrar">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>