<?php require_once 'NepaliCalendar.php'; ?>
<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>नेपाली पात्रो</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #1976d2;
            --accent-color: #e3f2fd;
            --border-color: #dee2e6;
        }

        body {
            font-family: 'Noto Sans', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 3fr 1fr;
            gap: 20px;
        }

        .calendar, .sidebar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
	}
.sidebar {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    border: 2px solid #ffb347;
    color: #4a2c2a;
    position: relative;
    overflow: hidden;
}
.sidebar .date-info {
    background: rgba(255,255,255,0.85);
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    border-left: 5px solid #ffb347;
    box-shadow: 0 2px 8px rgba(252,182,159,0.15);
}
.sidebar h3, .sidebar h4, .sidebar h5 {
    color: #ff7e5f;
    margin-top: 0;
}
.sidebar .clock {
    background: linear-gradient(90deg, #fcb69f 0%, #ffecd2 100%);
    border-radius: 8px;
    padding: 10px 15px;
    margin-bottom: 20px;
    color: #7b2ff2;
    font-size: 18px;
    box-shadow: 0 1px 4px rgba(123,47,242,0.08);
}
.sidebar .date-converter {
    background: rgba(255,255,255,0.85);
    border-radius: 10px;
    padding: 15px;
    border-left: 5px solid #7b2ff2;
    box-shadow: 0 2px 8px rgba(123,47,242,0.10);
}
.sidebar input[type="text"], .sidebar input[type="date"] {
    border: 1px solid #ffb347;
    border-radius: 5px;
    padding: 6px 10px;
    margin-bottom: 8px;
    width: 100%;
    box-sizing: border-box;
    background: #fff7e6;
    color: #4a2c2a;
}
.sidebar button {
    background: linear-gradient(90deg, #ffb347 0%, #ff7e5f 100%);
    color: white;
    border: none;
    border-radius: 20px;
    padding: 8px 18px;
    font-weight: bold;
    cursor: pointer;
    margin-bottom: 10px;
    transition: background 0.3s, transform 0.2s;
    box-shadow: 0 2px 6px rgba(255,126,95,0.10);
}
.sidebar button:hover {
    background: linear-gradient(90deg, #ff7e5f 0%, #feb47b 100%);
    transform: scale(1.05);
}
.sidebar .result {
    margin-top: 6px;
    padding: 6px 10px;
    border-radius: 5px;
    font-size: 15px;
    background: #fff7e6;
    color: #4a2c2a;
}
.sidebar .result.success {
    background: #d4fc79;
    color: #355c00;
}
.sidebar .result.error {
    background: #ffb3b3;
    color: #a80000;
}

        .calendar {
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }

        .navigation button {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .navigation button:hover {
            background: white;
            color: var(--primary-color);
        }

        .days-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: #f8f9fa;
            border-bottom: 1px solid var(--border-color);
        }

        .day-name {
            padding: 15px;
            text-align: center;
            font-weight: bold;
            color: #495057;
        }

        .day-name.saturday {
            color: red; /* Red color for Saturday */
        }

        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: var(--border-color);
            padding: 1px;
        }

        .day {
            background: white;
            padding: 15px;
            text-align: center;
            min-height: 60px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .day:hover {
            background: var(--accent-color);
            transform: scale(1.05);
            z-index: 1;
        }

        .empty {
            background: #f8f9fa;
            cursor: default;
        }

        .today {
            background: var(--accent-color);
            font-weight: bold;
            color: var(--secondary-color);
            border: 2px solid var(--primary-color);
        }

        .public-holiday {
            background-color: #ffcccb; /* Light red for public holidays */
            color: #d32f2f;
            font-weight: bold;
        }

        .weekend {
            background-color: white; /* Keep white background */
            color: red; /* Red font for weekends */
            font-weight: bold;
        }

        .clock, .date-converter {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
        }

        #loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255,255,255,0.9);
            padding: 20px;
            border-radius: 10px;
            display: none;
            z-index: 1000;
        }

        @media (max-width: 768px) {
            body {
                grid-template-columns: 1fr;
            }

            .day {
                padding: 10px;
                min-height: 40px;
                font-size: 14px;
            }

            .day-name {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="calendar">
        <?php
        $calendar = new NepaliCalendar();
        $year = isset($_GET['year']) ? (int)$_GET['year'] : null;
        $month = isset($_GET['month']) ? (int)$_GET['month'] : null;
        echo $calendar->getCalendarHTML($year, $month);
        ?>
    </div>

    <div class="sidebar">
        <div class="date-info">
            <h3>आजको मिति</h3>
            <div id="currentDate"></div>
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

    <div id="loading">
        <i class="fas fa-spinner fa-spin"></i> Loading...
    </div>
    
    <script>
        // Update Nepali Clock
        function updateNepaliTime() {
            const clockElement = document.getElementById('nepaliClock');
            const currentTime = new Date();

            const nepaliTimeOffset = 5.75 * 60 * 60 * 1000; // 5 hours 45 minutes in milliseconds
            const nepaliTime = new Date(currentTime.getTime() + nepaliTimeOffset);

            const hours = nepaliTime.getUTCHours().toString().padStart(2, '0');
            const minutes = nepaliTime.getUTCMinutes().toString().padStart(2, '0');
            const seconds = nepaliTime.getUTCSeconds().toString().padStart(2, '0');

            clockElement.textContent = `नेपाली समय: ${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateNepaliTime, 1000);

        // Date Converter Logic
        document.getElementById('convertNepali').addEventListener('click', function () {
            const nepaliDate = document.getElementById('nepaliDate').value;
            const resultDiv = document.getElementById('nepResult');

            if (!nepaliDate) {
                resultDiv.textContent = 'Please enter a valid Nepali date.';
                resultDiv.className = 'result error';
                return;
            }

            fetch('convert.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ type: 'nepToEng', date: nepaliDate }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        resultDiv.textContent = `Error: ${data.error}`;
                        resultDiv.className = 'result error';
                    } else {
                        resultDiv.textContent = `Converted Date: ${data.result.formatted}`;
                        resultDiv.className = 'result success';
                    }
                })
                .catch(() => {
                    resultDiv.textContent = 'Error: Conversion failed.';
                    resultDiv.className = 'result error';
                });
        });

        document.getElementById('convertEnglish').addEventListener('click', function () {
            const englishDate = document.getElementById('englishDate').value;
            const resultDiv = document.getElementById('engResult');

            if (!englishDate) {
                resultDiv.textContent = 'Please enter a valid English date.';
                resultDiv.className = 'result error';
                return;
            }

            fetch('convert.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ type: 'engToNep', date: englishDate }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        resultDiv.textContent = `Error: ${data.error}`;
                        resultDiv.className = 'result error';
                    } else {
                        resultDiv.textContent = `Converted Date: ${data.result.formatted}`;
                        resultDiv.className = 'result success';
                    }
                })
                .catch(() => {
                    resultDiv.textContent = 'Error: Conversion failed.';
                    resultDiv.className = 'result error';
                });
        });

        // Display current date
        const currentDate = new Date();
        document.getElementById('currentDate').textContent = currentDate.toLocaleDateString('ne-NP');
    </script>
</body>
</html>
