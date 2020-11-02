<?php
    require "conexion.php";
    session_start();
    if( $_POST ){
        if (isset($_POST['iniciate'])) {            
            $correo = $_POST['correo'];
            $pwd = $_POST['pass'];
            $sql = "SELECT id, nombres,apellidos,correo_electronico,password,tipo FROM clientes WHERE correo_electronico='$correo'";
            //echo $sql;  
            $resultado = $mysqli->query($sql);
            $num = $resultado->num_rows;    
            if( $num > 0){
                $row = $resultado->fetch_assoc();
                $password_bd = $row['password'];
                $pass_c = sha1($pwd);        
                if( $password_bd == $pass_c ){
                $_SESSION['id'] = $row['id'];
                $_SESSION['nombre'] = $row['nombres'];
                $_SESSION['apellidos'] = $row['apellidos'];
                $_SESSION['tipo'] = $row['tipo'];                
                $_SESSION['pwd'] = $pwd;
                if( $row['tipo'] == 1 )
                    header("Location: principal.php");                
                else
                    header("Location: reservas.php");

            }else{
                echo '<script type="text/javascript">'
                    ,'setTimeout(function() {  
                    $("#reg-exitoso").removeClass("alert-success");
                    $("#reg-exitoso").addClass("alert-danger");
                    $("#reg-exitoso").html("usuario y/o contraseña <strong>erroneos</strong>");
                    $("#reg-exitoso").css("display","block");
                    $("#mostrar").click();
                    $("#reg-exitoso").fadeOut(5000);
                    },1000);'
                    , '</script>'
                ;
            }
            }else{
                echo '<script type="text/javascript">'
                    ,'setTimeout(function() {  
                    $("#reg-exitoso").removeClass("alert-success");
                    $("#reg-exitoso").addClass("alert-danger");
                    $("#reg-exitoso").html("usuario y/o contraseña <strong>erroneos</strong>");
                    $("#reg-exitoso").css("display","block");
                    $("#mostrar").click();
                    $("#reg-exitoso").fadeOut(5000);
                    },1000);'
                    , '</script>'
                ;
            }
       }else if (isset($_POST['create'])) {
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $phone = $_POST['phone'];
            $dir = $_POST['dir'];
            $email = $_POST['email'];
            $contra = $_POST['contra'];
            $sqlexist = "SELECT correo_electronico FROM clientes WHERE correo_electronico='$email'";  
            $resultado = $mysqli->query($sqlexist);
            $num = $resultado->num_rows;            
            if( $num > 0 ){                
                echo '<script type="text/javascript">'
                    ,'setTimeout(function() {  
                    $("#reg-exitoso").removeClass("alert-success");
                    $("#reg-exitoso").addClass("alert-warning");
                    $("#reg-exitoso").html("Este correo ya existe <strong>intente con otro</strong>");
                    $("#reg-exitoso").css("display","block");
                    $("#reg-exitoso").fadeOut(5000);
                    $("#link-reg").click();
                    $("#inputFirstName").html("$nombre");
                    },1000);'
                    , '</script>'
                ;
            }else{
                $sql = "INSERT INTO clientes(nombres,apellidos,telefono,direccion,correo_electronico,password,tipo) values('$nombre','$apellidos','$phone','$dir','$email',sha1('$contra'),0)";
                $mysqli->query($sql);
                echo '<script type="text/javascript">'
                    ,'setTimeout(function() {  
                    $("#reg-exitoso").css("display","block");
                    $("#reg-exitoso").fadeOut(3000);
                    },1000);'
                    ,'</script>'
                ;
            }            
       }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema de reservaciones</title>
        <link href="styles/glDatePicker.default.css" rel="stylesheet" type="text/css">
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/estilos.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>             
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
        $( function() {
            $( "#mydate" ).datepicker({
                minDate: 0,
                monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
                dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ]
            });
        } );
        </script>   
    </head>
    <body style="background: black;">       
        <nav class='navbar navbar-expand-md navbar-light bg-warning h6'>
            <div class="container font-weight-bold">
                <a href="#" class='navbar-brand'>SalonDeEventos</a>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#first-navbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="first-navbar" class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="#">Principal</a></li>
                        <li class="nav-item"><a class="nav-link" href="#consultas">Consultar</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contacto">
                                Contacto
                            </a>
                        </li>                    
                        <li class="nav-item">
                            <a id="mostrar" class="nav-link btn btn-success btn-sm text-light" href="#" data-toggle="modal" data-target="#login">Iniciar Sesión                            
                            </a>
                        </li>
                        <li id="btnregister" class="nav-item ml-2">
                            <a id="link-reg" class="nav-link btn btn-primary btn-sm text-light" href="#" data-toggle="modal" data-target="#registro">Registrarse
                            </a>
                        </li>
                    </ul>                
                </div>
            </div>
        </nav>                                 
        <div id="layoutAuthentication">            
            <div id="layoutAuthentication_content">                
            <div>
            <div id="reg-exitoso" class="alert alert-success alert-dismissible text-center col-8">
            <button type="button" class="close" data-dismiss="alert">
                <span>×</span>
            </button>
             Registro <strong id="estado">Exitoso</strong> 
        </div>
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" style="margin-top: 15vh;">
                      <div class="carousel-item active">
                        <img src="img/ev1.jpg" class="d-block w-100" width="800" height="550" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Vive momentos mágicos a lado de los tuyos</h5>                    
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="img/ev2.png" class="d-block w-100" width="800" height="550" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Disfruta cada momento con la mejor animación y sonido</h5>                    
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="img/ev3.jpg" class="d-block w-100" width="800" height="550" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Servicios de calidad y muy económicos</h5>                    
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="img/ev4.jpg" class="d-block w-100" width="800" height="550" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Reuniones en un epacio amigable</h5>                    
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="img/ev5.jpg" class="d-block w-100" width="800" height="550" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Diversión al máximo como en casa</h5>                    
                        </div>
                      </div>
                      </div>
                      <div class="carousel-item">
                        <img src="img/ev7.jpg" class="d-block w-100" width="800" height="550" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Reserva ahora y conoce este espectacular salón</h5>                    
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="img/ev8.jpg" class="d-block w-100" width="800" height="550" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Servicio 100% garantizado</h5>                    
                        </div>
                      </div>
                    </div>
                    <a class="carousel-control-prev ml-1" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next mr-2" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                </div>
                </div>
                <main>
                <div id="regist" class="container z-index-modal mt-4 position-fixed">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h5 class="text-center font-weight-light my-1">Crear Cuenta</h5></div>
                                    <div class="card-body">
                                        <form id="crearuser" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
                                                <button class="ocultar col-4 btn btn-danger" type="button">Cancelar</button>
                                                <button class="col-4 btn btn-primary" type="submit" name="create">Crear Cuenta</button>
                                            </div>
                                        </form>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="init" class="container z-index-modal mt-5 position-fixed">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h5 class="text-center font-weight-light my-1">Iniciar Sesión</h5></div>
                                    <div class="card-body">
                                        <form id="acceder" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="form-group">
                                                <label class="small mb-1" for="correo">Email</label>
                                                <input class="form-control py-4" id="inputEmailAddress" name="correo" type="email" placeholder="Correo Electrónico" require/>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="pass">Contraseña</label>
                                                <input class="form-control py-4" id="inputPassword" name="pass" type="password" placeholder="Contraseña" require/>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group row justify-content-around">
                                                <button class="ocultar col-4 btn btn-danger" type="button">Cancelar</button>
                                                <button id="iniciar" class="col-4 btn btn-primary" type="submit" name="iniciate">Iniciar</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <section class="about" id="consultas">
        <div class="max-width">
            <h2 class="title">Consulta los días disponibles</h2>
            <div class="about-content">                    
                <div class="column">
                    <div class="text">Tenemos una fecha especial para tí y tus invitados <span class="typing-2"></span></div>
                    <p>Ven registrate y reserva tu lugar para tus eventos, un lugar cómodo muy tranquilo y sobre todo seguro, tenemos areas extensas para que puedas aprovechar al máximo tus fiestas, no dejes pasar esta oportunidad de celebrar con los tuyos de la mejor manera, contamos con una amplia gama de servicios de calidad para tí y tus invitados.</p>
                    <br>                    
                    
                    <div id="mydate" class="mx-auto" style="width: 200px;">

                    </div>                          
                </div>
            </div>
        </div>
    </section>
    <section class="about" id="contacto">
        <div class="max-width">
            <h2 class="title">Contactanos ahora</h2>
            <div class="about-content">                    
                <div class="column">
                    <div class="text">No lo pienses más, celebra con nosotros<span class="typing-2"></span></div>
                    <form class="form-container">
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3>Contáctanos</h3>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control py-4" type="text" placeholder="Nombre y Apellidos", require/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">                                    
                                    <input class="form-control py-4" type="text" placeholder="Correo" require/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Asunto" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" cols="30" rows="5" placeholder="Message.."
                                required></textarea>
                        </div>
                        <button type="button" class="btn btn-success btn-block w-25" style="margin:auto auto;">
                            <i class="mr-1"></i>Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
        <footer>
            <span>Creado por <a href="#">ISC-TECNM-7MO-EQUIPO N</a> | <span class=>&copy;</span>    2020 Todos los derechos reservados.</span>
        </footer>
        
        <script>
            $(document).ready(inicio);            
            $("#init").hide();                                    
            $("#regist").hide();
            //$("#reg-exitoso").hide();
            function inicio(){
                $('#mostrar').click(function(){
                    setTimeout(function() {    
                    $("#init").css("margin-left", '7%');             
                    $("main").css("z-index", '200');  
                    $("main").css("position", 'fixed');  
                    $("#regist").css("display", 'none');                    
                    $("#init").fadeIn(1000);
                    $("#acceder")[0].reset();                    
                    });
                });
                $('#btnregister').click(function(){
                    setTimeout(function() {                        
                    $("#init").css("display", 'none');  
                    $("#regist").css("margin-left", '7%');         
                    $("main").css("z-index", '200');  
                    $("main").css("position", 'fixed');
                    $("#regist").fadeIn(1000);                    
                    $("#crearuser")[0].reset();
                    });
                });                
                $('.ocultar').click(function(){
                    setTimeout(function() {
                    $("#init").fadeOut(1000);
                    $("#regist").fadeOut(1000);
                    $("main").css("z-index", '100');  
                    $("main").css("display", 'block');                    
                    });                                        
                });
            }            
        </script>
        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/validar.js"></script>       
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js"></script>
    </body>
</html>