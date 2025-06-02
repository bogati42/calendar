<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nepali Full Screen Vitra Ball Clock</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta+Vaani:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Ocean Theme Colors */
            --ocean-deep: #003f70;
            --ocean-medium: #0077be;
            --ocean-light: #00b4d8; 
            --accent-highlight: #ffcc00; 
            --text-color-on-dark: #ffffff;

            --neutral-light: #f0f0f0;
            --neutral-medium: #d0d0d0;
            --neutral-dark: #c0c0c0;

            /* Clock Specific Elements */
            --hand-hour-color: var(--neutral-light);
            --hand-minute-color: var(--neutral-medium);
            --hand-second-color: var(--accent-highlight);
            --spoke-color: var(--neutral-dark);
            --center-dot-color: var(--neutral-light);
        }

        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; 
        }

        body {
            font-family: 'Mukta Vaani', Arial, sans-serif;
            background: linear-gradient(135deg, var(--ocean-medium) 0%, var(--ocean-deep) 100%);
            /* --- OR --- For an Ocean Image Background ---
            background-image: url('YOUR_OCEAN_IMAGE_URL_HERE.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            */
            min-height: 100vh; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            color: var(--text-color-on-dark); 
        }

        .clock-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%; 
            height: 100%; 
            background: transparent; 
            padding: 0; 
            box-shadow: none; 
            /* Added position relative to potentially contain absolutely positioned children if needed in future */
            position: relative; 
        }

        .analog-clock {
            width: 90vmin; 
            height: 90vmin;
            position: relative;
            background-color: transparent;
            border: none;
            border-radius: 0; 
            /* Ensure clock is on top of a general background, but below overlays */
            z-index: 1; 
        }

        .hand {
            position: absolute;
            bottom: 50%;
            left: 50%;
            transform-origin: bottom center;
            z-index: 10;
            border-radius: 3px; 
        }

        .hour-hand {
            width: 10px; 
            height: 22%; 
            margin-left: -5px; 
            background-color: var(--hand-hour-color);
            z-index: 12;
        }

        .minute-hand {
            width: 7px; 
            height: 32%; 
            margin-left: -3.5px; 
            background-color: var(--hand-minute-color);
            z-index: 11;
        }

        .second-hand {
            width: 3px; 
            height: 38%;
            margin-left: -1.5px; 
            background-color: var(--hand-second-color);
            z-index: 13;
        }

        .center-dot {
            width: 2.5vmin; 
            height: 2.5vmin;
            min-width: 20px; 
            min-height: 20px;
            background-color: var(--center-dot-color);
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 14;
            box-shadow: 0 0 8px rgba(0,0,0,0.4); 
        }

        .spoke {
            position: absolute;
            bottom: 50%; 
            left: 50%;
            width: 0.7vmin; 
            min-width: 2px; 
            height: 48%; 
            background-color: var(--spoke-color);
            transform-origin: bottom center;
            z-index: 6;
            margin-left: -0.35vmin; 
            border-radius: 0.35vmin;
        }

        .ball {
            position: absolute;
            width: 3.5vmin; 
            height: 3.5vmin;
            min-width: 25px; 
            min-height: 25px;
            border-radius: 50%;
            z-index: 7; 
            transform: translate(-50%, -50%); 
            box-shadow: inset 0.3vmin 0.3vmin 0.7vmin rgba(0,0,0,0.2), 0.1vmin 0.1vmin 0.4vmin rgba(0,0,0,0.3);
        }
        
        /* Styling for initially visible, then idle-hidden elements */
        .clock-label {
            /* Positioned within the flex flow of .clock-container, below the clock */
            margin-top: 10px; /* Reduced margin as it's inside the main container */
            font-size: clamp(1rem, 2.5vw, 1.5rem);
            font-weight: bold;
            color: var(--text-color-on-dark);
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
            z-index: 20; /* Ensure it's above the clock if any overlap could occur */
            text-align: center;
        }

        .main-page-link {
            /* Positioned within the flex flow of body, below the .clock-container */
            margin-top: 10px; 
            margin-bottom: 10px;
            text-align: center;
            width: 100%;
            z-index: 20; /* Ensure it's above the clock if any overlap could occur */
        }

        .main-page-link a {
            color: var(--accent-highlight);
            text-decoration: none;
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            font-weight: bold;
            transition: color 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
            display: inline-block;
            padding: 6px 12px;
            border-radius: 5px;
            background-color: rgba(0, 0, 0, 0.25); 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .main-page-link a:hover {
            color: var(--text-color-on-dark);
            background-color: rgba(0, 0, 0, 0.45);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="clock-container">
        <div id="nepaliClockAnalog" class="analog-clock">
            <div class="hand hour-hand"></div>
            <div class="hand minute-hand"></div>
            <div class="hand second-hand"></div>
            <div class="center-dot"></div>

            <?php
            $ball_colors = [
                '#FF5733', '#3498DB', '#F1C40F', '#2ECC71',
                '#9B59B6', '#E74C3C', '#1ABC9C', '#F39C12',
                '#2980B9', '#27AE60', '#8E44AD', '#D35400'
            ];
            $ball_radius_percent = 42; 
            $num_balls = 12;

            for ($i = 0; $i < $num_balls; $i++):
                $angle_deg = $i * (360 / $num_balls);
                $spoke_angle_deg = $angle_deg;
                $positioning_angle_rad = deg2rad($angle_deg - 90);
                $x_ball = 50 + ($ball_radius_percent * cos($positioning_angle_rad));
                $y_ball = 50 + ($ball_radius_percent * sin($positioning_angle_rad));
                $current_ball_color = $ball_colors[$i % count($ball_colors)];
            ?>
                <div class="spoke"
                     style="transform: rotate(<?php echo $spoke_angle_deg; ?>deg);">
                </div>
                <div class="ball"
                     style="top: <?php echo $y_ball; ?>%; left: <?php echo $x_ball; ?>%; background-color: <?php echo $current_ball_color; ?>;">
                </div>
            <?php endfor; ?>
        </div>
        <div class="clock-label">नेपाली समय</div>
    </div>

    <div class="main-page-link">
        <a href="http://34.30.240.75/">Go to Main Page</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            function updateNepaliTime() {
                const $analogClock = $('#nepaliClockAnalog');
                if (!$analogClock.length) return;

                const now = new Date();
                const utcMs = now.getTime() + (now.getTimezoneOffset() * 60 * 1000);
                const nptOffsetMinutes = (5 * 60) + 45; // NPT is UTC+5:45
                const nptMs = utcMs + (nptOffsetMinutes * 60 * 1000);
                const nptDate = new Date(nptMs);

                const hours = nptDate.getHours();
                const minutes = nptDate.getMinutes();
                const seconds = nptDate.getSeconds();

                const secondDegrees = (seconds * 6);
                const minuteDegrees = (minutes * 6) + (seconds / 60 * 6);
                const hourDegrees = (hours % 12 * 30) + (minutes / 60 * 30) + (seconds / 3600 * 30);

                $analogClock.find('.second-hand').css('transform', `rotate(${secondDegrees}deg)`);
                $analogClock.find('.minute-hand').css('transform', `rotate(${minuteDegrees}deg)`);
                $analogClock.find('.hour-hand').css('transform', `rotate(${hourDegrees}deg)`);
            }

            (function initClock() {
                setInterval(updateNepaliTime, 1000);
                updateNepaliTime();
            })();

            // --- Mouse cursor and element hiding logic ---
            let mouseIdleTimeout = null;
            const idleDelay = 10000; // 10 seconds in milliseconds
            const $hidableElements = $('.clock-label, .main-page-link');

            function activateIdleMode() {
                $('body').css('cursor', 'none');
                $hidableElements.fadeOut(300); // Fade out the elements
            }

            function deactivateIdleModeAndResetTimer() {
                $('body').css('cursor', 'auto');
                $hidableElements.fadeIn(300); // Fade in the elements
                clearTimeout(mouseIdleTimeout);
                mouseIdleTimeout = setTimeout(activateIdleMode, idleDelay);
            }

            // Event listener for mouse movement
            $(document).on('mousemove', deactivateIdleModeAndResetTimer);

            // Initially, elements are visible (due to CSS). Start the timer to enter idle mode.
            mouseIdleTimeout = setTimeout(activateIdleMode, idleDelay);
            // --- End of mouse cursor and element hiding logic ---
        });
    </script>
</body>
</html>
