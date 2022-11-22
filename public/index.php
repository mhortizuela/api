<?php
header("Access-Control-Allow-Origin: *");
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../src/vendor/autoload.php';
$app = new \Slim\App;

//API END POINTS postName
	$app->post('/postName', function (Request $request, Response
				$response, array $args) {
			$data=json_decode($request->getBody());
			$fname =$data->fname ;
			$lname =$data->lname ;
			//Database
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "demo";try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname",
			$username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE,
			PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO names (fname, lname)
			VALUES ('". $fname ."','". $lname ."')";
			// use exec() because no results are returned
			$conn->exec($sql);
			$response->getBody()->write(json_encode(array("status"=>"success","data"=>null)));
			} catch(PDOException $e){
			$response->getBody()->write(json_encode(array("status"=>"error",
			"message"=>$e->getMessage())));
			}
			$conn = null;
		return $response;
	});
//API END POINTS printName
	$app->post('/printName', function (Request $request, Response
				$response, array $args) {
				//Database
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "demo";
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
				}
				$sql = "SELECT * FROM names";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					$data=array();
					while($row = $result->fetch_assoc()) {
						array_push($data,array("fname"=>$row["fname"]
						,"lname"=>$row["lname"]));
					}
					$data_body=array("status"=>"success","data"=>$data);
						$response->getBody()->write(json_encode($data_body));
				} else {
					$response->getBody()->write(array("status"=>"fail","data"=>array("title"=>"No Records Found")));
				}
				$conn->close();
	});


$app->run();
?>