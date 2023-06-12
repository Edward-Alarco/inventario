<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="?view=home">
            <h3 class="text-light mb-0">
                <img src="src/views/resources/img/logo.png" class="d-block" style="max-width:150px;margin:0;">
            </h3>
        </a>

        <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title text-light">Módulos</h5>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" href="?view=mi-perfil"><ion-icon name="person-circle-outline"></ion-icon>&nbsp;Mi Perfil</a>
                    </li>
                    <li class="nav-item disabled-for-user">
                        <a class="nav-link active d-flex align-items-center" href="?view=ingreso"><ion-icon name="cube-outline"></ion-icon>&nbsp;Ingresar Recursos</a>
                    </li>
                    <li class="nav-item disabled-for-user">
                        <a class="nav-link active d-flex align-items-center" href="?view=egreso"><ion-icon name="arrow-undo-circle-outline"></ion-icon>&nbsp;Retirar Recursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" href="?view=cerrar"><ion-icon name="exit-outline"></ion-icon>&nbsp;Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>