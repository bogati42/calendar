<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>नेपाली पात्रो</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Tailwind Dark Mode Setup and Custom Colors
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#ffb347',    // --primary-color
                        secondary: '#ff7e5f',  // --secondary-color
                        accent: '#fff7e6',     // --accent-color
                        border: '#fcb69f',     // --border-color
                        darkbody: '#2d3748',   // A darker shade for dark mode body
                        darktext: '#edf2f7',   // Light text for dark mode
                        darkfooter: '#1a202c', // Darker footer for dark mode
                    },
                    fontFamily: {
                        sans: ['Noto Sans', 'Arial', 'sans-serif'],
                        mono: ['Roboto Mono', 'monospace'],
                    }
                }
            }
        };
    </script>
</head>
<body class="text-gray-800 dark:bg-darkbody dark:text-darktext">
    <header class="bg-gradient-to-r from-primary to-secondary text-white shadow-lg py-4 relative">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between">
            <div class="flex items-center justify-between w-full md:w-auto">
                <div class="text-3xl font-extrabold">
                    <a href="http://34.30.240.75/" class="hover:text-accent transition-colors duration-300">My Awesome Site</a>
                </div>

                <div class="flex items-center md:hidden">
                    <button id="themeToggle" class="text-xl focus:outline-none mr-4">
                        🌙
                    </button>
                    <button id="menuToggle" class="text-xl focus:outline-none">
                        <i class="fas fa-bars"></i> </button>
                </div>
            </div>

            <nav class="w-full md:w-auto hidden md:block">
                <ul id="navMenuDesktop" class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-8 text-lg font-medium">
                    <li><a href="http://34.30.240.75/" class="nav-link block py-2 px-4 rounded-lg hover:bg-secondary transition-all duration-300">Homepage</a></li>
                    <li><a href="http://34.30.240.75:5000/" class="nav-link block py-2 px-4 rounded-lg hover:bg-secondary transition-all duration-300">BS TO AD Date Converter</a></li>
                    <li><a href="http://34.30.240.75/digitalclock.php" class="nav-link block py-2 px-4 rounded-lg hover:bg-secondary transition-all duration-300">Nepali Digital Clock</a></li>
                    <li><a href="http://34.30.240.75/nepaliclock.php" class="nav-link block py-2 px-4 rounded-lg hover:bg-secondary transition-all duration-300">Nepali Analog Clock</a></li>
                    <li><a href="http://34.30.240.75/science-calculator.php" class="nav-link block py-2 px-4 rounded-lg hover:bg-secondary transition-all duration-300">Digital Science Calculator</a></li>
                    <li><a href="http://34.30.240.75/globe.php" class="nav-link block py-2 px-4 rounded-lg hover:bg-secondary transition-all duration-300">Globe</a></li>
                </ul>
            </nav>
            <button id="themeToggleDesktop" class="ml-4 md:ml-0 text-xl focus:outline-none hidden md:block">
                🌙
            </button>
        </div>

        <ul id="navMenu" class="hidden md:hidden">
            <li><a href="http://34.30.240.75/" class="nav-link">Homepage</a></li>
            <li><a href="http://34.30.240.75:5000/" class="nav-link">BS TO AD Date Converter</a></li>
            <li><a href="http://34.30.240.75/digitalclock.php" class="nav-link">Nepali Digital Clock</a></li>
            <li><a href="http://34.30.240.75/nepaliclock.php" class="nav-link">Nepali Analog Clock</a></li>
            <li><a href="http://34.30.240.75/science-calculator.php" class="nav-link">Digital Science Calculator</a></li>
            <li><a href="http://34.30.240.75/globe.php" class="nav-link">Globe</a></li>
        </ul>
    </header>
    
