<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../src/vendor/autoload.php';
	$app = new \Slim\App;
	//endpoint get greeting
	$app->get('/getName/{fname}/{lname}', function (Request $request, Response
	$response, array $args) {
		$info=	array("fname"=>$args['fname'],"lname"=>$args['lname']);
		
		return json_encode($info);
	});
	//endpoint post greeting
	$app->post('/postName', function (Request $request, Response $response, array $args)
	{
		$data=json_decode($request->getBody());
		$info=array();
		array_push($info,array(
				"lname"=>$data->lastname,
				"fname"=> $data->firstname,
				"dept"=> $data->department,
				"col"=> $data->college,
		
		));
		$response->getBody()->write(json_encode(array("status"=>"success",
							"data"=>$info
		)));
		return $response;
	});
	$app->run();
?>