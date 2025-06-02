<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scientific Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for the calculator */
        body {
            font-family: 'Inter', sans-serif; /* Using Inter font */
            background-color: #1a202c; /* Dark background */
            /* Flexbox setup for pushing content */
            display: flex;
            flex-direction: column; /* Stack children vertically */
            justify-content: center; /* Center content vertically initially */
            align-items: center;
            min-height: 100vh; /* Ensure body takes full viewport height */
            margin: 0;
            padding: 20px; /* Add some padding for smaller screens */
            box-sizing: border-box;
        }

        .calculator {
            background-color: #2d3748; /* Slightly lighter dark for calculator body */
            border-radius: 1.5rem; /* More rounded corners */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            padding: 1.5rem;
            max-width: 380px; /* Adjusted max width for more buttons */
            width: 100%; /* Ensure it's responsive */
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: auto; /* Push the calculator up, creating space at bottom */
            margin-top: auto; /* Centers it vertically if no other elements push it */
        }

        .calculator-display {
            background-color: #4a5568; /* Darker display background */
            color: #e2e8f0; /* Light text color for display */
            font-size: 2.2rem; /* Slightly smaller font size for more content */
            padding: 1rem 1.5rem;
            border-radius: 0.75rem; /* Rounded display */
            text-align: right;
            overflow: hidden; /* Hide overflow text */
            white-space: nowrap; /* Prevent text wrapping */
            text-overflow: ellipsis; /* Add ellipsis for overflow */
            height: 60px; /* Fixed height for display */
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .calculator-buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 columns */
            gap: 0.75rem; /* Gap between buttons */
        }

        .calculator-button {
            background-color: #63b3ed; /* Sky-blue color for regular buttons */
            color: #ffffff; /* White text on buttons */
            font-size: 1.3rem; /* Button font size */
            padding: 1rem;
            border: none;
            border-radius: 0.75rem; /* Rounded buttons */
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60px; /* Fixed height for buttons */
        }

        .calculator-button:hover {
            background-color: #4299e1; /* Darker sky-blue on hover */
            transform: translateY(-2px); /* Slight lift on hover */
        }

        .calculator-button:active {
            background-color: #3182ce; /* Even darker on active */
            transform: translateY(0); /* Return to original position */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .calculator-button.operator {
            background-color: #5a67d8; /* Slightly different blue for operators */
        }

        .calculator-button.scientific-func {
            background-color: #805ad5; /* Purple for scientific functions */
        }

        .calculator-button.equals {
            background-color: #48bb78; /* Green for equals button */
            grid-column: span 4; /* Make equals button span all 4 columns */
        }

        .calculator-button.clear {
            background-color: #e53e3e; /* Red for clear button */
        }

        .calculator-button.del {
            background-color: #f6ad55; /* Orange for delete button */
        }

        /* Responsive adjustments */
        @media (max-width: 400px) {
            .calculator {
                padding: 0.8rem;
                border-radius: 1rem;
            }
            .calculator-display {
                font-size: 1.8rem;
                padding: 0.7rem 1rem;
            }
            .calculator-button {
                font-size: 1.1rem;
                padding: 0.7rem;
                height: 50px;
                border-radius: 0.6rem;
            }
        }

        /* Styles for the "Go to Main Page" link */
        .main-page-link {
            margin-top: 30px; /* Space above the link */
            margin-bottom: 20px; /* Space below the link */
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        .main-page-link a {
            color: #63b3ed; /* Match calculator's blue buttons */
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: bold;
            transition: color 0.3s ease, transform 0.3s ease;
            display: inline-block; /* Allows transform */
            padding: 8px 15px; /* Add padding for better click area */
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1); /* Slightly transparent background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .main-page-link a:hover {
            color: #4299e1; /* Darker blue on hover */
            text-decoration: underline; /* Add underline on hover */
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            background-color: rgba(255, 255, 255, 0.15);
        }
    </style>
</head>
<body>
    <div class="calculator">
        <div class="calculator-display" id="display">0</div>
        <div class="calculator-buttons">
            <button class="calculator-button clear" onclick="clearDisplay()">C</button>
            <button class="calculator-button del" onclick="deleteLastChar()">DEL</button>
            <button class="calculator-button operator" onclick="toggleSign()">+/-</button>
            <button class="calculator-button operator" onclick="appendOperator('/')">/</button>

            <button class="calculator-button scientific-func" onclick="applyFunction('sin')">sin</button>
            <button class="calculator-button scientific-func" onclick="applyFunction('cos')">cos</button>
            <button class="calculator-button scientific-func" onclick="applyFunction('tan')">tan</button>
            <button class="calculator-button operator" onclick="appendOperator('*')">*</button>

            <button class="calculator-button scientific-func" onclick="applyFunction('sqrt')">sqrt</button>
            <button class="calculator-button scientific-func" onclick="applyFunction('log')">log</button>
            <button class="calculator-button operator" onclick="appendOperator('^')">^</button>
            <button class="calculator-button operator" onclick="appendOperator('-')">-</button>

            <button class="calculator-button" onclick="appendNumber('7')">7</button>
            <button class="calculator-button" onclick="appendNumber('8')">8</button>
            <button class="calculator-button" onclick="appendNumber('9')">9</button>
            <button class="calculator-button operator" onclick="appendOperator('+')">+</button>

            <button class="calculator-button" onclick="appendNumber('4')">4</button>
            <button class="calculator-button" onclick="appendNumber('5')">5</button>
            <button class="calculator-button" onclick="appendNumber('6')">6</button>
            <button class="calculator-button" onclick="appendDecimal('.')">.</button>

            <button class="calculator-button" onclick="appendNumber('1')">1</button>
            <button class="calculator-button" onclick="appendNumber('2')">2</button>
            <button class="calculator-button" onclick="appendNumber('3')">3</button>
            <button class="calculator-button" onclick="appendNumber('0')">0</button>

            <button class="calculator-button equals" onclick="calculateResult()">=</button>
        </div>
    </div>

    <div class="main-page-link">
        <a href="http://34.30.240.75/">Go to Main Page</a>
    </div>

    <script>
        const display = document.getElementById('display');
        let currentInput = '0';
        let operator = null;
        let previousInput = '';
        let waitingForNewInput = false; // Flag to check if we are waiting for a new number after an operation or equals

        /**
         * Updates the calculator display with the given value.
         * @param {string} value - The string to display.
         */
        function updateDisplay(value) {
            // Limit display length to avoid overflow, but allow more for scientific notation
            if (value.length > 15 && !value.includes('e')) {
                display.textContent = parseFloat(value).toPrecision(10); // Use toPrecision for large numbers
            } else {
                display.textContent = value;
            }
        }

        /**
         * Appends a number to the current input.
         * @param {string} number - The number string to append.
         */
        function appendNumber(number) {
            if (waitingForNewInput) {
                currentInput = number;
                waitingForNewInput = false;
            } else {
                if (currentInput === '0' && number !== '.') {
                    currentInput = number;
                } else {
                    currentInput += number;
                }
            }
            updateDisplay(currentInput);
        }

        /**
         * Appends a decimal point to the current input, ensuring only one decimal.
         * @param {string} decimal - The decimal point string ('.').
         */
        function appendDecimal(decimal) {
            if (waitingForNewInput) {
                currentInput = '0' + decimal;
                waitingForNewInput = false;
            } else if (!currentInput.includes(decimal)) {
                currentInput += decimal;
            }
            updateDisplay(currentInput);
        }

        /**
         * Appends an operator to the current input.
         * If an operator is already present, it calculates the intermediate result.
         * @param {string} nextOperator - The operator string (+, -, *, /, ^).
         */
        function appendOperator(nextOperator) {
            if (operator && !waitingForNewInput) {
                // If there's an existing operator and we're not waiting for a new input,
                // it means the user entered an operation and then another operation.
                // Calculate the intermediate result before applying the new operator.
                calculateResult();
            }

            previousInput = currentInput;
            operator = nextOperator;
            waitingForNewInput = true; // Set flag to true, next number will start a new input
            updateDisplay(currentInput + ' ' + operator); // Show current input and operator
        }

        /**
         * Clears the calculator display and resets all internal states.
         */
        function clearDisplay() {
            currentInput = '0';
            operator = null;
            previousInput = '';
            waitingForNewInput = false;
            updateDisplay('0');
        }

        /**
         * Applies a scientific function to the current input.
         * @param {string} funcName - The name of the function (e.g., 'sin', 'cos', 'tan', 'sqrt', 'log').
         */
        function applyFunction(funcName) {
            let value = parseFloat(currentInput);
            if (isNaN(value)) {
                updateDisplay('Error');
                currentInput = '0'; // Reset for new input
                return;
            }

            let result;
            try {
                switch (funcName) {
                    case 'sin':
                        result = Math.sin(value * Math.PI / 180); // Convert degrees to radians
                        break;
                    case 'cos':
                        result = Math.cos(value * Math.PI / 180); // Convert degrees to radians
                        break;
                    case 'tan':
                        // Handle tangent for 90 + n*180 degrees (undefined)
                        if (Math.abs(value % 180) === 90) {
                            updateDisplay('Undefined');
                            currentInput = '0';
                            return;
                        }
                        result = Math.tan(value * Math.PI / 180); // Convert degrees to radians
                        break;
                    case 'sqrt':
                        if (value < 0) {
                            updateDisplay('Error: Negative sqrt');
                            currentInput = '0';
                            return;
                        }
                        result = Math.sqrt(value);
                        break;
                    case 'log':
                        if (value <= 0) {
                            updateDisplay('Error: Log of non-positive');
                            currentInput = '0';
                            return;
                        }
                        result = Math.log10(value); // Using log base 10
                        break;
                    default:
                        return;
                }
                currentInput = String(result);
                waitingForNewInput = true; // After applying function, next number starts new input
                updateDisplay(currentInput);
            } catch (error) {
                updateDisplay('Error');
                console.error('Function error:', error);
                currentInput = '0';
            }
        }

        /**
         * Toggles the sign of the current input.
         */
        function toggleSign() {
            let value = parseFloat(currentInput);
            if (isNaN(value)) {
                return;
            }
            currentInput = String(-value);
            updateDisplay(currentInput);
        }

        /**
         * Deletes the last character from the current input.
         */
        function deleteLastChar() {
            if (currentInput === 'Error' || currentInput === 'Undefined') {
                currentInput = '0';
            } else if (currentInput.length > 1) {
                currentInput = currentInput.slice(0, -1);
            } else {
                currentInput = '0';
            }
            updateDisplay(currentInput);
        }

        /**
         * Calculates the final result based on the current inputs and operator.
         * Handles division by zero, power operations, and other potential errors.
         */
        function calculateResult() {
            if (!operator || waitingForNewInput) {
                return; // Nothing to calculate or waiting for second operand
            }

            let result;
            const prev = parseFloat(previousInput);
            const current = parseFloat(currentInput);

            if (isNaN(prev) || isNaN(current)) {
                updateDisplay('Error');
                currentInput = '0'; // Reset for new input
                operator = null;
                previousInput = '';
                waitingForNewInput = false;
                return;
            }

            try {
                switch (operator) {
                    case '+':
                        result = prev + current;
                        break;
                    case '-':
                        result = prev - current;
                        break;
                    case '*':
                        result = prev * current;
                        break;
                    case '/':
                        if (current === 0) {
                            updateDisplay('Error: Div by 0');
                            currentInput = '0'; // Reset for new input
                            operator = null;
                            previousInput = '';
                            waitingForNewInput = false;
                            return;
                        }
                        result = prev / current;
                        break;
                    case '^':
                        result = Math.pow(prev, current);
                        break;
                    default:
                        return;
                }
                currentInput = String(result);
                operator = null;
                previousInput = '';
                waitingForNewInput = true; // After equals, next number starts a new input
                updateDisplay(currentInput);
            } catch (error) {
                updateDisplay('Error');
                console.error('Calculation error:', error);
                currentInput = '0';
                operator = null;
                previousInput = '';
                waitingForNewInput = false;
            }
        }

        // Initialize display on load
        window.onload = () => {
            updateDisplay(currentInput);
        };
    </script>
</body>
</html>
