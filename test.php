<?php 
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'time' => date('Y-m-d H:i:s')]);
