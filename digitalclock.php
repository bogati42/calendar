<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Nepali Digital Clock</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@remotemerge/nepali-date-converter@1/dist/ndc-browser.js"></script>
    <style>
        :root {
            --primary-color: #87ceeb; /* Sky Blue */
            --background-color: #000000; /* Dark Black */
            --text-shadow-color: rgba(135, 206, 235, 0.5); /* Sky Blue Shadow */
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--primary-color);
            display: flex; /* Changed to flexbox */
            flex-direction: column; /* Stack children vertically */
            justify-content: center; /* Center content vertically initially */
            align-items: center;
            min-height: 100vh; /* Ensure body takes at least full viewport height */
            overflow: hidden; /* Keep overflow hidden for the clock effect */
        }

        .clock-container {
            text-align: center;
            padding: 20px 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 8px 15px var(--text-shadow-color);
            backdrop-filter: blur(10px);
            animation: fadeIn 1.5s ease-out;
            margin-bottom: auto; /* Push the clock container to the top if body is flex column */
            margin-top: auto; /* Push the clock container to the bottom if body is flex column */
        }

        .time {
            font-size: 6rem;
            font-weight: 600;
            letter-spacing: 3px;
            text-shadow: 0 4px 10px var(--text-shadow-color);
            margin: 0;
        }

        .date {
            font-size: 1.5rem;
            font-weight: 400;
            margin: 10px 0 0;
            text-shadow: 0 2px 6px var(--text-shadow-color);
        }

        .label {
            font-size: 1rem;
            font-weight: 600;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(135, 206, 235, 0.8);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* These styles seem to be overrides and might conflict with the clock-container styles */
        /* If you want these digital clock specific styles to apply, ensure they have higher specificity */
        /* or remove the conflicting ones from .clock-container */
        #time {
            /* font-size: 3em; */ /* This was 6rem in .time, 3em might be smaller */
            /* font-weight: bold; */ /* This was 600 in .time */
            /* color: #ffffff; */ /* This was var(--primary-color) which is sky blue */
            /* background: linear-gradient(145deg, #1e1e1e, #2c2c2c); */
            /* padding: 20px 40px; */ /* Already set in .clock-container */
            /* border-radius: 15px; */ /* Already set in .clock-container (10px) */
            /* box-shadow: 8px 8px 15px #1a1a1a, -8px -8px 15px #2e2e2e; */
            /* text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); */
            /* display: inline-block; */
            transform: perspective(500px) rotateX(10deg); /* This transform IS unique and useful */
            transition: all 0.3s ease-in-out;
        }

        #time:hover {
            transform: perspective(500px) rotateX(0deg) scale(1.02); /* Added scale for more effect */
            box-shadow: 4px 4px 10px #1a1a1a, -4px -4px 10px #2e2e2e;
        }

        #date {
            margin-top: 10px;
            /* font-size: 1.2em; */ /* This was 1.5rem in .date */
            /* color: #ccc; */ /* This was var(--primary-color) */
        }

        /* This body style is an override and is likely causing issues with centering */
        /* body { */
        /* background-color: #121212; */
        /* font-family: 'Segoe UI', sans-serif; */
        /* text-align: center; */
        /* padding-top: 100px; */ /* This will push content down */
        /* } */

        .main-page-link {
            margin-top: auto; /* Pushes this element to the very bottom */
            padding: 20px; /* Add some padding around the link */
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        .main-page-link a {
            color: var(--primary-color); /* Use your primary color for the link */
            text-decoration: none; /* Remove underline by default */
            font-size: 1.1rem;
            font-weight: 600;
            transition: color 0.3s ease, transform 0.3s ease;
            display: inline-block; /* Allows transform on the link itself */
            text-shadow: 0 0 5px var(--text-shadow-color); /* Subtle glow */
        }

        .main-page-link a:hover {
            color: #ffffff; /* White on hover */
            text-decoration: underline; /* Underline on hover */
            transform: scale(1.05); /* Slightly enlarge on hover */
            text-shadow: 0 0 10px var(--primary-color), 0 0 20px var(--primary-color); /* Stronger glow */
        }

    </style>
</head>
<body>
    <div class="clock-container" id="clock-container">
        <div class="time" id="time">00:00:00</div>
        <div class="date" id="date">YYYY-MM-DD BS</div>
        <div class="label">नेपाली समय</div>
    </div>

    <div class="main-page-link">
        <a href="http://34.30.240.75/">Go to Main Page</a>
    </div>

<script>
    /**
     * Fetch wrapper for JSON requests.
     */
    async function fetchData(url, options = {}) {
        const response = await fetch(url, options);
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        return await response.json();
    }

    /**
     * Updates the current time in Nepali Time (NPT).
     */
    function updateNepaliClock() {
        const timeElement = document.getElementById('time');

        const now = new Date();
        const utcMs = now.getTime() + (now.getTimezoneOffset() * 60 * 1000);
        const nptOffsetMinutes = (5 * 60) + 45;
        const nptMs = utcMs + (nptOffsetMinutes * 60 * 1000);
        const nptDate = new Date(nptMs);

        const hours = String(nptDate.getHours()).padStart(2, '0');
        const minutes = String(nptDate.getMinutes()).padStart(2, '0');
        const seconds = String(nptDate.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;

        timeElement.textContent = timeString;
    }

    /**
     * Updates the current date display (English and Nepali).
     */
    async function updateCurrentDate() {
        const now = new Date();
        const englishDate = now.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            weekday: 'long'
        });

        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const englishDateISO = `${year}-${month}-${day}`;

        try {
            const data = await fetchData('../convert.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ type: 'engToNep', date: englishDateISO }),
            });

            if (data.result && data.result.formatted) {
                document.getElementById('date').innerHTML = `
                    नेपाली मिति: ${data.result.formatted}<br>
                    English Date: ${englishDate}
                `;
            } else {
                document.getElementById('date').textContent = 'Error: Invalid Nepali date conversion response.';
            }
        } catch (error) {
            document.getElementById('date').textContent = 'Error loading date. Please check your connection.';
            console.error("Date fetch error:", error);
        }
    }

    window.onload = () => {
        updateNepaliClock();
        updateCurrentDate();
        setInterval(updateNepaliClock, 1000);
    };
</script>
</body>
</html>
