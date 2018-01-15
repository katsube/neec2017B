<?php
$kaisuu = $_GET['kaisuu'];

$data = [];
for($i=0; $i<$kaisuu; $i++){
	array_push($data, ["id"=>rand(1,5)]);	
}

header('Access-Control-Allow-Origin: *');
echo json_encode($data);
