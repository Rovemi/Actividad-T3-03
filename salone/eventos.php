<?php
    session_start();

    if( !isset($_SESSION['id']) ){
        header("Location: index.php");
    }

    $id = $_SESSION['id'];
?>
<?php
    header('Content-Type: application/json');
    $pdo = new PDO("mysql:dbname=salon; host=127.0.0.1","root","1234");
    
    $accion = (isset($_GET['accion']))?$_GET['accion']:'leer';
    switch($accion){
        case 'agregar':
            $sentenciaSQL = $pdo->prepare("INSERT INTO eventos(title,descripcion,start,color,textColor,id_cliente) values(:title,:descripcion,:start,:color,:textColor,:id_cliente)");
                $des = str_split($_POST['descripcion'],6);

                if( strcmp($des[0],"Pagado") == 0 ){
                    $respuesta = $sentenciaSQL->execute(array(
                        "title" =>'Confirmado',
                        "descripcion" =>$_POST['descripcion'],
                        "start" =>$_POST['start'],
                        "color" =>'green',
                        "textColor" =>$_POST['textColor'],
                        "id_cliente" =>$id
                    ));
                }
                else{
                    $respuesta = $sentenciaSQL->execute(array(
                        "title" =>$_POST['title'],
                        "descripcion" =>$_POST['descripcion'],
                        "start" =>$_POST['start'],
                        "color" =>$_POST['color'],
                        "textColor" =>$_POST['textColor'],
                        "id_cliente" =>$id
                    ));
                }
            echo json_encode($respuesta);
            break;
        case 'eliminar':
            $respuesta = false;
            if(isset($_POST['id'])){
                $sentenciaSQL = $pdo->prepare("DELETE FROM eventos WHERE id=:id");
                $respuesta = $sentenciaSQL->execute(array("id"=>$_POST['id']));
            }
            echo json_encode($respuesta);
            break;
        case 'modificar':
            $sentenciaSQL = $pdo->prepare("UPDATE eventos SET
             title=:title,
             descripcion=:descripcion,
             start=:start,
             color=:color,
             textColor=:textColor WHERE id=:id");

            $des = str_split($_POST['descripcion'],6);
            
            if( strcmp($des[0],"Pagado") == 0 ){
                $respuesta = $sentenciaSQL->execute(array(
                    "id"=>$_POST['id'],
                    "title" =>'Confirmado',
                    "descripcion" =>$_POST['descripcion'],
                    "start" =>$_POST['start'],
                    "color" =>'green',
                    "textColor" =>$_POST['textColor'],
                ));
            }else{
                $respuesta = $sentenciaSQL->execute(array(
                    "id"=>$_POST['id'],
                    "title" =>$_POST['title'],
                    "descripcion" =>$_POST['descripcion'],
                    "start" =>$_POST['start'],
                    "color" =>$_POST['color'],
                    "textColor" =>$_POST['textColor']
                ));
            }
            echo json_encode($respuesta);
            break;
        default:
            //seleccionar los eventos del calendario
            $sentenciaSQL = $pdo->prepare("SELECT id,title,descripcion,start,color,textColor FROM  eventos");// WHERE id_cliente=:id
            $sentenciaSQL->execute();//array("id"=>$_SESSION['id'])
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($resultado);
            break;
    }
?>