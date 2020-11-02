<?php
    session_start();

    if( !isset($_SESSION['id']) ){
        header("Location: index.php");
    }

    $nombre = $_SESSION['nombre'];
    $tipo = $_SESSION['tipo'];
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
                            <a class="nav-link" href="principal.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Principal
                            </a>
                            <div class="sb-sidenav-menu-heading">opciones</div>
                            <a class="nav-link" href="reservas.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Reservaciones
                            </a>
                            <a class="nav-link" href="configuracion.phhp">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Configuracion
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
                                    <div class="col-sm-8"><h2>Agregar <b>Cliente</b></h2></div>
                                    <div class="col-sm-4">
                                        <a href="principal.php" class="btn btn-info add-new"><i     class="fa fa-arrow-left"></i> Regresar</a>
                                    </div>
                                </div>                                
                            </div>
                            <?php
                                include ("database.php");
                                $clientes= new Database();
                                if(isset($_POST) && !empty($_POST)){
                                    $nombres = $clientes->sanitize($_POST['nombre']);
                                    $apellidos = $clientes->sanitize($_POST['apellidos']);
                                    $telefono = $clientes->sanitize($_POST['phone']);
                                    $direccion = $clientes->sanitize($_POST['dir']);
                                    $correo_electronico = $clientes->sanitize($_POST['email']);
                                    $contra = $clientes->sanitize($_POST['contra']);
                                    $res = $clientes->create($nombres, $apellidos, $telefono, $direccion, $correo_electronico,$contra);
                                    
                                    if($res){
                                        $message= "Datos insertados con éxito";
                                        $class="alert alert-success";
                                    }else{
                                        $message="El correo ya existe";
                                        $class="alert alert-danger";
                                    }
                                    
                                    ?>
                                <div class="<?php echo $class?>">
                                <?php echo $message;?>
                                </div>	
                                    <?php
                                }
                            ?>
                            <form id="crearuser" method="POST">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control py-2" id="inputFirstName" type="text" placeholder="Nombre" name="nombre"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control py-2" id="inputLastName" type="text" placeholder="Apellidos" name="apellidos" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control py-2" id="phone" type="text" placeholder="Teléfono" name="phone"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control py-2" id="dir" type="text" placeholder="Dirección" name="dir"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control py-2" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Correo Electrónico" name="email"/>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control form-control-success py-2" id="contra" type="password" placeholder="Contraseña" name="contra"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control py-2" id="concontra" type="password" placeholder="Confirmar Contraseña" name="concontra"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-around">
                                    <a class="ocultar col-4 btn btn-danger" href="principal.php">Cancelar</a>
                                    <button class="col-4 btn btn-primary" type="submit" name="create">Crear Cuenta</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="js/validar.js"></script>       
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        
    </body>
</html>
