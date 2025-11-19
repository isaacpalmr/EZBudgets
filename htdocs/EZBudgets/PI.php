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
            margin: 20px 0px;
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

       .user_tables {
            display: flex;
            justify-content: flex-start;
        }

        .table_block {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: max-content;
        }

        #budget-metadata {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #budget-metadata > * {
            margin: 5px 0px;
        }

        #budget-dates {
            display: flex;
            flex-direction: row;
            margin-top: 20px;
        }

        #budget-dates > * {
            margin: 0px 10px;
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
        <div id="error-box"
            style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                background: #ffdddd;
                color: #900;
                padding: 10px;
                font-weight: bold;
                z-index: 9999;
                display: none;
            ">
        </div>

        <div id="budget-metadata">
            <div id="budget-title">
                <label>Title:</label>
                <input type="text">
            </div>
            <div id="budget-funding-source">
                <label>Funding Source:</label>
                <select>
                    <option value="">--Select funding source--</option>
                    <option value="National Science Foundation">National Science Foundation</option>
                    <option value="National Institutes of Health">National Institutes of Health</option>
                </select>
            </div>

            <div id="budget-dates">
                <div id="budget-start-date">
                    <label>Start Date:</label>
                    <input type="date">
                </div>
                <div id="budget-end-date">
                    <label>End Date:</label>
                    <input type="date">
                </div>
            </div>
        </div>
        
        <div id="tables">
            <div id="user_tables" style="text-align: center;">
                <div class="table_block">
                    <table id="pi_table">
                        <caption>
                            Principle investigators
                        </caption>
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Percent effort (of 40 hr week)</th>
                                <th>Hourly rate at start date</th>
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
                
                <div class="table_block">
                    <table id="ui_professional_staff_table">
                        <caption>
                            UI professional staff
                        </caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Percent effort (of 40 hr week)</th>
                                <th>Hourly rate at start date</th>
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

                <div class="table_block">
                    <table id="post_docs_table">
                        <caption>
                            Post doctorates
                        </caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Percent effort (of 40 hr week)</th>
                                <th>Hourly rate at start date</th>
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

            <div id="yearly_costs">
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
        const templateRows = {
            pi_table: `
                <tr>
                    <td class="type">Co-PI</td>
                    <td>
                        <select class="staff-picker" data-filter="pi">
                            <option value="">Select Co-PI</option>
                        </select>
                    </td>
                    <td class="title">Unknown</td>
                    <td><input class="percent-effort" type="number" value="0" min="0" max="100"></td>
                    <td class="rate">$0</td>
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
                    <td><input class="percent-effort" type="number" value="0" min="0" max="100"></td>
                    <td class="rate">$0</td>
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
                    <td><input class="percent-effort" type="number" value="0" min="0" max="100"></td>
                    <td class="rate">$0</td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `
        }

        const yearlyCostsTableBodyRow = document.querySelector("#yearly_costs tbody tr");
        const yearlyCostsTableCaption = document.querySelector("#yearly_costs caption");
        const yearlyCostsTableHeaderRow = document.querySelector("#yearly_costs thead tr");
        const budgetTitle = document.querySelector("#budget-title input");
        const downloadButton = document.getElementById("downloadspreadsheet");
        const budgetStartDate = document.getElementById("budget-start-date").querySelector("input");
        const budgetEndDate = document.getElementById("budget-end-date").querySelector("input");
        const budgetFundingSource = document.querySelector("#budget-funding-source select");
        const piTableBody = document.querySelector("#pi_table tbody");

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
                                const hourlyRate = row.querySelector(".rate");
                                hourlyRate.textContent = '$' + (data.hourly_rate ?? 0)

                                const title = row.querySelector(".title");
                                if (title) {
                                    title.textContent = data.staff_title ?? "Unknown";
                                }

                                updateYearlyCosts();
                            });
                    })
                });
        }
        
        function addRow(table) {
            const tbody = table.querySelector("tbody")
            tbody.insertAdjacentHTML("beforeend", templateRows[table.id]);
            const select = tbody.lastElementChild.querySelector(".staff-picker");
            initializeStaffPicker(select);
            return tbody.lastElementChild;
        }

        function showError(msg) {
            const error = document.getElementById("error-box");
            error.textContent = "Error: " + msg;
            error.style.display = "block";
        }

        function clearError() {
            const error = document.getElementById("error-box");
            error.textContent = "";
            error.style.display = "none";
        }

        function onNumBudgetYearsChanged() {
            const budgetNumYears = getNumBudgetYears();

            // Set table caption
            yearlyCostsTableCaption.textContent = budgetNumYears + " year cost"

            // Set number of columns
            yearlyCostsTableHeaderRow.innerHTML = ""
            yearlyCostsTableBodyRow.innerHTML = ""
            for (let i = 0; i < budgetNumYears; i++) {
                const th = document.createElement("th");
                th.textContent = "Year " + (i + 1);
                yearlyCostsTableHeaderRow.appendChild(th);

                const td = document.createElement("td");
                td.textContent = "$0";
                yearlyCostsTableBodyRow.appendChild(td);
            }
        }

        function calculateYearlyWagesFromRow(row) {
            const hourlyRate = Number(row.querySelector(".rate").textContent.replace(/[$, ]+/g, ''));
            const weeklyHoursWorked = Number(row.querySelector(".percent-effort").value/100 * 40);
            const yearlyHoursWorked = weeklyHoursWorked * 52.1429
            
            const yearlyWages = hourlyRate * yearlyHoursWorked;
            
            return yearlyWages;
        }

        function getTotalWagesForYear(yearNum) {
            // Add hourly rate costs
            let totalWagesPerYear = 0;
            const hourlyRates = document.querySelectorAll(".rate");
            hourlyRates.forEach(td => {
                const row = td.closest("tr");
                const yearlyWages = calculateYearlyWagesFromRow(row);
                if (yearlyWages <= 0) return;

                totalWagesPerYear += yearlyWages;
            });

            return totalWagesPerYear;
        }

        function updateYearlyCosts() {
            let totalYearlyWages = getTotalWagesForYear();
            totalYearlyWages = Math.round(totalYearlyWages * 100) / 100;
            
            for (const td of yearlyCostsTableBodyRow.children) {
                td.textContent = "$" + totalYearlyWages;
            }
        }

        // Calculates the number of budget years based off of start and end dates (default is 1)
        function getNumBudgetYears() {
            const start = new Date(budgetStartDate.value);
            const end = new Date(budgetEndDate.value);
            if (isNaN(start) || isNaN(end)) return 1;

            // GENERATED //
            // Calculate difference in years
            let numYears = end.getFullYear() - start.getFullYear() + 1;

            // Optional: adjust if the end month/day is before start month/day
            const endMonthDay = end.getMonth() * 100 + end.getDate();
            const startMonthDay = start.getMonth() * 100 + start.getDate();
            if (endMonthDay < startMonthDay) {
                numYears--; // end date hasn’t reached the anniversary in the final year
            }

            return numYears;
            // GENERATED//
        }

        // Initialize current staff pickers
        document.querySelectorAll(".staff-picker").forEach(initializeStaffPicker);

        // Listen for budget dates changed
        [budgetStartDate, budgetEndDate].forEach(date => {
            let oldValue = date.value;
            date.addEventListener("input", () => {
                const start = new Date(budgetStartDate.value);
                const end = new Date(budgetEndDate.value);
                if (isNaN(start) || isNaN(end)) return;

                if (end.getTime() < start.getTime()) {
                    showError("Budget end date cannot precede start date.");
                    date.value = oldValue;
                    return;
                }

                clearError();

                onNumBudgetYearsChanged()

                oldValue = date.value;
            });
        });

        // Remove row button
        document.addEventListener("click", (event) => {
            const button = event.target.closest("button")
            if (button) {
                const row = button.closest("tr");
                if (row) row.remove();
            }
        });

        // Add row button
        document.querySelectorAll(".add_row").forEach(button => {
            const table = button.previousElementSibling;
            
            button.addEventListener("click", () => {
                addRow(table);
            })
        })

        // Adding first PI row
        const piRow = addRow(document.querySelector("#pi_table"));
        piRow.querySelector(".type").textContent = "PI";
        piRow.querySelector("option").textContent = "Select PI";
        piRow.lastElementChild.remove() // Remove the remove button

        // User inputs percent effort, update yearly costs
        document.addEventListener("input", event => {
            const percentEffort = event.target.closest(".percent-effort");
            if (!percentEffort) return;

            updateYearlyCosts();
        })

        // User inputs number, clamp to min/max attributes of element
        document.addEventListener("input", event => {
            const input = event.target;
            if (input.type !== "number") return;

            const value = parseFloat(input.value);
            if (isNaN(value)) return;

            const min = parseFloat(input.min);
            if (!isNaN(min) && value < min) 
                input.value = min;

            const max = parseFloat(input.max);
            if (!isNaN(max) && value > max) 
                input.value = max;
            
        });

        // Download spreadsheet
        downloadButton.addEventListener("click", () => {
            // Create spreadsheet data table
            const spreadsheetData = [
                ["Title: "],
                ["Funding Source: "],
                ["PI: ",                   "Co-PIs: "],
                ["Project Start and End Dates: "],
                ["",                       "Hourly rate at start date"],
                ["Personnel Compensation", "Year 1 hours"],
                ["Other Personnel"],
                ["UI professional staff & Post Docs"],
                ["GRAs/UGrads"],
                ["Temp Help"],
            ];

            const headerRow = spreadsheetData[4];
            for (let i = 0; i < getNumBudgetYears(); i++) {
                headerRow.push("Year " + i);
            }
            headerRow.push("Total");

            // Apply meta data
            spreadsheetData[0][0] += budgetTitle.value;
            spreadsheetData[1][0] += budgetFundingSource.value;

            const piSelector = piTableBody.firstElementChild.querySelector(".staff-picker");
            spreadsheetData[2][0] += piSelector.options[piSelector.selectedIndex].text;

            

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
                            const yearlyWages = calculateYearlyWagesFromRow(row);
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