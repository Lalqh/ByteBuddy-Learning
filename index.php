<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ByteBuddy-Learning</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    @media (max-width: 768px) {
      .navbar-brand {
        font-size: 18px;
      }

      .nav-link {
        font-size: 14px;
      }
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">logo</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="views/login.html">Iniciar sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="views/Register.html">Registrarse</a>
          </li>
          <li class="d-flex align-items-end justify-content-end nav-item dropdown" style="margin-left: auto;">
            <a class="nav-link btn dropdown-toggle" href="#" id="carritoIcono" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img style="width: 20px; height: 20px;" src="assets/images/carrito-de-compras.png" alt="Carrito">
              <span id="contadorCarrito" class="badge badge-pill badge-danger">0</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="carritoIcono">
              <div id="carritoProductos" class="dropdown-item">
                <!-- Productos agregados al carrito -->
              </div>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Ir a comprar</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="row" id="productos">
      <?php
      require_once __DIR__ . '/models/Database/conector.php';
      require_once __DIR__ . '/models/Database/utils.php';
      $db = DB::getInstance()->getConnection();

      $crud = new Crud($db);

      $result = $crud->select("*", "Cursos", "_status = 'post'");

      if (!$result) {
        echo "No hay productos disponibles";
      } else {
        foreach ($result as $producto) {
      ?>
          <div class="col-md-4 mb-4">
            <div class="card">
              <img src="<?php echo $producto['img_src']; ?>" class="card-img-top" alt="Producto">
              <div class="card-body">
                <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                <p class="card-text"><?php echo $producto['descripcion']; ?></p>
                <p class="card-text">$<?php echo $producto['precio']; ?></p>
                <button type="button" class="btn btn-primary agregar-carrito" data-id="<?php echo $producto['id']; ?>">Comprar</button>
              </div>
            </div>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>

  <footer class="bg-light text-center py-4">
    <p>© 2024 ByteBuddy-Learning. Todos los derechos reservados.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    let cantidadCarrito = 0;
    const contadorCarrito = document.getElementById('contadorCarrito');
    const carritoProductos = document.getElementById('carritoProductos');

    function agregarAlCarrito(event) {
      event.stopPropagation();
      const idProducto = event.target.getAttribute('data-id');
      cantidadCarrito++;
      contadorCarrito.innerText = cantidadCarrito;

      const nombreProducto = event.target.parentNode.querySelector('.card-title').innerText;
      const nuevoProducto = document.createElement('a');
      nuevoProducto.classList.add('dropdown-item');
      nuevoProducto.href = '#';
      nuevoProducto.innerText = nombreProducto;
      carritoProductos.insertBefore(nuevoProducto, carritoProductos.childNodes[0]); // Insertar el nuevo producto al inicio del carrito
    }

    const botonesComprar = document.querySelectorAll('.agregar-carrito');
    botonesComprar.forEach(boton => {
      boton.addEventListener('click', agregarAlCarrito);
    });
  </script>


</body>

</html>