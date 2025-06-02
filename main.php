<?php
// main.php
// This file is designed to be included by index.php.
// It also acts as an AJAX endpoint for calendar updates.

// CRUCIAL: Include NepaliCalendar.php here so main.php is self-contained for calendar generation.
require_once 'NepaliCalendar.php';

// Detect if this is an AJAX request specifically for calendar data.
// This logic MUST be at the VERY TOP of the file, before any HTML output.
$is_ajax_calendar_request = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' &&
                            isset($_GET['year']) && isset($_GET['month']);

if ($is_ajax_calendar_request) {
    // If it's an AJAX request for calendar, only output the calendar HTML fragment.
    header('Content-Type: text/html; charset=utf-8'); // Ensure correct content type for HTML fragment
    
    if (!class_exists('NepaliCalendar')) {
        echo "<p style='color:red;'>Error: NepaliCalendar class not found when fetching calendar via AJAX. Check include path in main.php.</p>";
    } else {
        $calendar = new NepaliCalendar();
        $year = (int)$_GET['year'];
        $month = (int)$_GET['month'];
        if (method_exists($calendar, 'getCalendarHTML')) {
            echo $calendar->getCalendarHTML($year, $month);
        } else {
            echo "<p style='color:red;'>Error: getCalendarHTML method not found in NepaliCalendar class (AJAX context).</p>";
        }
    }
    exit; // IMPORTANT: Stop execution AFTER sending the calendar fragment for AJAX requests.
          // This prevents any other HTML from main.php from being sent with the AJAX response.
}
?>
    <div class="container"> 
        <div id="calendarContainer">
            <?php
            // Initial rendering of the calendar on full page load.
            // This relies on the NepaliCalendar class required above.
            if (!class_exists('NepaliCalendar')) {
                echo "<p style='color:red;'>Error: NepaliCalendar class not found during initial page load. Check include path in main.php.</p>";
            } else {
                $calendar = new NepaliCalendar();
                $year = isset($_GET['year']) ? (int)$_GET['year'] : null;
                $month = isset($_GET['month']) ? (int)$_GET['month'] : null;
                if (method_exists($calendar, 'getCalendarHTML')) {
                    echo $calendar->getCalendarHTML($year, $month);
                } else {
                    echo "<p style='color:red;'>Error: getCalendarHTML method not found during initial page load.</p>";
                }
            }
            ?>
        </div>
        <div class="sidebar">
            <div class="weather-info">
                <h3>Current Weather</h3>
                <div id="weatherForecast">
                    <p>Loading weather...</p>
                </div>
            </div>
            <div class="date-info">
                <h3>आजको मिति</h3>
                <div id="currentDate">
                </div>
            </div>
            <div id="nepaliClock" class="clock">Loading Nepali Time...</div>
            <div class="date-converter">
                <h4>Nepali ↔ English Date Converter</h4>
                <h5>Nepali to English</h5>
                <input type="text" id="nepaliDate" placeholder="YYYY-MM-DD" pattern="\d{4}-\d{2}-\d{2}">
                <button id="convertNepali">Convert</button>
                <div id="nepResult" class="result"></div>
                <h5>English to Nepali</h5>
                <input type="date" id="englishDate">
                <button id="convertEnglish">Convert</button>
                <div id="engResult" class="result"></div>
            </div>
        </div>
    </div>
    <div id="loading">
        <i class="fas fa-spinner fa-spin"></i> Loading...
    </div>

    <?php /* No <script> tags here. All JavaScript goes in js/script.js */ ?>
