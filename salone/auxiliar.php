<?php 
if (isset($_GET['valor'])){
	include('database.php');
    $eventos = new Database();
    
    $listado=$eventos->readEvents($_GET['valor']);                        
    while ($row=mysqli_fetch_object($listado)){
        $id_cli=$row->id_cliente;
    }

	echo $id_cli;
}
?>