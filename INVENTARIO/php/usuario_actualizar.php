<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

    /*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['pruebaaa_id']);

    /*== Verificando pruebaaa ==*/
	$check_pruebaaa=conexion();
	$check_pruebaaa=$check_pruebaaa->query("SELECT * FROM pruebaaa WHERE pruebaaa_id='$id'");

    if($check_pruebaaa->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El pruebaaa no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_pruebaaa->fetch();
    }
    $check_pruebaaa=null;


    /*== Almacenando datos del administrador ==*/
    $admin_pruebaaa=limpiar_cadena($_POST['administrador_pruebaaa']);
    $admin_clave=limpiar_cadena($_POST['administrador_clave']);


    /*== Verificando campos obligatorios del administrador ==*/
    if($admin_pruebaaa=="" || $admin_clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No ha llenado los campos que corresponden a su pruebaaa o CLAVE
            </div>
        ';
        exit();
    }

    /*== Verificando integridad de los datos (admin) ==*/
    if(verificar_datos("[a-zA-Z0-9]{4,20}",$admin_pruebaaa)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su pruebaaa no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su CLAVE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


    /*== Verificando el administrador en DB ==*/
    $check_admin=conexion();
    $check_admin=$check_admin->query("SELECT pruebaaa_pruebaaa,pruebaaa_clave FROM pruebaaa WHERE pruebaaa_pruebaaa='$admin_pruebaaa' AND pruebaaa_id='".$_SESSION['id']."'");
    if($check_admin->rowCount()==1){

    	$check_admin=$check_admin->fetch();

    	if($check_admin['pruebaaa_pruebaaa']!=$admin_pruebaaa || !password_verify($admin_clave, $check_admin['pruebaaa_clave'])){
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                pruebaaa o CLAVE de administrador incorrectos
	            </div>
	        ';
	        exit();
    	}

    }else{
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                pruebaaa o CLAVE de administrador incorrectos
            </div>
        ';
        exit();
    }
    $check_admin=null;


    /*== Almacenando datos del pruebaaa ==*/
    $nombre=limpiar_cadena($_POST['pruebaaa_nombre']);
    $apellido=limpiar_cadena($_POST['pruebaaa_apellido']);

    $pruebaaa=limpiar_cadena($_POST['pruebaaa_pruebaaa']);
    $email=limpiar_cadena($_POST['pruebaaa_email']);

    $clave_1=limpiar_cadena($_POST['pruebaaa_clave_1']);
    $clave_2=limpiar_cadena($_POST['pruebaaa_clave_2']);


    /*== Verificando campos obligatorios del pruebaaa ==*/
    if($nombre=="" || $apellido=="" || $pruebaaa==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos (pruebaaa) ==*/
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El APELLIDO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9]{4,20}",$pruebaaa)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El pruebaaa no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


    /*== Verificando email ==*/
    if($email!="" && $email!=$datos['pruebaaa_email']){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email=conexion();
            $check_email=$check_email->query("SELECT pruebaaa_email FROM pruebaaa WHERE pruebaaa_email='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El correo electrónico ingresado ya se encuentra registrado, por favor elija otro
                    </div>
                ';
                exit();
            }
            $check_email=null;
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Ha ingresado un correo electrónico no valido
                </div>
            ';
            exit();
        } 
    }


    /*== Verificando pruebaaa ==*/
    if($pruebaaa!=$datos['pruebaaa_pruebaaa']){
	    $check_pruebaaa=conexion();
	    $check_pruebaaa=$check_pruebaaa->query("SELECT pruebaaa_pruebaaa FROM pruebaaa WHERE pruebaaa_pruebaaa='$pruebaaa'");
	    if($check_pruebaaa->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El pruebaaa ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
	        exit();
	    }
	    $check_pruebaaa=null;
    }


    /*== Verificando claves ==*/
    if($clave_1!="" || $clave_2!=""){
    	if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                Las CLAVES no coinciden con el formato solicitado
	            </div>
	        ';
	        exit();
	    }else{
		    if($clave_1!=$clave_2){
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                Las CLAVES que ha ingresado no coinciden
		            </div>
		        ';
		        exit();
		    }else{
		        $clave=password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
		    }
	    }
    }else{
    	$clave=$datos['pruebaaa_clave'];
    }


    /*== Actualizar datos ==*/
    $actualizar_pruebaaa=conexion();
    $actualizar_pruebaaa=$actualizar_pruebaaa->prepare("UPDATE pruebaaa SET pruebaaa_nombre=:nombre,pruebaaa_apellido=:apellido,pruebaaa_pruebaaa=:pruebaaa,pruebaaa_clave=:clave,pruebaaa_email=:email WHERE pruebaaa_id=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":apellido"=>$apellido,
        ":pruebaaa"=>$pruebaaa,
        ":clave"=>$clave,
        ":email"=>$email,
        ":id"=>$id
    ];

    if($actualizar_pruebaaa->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡pruebaaa ACTUALIZADO!</strong><br>
                El pruebaaa se actualizo con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el pruebaaa, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_pruebaaa=null;