<?php
$servername = "localhost";
$username = "root";   // default in XAMPP
$password = "";       // default is empty
$dbname = "ezbudgets";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">


    <title>
        EZBudgets
    </title>

    <style>
        body {
            font-family: 'Open Sans';
        }

        body header {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        body header > * {
            /* background-color: blue; */
            padding: 0;
            margin: 5px 0px
        }

        th {
            border: 2px solid rgb(0, 0, 0);
            padding: 5px 10px;
        }

        td {
            text-align: center;
        }

        #tables {
            display: flex;
            flex-direction: row;
            align-items: top;
            justify-content: space-evenly;
            width: 100%;
        }

        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin: 50px 0px;
        }

        main > * {
            margin: 20px 0px;
        }

        button:hover {
            filter: brightness(85%)
        }
    </style>
</head>

<body>
    <header>
        <h1>
            EZBudgets
        </h1>

        <p style="font-style: italic;">
            Budget building wizard
        </p>
    </header>

    <main>
        <div id="budgettitle">
            <label>Budget Title:</label>
            <input type="text">
        </div>
        
        <div id="tables">
            <div style="text-align: center;">
                <table id="pi_table">
                    <caption>
                        Principle investigators
                    </caption>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Staff ID</th>
                            <th>Name</th>
                            <th>Hourly rate at start date</th>
                            <th>Year 1 hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="type">PI</td>
                            <td><input class="staff-id" type="number"></td>
                            <td class="name">Unknown</td>
                            <td class="rate">$0</td>
                            <td><input class="hours" type="number" value="0" min="0"></td>
                        </tr>
                    </tbody>
                </table>

                <button id="addco-pi" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                    <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                    width="24" height="24">
                </button>
            </div>
            <div id="fiveyearcalculation">
                <table>
                    <caption>
                        5 year cost
                    </caption>
                    <thead>
                        <tr>
                            <th>Year 1</th>
                            <th>Year 2</th>
                            <th>Year 3</th>
                            <th>Year 4</th>
                            <th>Year 5</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>$0</td>
                            <td>$0</td>
                            <td>$0</td>
                            <td>$0</td>
                            <td>$0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div>
            <input id="downloadspreadsheet" type="button" value="Download spreadsheet">
        </div>
    </main>

    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
        // Add co-PI button
        const piTableBody = document.querySelector('#pi_table tbody');
        const addRowButton = document.getElementById("addco-pi")
        addRowButton.addEventListener("click", () => {
            piTableBody.innerHTML += `
                <tr>
                    <td class="type">co-PI</td>
                    <td><input class="staff-id" type="number"></td>
                    <td class="name">Unknown</td>
                    <td class="rate">$0</td>
                    <td><input class="hours" type="number" value="0" min="0"></td>
                    <td>
                        <button class="removeco-pi" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                            width="24" height="24">
                        </button>
                    </td>
                </tr>
            `
        })

        // Auto update row information when Staff ID changes
        document.addEventListener("input", (event) => {
            const staffInput = event.target.closest(".staff-id"); 
            const row = event.target.closest("tr")
            if (!staffInput || !row) return;

            const staffId = staffInput.value;
            if (staffId !== "") {
                fetch(`get_employee.php?staff_id=${staffId}`)
                    .then(response => response.json())
                    .then(data => {
                        row.querySelector(".name").textContent = data.name || "Unknown";
                        row.querySelector(".rate").textContent = "$" + (data.hourly_rate || 0);
                    });
            } else {
                row.querySelector(".name").textContent = "Unknown";
                row.querySelector(".rate").textContent = "$0";
            }
        });

        // Remove co-PI button
        document.addEventListener("click", (event) => {
            const button = event.target.closest(".removeco-pi")
            if (button) {
                const row = button.closest("tr");
                if (row) row.remove();
            }
        });

        // Download spreadsheet
        const yearCostsTableBody = document.querySelector("#fiveyearcalculation tbody");
        const budgetTitle = document.querySelector("#budgettitle input")
        const downloadButton = document.getElementById("downloadspreadsheet");

        downloadButton.addEventListener("click", () => {
            const data = [
                ["", "", "Hourly rate at start date", "Year 1",  "Year 2", "Year 3", "Year 4", "Year 5"], // Header row
                ["Principle Investigators", "Year 1 hours"],
            ];

            // Add pi costs
            piTableBody.querySelectorAll("tr").forEach(row => {
                const type = row.querySelector(".type").textContent;
                const hourlyRate = Number(row.querySelector(".rate").textContent.replace(/[$, ]+/g, ''));
                const hoursWorked = Number(row.querySelector(".hours").value);
                
                const yearlyWages = '$' + hoursWorked*hourlyRate

                data.push([type, hoursWorked, '$' + hourlyRate, yearlyWages, yearlyWages, yearlyWages, yearlyWages, yearlyWages]);
            })

            const worksheet = XLSX.utils.aoa_to_sheet(data);
            
            // GENERATED //
            // Auto-size columns based on text length (approximation)
            const colWidths = data[0].map((_, colIdx) => {
            const maxLen = Math.max(...data.map(row => String(row[colIdx] ?? "").length));
            return { wch: maxLen + 2 }; // width in characters
            });
            worksheet["!cols"] = colWidths;
            // GENERATED //

            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Budget");

            XLSX.writeFile(workbook, budgetTitle.value + (budgetTitle.value !== "" ? "_" : "")  + "EZBudgets.xlsx")
        })
    </script>
</body>