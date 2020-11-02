<?php
    session_start();

    if( !isset($_SESSION['id']) ){
        header("Location: index.php");
    }

    $nombre = $_SESSION['nombre'];
    $tipo = $_SESSION['tipo'];
    $pwd = $_SESSION['pwd'];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema de Reservaciones/Salon de Eventos</title>
        <link href="css/styles.css" rel="stylesheet" />
        
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">Salón de Eventos</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $nombre; ?><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="configuracion.php">Configuración</a>                        
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">                            
                            <?php if($tipo == 1){ ?>
                                <a class="nav-link" href="principal.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                    Clientes
                                </a>
                            <?php } ?>                            
                            <div class="sb-sidenav-menu-heading">Opciones</div>
                            <a class="nav-link" href="reservas.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-plus"></i></div>
                                Reservaciones
                            </a>
                            <a class="nav-link" href="configuracion.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                                Configuración
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="text-center mb-2">Administra tu usuarios</h1>
                    <div class="container">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-8"><h2>Listado de  <b>Clientes</b></h2></div>
                                    <div class="col-sm-4">
                                        <a href="crear.php" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar cliente</a>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Teléfono</th>
                                        <th>Dirección</th>
                                        <th>E-mail</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <?php 
                                include ('database.php');
                                $clientes = new Database();
                                $listado=$clientes->read();
                                ?>
                                <tbody>
                                <?php 
                                    while ($row=mysqli_fetch_object($listado)){
                                        $id=$row->id;
                                        $nombres=$row->nombres." ".$row->apellidos;
                                        $telefono=$row->telefono;
                                        $direccion=$row->direccion;
                                        $email=$row->correo_electronico;
                                ?>
                                    <tr>
                                        <td><?php echo $nombres;?></td>
                                        <td><?php echo $telefono;?></td>
                                        <td><?php echo $direccion;?></td>
                                        <td><?php echo $email;?></td>
                                        <td class="text-center">
                                            <a style="color: #FFC107;" href="actualizar.php?id=<?php echo $id;?>" class="edit mr-2" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                            <a style="color: #E34724;" href="delete.php?id=<?php echo $id;?>" class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                        </td>
                                    </tr>	
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
