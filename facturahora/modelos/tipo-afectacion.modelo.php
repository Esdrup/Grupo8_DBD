<?php

require_once "conexion.php";
/**
  * 
  */
 class ModeloTipoAfectacion
 {
	 public $idTipoAfectacion;
	 public $nombre;
	 public $fecha;
	 public $simbolo;
	 public $tipo_pago;
	 public $orden;
	 public $estado;
	 public $id_local;

	/*=============================================
		Mostrar Otros Ingresos Egresos
	=============================================*/
	static public function mdlMostrarTipoAfectacion($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla" );

		$stmt -> execute();

		return $stmt -> fetchAll(PDO::FETCH_ASSOC);

	}
	/*=============================================
		Mostrar Otros Ingresos Egresos
	=============================================*/
	 static public function mdlListaTipoAfectacion($tabla){	 
	
		$stmt = Conexion::conectar()->prepare("SELECT * FROM tipopago WHERE estado = 1 AND efectivo <> 2 ORDER BY orden" );

		$stmt -> execute();

		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	
		$stmt-> close();

		$stmt = null;

	}

	
	/*
	=================================================
	|	MOSTRAR REGISTROS TIPO COBRO				|
	=================================================
	*/
	 static public function mdlMostrarTipoAfectacionTabla($tabla){
		 $sql= "SELECT
					$tabla.id,
					$tabla.nombre,
					$tabla.simbolo,
					$tabla.efectivo,
					$tabla.orden
				FROM
					$tabla
					LEFT JOIN local ON $tabla.id_local = local.id 
				WHERE 
					$tabla.estado = 1
				ORDER BY
					orden";

		$stmt = Conexion::conectar()->prepare( $sql );

		$stmt -> execute();

		return $stmt ->fetchAll(PDO::FETCH_ASSOC);

		$stmt-> close();

		$stmt = null;

	}
	/*
	=================================================
	|	AGREGAR TIPO COBRO							|
	=================================================
	*/
	 static public function mdlAgregarTipoAfectacion($tabla,$tipopago){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre,fecha,simbolo,efectivo,orden,estado,id_local) values (:nombre,NOW(),:simbolo,:efectivo,:orden,'1',:id_local);");
 
		$stmt->bindParam(":nombre", $tipopago->nombre, PDO::PARAM_STR);
		$stmt->bindParam(":simbolo", $tipopago->simbolo, PDO::PARAM_STR);
		$stmt->bindParam(":efectivo", $tipopago->tipo_pago, PDO::PARAM_STR);
		$stmt->bindParam(":orden", $tipopago->orden, PDO::PARAM_STR);
		$stmt->bindParam(":id_local", $tipopago->id_local, PDO::PARAM_STR);
		

 		if( $stmt -> execute()) 
 			return "ok";
 		else 
 			return "Error al crear el tipo de cobro ";

 		$stmt-> close();
 		$stmt= null;

	}
	/*
	=================================================
	|				EDITAR TIPO COBRO				|
	=================================================
	*/
	 static public function mdlEditarTipoAfectacion($tabla,$tipopago){		
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre=:nombre,simbolo=:simbolo,efectivo=:efectivo,orden=:orden WHERE id = :idTipoAfectacion;");
		
		$stmt->bindParam(":nombre", $tipopago->nombre, PDO::PARAM_STR);
		$stmt->bindParam(":simbolo", $tipopago->simbolo, PDO::PARAM_STR);
		$stmt->bindParam(":efectivo", $tipopago->tipo_pago, PDO::PARAM_STR);
		$stmt->bindParam(":orden", $tipopago->orden, PDO::PARAM_STR);
		$stmt->bindParam(":idTipoAfectacion", $tipopago->idTipoAfectacion, PDO::PARAM_INT);
 		if( $stmt -> execute()) 
 			return "ok";
 		else 
 			return "Error al editar el tipo de cobro ";

 		$stmt-> close();
 		$stmt= null;

	}
	/*
	=================================================
	|				EDITAR NOTA INCIAL				|
	=================================================
	*/
	 static public function mdlEditarNotaInicial($tipopago){	
		$stmt = Conexion::conectar()->prepare("UPDATE ventas_x_tipopago SET nota=:editNotaInicial WHERE id = :id_venta_tip_cobro;");
		
		$stmt->bindParam(":editNotaInicial", $tipopago->editNotaInicial, PDO::PARAM_STR);
		$stmt->bindParam(":id_venta_tip_cobro", $tipopago->id_venta_tip_cobro, PDO::PARAM_STR);
 		if( $stmt -> execute()) 
 			return "ok";
 		else 
 			return "Error al editar la nota inicial ";

 		$stmt-> close();
 		$stmt= null;

	}
	/*
	=================================================
	|				ELIMINAR TIPO COBRO				|
	=================================================
	*/
	 static public function mdlEliminarTipoAfectacion($tabla,$tipopago){	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado=0 WHERE id = :id");
		
		$stmt -> bindParam(":id" , $tipopago->idTipoAfectacion, PDO::PARAM_INT);
		
		if( $stmt -> execute()) 
			return "ok";
		else 
			return "Error al eliminar el tipo de cobro ";

		$stmt-> close();
		$stmt= null;

	}
	/*
	=================================================
	|				EDITAR TIPO COBRO				|
	=================================================
	*/
	 static public function mdlEditarVentaTipoAfectacion($tabla,$idTipoAfectacion){	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado=2 WHERE id = :id");
		
		$stmt -> bindParam(":id" , $idTipoAfectacion, PDO::PARAM_INT);
		
		if( $stmt -> execute()) 
			return "ok";
		else 
			return "Error al eliminar el tipo de cobro ";

		$stmt-> close();
		$stmt= null;

	}
	/*
	=================================================
	|	VALIDAR EFECTIVO							|
	=================================================
	*/
	 static public function mdlValidarEfectivo($tabla){
		 $sql= "SELECT
					count(*) efectivo
				FROM
					$tabla
				
				WHERE efectivo = '1'";

		$stmt = Conexion::conectar()->prepare( $sql );

		$stmt -> execute();

		return $stmt ->fetchAll(PDO::FETCH_ASSOC);

		$stmt-> close();

		$stmt = null;

	}



	/*
	=================================================
	|	VALIDAR EFECTIVO							|
	=================================================
	*/
	static public function mdlTipoAfectacionById($tipopago){
		$sql= "SELECT
				   efectivo,
				   nombre,
				   simbolo,
				   orden
			   FROM
				   tipopago
			   
			   WHERE  id = :id";

	   $stmt = Conexion::conectar()->prepare( $sql );
	   $stmt -> bindParam(":id" , $tipopago->idTipoAfectacion, PDO::PARAM_STR);

	   $stmt -> execute();

	   return $stmt ->fetchAll(PDO::FETCH_ASSOC);

	   $stmt-> close();

	   $stmt = null;

   }


/*=============================================
	Mostrar Otros Ingresos Egresos
=============================================*/
 static public function mdlMostrarTipoAfectacionEfectivo(){


 			$stmt = Conexion::conectar()->prepare("SELECT * FROM tipopago WHERE estado = 1 AND efectivo = 1 ORDER BY orden" );

			$stmt -> execute();

			return $stmt -> fetchAll();

 
		$stmt-> close();

		$stmt = null;

	}






}