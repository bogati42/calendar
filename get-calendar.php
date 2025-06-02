<?php
require_once 'NepaliCalendar.php';

$calendar = new NepaliCalendar();
$year = isset($_GET['year']) ? (int)$_GET['year'] : null;
$month = isset($_GET['month']) ? (int)$_GET['month'] : null;

echo $calendar->getCalendarHTML($year, $month);
