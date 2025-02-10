<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />

    
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
   
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="../../dist/css/adminlte.css" />
   
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    
    <div class="app-wrapper">
      <!-- barra superior -->
      <nav class="app-header navbar navbar-expand bg-primary" >
        <div class="container-fluid">
            <!-- esconder -->
          <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                  <i class="bi bi-list"></i>
                </a>
              </li>
          </ul>

          <!-- usuario -->
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="../../dist/assets/img/USUARIO.jpg
                "
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
              </a>
            </li>
            <!-- cerrar -->
            <a href="../../../cerrar.php" class="btn btn-default btn-flat float-end">Cerrar</a>
          </ul>
        </div>
      </nav>

      <!--Barra izquierda-->
      <aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="index2.php" class="brand-link">
            <img
              src="../../dist/assets/img/admin.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow" 
            />
            <span class="d-none d-md-inline" style="color: white;">
             <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </span>      
          </a>
        </div>
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p  style="color: white;">
                    Tablas
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>

                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./index2.php" class="nav-link active">
                      <i class="nav-icon bi bi-circle"></i>
                      <p  style="color: white;">Usuario</p>
                    </a>
                  </li>    
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </aside>

      <!--Contenido-->
      <div class="app-wrapper">
        <main class="app-main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Comienzo de la tarjeta -->
                        <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Lista de Usuarios</h3>
                        <a href="agregar_user.php" class="btn btn-success">Agregar Usuario</a>
                    </div>
                    <input type="text" id="search" class="form-control mb-3" placeholder="Buscar por nombre de usuario..." onkeyup="searchUser()">

                            <div class="card-body">
                                <table class="table table-bordered" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Password</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Incluir el archivo para conectar a la base de datos
                                        require_once '../../../conectar.php';
                                        
                                        // Obtener los usuarios desde la base de datos
                                        $stmt = $pdo->query("SELECT id, username, password FROM users");

                                        // Mostrar los usuarios
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['username']}</td>
                                                <td>{$row['password']}</td> <!-- Mostrar la contraseña cifrada -->
                                                <td>
                                                    <!-- Editar y eliminar -->
                                                    <a href='edit_user.php?id={$row['id']}' class='btn btn-warning btn-sm'>Editar</a>
                                                    <a href='delete_user.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este usuario?\")'>Eliminar</a>
                                                </td>
                                            </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </main>
   
      </div>

      <!--footer-->
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">Anything you want</div>
          <strong>
            Copyright &copy; 2014-2024&nbsp;
            <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
          </strong>All rights reserved.
      </footer>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <script src="../../dist/js/adminlte.js"></script>
    
  </body>
</html>