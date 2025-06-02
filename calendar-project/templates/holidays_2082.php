<?php
// Ensure this script only outputs JSON
header('Content-Type: application/json');

// Get year, month, day from query parameters
$year = isset($_GET['year']) ? (int)$_GET['year'] : null;
$month = isset($_GET['month']) ? (int)$_GET['month'] : null;
$day = isset($_GET['day']) ? (int)$_GET['day'] : null;

// This is your holiday data. You need to adjust this structure
// to match the expected format for your JavaScript.
// Specifically, for each day, you need:
//   - nepali_day, english_day, english_month, english_year, english_month_num, english_weekday, holiday (or null)
// Also, the month's first day's weekday (first_day_weekday) is needed.

// --- DUMMY DATA FOR DEMONSTRATION ---
// You will need a proper Nepali calendar conversion library in PHP
// to generate this dynamically for each month.
// This is just a placeholder to get your frontend working with a valid JSON response.

$holidays_for_year = []; // Initialize an array to hold holidays for the requested year

// Your provided holiday data (reformatted slightly for easier processing later)
$rawHolidays = [
    [
        "name" => "नेपाली नयाँ वर्ष/मेष संक्रान्ति/बिस्का जात्रा",
        "bs_date" => ["year" => 2082, "month" => 1, "day" => 1],
        "ad_date" => "2025-04-14"
    ],
    [
        "name" => "अन्तर्राष्ट्रिय श्रमिक दिवस/बुंगद्यो: रातो मत्स्येन्द्रनाथ रथ यात्रा प्रारम्भ",
        "bs_date" => ["year" => 2082, "month" => 1, "day" => 18],
        "ad_date" => "2025-05-01"
    ],
    [
        "name" => "प्रादेशिक सरकार आधिकारिक भाषा दिवस/किरात समाज सुधार दिवस",
        "bs_date" => ["year" => 2082, "month" => 1, "day" => 24],
        "ad_date" => "2025-05-07"
    ],
    [
        "name" => "बुद्ध जयन्ती/उभौली पर्व/चण्डेश्वरी जात्रा/चण्डी पूर्णिमा/कूर्म जयन्ती/गोरखनाथ जयन्ती/पूर्णिमा व्रत/बैशाख स्नान समाप्ति/अन्तर्राष्ट्रिय नर्स दिवस",
        "bs_date" => ["year" => 2082, "month" => 1, "day" => 29],
        "ad_date" => "2025-05-12"
    ],
    [
        "name" => "गणतन्त्र दिवस",
        "bs_date" => ["year" => 2082, "month" => 2, "day" => 15],
        "ad_date" => "2025-05-29"
    ],
    [
        "name" => "जनै पूर्णिमा/रक्षा बन्धन/क्वाँटी खाने दिन/पूर्णिमा व्रत/ऋषि तर्पणी/संस्कृत दिवस",
        "bs_date" => ["year" => 2082, "month" => 4, "day" => 24],
        "ad_date" => "2025-08-09"
    ],
    [
        "name" => "गाईजात्रा/विश्व आदिवासी जनजाति दिवस",
        "bs_date" => ["year" => 2082, "month" => 4, "day" => 25],
        "ad_date" => "2025-08-10"
    ],
    [
        "name" => "श्रीकृष्ण जन्माष्टमी/गोरखकाली पूजा",
        "bs_date" => ["year" => 2082, "month" => 4, "day" => 31],
        "ad_date" => "2025-08-16"
    ],
    [
        "name" => "हरितालिका तीज",
        "bs_date" => ["year" => 2082, "month" => 5, "day" => 10],
        "ad_date" => "2025-08-26"
    ],
    [
        "name" => "राधा जन्मोत्सव/गौरा पर्व/गोरखकाली पूजा/दुर्वाष्टमी",
        "bs_date" => ["year" => 2082, "month" => 5, "day" => 15],
        "ad_date" => "2025-08-31"
    ],
    [
        "name" => "इन्द्रजात्रा/अनन्त चतुर्दशी व्रत",
        "bs_date" => ["year" => 2082, "month" => 5, "day" => 21],
        "ad_date" => "2025-09-06"
    ],
    [
        "name" => "नवमी श्राद्ध/जितिया पर्व",
        "bs_date" => ["year" => 2082, "month" => 5, "day" => 30],
        "ad_date" => "2025-09-15"
    ],
    [
        "name" => "त्रयोदशी श्राद्ध/माघ श्राद्ध/संविधान दिवस",
        "bs_date" => ["year" => 2082, "month" => 6, "day" => 3],
        "ad_date" => "2025-09-19"
    ],
    [
        "name" => "घटस्थापना व्रत/नवरात्र आरम्भ",
        "bs_date" => ["year" => 2082, "month" => 6, "day" => 6],
        "ad_date" => "2025-09-22"
    ],
    [
        "name" => "फूलपाती/विश्व हृदय दिवस",
        "bs_date" => ["year" => 2082, "month" => 6, "day" => 13],
        "ad_date" => "2025-09-29"
    ],
    [
        "name" => "महा अष्टमी व्रत/कालरात्री/गोरखकाली पूजा/भौमाष्टमी व्रत",
        "bs_date" => ["year" => 2082, "month" => 6, "day" => 14],
        "ad_date" => "2025-09-30"
    ],
    [
        "name" => "महा नवमी व्रत/अन्तर्राष्ट्रिय ज्येष्ठ नागरिक दिवस",
        "bs_date" => ["year" => 2082, "month" => 6, "day" => 15],
        "ad_date" => "2025-10-01"
    ],
    [
        "name" => "विजया दशमी/देवी विसर्जन/विश्व अहिंसा दिवस",
        "bs_date" => ["year" => 2082, "month" => 6, "day" => 16],
        "ad_date" => "2025-10-02"
    ],
    [
        "name" => "पापकुन्सा एकादशी व्रत/विश्व मुस्कान दिवस",
        "bs_date" => ["year" => 2082, "month" => 6, "day" => 17],
        "ad_date" => "2025-10-03"
    ],
    [
        "name" => "दशैँ बिदा/शनि प्रदोष व्रत/विश्व पशु दिवस",
        "bs_date" => ["year" => 2082, "month" => 6, "day" => 18],
        "ad_date" => "2025-10-04"
    ],
    [
        "name" => "लक्ष्मी पूजा/लक्ष्मीप्रसाद देवकोटा जन्मजयन्ती/कुकुर तिहार/नरक चतुर्दशी/सुख रात्री",
        "bs_date" => ["year" => 2082, "month" => 7, "day" => 3],
        "ad_date" => "2025-10-20"
    ],
    [
        "name" => "तिहार बिदा",
        "bs_date" => ["year" => 2082, "month" => 7, "day" => 4],
        "ad_date" => "2025-10-21"
    ],
    [
        "name" => "गोवर्धन पूजा/गाइगोरु पूजा/म्ह पूजा/हलि तिहार/नेपाल संवत् ११४५ प्रारम्भ",
        "bs_date" => ["year" => 2082, "month" => 7, "day" => 5],
        "ad_date" => "2025-10-22"
    ],
    [
        "name" => "भाइ टीका/किजा पूजा",
        "bs_date" => ["year" => 2082, "month" => 7, "day" => 6],
        "ad_date" => "2025-10-23"
    ],
    [
        "name" => "तिहार बिदा/संयुक्त राष्ट्रसंघ दिवस/विश्व विकास सूचना दिवस",
        "bs_date" => ["year" => 2082, "month" => 7, "day" => 7],
        "ad_date" => "2025-10-24"
    ],
    [
        "name" => "छठ पर्व",
        "bs_date" => ["year" => 2082, "month" => 7, "day" => 10],
        "ad_date" => "2025-10-27"
    ],
    [
        "name" => "पूर्णिमा व्रत/चतुर्मास व्रत समाप्ति/कार्तिक स्नान समाप्ति/गुरु नानक जयन्ती",
        "bs_date" => ["year" => 2082, "month" => 7, "day" => 19],
        "ad_date" => "2025-11-05"
    ],
    [
        "name" => "फाल्गुनन्द जयन्ती",
        "bs_date" => ["year" => 2082, "month" => 7, "day" => 25],
        "ad_date" => "2025-11-11"
    ],
    [
        "name" => "अन्तर्राष्ट्रिय अपाङ्गता दिवस",
        "bs_date" => ["year" => 2082, "month" => 8, "day" => 17],
        "ad_date" => "2025-12-03"
    ],
    [
        "name" => "पूर्णिमा व्रत/धान्य पूर्णिमा/योमारी पूर्णी/ज्यापु दिवस",
        "bs_date" => ["year" => 2082, "month" => 8, "day" => 18],
        "ad_date" => "2025-12-04"
    ],
    [
        "name" => "क्रिसमस",
        "bs_date" => ["year" => 2082, "month" => 9, "day" => 10],
        "ad_date" => "2025-12-25"
    ],
    [
        "name" => "तमु ल्होसार/कवि शिरोमणि लेखनाथ जयन्ती/पुत्रदा एकादशी व्रत",
        "bs_date" => ["year" => 2082, "month" => 9, "day" => 15],
        "ad_date" => "2025-12-30"
    ],
    [
        "name" => "पृथ्वी जयन्ती/राष्ट्रिय एकता दिवस/गोरखकाली पूजा",
        "bs_date" => ["year" => 2082, "month" => 9, "day" => 27],
        "ad_date" => "2026-01-11"
    ],
    [
        "name" => "मकर संक्रान्ति/घिउ चाकु खाने दिन/उत्तरायण आरम्भ",
        "bs_date" => ["year" => 2082, "month" => 10, "day" => 1],
        "ad_date" => "2026-01-15"
    ],
    [
        "name" => "सोनम ल्होछार/श्री बल्लभ जयन्ती",
        "bs_date" => ["year" => 2082, "month" => 10, "day" => 5],
        "ad_date" => "2026-01-19"
    ],
    [
        "name" => "बसन्त पञ्चमी व्रत/सरस्वती पूजा",
        "bs_date" => ["year" => 2082, "month" => 10, "day" => 9],
        "ad_date" => "2026-01-23"
    ],
    [
        "name" => "शहीद दिवस/प्रदोष व्रत",
        "bs_date" => ["year" => 2082, "month" => 10, "day" => 16],
        "ad_date" => "2026-01-30"
    ],
    [
        "name" => "महाशिवरात्री/सेना दिवस/सिलाचह्रे पूजा",
        "bs_date" => ["year" => 2082, "month" => 11, "day" => 3],
        "ad_date" => "2026-02-15"
    ],
    [
        "name" => "ग्याल्पो ल्होसार",
        "bs_date" => ["year" => 2082, "month" => 11, "day" => 6],
        "ad_date" => "2026-02-18"
    ],
    [
        "name" => "प्रजातन्त्र दिवस/निर्वाचन दिवस",
        "bs_date" => ["year" => 2082, "month" => 11, "day" => 7],
        "ad_date" => "2026-02-19"
    ],
    [
        "name" => "फागु पूर्णिमा/होली/पूर्णिमा व्रत",
        "bs_date" => ["year" => 2082, "month" => 11, "day" => 18],
        "ad_date" => "2026-03-02"
    ],
    [
        "name" => "फागु पूर्णिमा (तराई)/खण्डग्रास चन्द्र ग्रहण/विश्व वन्यजन्तु दिवस",
        "bs_date" => ["year" => 2082, "month" => 11, "day" => 19],
        "ad_date" => "2026-03-03"
    ],
    [
        "name" => "अन्तर्राष्ट्रिय महिला दिवस",
        "bs_date" => ["year" => 2082, "month" => 11, "day" => 24],
        "ad_date" => "2026-03-08"
    ],
    [
        "name" => "घोडे जात्रा",
        "bs_date" => ["year" => 2082, "month" => 12, "day" => 4],
        "ad_date" => "2026-03-18"
    ],
    [
        "name" => "श्रीराम नवमी व्रत/विश्व रंगमञ्च दिवस",
        "bs_date" => ["year" => 2082, "month" => 12, "day" => 13],
        "ad_date" => "2026-03-27"
    ]
];

