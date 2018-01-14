<?php
header('Access-Control-Allow-Origin: *');
echo json_encode([
  "message"=>"Hello! RESTful API",
]);
