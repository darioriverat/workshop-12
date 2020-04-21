<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @section('header')
            <div>
                <nav class="navbar navbar-expand-lg navbar-light bg-primary">
                    <a class="navbar-brand" href="/">Mi Tienda</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="/orders">Ordenes</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Maestros
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/categories">Categorias</a>
                                    <a class="dropdown-item" href="/products">Productos</a>
                                    <a class="dropdown-item" href="/customers">Clientes</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        @show

        <div>
            @yield('content')
        </div>
    </body>
</html>