// In a real scenario, you would calculate the total days in the month,
// the first day's weekday, and populate the 'days' array with all days
// of the requested month, marking holidays where applicable.

// For demonstration, let's create a simplified structure for a month
// (e.g., Baishakh 2082 which has 31 days and starts on a Monday - weekday 1)
// **You MUST replace this with accurate Nepali calendar logic.**

$totalDaysInMonth = 31; // Example for Baishakh
$firstDayWeekday = 1; // Example: 0 for Sunday, 1 for Monday (Baishakh 1, 2082 was Monday)
$englishMonthName = "April"; // Example
$englishYear = 2025; // Example
$englishMonthNum = 4; // Example

// A very basic approximation for the English date for the first day of Nepali month
// This needs to be precise by a proper AD/BS converter
$adDateForFirstDay = new DateTime("2025-04-14"); // Baishakh 1, 2082 is approx. April 14, 2025

// Create the 'days' array with placeholder data and mark holidays
$daysData = [];
for ($i = 1; $i <= $totalDaysInMonth; $i++) {
    $currentAdDate = clone $adDateForFirstDay;
    $currentAdDate->modify("+" . ($i - 1) . " days");

    $holidayName = null;
    foreach ($rawHolidays as $holiday) {
        if ($holiday['bs_date']['year'] == $year &&
            $holiday['bs_date']['month'] == $month &&
            $holiday['bs_date']['day'] == $i) {
            $holidayName = $holiday['name'];
            break;
        }
    }

    $daysData[] = [
        "nepali_day" => $i,
        "english_day" => (int)$currentAdDate->format('j'),
        "english_month" => $currentAdDate->format('F'), // Full month name
        "english_year" => (int)$currentAdDate->format('Y'),
        "english_month_num" => (int)$currentAdDate->format('n'),
        "english_weekday" => (int)$currentAdDate->format('w'), // 0 (for Sunday) through 6 (for Saturday)
        "holiday" => $holidayName
    ];
}


// Final data structure to send to frontend
$response_data = [
    "nepali_year" => $year,
    "nepali_month_num" => $month,
    "nepali_day" => $day, // The day requested, used for initial selection
    "english_year" => $englishYear, // Example English year for the Nepali month
    "english_month" => $englishMonthName, // Example English month name for the Nepali month
    "english_day" => (int)$adDateForFirstDay->format('j'), // English day corresponding to the requested Nepali day (for display)
    "first_day_weekday" => $firstDayWeekday,
    "days" => $daysData
];

// Output the JSON
echo json_encode($response_data);
exit();
?>
