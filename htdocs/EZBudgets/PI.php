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
            align-items: flex-start;
            justify-content: space-evenly;
            width: 100%;
        }

        caption {
            text-align: left;
            margin-bottom: 10px;
        }

        #yearly-costs-caption {
            text-align: center;
            margin-bottom: 10px;
        }

        .add_row {
            margin-left: 10px;
        }

        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin: 20px 0px;
        }

        main > * {
            margin: 20px 0px;
        }

        button:hover {
            filter: brightness(85%)
        }

        #right-side {
            display: flex;
            flex-direction: column;
            align-items: center;

            position: sticky;
            top: 50%;                /* middle of viewport */
            transform: translateY(-50%);  /* shift it up by half its own height */
        }

        #downloadspreadsheet {
            margin-top: 50px;
        }

       #user_tables {
            display: flex;
            flex-direction: column;
        }

        #user_tables > * {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: max-content;
            transform: translateX(-100px);
            margin-bottom: 75px;
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
                <div>
                    <table id="pi-table">
                        <caption>
                            Principle investigators
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                                <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                                width="24" height="24">
                            </button>
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
                </div>
                
                <div>
                    <table id="pro-staff">
                        <caption>
                            UI professional staff
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                                <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                                width="24" height="24">
                            </button>
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
                </div>
                
                <div>
                    <table id="post-docs">
                        <caption>
                            Post doctoral researchers
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                                <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                                width="24" height="24">
                            </button>
                        </caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Request stipend?</th>
                                <th>Percent effort (of 40 hr week)</th>
                                <th>Stipend amount (per academic year)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                
                <div>
                    <table id="gras">
                        <caption>
                            Graduate research assistants
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                                <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                                width="24" height="24">
                            </button>
                        </caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Request stipend?</th>
                                <th>Percent effort (of 40 hr week, 50% max)</th>
                                <th>Stipend amount (per academic year)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                
                <div>
                    <table id="ugrads">
                        <caption>
                            Undergraduate research assistants
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                                <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                                width="24" height="24">
                            </button>
                        </caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Request stipend?</th>
                                <th>Percent effort (of 40 hr week, 50% max)</th>
                                <th>Stipend amount (per academic year)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div>
                    <table id="equipment">
                        <caption>
                            Equipment > $5,000.00
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                                <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                                width="24" height="24">
                            </button>
                        </caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <!-- <div>
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
                </div> -->
            </div>

            <div id="right-side">
                <div id="yearly_costs">
                    <table>
                        <caption id="yearly-costs-caption">
                            5 year cost
                        </caption>
                        <thead>
                            <tr>
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

                <div>
                    <input id="downloadspreadsheet" type="button" value="Download spreadsheet">
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
        const templateRows = {
            "pi-table": `
                <tr>
                    <td class="type">Co-PI</td>
                    <td>
                        <select class="staff-picker" data-filter="pi">
                            <option value="">Select Co-PI</option>
                        </select>
                    </td>
                    <td class="title">—</td>
                    <td><input class="percent-effort" type="number" value="0" min="0" max="100"></td>
                    <td class="rate">$0.00</td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
            "pro-staff": `
                <tr>
                    <td>
                        <select class="staff-picker" data-filter="pro-staff">
                            <option value="">Select Pro Staff</option>
                        </select>
                    </td>
                    <td class="title">—</td>
                    <td><input class="percent-effort" type="number" value="0" min="0" max="100"></td>
                    <td class="rate">$0.00</td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
            "post-docs": `
                <tr>
                    <td>
                        <select class="staff-picker" data-filter="post-doc">
                            <option value="">Select Post Doc</option>
                        </select>
                    </td>
                    <td><input class="request-stipend" type="checkbox"></td>
                    <td><input class="percent-effort" type="number" value="0" min="0" max="100" disabled></td>
                    <td class="stipend-amount">$0.00</td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
            "gras": `
                <tr>
                    <td>
                        <select class="staff-picker" data-filter="gra">
                            <option value="">Select GRA</option>
                        </select>
                    </td>
                    <td><input class="request-stipend" type="checkbox"></td>
                    <td><input class="percent-effort" type="number" value="0" min="0" max="50" disabled></td>
                    <td class="stipend-amount">$0.00</td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
            "ugrads": `
                <tr>
                    <td>
                        <select class="staff-picker" data-filter="ugrad">
                            <option value="">Select UGrad</option>
                        </select>
                    </td>
                    <td><input class="request-stipend" type="checkbox"></td>
                    <td><input class="percent-effort" type="number" value="0" min="0" max="50" disabled></td>
                    <td class="stipend-amount">$0.00</td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
            "equipment": `
                <tr>
                    <td><input class="name" type="text"></td>
                    <td><input class="quantity" type="number" value="0" min="0"></td>
                    <td><input class="unit-cost" type="number" value="5000" min="5000"></td>
                    <td class="total-cost">$0.00</td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
            // post_docs_table: `
            //     <tr>
            //         <td>
            //             <select class="staff-picker" data-filter="postdoc">
            //                 <option value="">Select Post Doc</option>
            //             </select>
            //         </td>
            //         <td><input class="percent-effort" type="number" value="0" min="0" max="100"></td>
            //         <td class="rate">$0</td>
            //         <td>
            //             <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
            //                 <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
            //             </button>
            //         </td>
            //     </tr>
            // `
        }

        const tableIdToPersonnelType = {
            "pi-table": "staff",
            "pro-staff": "staff",
            "post-docs": "post-doc",
            "gras": "gra",
            "ugrads": "ugrad",
        }

        const yearlyCostsTableBodyRow = document.querySelector("#yearly_costs tbody tr");
        const yearlyCostsTableCaption = document.querySelector("#yearly_costs caption");
        const yearlyCostsTableHeaderRow = document.querySelector("#yearly_costs thead tr");
        const budgetTitle = document.querySelector("#budget-title input");
        const downloadButton = document.getElementById("downloadspreadsheet");
        const budgetStartDate = document.getElementById("budget-start-date").querySelector("input");
        const budgetEndDate = document.getElementById("budget-end-date").querySelector("input");
        const budgetFundingSource = document.querySelector("#budget-funding-source select");
        const piTableBody = document.querySelector("#pi-table tbody");

        // Staff picker dropdown logic
        function initializeStaffPicker(select) {
            const table = select.closest("table");
            const row = select.closest("tr");
            const filter = select.dataset.filter;

            row.dataset.originalHTML = row.innerHTML;
            
            fetch(`get_personnel_list.php?filter=${filter}`)
                .then(res => res.json())
                .then(rows => {
                    rows.forEach(r => {
                        const opt = document.createElement("option");
                        opt.value = r.id;
                        opt.textContent = r.name;
                        select.appendChild(opt);
                    });

                    const ts = new TomSelect(select, {
                        maxItems: 1,
                        create: false
                    });

                    ts.on("change", personnelId => {
                        if (!personnelId) {
                            row.innerHTML = row.dataset.originalHTML; // Reset the row's values
                            return;
                        }

                        const personnelType = tableIdToPersonnelType[table.id];

                        fetch(`get_single_personnel.php?personnelType=${personnelType}&personnelId=${personnelId}`)
                            .then(r => r.json())
                            .then(data => {
                                const stipendAmount = row.querySelector(".stipend-amount");
                                if (stipendAmount) {
                                    stipendAmount.textContent = toDollar(data.stipend_per_academic_year ?? 0);
                                }

                                const hourlyRate = row.querySelector(".rate");
                                if (hourlyRate) {
                                    hourlyRate.textContent = toDollar(data.hourly_rate ?? 0)
                                }

                                const title = row.querySelector(".title");
                                if (title) {
                                    title.textContent = data.staff_title ?? "—";
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
            if (select) {
                initializeStaffPicker(select);
            }
            
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
                td.textContent = toDollar(0);
                yearlyCostsTableBodyRow.appendChild(td);
            }

            updateYearlyCosts();
        }

        // GENERATED //
        function toDollar(v) {
            // Convert input to a number
            const num = typeof v === "number" ? v : parseFloat(v);

            // Handle invalid input
            if (isNaN(num)) return "$0.00";

            // Format as US dollars
            return num.toLocaleString("en-US", { style: "currency", currency: "USD" });
        }
        // GENERATED //

        function getPersonnelIdFromRow(row) {
            const table = row.closest("table");

            const personnelType = tableIdToPersonnelType[table.id];
            const personnelId = row.querySelector(".staff-picker").value;

            return [personnelType, personnelId];
        }

        function calculateYearlyHoursWorkedFromRow(row) {
            const weeklyHoursWorked = Number(row.querySelector(".percent-effort").value/100 * 40);
            const yearlyHoursWorked = weeklyHoursWorked * 52.1429;
            return yearlyHoursWorked;
        }

        async function getFringeRateFromRowAsync(row) {
            const [personnelType, personnelId] = getPersonnelIdFromRow(row);
            const response = await fetch(`get_single_personnel.php?personnelType=${personnelType}&personnelId=${personnelId}`);
            const data = await response.json();
            return (data.fringe_rate ?? 0) / 100;
        }

        async function calculateYearlyWagesWithFringeRateFromRowAsync(row) {
            const hourlyRate = Number(row.querySelector(".rate").textContent.replace(/[$, ]+/g, ''));
            const yearlyHoursWorked = calculateYearlyHoursWorkedFromRow(row);
            
            const fringeRate = await getFringeRateFromRowAsync(row);
            const yearlyWages = (hourlyRate*yearlyHoursWorked) * (1+fringeRate);

            return yearlyWages;
        }

        async function getTotalWagesForYearWithFringeRateAsync(yearNum) {
            let totalWagesPerYear = 0;
            const hourlyRates = document.querySelectorAll(".rate");

            for (const td of hourlyRates) {
                const row = td.closest("tr");
                const yearlyWages = await calculateYearlyWagesWithFringeRateFromRowAsync(row);
                if (yearlyWages > 0 && !isNaN(yearlyWages)) {
                    totalWagesPerYear += yearlyWages;
                }
            }

            return totalWagesPerYear;
        }

        function updateYearlyCosts() {
            getTotalWagesForYearWithFringeRateAsync()
            .then(totalYearlyWages => {
                totalYearlyWages = Math.round(totalYearlyWages * 100) / 100;

                for (const td of yearlyCostsTableBodyRow.children) {
                    td.textContent = toDollar(totalYearlyWages);
                }
            });
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

        // Initialize yearly costs table
        onNumBudgetYearsChanged();

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
                updateYearlyCosts();
            }
        });

        // Add row button
        document.querySelectorAll(".add_row").forEach(button => {
            const table = button.closest("table");
            
            button.addEventListener("click", () => {
                addRow(table);
            })
        })

        // Adding first PI row
        const piRow = addRow(document.querySelector("#pi-table"));
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

        // Listen for equipment quantity/unit cost changed
        document.addEventListener("input", event => {
            const table = event.target.closest("table");
            if (!table || table.id !== "equipment") return;
            
            const row = event.target.closest("tr");
            const quantity = row.querySelector(".quantity");
            const unitCost = row.querySelector(".unit-cost");
            const totalCost = row.querySelector(".total-cost");

            totalCost.textContent = toDollar(quantity.value * unitCost.value);
        })

        // Listen for stipend request button clicked
        document.addEventListener("input", event => {
            const checkbox = event.target;
            if (!checkbox.classList.contains("request-stipend")) return;

            const row = checkbox.closest("tr");
            const percentEffort = row.querySelector(".percent-effort");

            if (checkbox.checked) {
                percentEffort.disabled = false;
            } else {
                percentEffort.value = 0;
                percentEffort.disabled = true;
            }
        })

        // Download spreadsheet
        downloadButton.addEventListener("click", async () => {
            // Create spreadsheet data table
            const spreadsheetData = [
                ["Title: "],
                ["Funding Source: "],
                ["PI: ",                   "Co-PIs: "],
                ["Project Start and End Dates: "],
                ["",                                    "",                 "Hourly rate at start date"],
                ["Personnel Compensation",              "Year 1 hours"],
                [],
                ["Other Personnel"],
                ["UI professional staff & Post Docs"],
                ["GRAs/UGrads"],
                ["Temp Help"],
                [],
                ["Fringe",                              "FY26 Fringe Rates"],
                ["UI professional staff & Post Docs",   "36.7%"],
                ["Faculty",                             "29.5%"],
                ["Temp Help",                           "10.5%"],
                ["GRAs/UGrads",                         "3.2%"],
                [],
                ["Equipment > $5000.00"],
                [],
                ["Travel"],
                ["Domestic"],
                ["International"],
                [],
                ["Participant support costs (NSF only)"],
                [],
                ["Other Direct Costs"],
                ["Materials and supplies"],
                ["<$5K small equipment"],
                ["Publication costs"],
                ["Computer services"],
                ["Software"],
                ["Facility useage fees"],
                ["Conference registration"],
                ["Other"],
                ["Other"],
                ["Grad Student Tuition & Health Insurance"],
                [],
                ["Consortia/Subawards"],
                ["Sub award 1"],
                ["Sub award 2"],
                [],
                ["Total Direct Cost"],
                ["Back out GRA T&F"],
                ["Back out capital EQ"],
                ["Back out subawards totals"],
                ["Sub award 1 1st $25k"],
                ["Sub award 2 1st $25k"],
                ["Modified Total Direct Costs"],
                ["Indirect Costs",                      "50.0%"],
                ["Total Project Cost"],
            ];

            function getSpreadsheetRowIndexByLabel(label) {
                return spreadsheetData.findIndex(row => row[0] === label);
            }

            const numBudgetYears = getNumBudgetYears();

            const headerRow = spreadsheetData[4];
            for (let i = 0; i < numBudgetYears; i++) {
                headerRow.push("Year " + (i+1));
            }
            headerRow.push("Total");

            // Apply title + funding source
            spreadsheetData[0][0] += budgetTitle.value;
            spreadsheetData[1][0] += budgetFundingSource.value;

            // Apply PI
            const piSelector = piTableBody.firstElementChild.querySelector(".staff-picker");
            spreadsheetData[2][0] += piSelector.options[piSelector.selectedIndex].text;
            
            // Apply Co-PIs
            const names = [];
            for (let i = 1; i < piTableBody.children.length; i++) {
                const selector = piTableBody.children[i].querySelector(".staff-picker");
                names.push(selector.options[selector.selectedIndex].text);
            }
            spreadsheetData[2][1] += names.join(", ");

            // Apply start + end dates
            spreadsheetData[3][0] += budgetStartDate.value + " – " + budgetEndDate.value;

            // Apply principle investigators
            const piRows = piTableBody.children;
            for (let i = 0; i < piRows.length; i++) {
                const row = piRows[i];
                const piType = row.querySelector(".type").textContent.trim();
                const hourlyRate = row.querySelector(".rate").textContent.trim();
                const year1HoursWorked = calculateYearlyHoursWorkedFromRow(row);
                const yearlyWages = await calculateYearlyWagesWithFringeRateFromRowAsync(row);
                const totalWagesForBudgetDuration = yearlyWages*numBudgetYears;
                spreadsheetData.splice(i+6, 0, [piType, year1HoursWorked, toDollar(hourlyRate), ...Array(numBudgetYears).fill(toDollar(yearlyWages)), toDollar(totalWagesForBudgetDuration)])
            }

            // Apply UI professional staff & Post Docs
            const uiStaffTBody = document.querySelector("#pro-staff-and-post-docs tbody")
            const uiStaffRows = uiStaffTBody.children;
            let aggregatedYear1HoursWorked = 0;
            let aggregatedYearlyWages = 0;
            for (const row of uiStaffRows) {
                const year1HoursWorked = calculateYearlyHoursWorkedFromRow(row);
                const yearlyWages = await calculateYearlyWagesWithFringeRateFromRowAsync(row);
                aggregatedYear1HoursWorked += year1HoursWorked;
                aggregatedYearlyWages += yearlyWages;
            }
            const totalWagesForBudgetDuration = aggregatedYearlyWages*numBudgetYears;
            const uiStaffSpreadsheetRow = spreadsheetData[getSpreadsheetRowIndexByLabel("Other Personnel") + 1];
            uiStaffSpreadsheetRow.push(aggregatedYear1HoursWorked, null, ...Array(numBudgetYears).fill(toDollar(aggregatedYearlyWages)), toDollar(totalWagesForBudgetDuration))

            const worksheet = XLSX.utils.aoa_to_sheet(spreadsheetData);

            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Budget");

            // GENERATED //
            // Adjust column widths
            const colWidths = [];
            for (let r = 0; r < spreadsheetData.length; r++) {
                const row = spreadsheetData[r];
                row.forEach((cell, c) => {
                    const cellStr = cell ? cell.toString() : '';
                    const len = cellStr.length;
                    colWidths[c] = Math.max(colWidths[c] || 10, len);
                });
            }
            worksheet['!cols'] = colWidths.map(w => ({ wch: w }));
            // GENERATED //

            XLSX.writeFile(workbook, budgetTitle.value + (budgetTitle.value !== "" ? "_" : "")  + "EZBudgets.xlsx")
        })
    </script>
</body>
</html>