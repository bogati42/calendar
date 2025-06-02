<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sakura Themed Tokyo Analog Clock - Idle Cursor Hide</title> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta+Vaani:wght@400;700&family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Sakura Color Palette */
            --sakura-white: #FFF9FB;
            --sakura-light-pink: #FFEFF2;
            --sakura-pink: #FFC2D1;
            --sakura-medium-pink: #FFB2C6;
            --sakura-deep-pink: #E6A4B4;
            --branch-brown: #8B6B61;
            --hand-dark: #5C5C5C;
            --second-hand-accent: #F57187;

            --primary-color: var(--sakura-pink);
            --secondary-color: var(--sakura-medium-pink);
            --accent-color: var(--sakura-white);

            --hand-hour-color: var(--hand-dark);
            --hand-minute-color: var(--hand-dark);
            --hand-second-color: var(--second-hand-accent);

            --spoke-color: var(--branch-brown);
            --center-dot-color: var(--hand-dark);
            --label-color: var(--sakura-deep-pink);

            --clock-size: 85vmin;
            --ball-size: calc(var(--clock-size) * 0.075);
            --spoke-width: calc(var(--clock-size) * 0.009);
            --center-dot-size: calc(var(--clock-size) * 0.055);
            --hand-hour-width: calc(var(--clock-size) * 0.022);
            --hand-minute-width: calc(var(--clock-size) * 0.017);
            --hand-second-width: calc(var(--clock-size) * 0.006);
        }

        body {
            font-family: 'Noto Sans JP', 'Mukta Vaani', Arial, sans-serif;
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 60%, var(--secondary-color) 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            color: #333;
            overflow: hidden;
            /* Default cursor, will be managed by JS */
            /* cursor: auto; (already default) */
        }

        /* CSS rules for hiding cursor in fullscreen are removed as JS will handle idle cursor */

        .clock-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: transparent;
            padding: 0;
            box-shadow: none;
            width: 100%;
            height: 100%;
        }

        .analog-clock {
            width: var(--clock-size);
            height: var(--clock-size);
            position: relative;
            background-color: transparent;
            border: none;
        }

        .hand {
            position: absolute;
            bottom: 50%;
            left: 50%;
            transform-origin: bottom center;
            z-index: 10;
            border-radius: calc(var(--clock-size) * 0.005);
        }

        .hour-hand {
            width: var(--hand-hour-width);
            height: 22%;
            margin-left: calc(var(--hand-hour-width) / -2);
            background-color: var(--hand-hour-color);
            z-index: 12;
        }

        .minute-hand {
            width: var(--hand-minute-width);
            height: 32%;
            margin-left: calc(var(--hand-minute-width) / -2);
            background-color: var(--hand-minute-color);
            z-index: 11;
        }

        .second-hand {
            width: var(--hand-second-width);
            height: 38%;
            margin-left: calc(var(--hand-second-width) / -2);
            background-color: var(--hand-second-color);
            z-index: 13;
        }

        .center-dot {
            width: var(--center-dot-size);
            height: var(--center-dot-size);
            background-color: var(--center-dot-color);
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 14;
            box-shadow: 0 0 calc(var(--clock-size) * 0.01) rgba(0,0,0,0.2);
        }

        .spoke {
            position: absolute;
            bottom: 50%;
            left: 50%;
            width: var(--spoke-width);
            height: 48%;
            background-color: var(--spoke-color);
            transform-origin: bottom center;
            z-index: 6;
            margin-left: calc(var(--spoke-width) / -2);
            border-radius: calc(var(--spoke-width) / 2);
        }

        .ball {
            position: absolute;
            width: var(--ball-size);
            height: var(--ball-size);
            border-radius: 50%;
            z-index: 7;
            transform: translate(-50%, -50%);
            box-shadow: inset calc(var(--ball-size) * 0.07) calc(var(--ball-size) * 0.07) calc(var(--ball-size) * 0.18) rgba(0,0,0,0.15),
                        calc(var(--ball-size) * 0.03) calc(var(--ball-size) * 0.03) calc(var(--ball-size) * 0.1) rgba(0,0,0,0.2);
        }

        .clock-label {
            margin-top: calc(var(--clock-size) * 0.04);
            font-size: clamp(1rem, calc(var(--clock-size) * 0.07), 3rem);
            font-weight: bold;
            color: var(--label-color);
            text-shadow: 1px 1px 3px rgba(255,255,255,0.5);
            z-index: 15;
        }

        .main-page-link {
           display: none;
        }
    </style>
</head>
<body>
    <div class="clock-container">
        <div id="tokyoAnalogClock" class="analog-clock">
            <div class="hand hour-hand"></div>
            <div class="hand minute-hand"></div>
            <div class="hand second-hand"></div>
            <div class="center-dot"></div>

            <?php
            $ball_colors = [
                '#FFFFFF', '#FFEFF2', '#FFDFE6', '#FFC2D1',
                '#FFB2C6', '#FBCFE8', '#FFFFFF', '#FFEFF2',
                '#E6A4B4', '#FFC2D1', '#FFB2C6', '#F9A8D4'
            ];
            $ball_radius_percent = 42;
            $num_elements = 12;
            for ($i = 0; $i < $num_elements; $i++):
                $angle_deg = $i * (360 / $num_elements);
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
        <div class="clock-label">東京時間</div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // --- Clock Update Logic ---
            function updateTokyoTime() {
                const $analogClock = $('#tokyoAnalogClock');
                if (!$analogClock.length) return;
                const now = new Date();
                const utcMs = now.getTime() + (now.getTimezoneOffset() * 60 * 1000);
                const tokyoOffsetMinutes = 9 * 60; 
                const tokyoMs = utcMs + (tokyoOffsetMinutes * 60 * 1000);
                const tokyoDate = new Date(tokyoMs);
                const hours = tokyoDate.getHours();
                const minutes = tokyoDate.getMinutes();
                const seconds = tokyoDate.getSeconds();
                const secondDegrees = (seconds * 6);
                const minuteDegrees = (minutes * 6) + (seconds / 60 * 6);
                const hourDegrees = (hours % 12 * 30) + (minutes / 60 * 30) + (seconds / 3600 * 30);
                $analogClock.find('.second-hand').css('transform', `rotate(${secondDegrees}deg)`);
                $analogClock.find('.minute-hand').css('transform', `rotate(${minuteDegrees}deg)`);
                $analogClock.find('.hour-hand').css('transform', `rotate(${hourDegrees}deg)`);
            }

            (function initClock() {
                setInterval(updateTokyoTime, 1000);
                updateTokyoTime();
            })();

            // --- Idle Cursor Logic ---
            let idleTimer;
            const IDLE_TIMEOUT = 5000; // 5 seconds

            function hideMouseCursor() {
                $('body').css('cursor', 'none');
            }

            function showMouseCursorAndResetTimer() {
                $('body').css('cursor', 'auto'); // Or 'default'
                clearTimeout(idleTimer);
                idleTimer = setTimeout(hideMouseCursor, IDLE_TIMEOUT);
            }

            // Initial setup for idle cursor
            showMouseCursorAndResetTimer(); // Show cursor initially and start timer

            // Reset timer on user activity
            $(document).on('mousemove mousedown keydown', function() {
                showMouseCursorAndResetTimer();
            });
        });
    </script>
</body>
</html>
