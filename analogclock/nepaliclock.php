<?php require_once 'header.php'; ?>
    <div class="clock-container">
        <div id="nepaliClockAnalog" class="analog-clock">
            <div class="hand hour-hand"></div>
            <div class="hand minute-hand"></div>
            <div class="hand second-hand"></div>
            <div class="center-dot"></div>

            <?php
            // Radius for numbers and marks (as a percentage of clock size)
            $number_radius_percent = 40; // Adjust as needed
            $mark_radius_percent = 47; // Marks should be closer to the edge

            for ($i = 1; $i <= 12; $i++):
                $angle_deg = $i * 30; // 360 degrees / 12 hours = 30 degrees per hour
                $angle_rad = deg2rad($angle_deg - 90); // Convert to radians, adjust for 12 at top (0 degrees at 3 o'clock)

                // Calculate x and y positions for numbers
                $x_num = 50 + ($number_radius_percent * cos($angle_rad));
                $y_num = 50 + ($number_radius_percent * sin($angle_rad));
            ?>
                <div class="hour-number"
                     style="top: <?php echo $y_num; ?>%; left: <?php echo $x_num; ?>%;">
                    <?php echo $i; ?>
                </div>
            <?php endfor; ?>

            <?php for ($i = 0; $i < 60; $i++):
                $angle_deg = $i * 6; // 360 degrees / 60 minutes = 6 degrees per minute
                $angle_rad = deg2rad($angle_deg - 90); // Adjust for 12 at top (0 degrees at 3 o'clock)

                // Calculate x and y positions for marks
                $x_mark = 50 + ($mark_radius_percent * cos($angle_rad));
                $y_mark = 50 + ($mark_radius_percent * sin($angle_rad));
            ?>
                <?php if ($i % 5 === 0): // Hour marks (every 5 minutes) ?>
                    <div class="mark hour-mark"
                         style="transform: translate(-50%, -50%) rotate(<?php echo $angle_deg; ?>deg);
                                top: <?php echo $y_mark; ?>%; left: <?php echo $x_mark; ?>%;"></div>
                <?php else: // Minute marks ?>
                    <div class="mark minute-mark"
                         style="transform: translate(-50%, -50%) rotate(<?php echo $angle_deg; ?>deg);
                                top: <?php echo $y_mark; ?>%; left: <?php echo $x_mark; ?>%;"></div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
        <div class="clock-label">नेपाली समय</div>
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
                const hourDegrees = (hours % 12 * 30) + (minutes / 60 * 30) + (seconds / 3600 * 30); // Add second influence to hour hand

                $analogClock.find('.second-hand').css('transform', `rotate(${secondDegrees}deg)`);
                $analogClock.find('.minute-hand').css('transform', `rotate(${minuteDegrees}deg)`);
                $analogClock.find('.hour-hand').css('transform', `rotate(${hourDegrees}deg)`);
            }

            (function init() {
                setInterval(updateNepaliTime, 1000);
                updateNepaliTime();
            })();
        });
    </script>
</body>
</html>
