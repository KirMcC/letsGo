<?php 

ob_start();
session_start();
require_once '../config.php';



if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
    $action = $_POST["action"];
    switch($action) { //Switch case for value of action
      case "store": store_function(); break;
      case "login": login_function(); break;
      case "reg": reg_function(); break;
      case "delete": del_function(); break;
      case "update": update_function(); break;
      case "del_venue": delvenue_function(); break;
    }
  }
}
    

function store_function(){

    if( !empty( $_POST )){
		try {
			$user_obj = new Cl_User();
			$data = $user_obj->store( $_POST );
            
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	}
}


function login_function(){
if( !empty( $_POST )){
		try {
			$user_obj = new Cl_User();
			$data = $user_obj->login( $_POST );
			
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	}
	
}

function reg_function(){
    if(!empty($_POST)){
		try {
			$user_obj = new Cl_User();
			$data = $user_obj->registration( $_POST );
			if($data)$success = USER_REGISTRATION_SUCCESS;
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	}
}

function del_function(){
    if( !empty( $_POST )){
		try {
			$user_obj = new Cl_User();
			$data = $user_obj->delete( $_POST );
			
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	}
}

function delvenue_function(){
    if( !empty( $_POST )){
		try {
			$user_obj = new Cl_User();
			$data = $user_obj->delvenue( $_POST );
			
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	}
}

function update_function(){ 
if( !empty( $_POST )){
    try {
        $user_obj = new Cl_User();
        $data = $user_obj->account( $_POST );
        if($data)$success = PASSOWRD_CHANAGE_SUCCESS;
    } catch (Exception $e) {
        $error = $e->getMessage();
    } 
}
}
	
?>