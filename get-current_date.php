<?php
require_once 'NepaliCalendar.php';

$calendar = new NepaliCalendar();
$current_date = $calendar->getCurrentBSDate();
echo $calendar->formatCurrentDate($current_date);
