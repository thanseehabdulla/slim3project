<?php

require_once '../include/DbHandler.php';
require '.././libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

// User id from db - Global Variable
$user_id = NULL;



$app->post('/register', function() use ($app) {
	verifyRequiredParams(array('name', 'email', 'password','mobile','address','typeid','isactive','created','updated'));
	$response = array();
	$name = $app->request->post('name');
	$email = $app->request->post('email');
	$password = $app->request->post('password');
	$mobile = $app->request->post('mobile');
	$address = $app->request->post('address');
	$typeid = $app->request->post('typeid');
	$isactive = $app->request->post('isactive');
	$created = $app->request->post('created');
	$updated = $app->request->post('updated');
	validateEmail($email);
	$db = new DbHandler();
	$res = $db->createUser($name, $email, $password, $mobile, $address, $typeid, $isactive, $created,$updated);

	if ($res == USER_CREATED_SUCCESSFULLY) {
		$response["error"] = 1;
		$response["message"] = "You are successfully registered";
	} else if ($res == USER_CREATE_FAILED) {
		$response["error"] = true;
		$response["message"] = "Oops! An error occurred while registereing";
	} else if ($res == USER_ALREADY_EXISTED) {
		$response["error"] = true;
		$response["message"] = "Sorry, this email already existed";
	}
            // echo json response
	echoRespnse(201, $response);
});
$app->post('/login', function() use ($app) {
	verifyRequiredParams(array('email', 'password'));
	$email = $app->request()->post('email');
	$password = $app->request()->post('password');
	$response = array();
	$db = new DbHandler();
	if ($db->checkLogin($email, $password)) {
		$user = $db->getUserByEmail($email);
		if ($user != NULL) {
			$response["status"] = 1;
			$response['login'] = "successfully";
			$response['id'] = $user['id'];
			$response['name'] = $user['name'];
                    // $response['email'] = $user['email'];
                    // $response['pass'] = $user['passwords'];
                    // $response['mobile'] = $user['mob'];
			$response['typeid'] = $user['type'];
                    // $response['isactive'] = $user['isactive'];
                    // $response['created'] = $user['created'];
                    // $response['updated'] = $user['updated'];


		} else {
                    // unknown error occurred
			$response['status'] = 0;
			$response['login'] = "An error occurred. Please try again";
		}

	} else {
		$response['status'] = 2;
		$response['login'] = 'Login failed. Incorrect credentials';
	}

	echoRespnse(200, $response);
});
$app->post('/insertdata', function() use ($app) {      
	verifyRequiredParams(array('order_number', 'order_desc', 'order_qty','order_amount','order_date', 'product_id', 'dealer_id','agent_id','client_id', 'isactive', 'created','updated'));
	$response = array();
	$order_number = $app->request->post('order_number');
	$order_desc = $app->request->post('order_desc');
	$order_qty = $app->request->post('order_qty');
	$order_amount = $app->request->post('order_amount');
	$order_date = $app->request->post('order_date');
	$product_id = $app->request->post('product_id');
	$dealer_id = $app->request->post('dealer_id');
	$agent_id = $app->request->post('agent_id');
	$client_id = $app->request->post('client_id');
	$isactive = $app->request->post('isactive');
	$created = $app->request->post('created');
	$updated = $app->request->post('updated');

	$db = new DbHandler();
	$res = $db->insertData($order_number, $order_desc, $order_qty,$order_amount, $order_date, $product_id,$dealer_id, $agent_id, $client_id, $isactive, $created,$updated);
	if ($res == USER_CREATED_SUCCESSFULLY) {
		$response["error"] = 1;
		$response["message"] = "DATA successfully inserted";
	} else if ($res == USER_CREATE_FAILED) {
		$response["error"] = 2;
		$response["message"] = "Oops! An error occurred while inserting";
	} 
	echoRespnse(201, $response);
});
$app->post('/getdata', function() use ($app) {
	verifyRequiredParams(array('id'));
	$id = $app->request()->post('id');
	$response = array();
	try {


		$db = new DbHandler();
		$user = $db->getAllDataByID($id);
		if ($user != NULL) {
                    // $response["error"] = false;
                    // $response['id'] = $user['id'];
                    // $response['order_qty'] = $user['order_qty'];
                    // $response['order_desc'] = $user['order_desc'];
                    // $response['order_number'] = $user['order_number'];

			$app->response()->headers->set('Content-Type', 'application/json');
			$response=$user;
		} else {
			$response['error'] = true;
			$response['message'] = "An error occurred. Please try again";
		}
	} catch (Exception $e) {
		$response = array(
			'status'=>"2",
			'operation'=>"error",
			);
	}

              //  $jsonstring = "{\"data\" : " . json_encode($response) . "}";
   // echo $jsonstring;
	echo json_encode($response);
 //  echoRespnse(200, $response);
});
$app->post('/getdataByAgentDealerID', function() use ($app) {
	$dealer_id = $app->request()->post('dealer_id');
	$agent_id = $app->request()->post('agent_id');
	$value;
	if ($dealer_id!=NULL) {
		$dealer='dealer_id';
		$v=$dealer;
		$value=$dealer_id;
	}
	else if($agent_id!=NULL){

		$agent='agent_id';
		$v=$agent;
		$value=$agent_id;
	}
	$response = array();
	try {
		$db=new PDO('mysql:dbname=beforelive_test;host=localhost;','root','');  
		$row=$db->prepare("select * from item_order where $v = $value");     
		$row->execute(); 
		$json_data=array();
		foreach($row as $rec)
		{  
			$json_array['id']=$rec['id'];  
			$json_array['order_number']=$rec['order_number'];  
			$json_array['order_desc']=$rec['order_desc'];  
			$json_array['order_qty']=$rec['order_qty'];  
			$json_array['order_amount']=$rec['order_amount'];  
			      // $json_array['dealer_id']=$rec['dealer_id'];  
			      // $json_array['order_date']=$rec['order_date'];  
			      // $json_array['product_id']=$rec['product_id'];  
			      // $json_array['agent_id']=$rec['agent_id'];  
			      // $json_array['client_id']=$rec['client_id'];  
			      // $json_array['isactive']=$rec['isactive'];  
			      // $json_array['created']=$rec['created'];  
			      // $json_array['updated']=$rec['updated'];  
			array_push($json_data,$json_array);  
		} 
		$response['data'] = $json_data;
	} 
	catch (Exception $e) {
		$response['data'] = array(
			'order_number'=>"0",
			'order_desc'=>"error",
			);
	}
        //  $jsonstring = "{\"data\" : " . json_encode($response) . "}";
	echo json_encode($response);
});
$app->post('/getPaymentByUserID', function() use ($app) {
	$order_id = $app->request()->post('order_id');


	$response = array();
	try {
		$db=new PDO('mysql:dbname=beforelive_test;host=localhost;','root','');  
		$row=$db->prepare("select TR.order_id order_id,
			TR.payment_date payment_date, 
			TR.payment_amount payment_amount, 
			TY.type_name type, 
			TR.payment_status payment_status
			from payment_transaction TR join payment_type TY on TR.type_id=TY.id 
			where TR.order_id= $order_id");     
		$row->execute(); 
		$json_data=array();
		foreach($row as $rec)
		{  
                //   $json_array['id']=$rec['id'];  
			$json_array['payment_amount']=$rec['payment_amount'];  
			$json_array['payment_date']=$rec['payment_date'];  
			$json_array['type_id']=$rec['type'];  
			switch($rec['payment_status']){
				case 1:
				$json_array['payment_status']="New"; 
				break;  
				case 2:
				$json_array['payment_status']="Pending"; 
				break;  
				case 4:
				$json_array['payment_status']="Completed"; 
			}
			$json_array['order_id']=$rec['order_id'];  
                 //  $json_array['isactive']=$rec['isactive'];  
                 //  $json_array['created']=$rec['created'];  

                 // $json_array['updated']=$rec['updated'];  
			array_push($json_data,$json_array);  
		} 
		$response['data'] = $json_data;
	} 
	catch (Exception $e) {
		$response = array(
			'status'=>"2",
			'operation'=>"error",
			);
	}
        //  $jsonstring = "{\"data\" : " . json_encode($response) . "}";
	echo json_encode($response);
});
$app->post('/insertPayment', function() use ($app) {
	$response = array();

	$order_id = $app->request()->post('order_id');
	$payment_date = $app->request()->post('payment_date');
	$type_id = $app->request()->post('type_id');
	$payment_status = $app->request()->post('payment_status');
	$payment_amount = $app->request()->post('payment_amount');
	try {
		$db=new PDO('mysql:dbname=beforelive_test;host=localhost;','root','');  
		$row=$db->prepare("INSERT INTO payment_transaction(order_id,payment_date,type_id, payment_status,payment_amount) values($order_id,'$payment_date',$type_id,$payment_status,$payment_amount)");     
		$row->execute(); 
		if ($row) {
			$response["status"] = 1;
			$response["login"] = "DATA successfully inserted";
		} 
		else{
			$response["status"] = 0;
			$response["login"] = "DATA inserted fail";
		}
	}
	catch  (Exception $e) {

		$response["status"] = 2;
		$response["login"] = "DATA  fail";
	} 
	echoRespnse(201, $response);
});
$app->post('/getSpinnerItem', function() use ($app) {
	$order_id = $app->request()->post('id');


	$response = array();
	try {
		$db=new PDO('mysql:dbname=beforelive_test;host=localhost;','root','');  
		$row=$db->prepare("select type_name,id from payment_type");     
		$row->execute(); 
		$json_data=array();
		foreach($row as $rec)
		{  
			$json_array['id']=$rec['id'];  
			$json_array['type_name']=$rec['type_name'];  

			array_push($json_data,$json_array);  
		} 
		$response['data'] = $json_data;
	} 
	catch (Exception $e) {
		$response = array(
			'status'=>"2",
			'operation'=>"error",
			);
	}
        //  $jsonstring = "{\"data\" : " . json_encode($response) . "}";
	echo json_encode($response);
});
function verifyRequiredParams($required_fields) {
	$error = false;
	$error_fields = "";
	$request_params = array();
	$request_params = $_REQUEST;
    // Handling PUT request params
	if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
		$app = \Slim\Slim::getInstance();
		parse_str($app->request()->getBody(), $request_params);
	}
	foreach ($required_fields as $field) {
		if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
			$error = true;
			$error_fields .= $field . ', ';
		}
	}

	if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
		$response = array();
		$app = \Slim\Slim::getInstance();
		$response["error"] = true;
		$response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
		echoRespnse(400, $response);
		$app->stop();
	}
}
function validateEmail($email) {
	$app = \Slim\Slim::getInstance();
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$response["error"] = true;
		$response["message"] = 'Email address is not valid';
		echoRespnse(400, $response);
		$app->stop();
	}
}
function echoRespnse($status_code, $response) {
	$app = \Slim\Slim::getInstance();
    // Http response code
	$app->status($status_code);

    // setting response content type to json
	$app->contentType('application/json');

	echo json_encode($response);
}
$app->run();
?>