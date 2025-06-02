<?php
require 'vendor/autoload.php';
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

header('Content-Type: application/json');

try {
    $currentYear = (new LaravelNepaliDate())->now()->getYear();
    $years = range($currentYear - 10, $currentYear + 10);
    
    echo json_encode($years);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
