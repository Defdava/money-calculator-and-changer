<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator - Money Calculator</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="header">
        <div class="calculator-icon">
            <div class="screen"></div>
            <div class="buttons">
                <div class="button"></div>
                <div class="button"></div>
                <div class="button"></div>
            </div>
        </div>
        <div class="date-time" id="liveTime">02:13 AM WIB, Thursday, June 05, 2025</div>
        <button class="logout-btn" onclick="window.location.href='login.php'">Logout</button>
    </div>
    <div class="container">
        <div class="calculator">
            <h2>Calculator</h2>
            <div class="display" id="display">0</div>
            <div class="buttons">
                <button class="clear" onclick="clearDisplay()">CE</button>
                <button class="clear" onclick="clearAll()">C</button>
                <button onclick="appendToDisplay('%')">%</button>
                <button class="operation" onclick="appendToDisplay('/')">÷</button>
                <button onclick="appendToDisplay('7')">7</button>
                <button onclick="appendToDisplay('8')">8</button>
                <button onclick="appendToDisplay('9')">9</button>
                <button class="operation" onclick="appendToDisplay('*')">×</button>
                <button onclick="appendToDisplay('4')">4</button>
                <button onclick="appendToDisplay('5')">5</button>
                <button onclick="appendToDisplay('6')">6</button>
                <button class="operation" onclick="appendToDisplay('-')">-</button>
                <button onclick="appendToDisplay('1')">1</button>
                <button onclick="appendToDisplay('2')">2</button>
                <button onclick="appendToDisplay('3')">3</button>
                <button class="operation" onclick="appendToDisplay('+')">+</button>
                <button onclick="appendToDisplay('+/-')">±</button>
                <button onclick="appendToDisplay('0')">0</button>
                <button onclick="appendToDisplay('.')">.</button>
                <button class="equals" onclick="calculate()">=</button>
            </div>
        </div>
        <div class="money-changer">
            <h2>Money Changer</h2>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" id="amount" placeholder="Enter amount" min="0" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="fromCurrency">From</label>
                <select id="fromCurrency">
                    <option value="IDR">Rupiah (IDR)</option>
                    <option value="USD">Dollar (USD)</option>
                    <option value="EUR">Euro (EUR)</option>
                    <option value="THB">Bath (THB)</option>
                    <option value="JPY">Yen (JPY)</option>
                    <option value="GBP">Pound (GBP)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="toCurrency">To</label>
                <select id="toCurrency">
                    <option value="USD">Dollar (USD)</option>
                    <option value="EUR">Euro (EUR)</option>
                    <option value="IDR">Rupiah (IDR)</option>
                    <option value="THB">Bath (THB)</option>
                    <option value="JPY">Yen (JPY)</option>
                    <option value="GBP">Pound (GBP)</option>
                </select>
            </div>
            <button class="btn btn-primary" onclick="convertAndSave()">Convert & Save</button>
            <div class="result" id="result"></div>
        </div>
    </div>
    <div class="notes">
        <h3>Conversion Notes</h3>
        <div class="note-list" id="noteList"></div>
    </div>
    <script>
        let display = document.getElementById('display');
        let currentExpression = '';
        let notes = [];

        // Fungsi untuk memperbarui live time
        function updateLiveTime() {
            const liveTimeElement = document.getElementById('liveTime');
            const now = new Date();
            const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dayOfWeek = daysOfWeek[now.getDay()];
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const month = months[now.getMonth()];
            const day = now.getDate();
            const year = now.getFullYear();
            let hours = now.getHours();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds} ${ampm} WIB, ${dayOfWeek}, ${month} ${day}, ${year}`;
            liveTimeElement.textContent = timeString;
        }

        // Perbarui waktu setiap detik
        setInterval(updateLiveTime, 1000);
        updateLiveTime(); // Panggil sekali saat halaman dimuat

        function appendToDisplay(value) {
            if (display.innerText === '0' && value !== '.') {
                display.innerText = value;
                currentExpression = value;
            } else {
                display.innerText += value;
                currentExpression += value;
            }
        }

        function clearDisplay() {
            display.innerText = '0';
            currentExpression = '';
        }

        function clearAll() {
            display.innerText = '0';
            currentExpression = '';
        }

        function calculate() {
            try {
                let result = eval(currentExpression);
                display.innerText = result;
                currentExpression = result.toString();
            } catch (error) {
                display.innerText = 'Error';
                currentExpression = '';
            }
        }

        function convertAndSave() {
            let amount = parseFloat(document.getElementById('amount').value);
            let fromCurrency = document.getElementById('fromCurrency').value;
            let toCurrency = document.getElementById('toCurrency').value;
            let resultElement = document.getElementById('result');
            let noteList = document.getElementById('noteList');

            if (isNaN(amount) || amount <= 0) {
                resultElement.innerText = 'Please enter a valid amount';
                return;
            }

            const rates = {
                'IDR': { 'USD': 0.000063, 'EUR': 0.000058, 'THB': 0.0021, 'JPY': 0.0099, 'GBP': 0.000049 },
                'USD': { 'IDR': 15873, 'EUR': 0.92, 'THB': 33.33, 'JPY': 157.14, 'GBP': 0.78 },
                'EUR': { 'IDR': 17241, 'USD': 1.09, 'THB': 36.21, 'JPY': 170.71, 'GBP': 0.85 },
                'THB': { 'IDR': 476.19, 'USD': 0.03, 'EUR': 0.028, 'JPY': 4.71, 'GBP': 0.023 },
                'JPY': { 'IDR': 101.01, 'USD': 0.0064, 'EUR': 0.0059, 'THB': 0.212, 'GBP': 0.005 },
                'GBP': { 'IDR': 20408, 'USD': 1.28, 'EUR': 1.18, 'THB': 43.48, 'JPY': 200 }
            };

            let rate = rates[fromCurrency][toCurrency];
            let result = amount * rate;

            resultElement.innerText = `${amount.toLocaleString()} ${fromCurrency} = ${result.toFixed(2).toLocaleString()} ${toCurrency}`;

            // Simpan ke catatan
            let note = {
                text: `${amount.toLocaleString()} ${fromCurrency} = ${result.toFixed(2).toLocaleString()} ${toCurrency}`,
                time: new Date().toLocaleTimeString()
            };
            notes.push(note);
            updateNotes();
        }

        function updateNotes() {
            let noteList = document.getElementById('noteList');
            noteList.innerHTML = '';
            notes.forEach((note, index) => {
                let noteItem = document.createElement('div');
                noteItem.className = 'note-item';
                noteItem.innerHTML = `
                    <span>${note.text} (${note.time})</span>
                    <button onclick="deleteNote(${index})">Delete</button>
                `;
                noteList.appendChild(noteItem);
            });
        }

        function deleteNote(index) {
            notes.splice(index, 1);
            updateNotes();
        }
    </script>
</body>
</html>