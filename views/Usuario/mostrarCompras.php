<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/usuario.css" />
    <link rel="stylesheet" href="../../styles/product.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="icon"
      href="../../assets/images/Logo ByteBuddy Learning.png"
      type="image/x-icon"
    />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="sidebar p-3">
        <div class="logo-details">
            <i class="bx bxl-c-plus-plus icon"></i>
            <div class="logo_name">ByteBuddy Learning</div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul class="nav-list p-0">
            <li>
            <li class="nav-item dropdown">
                <a href="../Qr.html" class="nav-link">
                    <i class="fa-solid fa-users"></i>
                    <span class="links_name">Chat</span>
                </a>
                <span class="tooltip">Chat</span>
            </li>
            </li>
            <li>
                <a id="pas" href="./mostrarCompras.php" class="nav-link">
                    <i class="fa-solid fa-gear"></i>
                    <span class="links_name">Ver compras</span>
                  </a>
                  <span class="tooltip">Ver compras</span>
            </li> 
             <li>
                <a id="pas" href="#" class="nav-link">
                    <i class="fa-solid fa-gear"></i>
                    <span class="links_name">Cambiar contraseña</span>
                  </a>
                  <span class="tooltip">Cambiar contraseña</span>
            </li> 
            <li>
        </ul>
    </div>
    <section class="home-section">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1d1b31;">
            <div class="container-fluid">
                <img src="../../assets/images/Logo ByteBuddy Learning.png" alt="" id="imgLogo" class="">
                <span class="h5 mt-3 text-white">Bienvenido</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a id="sesion" class="nav-link text-white" href="#"><i
                                    class="fa-solid fa-arrow-right-from-bracket px-1"></i>Cerrar
                                Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="row">
            <?php
    try {
        echo "Hola";
        require_once __DIR__ . '/../models/Auth/jwtManager.php';
        require_once __DIR__ . '/../../models/Generals/pdfHelper.php'; 
        echo "Adios";
        $jwt = new JwtManager();
        $pdf = new PdfHelper();

        $infoUser = $jwt->getJwt();
        echo var_dump($infoUser);

        $data = $infoUser["id"];
        echo var_dump($data);
        $result = $pdf->getPdfPaths($data); // Corrección del método
        echo var_dump($result);
        if (!$result) {
            echo "Aún no hay compras realizadas";
        } else {
    ?>
            <ul>
                <?php foreach ($result as $pdfPath) { ?>
                    <li><a href="<?php echo $pdfPath; ?>" target="_blank"><?php echo basename($pdfPath); ?></a></li>
                <?php } ?>
            </ul>
    <?php
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

</body>

</html>