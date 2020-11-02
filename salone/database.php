<?php
	class Database{
		private $con;
		private $dbhost="localhost";
		private $dbuser="root";
		private $dbpass="1234";
		private $dbname="salon";
		function __construct(){
			$this->connect_db();
		}
		public function connect_db(){
			$this->con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
			if(mysqli_connect_error()){
				die("Conexión a la base de datos falló " . mysqli_connect_error() . mysqli_connect_errno());
			}
		}
		
		public function sanitize($var){
			$return = mysqli_real_escape_string($this->con, $var);
			return $return;
		}
		public function create($nombres,$apellidos,$telefono,$direccion,$correo_electronico,$contra){
			$sqlexist = "SELECT correo_electronico FROM clientes WHERE correo_electronico='$correo_electronico'";  
            $resultado = mysqli_query($this->con,$sqlexist);
			$num = $resultado->num_rows;
			if( $num > 0 ){
				return false;
			}
			else{
				$sql = "INSERT INTO `clientes` (nombres, apellidos, telefono, direccion, correo_electronico,password,tipo) VALUES ('$nombres', '$apellidos', '$telefono', '$direccion', '$correo_electronico',sha1('$contra'),0)";
				$res = mysqli_query($this->con,$sql);
				return true;
			}			

			/*
			$res = mysqli_query($this->con, $sql);
			if($res){
				return true;
			}else{
				return false;
			}*/
		}
		public function read(){
			$sql = "SELECT * FROM clientes WHERE tipo!=1";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function readEvents($v){
			$sql = "SELECT id_cliente FROM eventos WHERE id='$v'";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		
		public function single_record($id){
			$sql = "SELECT * FROM clientes where id='$id'";
			$res = mysqli_query($this->con, $sql);
			$return = mysqli_fetch_object($res );
			return $return ;
		}
		public function update($nombres,$apellidos,$telefono,$direccion,$correo_electronico, $id){
			$sql = "UPDATE clientes SET nombres='$nombres', apellidos='$apellidos', telefono='$telefono', direccion='$direccion', correo_electronico='$correo_electronico' WHERE id=$id";
			$res = mysqli_query($this->con, $sql);
			if($res){
				return true;
			}else{
				return false;
			}
		}
		public function update2($nombres,$apellidos,$telefono,$direccion,$correo_electronico, $id,$contra,$concontra){
			
			$sql = "SELECT password FROM clientes where id='$id'";
			$res = mysqli_query($this->con, $sql);
			$row = $res->fetch_assoc();
			$num = $res->num_rows;
			if( $num>0 )
			if( sha1($contra) != $row['password'] ){
				return false;
			}
			
			$sql = "UPDATE clientes SET nombres='$nombres', apellidos='$apellidos', telefono='$telefono', direccion='$direccion', correo_electronico='$correo_electronico', password=sha1('$concontra') WHERE id=$id";
			$res = mysqli_query($this->con, $sql);
			if($res){
				return true;
			}else{
				return false;
			}
		}
		public function delete($id){
			$sql = "DELETE FROM clientes WHERE id=$id";
			$res = mysqli_query($this->con, $sql);
			if($res){
				return true;
			}else{
				return false;
			}
		}
	}
	
	

?>	

