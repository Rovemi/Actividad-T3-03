<?php
    session_start();

    if( !isset($_SESSION['id']) ){
        header("Location: index.php");
    }

    $id = $_SESSION['id'];
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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js"></script>
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
                    <h1 class="text-center mb-2">Mis datos personales</h1>
                    <div class="container">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-8"><h2>Actualizar <b>mis datos</b></h2></div>
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
                                $concontra = $clientes->sanitize($_POST['concontra']);

                                $id_cliente=intval($_POST['id_cliente']);

                                if( $contra != "" && $concontra != ""){
                                    $res = $clientes->update2($nombres, $apellidos, $telefono, $direccion, $correo_electronico,$id_cliente,$contra,$concontra);    
                                }else{
                                    $res = $clientes->update($nombres, $apellidos, $telefono, $direccion, $correo_electronico,$id_cliente);
                                }

                                if($res){
                                    $message= "Datos actualizados con éxito";
                                    $class="alert alert-success";
                                    
                                }else{
                                    $message="No se pudieron actualizar los datos";
                                    $class="alert alert-danger";
                                }
                                
                                ?>
                            <div class="<?php echo $class?>">
                            <?php echo $message;?>
                            </div>	
                                <?php
                            }
                            $datos_cliente=$clientes->single_record($id);
                        ?>
                            <form id="crearuser" method="POST">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control py-2" id="inputFirstName" type="text" placeholder="Nombre" name="nombre"
                                            value="<?php echo $datos_cliente->nombres;?>"/>
                                            <input type="hidden" name="id_cliente" id="id_cliente" class='form-control' maxlength="100"   value="<?php echo $datos_cliente->id;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control py-2" id="inputLastName" type="text" placeholder="Apellidos" name="apellidos" value="<?php echo $datos_cliente->apellidos;?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control py-2" id="phone" type="text" placeholder="Teléfono" name="phone"
                                            value="<?php echo $datos_cliente->telefono;?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control py-2" id="dir" type="text" placeholder="Dirección" name="dir"
                                            value="<?php echo $datos_cliente->direccion;?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control py-2" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Correo Electrónico" name="email"
                                    value="<?php echo $datos_cliente->correo_electronico;?>"/>
                                </div>
                                <h4>Cambiar contraseña</h4>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contraseña actual</label>
                                            <div class="input-group">
                                                <input ID="txtPassword" type="Password" Class="form-control" name="contra">
                                                <div class="input-group-append">
                                                    <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contraseña nueva</label>
                                            <div class="input-group">
                                                <input ID="txtPassword2" type="Password" Class="form-control" name="concontra">
                                                <div class="input-group-append">
                                                    <button id="show_password2" class="btn btn-primary" type="button" onclick="mostrarPassword2()"> <span class="fa fa-eye-slash icon2"></span> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-around">
                                    
                                    <button class="col-4 btn btn-success" type="submit" name="create">Actualizar Datos</button>
                                </div>
                            </form>
                            <script>
                                $(document).ready(function(){
                                    $('#crearuser').validate({
                                rules: {
                                    nombre: {
                                        required: true,                
                                    },
                                    apellidos: {
                                    required: true,            
                                    },
                                    phone: {
                                    required: true,
                                    },
                                    dir: {
                                    required: true,          
                                    },          
                                email: {
                                    required: true,
                                    email: true
                                }
                                },
                                messages: {  
                                nombre: "Por favor, ingresa un nombre",         
                                apellidos: "Por favor, ingresa tus apellidos",
                                phone: "Por favor ingresa un número de teléfono",                   
                                dir: "Por favor, ingresa tu dirección",
                                email: "Por favor ingresa un correo válido"     
                                },
                                errorElement: "em",
                                highlight: function ( element, errorClass, validClass ) {
                                $( element ).parents( ".col-sm-10" ).addClass( "has-error" ).removeClass( "has-success" );
                                },
                                unhighlight: function (element, errorClass, validClass) {
                                $( element ).parents( ".col-sm-10" ).addClass( "has-success" ).removeClass( "has-error" );  
                                } 
                            });
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        </div>
        <script type="text/javascript">
        function mostrarPassword(){
                var cambio = document.getElementById("txtPassword");
                if(cambio.type == "password"){
                    cambio.type = "text";
                    $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                }else{
                    cambio.type = "password";
                    $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                }
            }
            function mostrarPassword2(){
                var cambio = document.getElementById("txtPassword2");
                if(cambio.type == "password"){
                    cambio.type = "text";
                    $('.icon2').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                }else{
                    cambio.type = "password";
                    $('.icon2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                }
            } 
            
            $(document).ready(function () {
            //CheckBox mostrar contraseña
            $('#ShowPassword').click(function () {
                $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
            $('#ShowPassword2').click(function () {
                $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
