<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nepali Calendar</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --background-color: #f8f9fa; --surface-color: #ffffff; --text-color: #343a40;
            --secondary-text-color: #6c757d; --accent-color: #28a745; --accent-hover-color: #218838;
            --border-color: #e0e0e0; 
            --weekend-color: #dc3545; /* Original red for Sundays */
            --holiday-bg-color: #fff3cd;
            --today-bg-color: #007bff; --today-text-color: #ffffff;
            --custom-dark-red: #C00000; /* New dark red for Saturdays and Holidays text */
            --font-sans: 'Noto Sans', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            --font-mono: 'Roboto Mono', monospace; --spacing-xs: 5px; --spacing-sm: 10px; --spacing-md: 15px;
            --spacing-lg: 20px; --spacing-xl: 30px; --border-radius-sm: 4px; --border-radius-md: 8px;
            --box-shadow-light: 0 2px 5px rgba(0,0,0,0.07); --box-shadow-medium: 0 4px 10px rgba(0,0,0,0.1);
        }
        html { box-sizing: border-box; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        *, *::before, *::after { box-sizing: inherit; }
        body { display: flex; flex-direction: column; min-height: 100vh; margin: 0; padding: 0; font-family: var(--font-sans); background-color: var(--background-color); color: var(--text-color); line-height: 1.6; }
        .main-content-wrapper { max-width: 1500px; width: 95%; margin: var(--spacing-lg) auto; padding: 0 var(--spacing-sm); display: flex; flex-direction: column; flex-grow: 1; gap: var(--spacing-lg); }
        .calendar-card { background-color: var(--surface-color); border-radius: var(--border-radius-md); box-shadow: var(--box-shadow-light); padding: var(--spacing-md); margin-bottom: var(--spacing-lg); }
        .calendar-card:last-child { margin-bottom: 0; }
        .calendar-header-section { text-align: center; }
        .calendar-header-section h2 { margin: 0 0 var(--spacing-sm); font-size: clamp(1.5em, 4vw, 1.8em); color: var(--text-color); }
        .calendar-header-section p { margin: 0; font-size: clamp(1em, 3vw, 1.1em); color: var(--secondary-text-color); }

        /* --- Month Navigation Styles --- */
        .month-navigation { display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md); }
        .month-navigation button {
            background-color: var(--accent-color); color: white; border: none;
            padding: var(--spacing-sm) var(--spacing-md); 
            border-radius: var(--border-radius-sm); cursor: pointer;
            font-size: 1em; 
            transition: background-color 0.2s ease, transform 0.15s ease;
            display: flex; align-items: center; gap: var(--spacing-xs);
        }
        .month-navigation button:hover:not(:disabled) { background-color: var(--accent-hover-color); transform: translateY(-2px); }
        .month-navigation button:active:not(:disabled) { transform: translateY(0); }
        .month-navigation button:disabled {
            background-color: var(--secondary-text-color);
            cursor: not-allowed;
            transform: none; 
        }
        .month-navigation span#current-view-display { font-size: clamp(1.3em, 3.5vw, 1.5em); font-weight: bold; color: var(--text-color); text-align: center; padding: 0 var(--spacing-sm); flex-grow: 1; min-width: 150px; }
        .month-navigation i { font-size: 1.1em; }

        /* --- Date Selector Form Styles --- */
        .date-selector-form { display: flex; flex-wrap: wrap; gap: var(--spacing-md); justify-content: center; align-items: flex-end; margin-bottom: var(--spacing-lg); }
        .input-group { display: flex; flex-direction: column; gap: var(--spacing-xs); }
        .input-group label { font-size: 0.9em; color: var(--secondary-text-color); }
        .input-group select, .date-selector-form button[type="submit"] {
            padding: var(--spacing-xs) var(--spacing-sm); 
            font-size: 0.9em;   
            height: 36px;       
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background-color: var(--surface-color);
            color: var(--text-color);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .date-selector-form button[type="submit"] {
            background-color: var(--accent-color);
            color: white;
            cursor: pointer;
            flex-shrink: 0;
        }
        .date-selector-form button[type="submit"]:hover:not(:disabled) { 
            background-color: var(--accent-hover-color);
            transform: translateY(-2px);
        }
        .date-selector-form button[type="submit"]:active:not(:disabled) { 
            transform: translateY(0);
        }
        
        /* Layout for Calendar and Sidebar */
        .calendar-body-layout {
            display: flex;
            flex-direction: row; 
            gap: var(--spacing-lg);
        }
        .calendar-main-area {
            flex: 1; 
            display: flex;
            flex-direction: column;
        }

        .calendar-grid { width: 100%; display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; background-color: var(--border-color); border-radius: var(--border-radius-md); overflow: hidden; box-shadow: var(--box-shadow-light); border: 1px solid var(--border-color); }
        .day-name { background-color: #f1f3f5; padding: var(--spacing-sm); text-align: center; font-weight: bold; color: var(--text-color); font-size: 0.9em; }
        .day-cell { background-color: var(--surface-color); padding: var(--spacing-sm); text-align: center; min-height: 90px; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; position: relative; cursor: pointer; transition: background-color 0.2s ease, transform 0.2s ease; font-size: 1em; overflow: hidden; }
        .day-cell:hover:not(.empty):not(.today) { background-color: #e9ecef; transform: scale(1.02); z-index: 10; }
        .day-cell.empty { background-color: var(--background-color); cursor: default; }
        
        .day-cell.sat .nepali-day-number { color: var(--custom-dark-red); }
        .day-cell.sat .english-day-number { color: var(--custom-dark-red); opacity: 0.8; }

        .day-cell.sun .nepali-day-number { color: var(--weekend-color); }
        .day-cell.sun .english-day-number { color: var(--weekend-color); opacity: 0.8; }
        
        .day-cell.today { background-color: var(--today-bg-color) !important; color: var(--today-text-color) !important; font-weight: bold; border-radius: var(--border-radius-sm); transform: scale(1.03); box-shadow: 0 0 0 2px var(--today-bg-color) inset, var(--box-shadow-medium); z-index: 20; }
        .day-cell.today .nepali-day-number, .day-cell.today .english-day-number, .day-cell.today .holiday-name { color: var(--today-text-color) !important; }
        
        .day-cell.holiday:not(.today) { background-color: var(--holiday-bg-color); }
        
        .day-cell.holiday .holiday-name { 
            color: var(--custom-dark-red); 
        }
        .day-cell.holiday:not(.today) .nepali-day-number {
            color: var(--custom-dark-red);
        }
        .day-cell.holiday:not(.today) .english-day-number {
            color: var(--custom-dark-red);
            opacity: 0.8;
        }

        .nepali-day-number { font-size: 1.5em; font-weight: bold; display: block; margin-bottom: var(--spacing-xs); }
        .english-day-number { font-size: 0.8em; color: var(--secondary-text-color); display: block; font-family: var(--font-mono); }
        .day-cell:not(.holiday):not(.sat):not(.sun):not(.today) .english-day-number {
             color: var(--secondary-text-color);
        }
        .day-cell.today .english-day-number { color: rgba(255,255,255,0.85); } 

        .holiday-name { font-size: 0.75em; font-weight: bold; position: absolute; bottom: var(--spacing-xs); left: var(--spacing-xs); right: var(--spacing-xs); text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.3; }
        
        /* Sidebar Styles */
        .sidebar {
            width: 300px; 
            flex-shrink: 0; 
            padding: var(--spacing-md);
            background-color: var(--surface-color);
            border-radius: var(--border-radius-md);
            box-shadow: var(--box-shadow-light);
            height: fit-content; 
        }
        .sidebar h2 { /* Applied to #holiday-list-title */
            font-size: 1.2em; 
            font-weight: bold;
            margin-top: 0;
            color: var(--text-color);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: var(--spacing-sm);
            margin-bottom: var(--spacing-md);
        }
        #holiday-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            max-height: 450px; 
            overflow-y: auto;
        }
        #holiday-list li {
            padding: var(--spacing-xs) 0;
            border-bottom: 1px dotted #eee;
            font-size: 0.9em;
        }
        #holiday-list li:last-child {
            border-bottom: none;
        }
        #holiday-list .holiday-link {
            text-decoration: none;
            color: var(--accent-color);
            cursor: pointer;
            display: block;
            padding: var(--spacing-xs);
            border-radius: var(--border-radius-sm);
            transition: background-color 0.2s;
        }
        #holiday-list .holiday-link:hover {
            background-color: #e9ecef; 
            color: var(--accent-hover-color);
        }

        #loading-overlay { position: fixed; top:0;left:0;width:100%;height:100%;background-color:rgba(255,255,255,0.85);display:flex;flex-direction:column;justify-content:center;align-items:center;z-index:9999;color:var(--text-color);font-size:1.3em;transition:opacity .3s ease,visibility 0s .3s;opacity:0;visibility:hidden; }
        #loading-overlay.visible { opacity:1;visibility:visible;transition:opacity .3s ease,visibility 0s 0s; }
        .spinner { border:4px solid rgba(0,0,0,0.1);border-top-color:var(--accent-color);border-radius:50%;width:35px;height:35px;animation:spin .8s linear infinite;margin-bottom:var(--spacing-md); }
        @keyframes spin { to{transform:rotate(360deg);} }
        .day-tooltip { position:fixed;background-color:#333;color:#fff;padding:var(--spacing-sm) var(--spacing-md);border-radius:var(--border-radius-sm);font-size:.9em;z-index:10000;display:none;pointer-events:none;white-space:pre-wrap;box-shadow:var(--box-shadow-medium);line-height:1.4;width:max-content;max-width:250px; }
        .day-tooltip::after { content:'';position:absolute;left:50%;border:solid transparent;height:0;width:0;pointer-events:none;border-width:6px;margin-left:-6px;bottom:100%;border-bottom-color:#333; }
        .main-page-link { margin-top:var(--spacing-xl);padding:var(--spacing-lg) 0;text-align:center;width:100%;background-color:var(--surface-color);border-top:1px solid var(--border-color);box-shadow:0 -2px 5px rgba(0,0,0,0.05); }
        .main-page-link a { color:var(--accent-color);text-decoration:none;font-size:1.1rem;font-weight:bold;padding:var(--spacing-xs) var(--spacing-sm);transition:color .2s ease,text-decoration .2s ease; }
        .main-page-link a:hover { color:var(--accent-hover-color);text-decoration:underline; }

        /* --- Media Queries for Responsiveness --- */
        @media (max-width:992px){ 
            .calendar-body-layout{
                flex-direction: column;
            }
            .sidebar {
                width: 100%; 
                margin-left: 0;
                margin-top: var(--spacing-lg);
            }
        }

        @media (max-width:768px){
            .main-content-wrapper{width:auto;padding:0 var(--spacing-md);}
            .month-navigation{flex-direction:column;gap:var(--spacing-md);}
            .month-navigation button {
                padding: var(--spacing-xs) var(--spacing-sm); 
                font-size: 0.9em;
            }
            .month-navigation i {
                font-size: 1em; 
            }
            .month-navigation span#current-view-display{font-size:1.3em;order:-1;margin-bottom:var(--spacing-sm);}
            .date-selector-form{flex-direction:column;align-items:stretch;}
            .input-group{min-width:0;width:100%;}
            .date-selector-form button[type="submit"]{width:100%;} 
            .calendar-grid .day-cell{min-height:70px;font-size:.9em;}
            .nepali-day-number{font-size:1.2em;}
            .english-day-number{font-size:.75em;}
            .holiday-name{font-size:.7em;}
        }
        @media (max-width:480px){
            .main-content-wrapper{padding:0 var(--spacing-sm);}
            .calendar-header-section h2{font-size:1.4em;}
            .calendar-header-section p{font-size:.95em;}
            .month-navigation button{
                width:100%; 
                justify-content:center; 
            }
            .month-navigation span#current-view-display{font-size:1.2em;}
            .date-selector-form{padding:var(--spacing-md);}
            .calendar-grid .day-cell{min-height:60px;font-size:.8em;padding:var(--spacing-xs);}
            .nepali-day-number{font-size:1.1em;}
            .english-day-number{font-size:.7em;}
            .holiday-name{font-size:.65em;}
            .day-name{font-size:.8em;padding:var(--spacing-xs);}
        }
    </style>
</head>
<body>
    <div class="main-content-wrapper">

        <div class="calendar-header-section calendar-card">
            <h2 id="current-nepali-date-display"></h2> {# Will be updated by JS #}
            <p id="selected-date-display"></p> {# Will be updated by JS #}
        </div>

        <form id="date-selector-form" class="date-selector-form calendar-card" action="/custom" method="POST">
            <div class="input-group">
                <label for="nepali_year_select">Nepali Year:</label>
                <select name="nepali_year" id="nepali_year_select" required>
                    {# Options will be dynamically populated by JS #}
                </select>
            </div>
            <div class="input-group">
                <label for="nepali_month_select">Month:</label>
                <select name="nepali_month" id="nepali_month_select" required>
                    {# Options will be dynamically populated by JS #}
                </select>
            </div>
            <div class="input-group">
                <label for="nepali_day_select">Day:</label>
                <select name="nepali_day" id="nepali_day_select" required>
                    {# Options will be dynamically populated by JS #}
                </select>
            </div>
            <button type="submit" id="go-to-date-btn">Go to Date</button>
        </form>
        
        <div class="calendar-body-layout calendar-card">
            <div class="calendar-main-area">
                <div class="month-navigation">
                    <button id="prev-month-btn"><i class="fas fa-chevron-left"></i> Previous</button>
                    <span id="current-view-display"></span> 
                    <button id="next-month-btn">Next <i class="fas fa-chevron-right"></i></button>
                </div>
                <div id="calendar-grid-container" class="calendar-grid">
                    {# This section will be dynamically rendered by JavaScript #}
                </div>
            </div>
            <div class="sidebar" id="holiday-sidebar">
                <h2 id="holiday-list-title">महिनाको सार्वजनिक बिदाहरू</h2> 
                <ul id="holiday-list">
                    </ul>
            </div>
        </div>
    </div>

    <div id="loading-overlay">
        <div class="spinner"></div>
        <span id="loading-text-span">Loading Calendar...</span> 
    </div>

    <div class="main-page-link">
        <a href="http://34.30.240.75/">Go to Main Page</a>
    </div>

<script>
    const NEP_MONTHS = {
        1: 'बैशाख', 2: 'जेठ', 3: 'असार', 4: 'श्रावण',
        5: 'भदौ', 6: 'असोज', 7: 'कार्तिक', 8: 'मंसिर',
        9: 'पुष', 10: 'माघ', 11: 'फागुन', 12: 'चैत'
    };

    const NEP_DAYS_OF_WEEK = {
        0: 'आइतबार', 1: 'सोमबार', 2: 'मंगलबार', 3: 'बुधबार',
        4: 'बिहिबार', 5: 'शुक्रबार', 6: 'शनिबार'
    };

    function convertToNepaliNumber(num) {
        if (num === null || num === undefined) return '';
        const nepaliNumbers = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
        return String(num).split('').map(digit => nepaliNumbers[parseInt(digit)] || digit).join('');
    }

    let currentNepaliYear = parseInt("{{ nepali_year }}") || new Date().getFullYear() + 56; 
    let currentNepaliMonthNum = parseInt("{{ nepali_month_num }}") || new Date().getMonth() + 1; 
    let currentNepaliDay = parseInt("{{ nepali_day }}") || new Date().getDate(); 

    const currentNepaliDateDisplay = document.getElementById('current-nepali-date-display');
    const selectedDateDisplay = document.getElementById('selected-date-display');
    const currentViewDisplay = document.getElementById('current-view-display');
    const prevMonthBtn = document.getElementById('prev-month-btn');
    const nextMonthBtn = document.getElementById('next-month-btn');
    const nepaliYearSelect = document.getElementById('nepali_year_select');
    const nepaliMonthSelect = document.getElementById('nepali_month_select');
    const nepaliDaySelect = document.getElementById('nepali_day_select');
    const dateSelectorForm = document.getElementById('date-selector-form');
    const calendarGridContainer = document.getElementById('calendar-grid-container');
    const loadingOverlay = document.getElementById('loading-overlay');
    const loadingTextSpan = document.getElementById('loading-text-span'); 

    const holidayListUl = document.getElementById('holiday-list');
    const holidayListTitle = document.getElementById('holiday-list-title'); 

    document.addEventListener('DOMContentLoaded', () => {
        prevMonthBtn.innerHTML = '<i class="fas fa-chevron-left"></i> अघिल्लो';
        nextMonthBtn.innerHTML = 'पछिल्लो <i class="fas fa-chevron-right"></i>'; // UPDATED

        document.querySelector('label[for="nepali_year_select"]').textContent = 'वर्ष:'; // UPDATED
        document.querySelector('label[for="nepali_month_select"]').textContent = 'महिना:';
        document.querySelector('label[for="nepali_day_select"]').textContent = 'दिन:';
        document.getElementById('go-to-date-btn').textContent = 'मितिमा जानुहोस्'; // UPDATED
        
        if(loadingTextSpan) loadingTextSpan.textContent = 'पात्रो लोड गर्दै...';
        
        const mainPageLink = document.querySelector('.main-page-link a');
        if(mainPageLink) mainPageLink.textContent = 'मुख्य पृष्ठमा जानुहोस्';

        if (isNaN(currentNepaliYear) || isNaN(currentNepaliMonthNum) || isNaN(currentNepaliDay)) {
            const today = new Date();
            currentNepaliYear = today.getFullYear() + 56; 
            currentNepaliMonthNum = today.getMonth() + 1; 
            currentNepaliDay = today.getDate();
            console.warn("Initial date from template was invalid, using fallback.");
        }

        fetchCalendar(currentNepaliYear, currentNepaliMonthNum, currentNepaliDay);
    });

    function showLoading() {
        loadingOverlay.classList.add('visible');
    }

    function hideLoading() {
        loadingOverlay.classList.remove('visible');
    }

    function updateDisplayHeaders(data) {
        currentNepaliDateDisplay.textContent = `${NEP_MONTHS[data.nepali_month_num]} ${convertToNepaliNumber(data.nepali_year)} (${data.english_month} ${data.english_year})`;
        selectedDateDisplay.textContent = `चयन गरिएको मिति: ${convertToNepaliNumber(data.nepali_day)} ${NEP_MONTHS[data.nepali_month_num]} ${convertToNepaliNumber(data.nepali_year)} (${data.english_day} ${data.english_month} ${data.english_year})`;
        currentViewDisplay.textContent = `${NEP_MONTHS[data.nepali_month_num]} ${convertToNepaliNumber(data.nepali_year)}`;
    }

    function updateFormDropdowns() {
        nepaliYearSelect.innerHTML = '';
        const minYear = 2000;
        const maxYear = 2090;
        for (let year = minYear; year <= maxYear; year++) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = convertToNepaliNumber(year);
            if (year === currentNepaliYear) option.selected = true;
            nepaliYearSelect.appendChild(option);
        }

        nepaliMonthSelect.innerHTML = '';
        for (let i = 1; i <= 12; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = NEP_MONTHS[i];
            if (i === currentNepaliMonthNum) option.selected = true;
            nepaliMonthSelect.appendChild(option);
        }

        nepaliDaySelect.innerHTML = '';
        const daysInMonth = 32; 
        for (let day = 1; day <= daysInMonth; day++) {
            const option = document.createElement('option');
            option.value = day;
            option.textContent = convertToNepaliNumber(day);
            if (day === currentNepaliDay) option.selected = true;
            nepaliDaySelect.appendChild(option);
        }
    }

    function renderCalendar(data) {
        let html = '';
        const dayNames = ['आइतबार', 'सोमबार', 'मंगलबार', 'बुधबार', 'बिहिबार', 'शुक्रबार', 'शनिबार'];
        dayNames.forEach(name => html += `<div class="day-name">${name}</div>`);

        const totalDays = data.days.length;
        const firstDayWeekday = data.first_day_weekday;

        for (let week = 0; week < Math.ceil((totalDays + firstDayWeekday) / 7); week++) {
            for (let dayIndex = 0; dayIndex < 7; dayIndex++) {
                const currentDayVal = (week * 7) + dayIndex - firstDayWeekday + 1;
                let cellClass = 'day-cell';

                if (data.nepali_year === currentNepaliYear &&
                    data.nepali_month_num === currentNepaliMonthNum &&
                    currentDayVal === currentNepaliDay) {
                    cellClass += ' today';
                } else if (dayIndex === 6) { cellClass += ' sat'; } 
                  else if (dayIndex === 0) { cellClass += ' sun'; }

                if (currentDayVal > 0 && currentDayVal <= totalDays) {
                    const dayData = data.days[currentDayVal - 1];
                    let cellContent = `<span class="nepali-day-number">${convertToNepaliNumber(currentDayVal)}</span>`;
                    cellContent += `<span class="english-day-number">${dayData.english_day}</span>`;

                    if (dayData.holiday && dayData.holiday.trim() !== "") {
                        cellContent += `<span class="holiday-name">${dayData.holiday}</span>`;
                        cellClass += ' holiday';
                    }

                    const tooltipNepaliMonth = NEP_MONTHS[data.nepali_month_num];
                    const tooltipContent = `नेपाली: ${convertToNepaliNumber(currentDayVal)} ${tooltipNepaliMonth} ${convertToNepaliNumber(data.nepali_year)}\nअंग्रेजी: ${dayData.english_day} ${dayData.english_month} ${dayData.english_year}${dayData.holiday ? `\nबिदा: ${dayData.holiday}` : ''}`;

                    html += `<div class="${cellClass}" data-nepali-year="${data.nepali_year}" data-nepali-month-num="${data.nepali_month_num}" data-nepali-day="${currentDayVal}" data-tooltip="${tooltipContent}">${cellContent}</div>`;
                } else {
                    html += `<div class="day-cell empty"></div>`;
                }
            }
        }
        calendarGridContainer.innerHTML = html;
        addDayCellEventListeners();
    }

    function updateHolidaySidebar(daysData, year, monthNum) {
        if (holidayListTitle && NEP_MONTHS[monthNum]) { 
            holidayListTitle.textContent = `${NEP_MONTHS[monthNum]} महिनाका सार्वजनिक बिदाहरू`;
        } else if (holidayListTitle) {
            holidayListTitle.textContent = 'महिनाका सार्वजनिक बिदाहरू'; 
        }

        if (!holidayListUl) return;
        holidayListUl.innerHTML = ''; 

        if (!daysData || daysData.length === 0) {
            holidayListUl.innerHTML = '<li>यो महिनाको लागि कुनै डाटा छैन।</li>';
            return;
        }

        let hasHolidays = false;
        daysData.forEach((day, index) => {
            if (day.holiday && day.holiday.trim() !== "") {
                hasHolidays = true;
                const dayNumber = index + 1; 

                const listItem = document.createElement('li');
                const holidayLink = document.createElement('span');
                holidayLink.className = 'holiday-link';
                holidayLink.textContent = `${NEP_MONTHS[monthNum]} ${convertToNepaliNumber(dayNumber)} : ${day.holiday}`;
                holidayLink.dataset.nepaliDay = dayNumber;
                
                holidayLink.addEventListener('click', () => {
                    const clickedDay = parseInt(holidayLink.dataset.nepaliDay);
                    fetchCalendar(year, monthNum, clickedDay);
                });
                listItem.appendChild(holidayLink);
                holidayListUl.appendChild(listItem);
            }
        });

        if (!hasHolidays) {
            holidayListUl.innerHTML = '<li>यो महिनामा कुनै पनि सार्वजनिक बिदाहरू छैनन्।</li>'; // UPDATED
        }
    }

    async function fetchCalendar(year, monthNum, day) {
        showLoading();
        try {
            const fetchYear = parseInt(year);
            const fetchMonth = parseInt(monthNum);
            const fetchDay = parseInt(day);

            if (isNaN(fetchYear) || isNaN(fetchMonth) || isNaN(fetchDay)) {
                console.error("Invalid date components for fetch:", year, monthNum, day);
                alert("मिति अनुरोध गर्न अवैध प्यारामिटरहरू।");
                hideLoading();
                return;
            }

            const response = await fetch(`/custom_ajax?nepali_year=${fetchYear}&nepali_month=${fetchMonth}&nepali_day=${fetchDay}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status} - ${response.statusText}`);
            }
            const data = await response.json();
            
            if (!data || !data.days) { 
                throw new Error("Invalid data received from server.");
            }

            currentNepaliYear = data.nepali_year;
            currentNepaliMonthNum = data.nepali_month_num;
            currentNepaliDay = data.nepali_day;

            updateFormDropdowns();
            updateDisplayHeaders(data);
            renderCalendar(data);
            updateHolidaySidebar(data.days, data.nepali_year, data.nepali_month_num);

        } catch (error) {
            console.error("Error fetching calendar data:", error);
            if (holidayListUl) holidayListUl.innerHTML = '<li>बिदाहरू लोड गर्न असमर्थ।</li>';
            alert(`पात्रो लोड गर्न असमर्थ भयो। समस्या: ${error.message}`);
        } finally {
            hideLoading();
        }
    }

    prevMonthBtn.addEventListener('click', () => {
        let newMonthNum = currentNepaliMonthNum - 1;
        let newYear = currentNepaliYear;
        if (newMonthNum < 1) { newMonthNum = 12; newYear--; }
        fetchCalendar(newYear, newMonthNum, currentNepaliDay);
    });

    nextMonthBtn.addEventListener('click', () => {
        let newMonthNum = currentNepaliMonthNum + 1;
        let newYear = currentNepaliYear;
        if (newMonthNum > 12) { newMonthNum = 1; newYear++; }
        fetchCalendar(newYear, newMonthNum, currentNepaliDay);
    });

    dateSelectorForm.addEventListener('submit', function(event) {
        event.preventDefault();
        fetchCalendar(parseInt(nepaliYearSelect.value), parseInt(nepaliMonthSelect.value), parseInt(nepaliDaySelect.value));
    });

    function addDayCellEventListeners() {
        const existingTooltips = document.querySelectorAll('.day-tooltip');
        existingTooltips.forEach(tt => tt.remove());
        
        let currentTooltip = null; 

        document.querySelectorAll('.day-cell:not(.empty)').forEach(cell => {
            cell.addEventListener('mouseenter', (e) => {
                if (!currentTooltip) { 
                    currentTooltip = document.createElement('div');
                    currentTooltip.className = 'day-tooltip';
                    document.body.appendChild(currentTooltip);
                }
                
                const tooltipText = cell.getAttribute('data-tooltip');
                if (tooltipText) {
                    currentTooltip.innerHTML = tooltipText; 
                    currentTooltip.style.display = 'block';
                    
                    const rect = cell.getBoundingClientRect();
                    let left = e.clientX + 15 + window.scrollX;
                    let top = e.clientY + 15 + window.scrollY;

                    const tooltipRect = currentTooltip.getBoundingClientRect();
                    if (left + tooltipRect.width > window.innerWidth) {
                        left = window.innerWidth - tooltipRect.width - 10;
                    }
                    if (top + tooltipRect.height > window.innerHeight) {
                        top = e.clientY - tooltipRect.height - 10 + window.scrollY;
                    }
                     if (left < 0) left = 10;
                     if (top < 0) top = 10;


                    currentTooltip.style.left = `${left}px`;
                    currentTooltip.style.top = `${top}px`;
                }
            });

            cell.addEventListener('mousemove', (e) => { 
                if (currentTooltip && currentTooltip.style.display === 'block') {
                    let left = e.clientX + 15 + window.scrollX;
                    let top = e.clientY + 15 + window.scrollY;

                    const tooltipRect = currentTooltip.getBoundingClientRect();
                    if (left + tooltipRect.width > window.innerWidth) {
                        left = window.innerWidth - tooltipRect.width - 10;
                    }
                    if (top + tooltipRect.height > window.innerHeight) {
                        top = e.clientY - tooltipRect.height - 10 + window.scrollY;
                    }
                    if (left < 0) left = 10;
                    if (top < 0) top = 10;

                    currentTooltip.style.left = `${left}px`;
                    currentTooltip.style.top = `${top}px`;
                }
            });

            cell.addEventListener('mouseleave', () => {
                if (currentTooltip) {
                    currentTooltip.style.display = 'none';
                }
            });

            cell.addEventListener('click', () => {
                const prevToday = document.querySelector('.day-cell.today');
                if(prevToday) prevToday.classList.remove('today');
                
                cell.classList.add('today');

                currentNepaliDay = parseInt(cell.dataset.nepaliDay);
                currentNepaliMonthNum = parseInt(cell.dataset.nepaliMonthNum);
                currentNepaliYear = parseInt(cell.dataset.nepaliYear);
                
                fetchCalendar(currentNepaliYear, currentNepaliMonthNum, currentNepaliDay);
            });
        });
    }
</script>
</body>
</html>
