<?php
require 'vendor/autoload.php';
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

header('Content-Type: application/json');

try {
    $year = $_GET['year'] ?? null;
    $month = $_GET['month'] ?? null;
    
    $nepaliDate = new LaravelNepaliDate();
    $monthData = $nepaliDate->getNepaliMonthData($year, $month);
    $today = $nepaliDate->now()->format('Y-m-d');

    echo json_encode([
        'start_weekday' => $monthData['start_weekday'],
        'total_days' => $monthData['total_days'],
        'today' => $today
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
