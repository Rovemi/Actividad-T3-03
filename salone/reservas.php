<?php
    session_start();

    if( !isset($_SESSION['id']) ){
        header("Location: index.php");
    }

    $nombre = $_SESSION['nombre'];
    $tipo = $_SESSION['tipo'];
    $pwd = $_SESSION['pwd'];
    $id = $_SESSION['id'];    
    $aux = 0;
    if( isset($_GET['valor']) )
        $aux = $_GET['valor'];
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
        <link rel="stylesheet" href="css/fullcalendar.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" 
        crossorigin="anonymous"></script>
        <script src="js/moment.min.js"></script>
        <script src="js/fullcalendar.min.js"></script>
        <script src="js/es.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <script src="js/bootstrap-clockpicker.js"></script>
        <link rel="stylesheet" href="css/bootstrap-clockpicker.css">
        <script>
        $( function() {
            $( "#txtFecha" ).datepicker({
                minDate: 0,
                monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
                dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
                dateFormat: "yy-mm-dd"
            });
        } );
        </script>
        <style>
            .fc td:hover{
                cursor: pointer;
            }
        </style>
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
                    <h1 class="text-center mb-2">Reservaciones</h1>
                    <div class="container">
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-7">
                                <div id="calendario">                    
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                    <script>
                        var entro= <?php echo $id; ?> ;

                        $(document).ready( function(){
                            $("#calendario").fullCalendar({
                                dayClick:function(date,jsEvent,view){
                                    var puedo=1;
                                    $('#calendario').fullCalendar('clientEvents', function(event) {
                                        var e = event.start._i.split(" ");
                                        if(e[0]== date.format()) {
                                            puedo = 0;
                                        }
                                    });

                                    if( puedo == 1 ){
                                        $("#btnAgregar").css('display','block');
                                        $("#btnModificar").css('display','none');
                                        $("#btnEliminar").css('display','none');
                                        limpiarFormulario();
                                        $("#labelPay").css('display','inline');
                                        $("#labelPay").css('display','inline');
                                        $("#pagarcheck").css('display','inline');
                                        $("#txtFecha").val(date.format());
                                        var myDate = new Date();
                                        myDate.setDate(myDate.getDate()-1);
                                        if( date < myDate){
                                            alert("fecha no válida");
                                        }else{
                                            $("#ModalEventos").modal();
                                        }
                                    }
                                                                        
                                },
                                events:'http://localhost/salon/eventos.php',
                                eventClick:function(calEvent,jsEvent,view){
                                var valor=calEvent.id;
                                esperame = 0;
                                $.ajax({
                                    method:'GET',
                                    url: 'auxiliar.php',                    
                                    data: {'valor':valor},
                                    success:function(msg){   
                                        if(msg){
                                            esperame = 1;
                                            entro = new String(msg);
                                        }
                                    }
                                });
                                    //alert("Verificando");
                                    //verificamos el id del admin
                                    if( entro == <?php echo $id ?> || <?php echo $id ?>  == 1){
                                        $("#btnAgregar").css('display','none');
                                        $("#btnModificar").css('display','block');
                                        $("#btnEliminar").css('display','block');

                                        $("#titulo_evento").html(calEvent.title);
                                        $("#txtID").val(calEvent.id);
                                        $("#ModalEventos").modal();
                                        FechaHora=calEvent.start._i.split(" ");
                                        $("#txtFecha").val(FechaHora[0]);
                                        $("#horallegada").val(FechaHora[1]);
                                        Descripcion = calEvent.descripcion.split(" ");
                                        if( Descripcion[0] == "Pagado" ){
                                            $("#pagarcheck").css('display','none');
                                            $("#labelPay").css('display','none');
                                            $("#paid").css('display', 'none');
                                        }else{
                                            limpiarFormulario();
                                            $("#pagarcheck").css('display','inline');
                                            $("#labelPay").css('display','inline');
                                        }

                                    }else{
                                        alert("Oh parece que esta fecha no está disponible o ha sido reservada por otro cliente");
                                    }
                                },
                                editable:true,
                                eventDrop:function(calEvent){
                                    $("#txtID").val(calEvent.id);
                                    $("#titulo_evento").html(calEvent.title);
                                    var fechaHora=calEvent.start.format().split("T");
                                    $("#txtFecha").val(fechaHora[0]);
                                    $("#horallegada").val(fechaHora[1]);
                                    RecolectarInformacionGUI();
                                    EnviarInformacion('modificar',nuevoEvento,true);
                                }
                            });
                        });
                    </script>                    
                </div>
            </main>
        </div>
        </div>
        <!-- Modal 
        <div class="modal fade" id="dia_res" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_evento">Evento Programado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="descripcion"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Agregar</button>
                <button type="button" class="btn btn-success">Modificar</button>
                <button type="button" class="btn btn-danger">Borrar</button>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancelar</button>                
            </div>
            </div>
        </div>
        </div>
        -->

        <!-- Modal (agregar, modificar, eliminar) -->
        <div class="modal fade" id="ModalEventos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_evento"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="txtID" id="txtID">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label>Fecha:</label>
                        <input type="text" name="txtFecha" id="txtFecha" class="form-control">
                    </div>
                    <div class="form-group col-md-7">
                        <label>Hora estimada de llegada:</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                            <input type="text" name="" id="horallegada" value="10:00" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label id="labelPay">Pagar ahora:</label>
                    <input type="checkbox" name="pagarcheck" id="pagarcheck">
                    <div id="paid" style="display: none;">
                        <strong>Pagar a: 2345 8883 1244 888</strong>
                        <div class="form-group">
                            <label>Folio de Pago:</label>
                            <input type="text" name="txtFecha" id="folio" class="form-control">
                        </div>                        
                    </div>
                </div>
                <script>
                    $(document).ready( function(){
                        var checkbox = document.getElementById("pagarcheck");
                        checkbox.addEventListener( 'change', function() {
                            if(this.checked) {
                                $("#paid").css("display","block");
                            } else {
                                $("#paid").css("display","none");
                            }
                        });
                    });
                </script>
            </div>
            <div class="modal-footer">
                <button id="btnAgregar" type="button" class="btn btn-primary">Reservar</button>
                <button id="btnModificar" type="button" class="btn btn-success">Modificar</button>
                <button id="btnEliminar" type="button" class="btn btn-danger">Borrar</button>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancelar</button>                
            </div>
            </div>
        </div>
        </div>
        <script>
            var nuevoEvento;
            $("#btnAgregar").click(function(){
                RecolectarInformacionGUI();
                EnviarInformacion('agregar',nuevoEvento);
            });

            $("#btnEliminar").click(function(){
                RecolectarInformacionGUI();
                EnviarInformacion('eliminar',nuevoEvento);
            });

            $("#btnModificar").click(function(){
                RecolectarInformacionGUI();
                EnviarInformacion('modificar',nuevoEvento);
            });

            function RecolectarInformacionGUI(){
                nuevoEvento={
                    id:$("#txtID").val(),
                    title:'En espera',
                    descripcion: valor(),
                    start:$("#txtFecha").val()+" "+$("#horallegada").val(),
                    color: "purple",
                    textColor: "#fff"
                };
            }

            function EnviarInformacion(accion,objEvento,modal){
                $.ajax({
                    type:'POST',
                    url: 'eventos.php?accion='+accion,                    
                    data: objEvento,
                    success:function(msg){
                        if(msg){
                            $("#calendario").fullCalendar('refetchEvents');
                            if(!modal){
                                $("#ModalEventos").modal('toggle');
                            }
                        }
                    },
                    error:function(){                        
                        alert("error");
                    }
                });
            }

            $('.clockpicker').clockpicker();

            function valor(){
                if($("#folio").val()=="")
                    return "Sin Pagar";
                else
                    return "Pagado"+" Folio: "+$("#folio").val();
            }

            function limpiarFormulario(){
                $("#folio").val('');
                $("#pagarcheck").prop("checked", false);
                $("#paid").css("display","none");
            }
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
