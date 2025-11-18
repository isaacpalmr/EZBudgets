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
<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

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

        #user_tables > * {
            padding-bottom: 100px;
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
            <div id="user_tables" style="text-align: center;">
                <div>
                    <table id="pi_table">
                        <caption>
                            Principle investigators
                        </caption>
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Hourly rate at start date</th>
                                <th>Year 1 hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="type">PI</td>
                                <td>
                                    <select class="staff-picker" data-filter="pi">
                                        <option value="">Select PI</option>
                                    </select>
                                </td>
                                <td class="title">Unknown</td>
                                <td class="rate">$0</td>
                                <td><input class="hours" type="number" value="0" min="0"></td>
                            </tr>
                        </tbody>
                    </table>

                    <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                        <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                        width="24" height="24">
                    </button>
                </div>
                
                <div>
                    <table id="ui_professional_staff_table">
                        <caption>
                            UI professional staff
                        </caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Hourly rate at start date</th>
                                <th>Year 1 hours</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                        <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                        width="24" height="24">
                    </button>
                </div>

                <div>
                    <table id="post_docs_table">
                        <caption>
                            Post doctorates
                        </caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Hourly rate at start date</th>
                                <th>Year 1 hours</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                        <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                        width="24" height="24">
                    </button>
                </div>
            </div>

            <div id="fiveyearcost">
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
        // Add row button
        const templateRows = {
            pi_table: `
                <tr>
                    <td class="type">PI</td>
                    <td>
                        <select class="staff-picker" data-filter="pi">
                            <option value="">Select PI</option>
                        </select>
                    </td>
                    <td class="title">Unknown</td>
                    <td class="rate">$0</td>
                    <td><input class="hours" type="number" value="0" min="0"></td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
            ui_professional_staff_table: `
                <tr>
                    <td>
                        <select class="staff-picker" data-filter="prostaff">
                            <option value="">Select Pro Staff</option>
                        </select>
                    </td>
                    <td class="title">Unknown</td>
                    <td class="rate">$0</td>
                    <td><input class="hours" type="number" value="0" min="0"></td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
            post_docs_table: `
                <tr>
                    <td>
                        <select class="staff-picker" data-filter="postdoc">
                            <option value="">Select Post Doc</option>
                        </select>
                    </td>
                    <td class="rate">$0</td>
                    <td><input class="hours" type="number" value="0" min="0"></td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `
        }
        document.querySelectorAll(".add_row").forEach(button => {
            const table = button.previousElementSibling;
            const tbody = table.querySelector("tbody")
            
            button.addEventListener("click", () => {
                tbody.insertAdjacentHTML("beforeend", templateRows[table.id]);
                const select = tbody.lastElementChild.querySelector(".staff-picker");
                initializeStaffPicker(select);
            })
        })

        // Remove row button
        document.addEventListener("click", (event) => {
            const button = event.target.closest("button")
            if (button) {
                const row = button.closest("tr");
                if (row) row.remove();
            }
        });

        // Staff picker dropdown logic
        function initializeStaffPicker(select) {
            const table = select.closest("table");
            const row = select.closest("tr");
            const filter = select.dataset.filter;

            row.dataset.originalHTML = row.innerHTML;
            
            fetch(`get_staff_list.php?filter=${filter}`)
                .then(res => res.json())
                .then(rows => {
                    rows.forEach(r => {
                        const opt = document.createElement("option");
                        opt.value = r.staff_id;
                        opt.textContent = r.name;
                        select.appendChild(opt);
                    });

                    const ts = new TomSelect(select, {
                        maxItems: 1,
                        create: false
                    });

                    ts.on("change", value => {
                        if (!value) {
                            row.innerHTML = row.dataset.originalHTML; // Reset the row's values
                            return;
                        }

                        fetch(`get_employee.php?staff_id=${value}`)
                            .then(r => r.json())
                            .then(data => {
                                row.querySelector(".rate").textContent = "$" + (data.hourly_rate ?? 0);

                                const title = row.querySelector(".title");
                                if (title) {
                                    title.textContent = data.staff_title ?? "Unknown";
                                }

                                update5YearCost();
                            });
                    })
                });
        }
        document.querySelectorAll(".staff-picker").forEach(initializeStaffPicker);

        const fiveYearCostTableBody = document.querySelector("#fiveyearcost tbody")
        function update5YearCost() {
            let yearlyTotal = 0;

            // Add hourly rate costs
            const hourlyRates = document.querySelectorAll(".rate");
            hourlyRates.forEach(td => {
                const row = td.closest("tr");
                const hourlyRate = Number(row.querySelector(".rate").textContent.replace(/[$, ]+/g, ''));
                const hoursWorked = Number(row.querySelector(".hours").value);
                
                const yearlyWages = hoursWorked*hourlyRate;
                if (yearlyWages <= 0) return;

                yearlyTotal += yearlyWages;
            })

            yearlyTotal = Math.round(yearlyTotal * 100) / 100;

            fiveYearCostTableBody.innerHTML = `
                <tr>
                    <td>$${yearlyTotal}</td>
                    <td>$${yearlyTotal}</td>
                    <td>$${yearlyTotal}</td>
                    <td>$${yearlyTotal}</td>
                    <td>$${yearlyTotal}</td>
                </tr>
            `
        }

        document.addEventListener("input", event => {
            const hours = event.target.closest(".hours");
            if (!hours) return;

            update5YearCost();
        })

        // Download spreadsheet
        const yearCostsTableBody = document.querySelector("#fiveyearcost tbody");
        const budgetTitle = document.querySelector("#budgettitle input")
        const downloadButton = document.getElementById("downloadspreadsheet");

        downloadButton.addEventListener("click", () => {
            const spreadsheetData = [
                ["", "", "Hourly rate at start date", "Year 1",  "Year 2", "Year 3", "Year 4", "Year 5"], // Header row
            ];

            // Loop through each table calculating costs
            [
                {title: "Principle investigators", aggregate: false}, 
                {title: "UI professional staff", aggregate: true}, 
                {title: "Post doctorates", aggregate: true}, 
            ].forEach(tinfo => {
                spreadsheetData.push([tinfo.title, "Year 1 hours"]);

                document.querySelectorAll("table caption").forEach(caption => {
                    if (caption.textContent.trim() === tinfo.title) {
                        const table = caption.closest("table");
                        
                        // Add hourly rate costs
                        const hourlyRates = table.querySelectorAll(".rate");
                        hourlyRates.forEach(td => {
                            const row = td.closest("tr");
                            const type = row.querySelector(".type").textContent;
                            const hourlyRate = Number(row.querySelector(".rate").textContent.replace(/[$, ]+/g, ''));
                            const hoursWorked = Number(row.querySelector(".hours").value);
                            
                            const yearlyWages = hoursWorked*hourlyRate;
                            if (yearlyWages <= 0) return;

                            const yearlyWagesStr = '$' + yearlyWages;

                            spreadsheetData.push([type, hoursWorked, '$' + hourlyRate, yearlyWagesStr, yearlyWagesStr, yearlyWagesStr, yearlyWagesStr, yearlyWagesStr]);
                        })
                    }
                });
            })

            const worksheet = XLSX.utils.aoa_to_sheet(spreadsheetData);
            
            // GENERATED //
            // Auto-size columns based on text length (approximation)
            const colWidths = spreadsheetData[0].map((_, colIdx) => {
            const maxLen = Math.max(...spreadsheetData.map(row => String(row[colIdx] ?? "").length));
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
</html>
