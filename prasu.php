<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales History</title>
<style>
      body {
            font-family: Arial, sans-serif;
            background-image: url('https://c8.alamy.com/comp/2F5B8WA/traditional-indian-foods-arranged-as-collage-of-the-cuisine-2F5B8WA.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        select, input, button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        .save-btn {
            background-color: darkblue;
            color: white;
        }

        .save-btn:hover {
            background-color: #45a049;
        }

        .cart-section {
            margin-top: 20px;
            padding: 10px;
            background: #f7f7f7;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid rgba(0, 0, 0, 0.3);
        }

        th, td {
            padding: 10px;
            text-align: left;
            background-color: rgba(0, 0, 0, 0.2);
            color: black;
        }

        th {
            background-color: rgba(0, 0, 0, 0.3);
        }

        .remove-btn {
            background-color: red;
            color: white;
            width: 80px;
        }

        @media print {
            body {
                background: white;
            }

            .container {
                background: none;
            }

            .no-print {
                display: none;
            }

            #salesTableContainer {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>House of Curries</h1>
        <div class="form-group">
            <label for="saleDate">Sale Date:</label>
            <input type="date" id="saleDate" name="sale_date">
        </div>

        <div class="form-group">
            <label for="placeSelect">Select Place:</label>
            <select id="placeSelect">
                <option value="miyapur">Miyapur</option>
                <option value="ameerpet">Ameerpet</option>
                <option value="oldcity">Old City</option>
            </select>
        </div>

      <div class="form-group">
            <label for="currySelect">Select Curry:</label>
            <select id="currySelect" onchange="filterCurryOptions()">
                <optgroup label="Rice">
                    <option value="Veg Biriyani">Veg Biriyani</option>
                    <option value="Rice">Rice</option>
                </optgroup>
                <optgroup label="Starters">
                    <option value="Cashew Fry">Cashew Fry</option>
                    <option value="Leg Piece">Leg Piece</option>
                    <option value="Chapathi">Chapathi</option>
                </optgroup>
                <optgroup label="Vegetarian Curries">
                    <option value="Brinjal">Brinjal Curry</option>
                    <option value="Potato">Potato Curry</option>
                    <option value="Lady Finger">Lady Finger Curry</option>
                    <option value="Cabbage Fry">Cabbage Fry</option>
                    <option value="Paneer">Paneer Curry</option>
                    <option value="Dal">Pappu</option>
                    <option value="Masala">Masala Curry</option>
                    <option value="Dondakai">Dondakai</option>
                    <option value="Chutney">Chutney</option>
                    <option value="Sambar">Sambar</option>
                    <option value="Rasam">Rasam</option>
                </optgroup>
                <optgroup label="Non-Vegetarian Curries">
                    <option value="Mutton">Mutton Curry</option>
                    <option value="Prawns">Prawns Curry</option>
                    <option value="Crab">Crab Fry (Pithalu)</option>
                    <option value="Chicken">Chicken Curry</option>
                    <option value="Fish">Fish Curry</option>
                    <option value="Boti">Boti</option>
                    <option value="Boti Fry">Boti Fry</option>
             <option value="Liver Fry">Liver Fry</option>


                </optgroup>
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity Sold (in kgs):</label>
            <input type="number" id="quantity" min="1" value="1">
        </div>

        <div class="form-group">
            <label for="leftover">Leftover Quantity (in kgs):</label>
            <input type="number" id="leftover" min="0" value="0">
        </div>

        <div class="form-group">
            <label for="unitsPerPacket">Units per Packet (in grams):</label>
            <input type="number" id="unitsPerPacket" min="1" value="100">
        </div>

        <div class="form-group">
            <label for="price">Price per Packet (in ₹):</label>
            <input type="number" id="price" min="0" placeholder="Enter price for the selected curry">
        </div>

        <button class="save-btn" onclick="addToCart()">Add to Cart</button>

        <div id="cart">
            <h2 class="section-heading">Cart</h2>

            <h3>Miyapur</h3>
            <ul id="cartMiyapur"></ul>

            <h3>Ameerpet</h3>
            <ul id="cartAmeerpet"></ul>

            <h3>Old City</h3>
            <ul id="cartOldCity"></ul>
        </div>

        <button class="save-btn" onclick="saveSalesData()">Save Sales Data</button>

        <!-- History Section -->
        <div class="form-group">
            <label for="historyDate" class="section-heading">Select Date for History:</label>
            <input type="date" id="historyDate">
        </div>

        <div class="form-group">
            <label for="historyPlace">Select Place for Printing History:</label>
            <select id="historyPlace">
                <option value="all">All</option>
                <option value="miyapur">Miyapur</option>
                <option value="ameerpet">Ameerpet</option>
                <option value="oldcity">Old City</option>
            </select>
        </div>

        <button class="save-btn" onclick="showHistory()">Show History</button>

        <div id="salesTableContainer" style="margin-top: 20px;">
            <table id="salesTable">
                <thead>
                    <tr>
                        <th>Place</th>
                        <th>Curry</th>
                        <th>Quantity (kg)</th>
                        <th>Price (₹)</th>
                        <th>Total (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sales data will be dynamically inserted here -->
                </tbody>
            </table>
        </div>

        <button class="save-btn" onclick="printHistoryTable()">Print History</button>
    </div>

    <script>
        let cartMiyapur = [];
        let cartAmeerpet = [];
        let cartOldCity = [];

        function addToCart() {
            const placeSelect = document.getElementById("placeSelect").value;
            const curryName = document.getElementById("currySelect").options[document.getElementById("currySelect").selectedIndex].text;
            const quantity = parseFloat(document.getElementById("quantity").value); // in kgs
            const leftover = parseFloat(document.getElementById("leftover").value); // in kgs
            const unitsPerPacket = parseFloat(document.getElementById("unitsPerPacket").value); // in grams
            const price = parseFloat(document.getElementById("price").value); // price per packet
            const saleDate = document.getElementById("saleDate").value;

            if (!saleDate || isNaN(quantity) || isNaN(price) || isNaN(unitsPerPacket)) {
                return;
            }

            const soldQuantityInGrams = (Math.max(0, quantity - leftover)) * 1000; // converting kg to grams
            const numPackets = soldQuantityInGrams / unitsPerPacket; // total number of packets
            const total = numPackets * price; // total price based on number of packets

            const item = {
                saleDate: saleDate,
                curryName: curryName,
                quantity: soldQuantityInGrams / 1000, // back to kgs for display
                price: price,
                total: total
            };

            if (placeSelect === "miyapur") {
                cartMiyapur.push(item);
            } else if (placeSelect === "ameerpet") {
                cartAmeerpet.push(item);
            } else if (placeSelect === "oldcity") {
                cartOldCity.push(item);
            }

            updateCartUI();
        }

        function updateCartUI() {
            const cartMiyapurElement = document.getElementById("cartMiyapur");
            const cartAmeerpetElement = document.getElementById("cartAmeerpet");
            const cartOldCityElement = document.getElementById("cartOldCity");

            cartMiyapurElement.innerHTML = "";
            cartAmeerpetElement.innerHTML = "";
            cartOldCityElement.innerHTML = "";

            cartMiyapur.forEach(item => {
                cartMiyapurElement.innerHTML += `<li>${item.curryName} - ${item.quantity} kg @ ₹${item.price} per packet = ₹${item.total} <button class="remove-btn" onclick="removeItem('miyapur', ${cartMiyapur.indexOf(item)})">Remove</button></li>`;
            });

            cartAmeerpet.forEach(item => {
                cartAmeerpetElement.innerHTML += `<li>${item.curryName} - ${item.quantity} kg @ ₹${item.price} per packet = ₹${item.total} <button class="remove-btn" onclick="removeItem('ameerpet', ${cartAmeerpet.indexOf(item)})">Remove</button></li>`;
            });

            cartOldCity.forEach(item => {
                cartOldCityElement.innerHTML += `<li>${item.curryName} - ${item.quantity} kg @ ₹${item.price} per packet = ₹${item.total} <button class="remove-btn" onclick="removeItem('oldcity', ${cartOldCity.indexOf(item)})">Remove</button></li>`;
            });
        }

        function removeItem(place, index) {
            if (place === "miyapur") {
                cartMiyapur.splice(index, 1);
            } else if (place === "ameerpet") {
                cartAmeerpet.splice(index, 1);
            } else if (place === "oldcity") {
                cartOldCity.splice(index, 1);
            }

            updateCartUI();
        }

        function saveSalesData() {
            const salesData = {
                sale_date: document.getElementById("saleDate").value,
                miyapur: cartMiyapur,
                ameerpet: cartAmeerpet,
                oldcity: cartOldCity
            };

            fetch('save_sales.php', {
                method: 'POST',
                body: JSON.stringify(salesData),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.text())
            .then(data => alert(data))
            .catch(error => alert("Error saving data: " + error));
        }

        function showHistory() {
            const date = document.getElementById("historyDate").value;
            const place = document.getElementById("historyPlace").value;

            fetch(`show_history.php?date=${date}&place=${place}`)
                .then(response => response.text())
                .then(data => {
                    document.querySelector("#salesTable tbody").innerHTML = data;
                })
                .catch(error => alert("Error loading history: " + error));
        }

        function printHistoryTable() {
            const salesTable = document.getElementById("salesTableContainer").innerHTML;
            const place = document.getElementById("historyPlace").value;
            const date = document.getElementById("historyDate").value;

            let placeText = place === "all" ? "All Places" : place.charAt(0).toUpperCase() + place.slice(1);

            const newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><head><title>Print History</title>');
            newWin.document.write('<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid black; padding: 8px; text-align: left;} th {background-color: #f2f2f2;}</style>');
            newWin.document.write('</head><body>');
            newWin.document.write(`<h1>Sales History for ${placeText}</h1>`);
            newWin.document.write(`<h2>Date: ${date}</h2>`);
            newWin.document.write(salesTable);
            newWin.document.write('</body></html>');
            newWin.document.close();

            setTimeout(function () { newWin.print(); newWin.close(); }, 100);
        }
    </script>
</body>
</html>
