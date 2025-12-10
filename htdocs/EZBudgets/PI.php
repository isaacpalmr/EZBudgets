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

        .include-label {
            background: #ffffff;        /* unchecked */
            color: #333;
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 2px 8px;
            margin: 2px 0;
            font-size: 0.85em;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* when checked */
        .include-label:has(.include-check:checked) {
            background: #46b5ffff;
            color: #000000ff;
            border-color: #3b94cfff;
        }

        .include-check {
            accent-color: #ffffffff;
            cursor: pointer;
        }

        .add_row {
            border-radius: 3px;
            padding: 0px 3px;
            padding-top: 3px;
            margin-left: 10px;
        }
        
        .rem_row {
            border-radius: 3px;
            padding: 0px 3px;
            padding-top: 3px;
            margin-left: 10px;
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

        .option {
            z-index: 9999; 
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
                                <th>Percent Effort<br><i style="font-weight: normal;  font-size: 0.85em;">of 40 hr week</i></th>
                                <th>Salary</th>
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
                                <th>Percent Effort<br><i style="font-weight: normal;  font-size: 0.85em;">of 40 hr week</i></th>
                                <th>Salary</th>
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
                                <th>Percent Effort<br><i style="font-weight: normal;  font-size: 0.85em;">of 40 hr week</i></th>
                                <th>Stipend<br><i style="font-weight: normal;  font-size: 0.85em;">per academic year</i></th>
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
                                <th>Percent Effort<br><i style="font-weight: normal;  font-size: 0.85em;">of 40 hr week, 50% max</i></th>
                                <th>Stipend<br><i style="font-weight: normal;  font-size: 0.85em;">per academic year</i></th>
                                <th>Tuition<br><i style="font-weight: normal;  font-size: 0.85em;">per academic year</i></th>
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
                                <th>Percent Effort<br><i style="font-weight: normal;  font-size: 0.85em;">of 40 hr week, 50% max</i></th>
                                <th>Stipend<br><i style="font-weight: normal;  font-size: 0.85em;">per academic year</i></th>
                                <th>Tuition<br><i style="font-weight: normal;  font-size: 0.85em;">per academic year</i></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div>
                    <table id="travel">
                        <caption>
                            Travel
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                                <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                                width="24" height="24">
                            </button>
                        </caption>
                        <thead>
                            <tr>
                                <th>Travel Type</th>
                                <th>Per Diem</th>
                                <th>Airfare</th>
                                <th>Number of Nights</th>
                                <th>Number of Travelers</th>
                                <th>Trip Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div>
                    <table id="itemized-costs">
                        <caption>
                            Itemized costs
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
                                <img src="Images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                                width="24" height="24">
                            </button>
                        </caption>
                        <thead>
                            <tr>
                                <th>Type</th>
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
                    <input id="downloadspreadsheet" type="button" value="Download Spreadsheet">
                    <input id="saveBudget" type="button" value="Save" style="margin-left:10px;">
                    <input id="save-and-close" type="button" value="Close and Save" style="margin-left:10px;">
                </div>
            </div>
        </div>
    </main>

    <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
    <script>
        async function fetchJson(url, opts = {}) {
            const resp = await fetch(url, opts);
            const text = await resp.text();
            // Helpful debug: if response isn't JSON this logs the raw server output
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error(`Invalid JSON from ${url} — response text:\n`, text);
                // rethrow something helpful to your existing try/catch
                throw new Error('Invalid JSON from server (see console for server output)');
            }
        }

        // At the very top of your existing <script> in PI.php
        const currentBudgetId = <?php echo isset($_GET['budget_id']) ? intval($_GET['budget_id']) : 0; ?>;
        window.currentBudgetId = currentBudgetId;

        //BUDGET LOAD HANDLER
        // --- loadBudget + on-ready hookup (replace the old version) ---
        async function loadBudget(budgetId) {
            if (!budgetId) return;

            try {
                // const resp = await fetch(`get_budget.php?budget_id=${budgetId}`);
                // const data = await resp.json();
                const data = await fetchJson(`get_budget.php?budget_id=${budgetId}`);

                if (!data.success) throw new Error(data.error || "Budget not found");

                    const budget = data.budget || {};
                    const personnel = data.personnel || [];
                    const travels = data.travels || [];
                    const items = data.items || [];


                    // Set global budget ID
                    window.currentBudgetId = parseInt(budget.budget_id || budgetId || window.currentBudgetId || 0);

                    // Populate top-level fields
                    budgetTitle.value = budget.budget_name ?? "";
                    budgetFundingSource.value = budget.funding_source ?? "";
                    budgetStartDate.value = budget.start_date ?? "";
                    budgetEndDate.value = budget.end_date ?? "";

                    // Recompute number of years (will recreate yearly-costs columns)
                    onNumBudgetYearsChanged();

                    // Table mapping: personnel_type -> table id
                    const personnelMap = {
                        "PI": "pi-table",
                        "staff": "pro-staff",
                        "postdoc": "post-docs",
                        "grad_assistant": "gras",
                        "undergrad_assistant": "ugrads",
                    };

                    // Clear all tables
                    Object.values(personnelMap).forEach(tid => {
                        const t = document.getElementById(tid);
                        if (t) t.querySelector("tbody").innerHTML = "";
                    });
                    

                    // Helper functions to fire events
                    const fireChange = el => el.dispatchEvent(new Event('change', { bubbles: true }));
                    const fireInput = el => el.dispatchEvent(new Event('input', { bubbles: true }));
                    
                    // Populate personnel rows
                    for (const p of personnel) {
                        const tid = personnelMap[p.personnel_type] || "pro-staff";
                        const table = document.getElementById(tid);
                        if (!table) continue;

                        const row = addRow(table);
                        const select = row.querySelector(".staff-picker");

                        // Only for PI/pro-staff do we simulate selection with TomSelect
                        if (select && select.tom && (p.personnel_type === "PI" || p.personnel_type === "staff")) {
                            select.tom.addOption({ value: String(p.personnel_id), text: p.name });

                            // Defer setValue to allow TomSelect to fully initialize
                            setTimeout(() => {
                                select.tom.setValue(String(p.personnel_id));

                                onStaffPickerSelect(row);
                            }, 0);
                        } else if (select) {
                            // Other tables: just set the raw value
                            const opt = document.createElement("option");
                            opt.value = p.personnel_id;
                            opt.textContent = p.name;
                            select.appendChild(opt);
                            select.value = p.personnel_id;
                            fireChange(select);
                        }

                        // Percent Effort
                        const percentEl = row.querySelector(".percent-effort");
                        if (percentEl) {
                            percentEl.disabled = false;
                            percentEl.value = p.percent_effort ?? 0;
                        }

                        // Stipend checkbox
                        const stipendCheckbox = row.querySelector(".request-stipend");
                        if (stipendCheckbox) {
                            stipendCheckbox.checked = !!Number(p.stipend_requested);
                            fireInput(stipendCheckbox);
                        }

                        // Stipend cell
                        const stipendAmountEl = row.querySelector(".stipend-amount");
                        if (stipendAmountEl) {
                            if ('value' in stipendAmountEl) stipendAmountEl.value = p.stipend_amount ?? 0;
                            else stipendAmountEl.textContent = toDollar(p.stipend_amount ?? 0);
                        }
                        onStaffPickerSelect(row);
                    }

                    // Clear travel and itemized-costs tables (use the actual IDs from your HTML)
                    ["travel", "itemized-costs"].forEach(tid => {
                        const t = document.getElementById(tid);
                        if (t) t.querySelector("tbody").innerHTML = "";
                    });

                    const travelTableEl = document.getElementById("travel");
                    if (travelTableEl) {
                        for (const t of travels) {
                            const row = addRow(travelTableEl);                    // <-- pass the table
                            const typeSelect = row.querySelector("select.type") || row.querySelector(".type");
                            if (typeSelect) typeSelect.value = t.travel_type || "";

                            const nightsEl = row.querySelector(".num-nights");
                            if (nightsEl) nightsEl.value = (t.num_nights ?? 0);

                            const travelersEl = row.querySelector(".num-travelers");
                            if (travelersEl) travelersEl.value = (t.num_travelers ?? 0);

                            // store id (optional) and recompute cost display
                            if (t.id) row.dataset.travelId = t.id;
                            const totalCostEl = row.querySelector(".total-cost");
                            if (totalCostEl) totalCostEl.textContent = toDollar(calculateTotalTravelCostFromRow(row));
                        }
                    }

                    // --- Populate Itemized Costs Table ---
                    const itemsTableEl = document.getElementById("itemized-costs");
                    if (itemsTableEl) {
                        for (const i of items) {
                            const row = addRow(itemsTableEl);  // pass table
                            const itemSelect = row.querySelector("select.type");
                            if (itemSelect) itemSelect.value = i.item_type ?? "";

                            const nameEl = row.querySelector(".name");
                            if (nameEl) nameEl.value = i.name ?? "";

                            const qtyEl = row.querySelector(".quantity");
                            if (qtyEl) qtyEl.value = i.quantity ?? 0;

                            const unitCostEl = row.querySelector(".unit-cost");
                            if (unitCostEl) unitCostEl.value = i.unit_cost ?? 0;

                            if (i.id) row.dataset.itemId = i.id;
                            const totalCostEl = row.querySelector(".total-cost");
                            if (totalCostEl) totalCostEl.textContent = toDollar(calculateTotalItemCostFromRow(row));
                        }
                    }


                    // Recalculate totals
                    updateYearlyCosts();

            } catch (err) {
                console.error("Error loading budget:", err);
                showError("Failed to load budget: " + (err.message || err));
            }
        }

        /* // Call loadBudget on DOM ready — prefer currentBudgetId or budget_id query param
        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            const queryBudgetId = urlParams.get("budget_id");
            const effectiveId = Number(window.currentBudgetId || queryBudgetId || 0);
                if (effectiveId > 0) {
                    loadBudget(effectiveId);
                }
        });

        // On page load
        document.addEventListener("DOMContentLoaded", () => {
            if (window.currentBudgetId) {
                loadBudget(window.currentBudgetId);
            } else {
                // Optionally, check query string
                const urlParams = new URLSearchParams(window.location.search);
                const bid = urlParams.get("budget_id");
                if (bid) loadBudget(bid);
            }
        }); */

        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            const queryBudgetId = Number(urlParams.get("budget_id") || 0);
            const effectiveId = Number(window.currentBudgetId || queryBudgetId);

            if (effectiveId > 0) {
                loadBudget(effectiveId)
                .then(() => {
                    // Updating/adding first PI row
                    const piTable = document.querySelector("#pi-table");
                    const piBody = piTable.querySelector("tbody");
                    let piRow;
                    if (piBody.children.length === 0) {
                        piRow = addRow(piTable, 1);
                    } else {
                        piRow = piBody.firstElementChild;
                    }
                    piRow.querySelector(".type").textContent = "PI";
                    const tom = piRow.querySelector(".staff-picker").tom
                    tom.settings.placeholder = "Select PI";
                    tom.inputState();
                    piRow.lastElementChild.remove() // Remove the remove button
                })
            }
        });

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
                    <td class="salary">$0.00</td>
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
                    <td class="salary">$0.00</td>
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
                    <td><input class="percent-effort" type="number" value="0" min="0" max="100"></td>
                    <td class="stipend-amount"><p>$0.00<p></td>
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
                    <td><input class="percent-effort" type="number" value="0" min="0" max="50" disabled></td>
                    <td class="stipend-amount">
                        <p style="margin: 0; padding: 0">$0.00</p>

                        <label class="include-label">
                            <input class="include-check" type="checkbox">
                            Include?
                        </label>
                    </td>
                    <td class="tuition-amount">
                        <p style="margin: 0; padding: 0">$0.00</p>

                        <label class="include-label">
                            <input class="include-check" type="checkbox">
                            Include?
                        </label>
                    </td>
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
                    <td><input class="percent-effort" type="number" value="0" min="0" max="50" disabled></td>
                    <td class="stipend-amount">
                        <p style="margin: 0; padding: 0">$0.00</p>

                        <label class="include-label">
                            <input class="include-check" type="checkbox">
                            Include?
                        </label>
                    </td>
                    <td class="tuition-amount">
                        <p style="margin: 0; padding: 0">$0.00</p>

                        <label class="include-label">
                            <input class="include-check" type="checkbox">
                            Include?
                        </label>
                    </td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
            "travel": `
                <tr>
                    <td>
                        <select class="type">
                            <option value="">Select Travel Type</option>
                            <option value="Domestic">Domestic</option>
                            <option value="International">International</option>
                        </select>
                    </td>
                    <td class="per-diem">$0.00</td>
                    <td class="airfare">$0.00</td>
                    <td><input class="num-nights" type="number" value="0" min="0" max="0"></td>
                    <td><input class="num-travelers" type="number" value="0" min="0"></td>
                    <td class="total-cost">$0.00</td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
            "itemized-costs": `
                <tr>
                    <td>
                        <select class="type">
                            <option value="">Select Item Type</option>
                            <option value="Equipment">Equipment</option>
                            <option value="Materials & Supplies">Materials & Supplies</option>
                            <option value="Publication Costs">Publication Costs</option>
                            <option value="Computer Services">Computer Services</option>
                            <option value="Software">Software</option>
                            <option value="Facility Useage Fees">Facility Useage Fees</option>
                            <option value="Conference Registration">Conference Registration</option>
                        </select>
                    </td>
                    <td><input class="name" type="text"></td>
                    <td><input class="quantity" type="number" value="0" min="0"></td>
                    <td><input class="unit-cost" type="number" value="0" min="0"></td>
                    <td class="total-cost">$0.00</td>
                    <td>
                        <button class="rem_row" style="background-color: rgb(255, 82, 82); border-width: 1px;">
                            <img src="Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                        </button>
                    </td>
                </tr>
            `,
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
        const staffPickerSelected = new Map()

        let travelProfiles;

        function findOptionByText(select, textToFind) {
            const lowerText = textToFind.toLowerCase();

            for (const option of Object.values(select.tom.options)) {
                if (option.text && option.text.toLowerCase() === lowerText) {
                    return option;
                }
            }
            return null;
        }

        function unhideStaffPickerOpt(select, staffId, staffName, staffUniqueKey) {
            const hidden = select.hiddenOptions || []
            const foundIdx = hidden.indexOf(staffUniqueKey)
            if (foundIdx === -1) {
                return
            } else {
                hidden.splice(foundIdx, 1)
            }

            select.tom.addOption({
                value: staffId,
                text: staffName
            });
        }

        function hideStaffPickerOpt(select, staffId, staffName, staffUniqueKey) {
            const hidden = select.hiddenOptions || []
            if (!findOptionByText(select, staffName)) {
                return;
            }

            select.tom.removeOption(staffId);

            if (hidden.indexOf(staffUniqueKey) === -1) {
                hidden.push(staffUniqueKey)
            }
        };

        // Staff picker dropdown logic. Note: Staff means personnel here
        function onStaffPickerSelect(row) {
            const table = row.closest("table");
            const select = row.querySelector(".staff-picker");
            if (!select) return;
            
            const personnelType = tableIdToPersonnelType[table.id];
            const staffId = select.tom.getValue()
            const staffName = staffId && select.tom.getOption(staffId).textContent.trim()
            const staffUniqueKey = staffId ? `${personnelType}-${staffId}` : null;

            const [lastStaffId, lastStaffName, lastStaffUniqueKey] = select.currSelected
            select.currSelected = [staffId, staffName, staffUniqueKey]

            const otherStaffPickers = Array.from(document.querySelectorAll("select.staff-picker")).filter(other => other !== select)

            if (lastStaffUniqueKey && lastStaffUniqueKey !== staffUniqueKey) { // Add the previous selected id back to the other staff pickers
                staffPickerSelected.delete(lastStaffUniqueKey)

                otherStaffPickers.forEach(otherSelect => {
                    console.log("unhide", lastStaffName)
                    unhideStaffPickerOpt(otherSelect, lastStaffId, lastStaffName, lastStaffUniqueKey)})
            }

            if (!staffUniqueKey) {
                const stipendAmount = row.querySelector(".stipend-amount p");
                if (stipendAmount) {
                    stipendAmount.textContent = toDollar(0);
                }
                
                const tuitionAmount = row.querySelector(".tuition-amount p");
                if (tuitionAmount) {
                    tuitionAmount.textContent = toDollar(0);
                }

                const salary = row.querySelector(".salary");
                if (salary) {
                    salary.textContent = toDollar(0)
                }

                const title = row.querySelector(".title");
                if (title) {
                    title.textContent = "—";
                }

                updateYearlyCosts();
            } else {
                staffPickerSelected.set(staffUniqueKey, [staffId, staffName, staffUniqueKey])

                otherStaffPickers.forEach(otherSelect => {
                    console.log("hide", staffName)
                    hideStaffPickerOpt(otherSelect, staffId, staffName, staffUniqueKey)})

                fetch(`get_single_personnel.php?personnelType=${personnelType}&personnelId=${staffId}`)
                    .then(r => r.json())
                    .then(data => {
                        const stipendAmount = row.querySelector(".stipend-amount p");
                        if (stipendAmount) {
                            stipendAmount.textContent = toDollar(data.stipend_per_academic_year ?? 0);
                        }

                        const tuitionAmount = row.querySelector(".tuition-amount p");
                        if (tuitionAmount) {
                            tuitionAmount.textContent = toDollar(data.tuition_per_academic_year ?? 0);
                            tuitionAmount.dataset.tuitionIncreasePct = data.projected_tuition_increase_pct ?? 0
                        }

                        const salary = row.querySelector(".salary");
                        if (salary) {
                            salary.textContent = toDollar(data.salary ?? 0)
                        }

                        const title = row.querySelector(".title");
                        if (title) {
                            title.textContent = data.staff_title ?? "—";
                        }

                        updateYearlyCosts();
                    });
            }
        }

        function initializeStaffPicker(select) {
            select.tom = new TomSelect(select, {
                maxItems: 1,
                create: false,
                dropdownParent: "body"
            });
            select.currSelected = []
            select.hiddenOptions = []
            select.tom.on("change", () => onStaffPickerSelect(row))
            select.tom.input.addEventListener("input", () => {
                if (!select.tom.getValue()) { // See if cleared using backspace/del
                    onStaffPickerSelect(row);
                }
            });

            const table = select.closest("table");
            const row = select.closest("tr");
            const filter = select.dataset.filter;

            fetch(`get_personnel_list.php?filter=${filter}`)
                .then(res => res.json())
                .then(rows => {
                    rows.forEach(r => {
                        select.tom.addOption({
                            value: r.id,
                            text: r.name
                        })
                    });

                    Array.from(staffPickerSelected.values()).forEach(([staffId, staffName, staffUniqueKey]) => {
                        console.log(staffId, staffName, staffUniqueKey)
                        hideStaffPickerOpt(select, staffId, staffName, staffUniqueKey)
                    })
                });
        }

        // Item type picker dropdown logic
        function initializeItemPicker(select) {
            const table = select.closest("table");
            const row = select.closest("tr");

            row.dataset.originalHTML = row.innerHTML;

            const itemTypes = [
                "Equipment",
                "Materials & Supplies",
                "Publication Costs",
                "Computer Services",
                "Software",
                "Facility Useage Fees",
                "Conference Registration",
                "Other"
            ];

            itemTypes.forEach(itemType => {
                const opt = document.createElement("option");
                opt.value = itemType;
                opt.textContent = itemType;
                select.appendChild(opt);
            });

            const ts = new TomSelect(select, {
                maxItems: 1,
                create: false,
                dropdownParent: 'body'
            });

            // TODO: Add logic to this event
            ts.on("change", itemType => {
                if (!itemType) {
                    row.innerHTML = row.dataset.originalHTML; // Reset the row's values
                    return;
                }
            });
        }

        // Adds a row to the table, appending if 'pos' is null
        function addRow(table, pos) {
            const tbody = table.querySelector("tbody");

            if (pos && tbody.children.length > 0) {
                tbody.children[pos]?.insertAdjacentHTML("beforebegin", templateRows[table.id]);
            } else {
                tbody.insertAdjacentHTML("beforeend", templateRows[table.id]);
            }
            
            const staffPickerSelect = tbody.lastElementChild.querySelector(".staff-picker");
            if (staffPickerSelect) {
                initializeStaffPicker(staffPickerSelect);
            }
            
            const itemTypeSelect = tbody.lastElementChild.querySelector(".item-picker");
            if (itemTypeSelect) {
                initializeItemPicker(itemTypeSelect);
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

        function dollarToNumber(v) {
            return Number(v?.replace(/[$, ]+/g, ''));
        }

        function getPersonnelIdFromRow(row) {
            if (!row) return [null, 0];

            // Try to find the table containing the row; be defensive if closest() returns null
            let table = row.closest("table");
            if (!table && row.parentElement) {
                // fallback: maybe the row was inserted in a fragment — try parentElement.closest
                table = row.parentElement.closest ? row.parentElement.closest("table") : null;
            }

            // If still no table, return defaults to avoid crashes
            if (!table) {
                return [null, 0];
            }

            const personnelType = tableIdToPersonnelType[table.id] || "staff";
            const picker = row.querySelector(".staff-picker");
            const personnelId = picker ? picker.value : 0;

            return [personnelType, personnelId];
        }

        function getPercentEffortFromRow(row) {
            return row.querySelector(".percent-effort").value/100;
        }

        

        async function getFringeRateFromRowAsync(row) {
            const [personnelType, personnelId] = getPersonnelIdFromRow(row);
            const response = await fetch(`get_single_personnel.php?personnelType=${personnelType}&personnelId=${personnelId}`);
            const data = await response.json();
            return (data.fringe_rate ?? 0) / 100;
        }



        async function calculateYearlyWagesWithFringeRateFromRowAsync(row, yearIndex) {
            const salary = row.querySelector(".salary");
            if (salary) {
                const salaryNum = dollarToNumber(salary.textContent.trim())
                const percentEffort = getPercentEffortFromRow(row);
                const fringeRate = await getFringeRateFromRowAsync(row);
                const yearlyWages = (percentEffort*salaryNum) * (1+fringeRate);

                return yearlyWages;
            } else {
                const stipendAmount = row.querySelector(".stipend-amount p");
                const stipendIncludeCheckbox = stipendAmount.parentElement.querySelector(".include-check")
                const tuitionAmount = row.querySelector(".tuition-amount p");

                let fringeRate = null
                let yearlyWages = 0

                if (stipendAmount && (!stipendIncludeCheckbox || stipendIncludeCheckbox.checked)) {
                    const stipendAmountNum = dollarToNumber(stipendAmount.textContent);
                    const percentEffort = getPercentEffortFromRow(row);

                    fringeRate = await getFringeRateFromRowAsync(row);
                    yearlyWages = (percentEffort*stipendAmountNum) * (1+fringeRate);
                }

                if (tuitionAmount && tuitionAmount.parentElement.querySelector(".include-check").checked) {
                    const tuitionIncreasePct = Number(tuitionAmount.dataset.tuitionIncreasePct)
                    const tuitionAmountNum = dollarToNumber(tuitionAmount.textContent);

                    fringeRate = fringeRate || await getFringeRateFromRowAsync(row);
                    yearlyWages += tuitionAmountNum * (1 + tuitionIncreasePct)**(yearIndex ?? 0);
                }

                return yearlyWages;
            }
        }

        async function getTotalWagesForYearWithFringeRateAsync(yearIndex) {
            let totalWagesPerYear = 0;
            const usedRows = []

            const payFields = [...document.querySelectorAll(".salary"), ...document.querySelectorAll(".stipend-amount p"), ...document.querySelectorAll(".tuition-amount p")];
            for (const td of payFields) {
                const row = td.closest("tr");
                
                if (usedRows.indexOf(row) !== -1) {
                    continue
                }
                usedRows.push(row)

                const yearlyWages = await calculateYearlyWagesWithFringeRateFromRowAsync(row, yearIndex);

                if (yearlyWages > 0 && !isNaN(yearlyWages)) {
                    totalWagesPerYear += yearlyWages;
                }
            }

            return totalWagesPerYear;
        }

        function calculateTotalItemCostFromRow(row) {
            const quantity = row.querySelector(".quantity");
            const unitCost = row.querySelector(".unit-cost");

            return quantity.value * unitCost.value;
        }

        function calculateTotalTravelCostFromRow(row) {
            const travelType = row.querySelector(".type");
            const numNights = row.querySelector(".num-nights");
            const numTravelers = row.querySelector(".num-travelers");
            const perDiem = row.querySelector(".per-diem");
            const airfare = row.querySelector(".airfare");

            const travelProfile = travelProfiles?.[travelType.value];
            if (!travelProfile) return 0;

            numNights.max = travelProfile.max_lodging_days;
            if (Number(numNights.value) > numNights.max) {
                numNights.value = numNights.max;
            }

            airfare.textContent = toDollar(travelProfile.airfare)
            perDiem.textContent = toDollar(travelProfile.per_diem);

            const totalLodging = (numNights.value*numTravelers.value) * travelProfile.per_diem;;
            const totalAirfare = travelProfile.airfare * numTravelers.value;

            return totalLodging + totalAirfare;
        }

        function getTotalItemizedCosts() {
            const tbody = document.querySelector("#itemized-costs tbody");
            const rows = tbody.children;

            let totalItemizedCosts = 0;

            for (row of rows) {
                totalItemizedCosts += calculateTotalItemCostFromRow(row);
            }

            return totalItemizedCosts;
        }
        
        function getTotalTravelCosts() {
            const tbody = document.querySelector("#travel tbody");
            const rows = tbody.children;

            let totalTravelCosts = 0;

            for (row of rows) {
                totalTravelCosts += calculateTotalTravelCostFromRow(row);
            }

            return totalTravelCosts;
        }

        function updateYearlyCosts() {
            const totalItemizedCosts = getTotalItemizedCosts();
            const totalTravelCosts = getTotalTravelCosts();

            for (let yearIndex = 0; yearIndex < getNumBudgetYears(); yearIndex++) {
                getTotalWagesForYearWithFringeRateAsync(yearIndex)
                    .then(totalYearlyWages => {
                        const td = yearlyCostsTableBodyRow.children[yearIndex];
                        td.textContent = toDollar(totalYearlyWages + totalItemizedCosts + totalTravelCosts);
                    });
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
                if (row) {
                    const select = row.querySelector("select.staff-picker")
                    if (select && select.tom) {
                        select.tom.clear() // Deselect in order to allow other staff pickers to use name
                    }
                    row.remove()
                };
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

        // Listen for itemized costs changed
        document.addEventListener("input", event => {
            const table = event.target.closest("table");
            if (!table || table.id !== "itemized-costs") return;
            
            const row = event.target.closest("tr");
            const totalCost = row.querySelector(".total-cost");

            totalCost.textContent = toDollar(calculateTotalItemCostFromRow(row));

            updateYearlyCosts();
        })

        // Listen for travel input changes
        fetch("get_travel_profiles.php")
        .then(res => res.json())
        .then(data => {
            travelProfiles = data;
            
            // Listen for travel type/num days/num travelers changed
            document.addEventListener("input", event => {
                const table = event.target.closest("table");
                if (!table || table.id !== "travel") return;
                
                console.log("travel input");

                const row = event.target.closest("tr");
                const totalCost = row.querySelector(".total-cost");

                totalCost.textContent = toDollar(calculateTotalTravelCostFromRow(row));

                updateYearlyCosts();
            })
        })

        // Listen for stipend request button clicked
        document.addEventListener("input", event => {
            const checkbox = event.target;
            if (!checkbox.classList.contains("include-check")) return;

            const isStipendType = checkbox.closest(".stipend-amount"); // As opposed to tuition type

            if (isStipendType) {
                const row = checkbox.closest("tr");
                const percentEffort = row.querySelector(".percent-effort");

                if (checkbox.checked) {
                    percentEffort.disabled = false;
                } else {
                    percentEffort.value = 0;
                    percentEffort.disabled = true;
                }
            }

            updateYearlyCosts();
        })

        // Download spreadsheet
        downloadButton.addEventListener("click", async () => {
            // Create spreadsheet data table
            const spreadsheetData = [
                ["Title: "],
                ["Funding Source: "],
                ["PI: ",                   "Co-PIs: "],
                ["Project Start and End Dates: "],
                ["",                                    "",                 "Salary"],
                ["Personnel Compensation",              "Percent Effort"],
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
                [],
                ["Consortia/Subawards"],
                [],
                ["Total Direct Cost"],
                ["Back out GRA T&F"],
                ["Back out capital EQ"],
                ["Back out subawards totals"],
                ["Modified Total Direct Costs"],
                ["Indirect Costs",                      "50.0%"],
                ["Total Project Cost"],
            ];

            function getSpreadsheetRowIndexByLabel(label) {
                return spreadsheetData.findIndex(row => row[0] === label);
            }

            function pushRepeatYearlyCost(rowIndex, insertColumnIndex, yearlyCost) {
                if (yearlyCost === 0) return;

                const spreadsheetRow = spreadsheetData[rowIndex];
                
                // Calculate how many empty cells are needed to reach the insert index
                const gapSize = insertColumnIndex - spreadsheetRow.length;

                // If there is a gap, fill it with empty strings in one go
                if (gapSize > 0) {
                    spreadsheetRow.push(...Array(gapSize).fill(""));
                }

                // Insert the yearly cost data
                spreadsheetRow.splice(insertColumnIndex, 0, ...Array(numBudgetYears).fill(toDollar(yearlyCost)), toDollar(yearlyCost * numBudgetYears));
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
            // Apply principal investigators
            const piRows = piTableBody.children;
            for (let i = 0; i < piRows.length; i++) {
                const row = piRows[i];
                const piType = row.querySelector(".type").textContent.trim();

                // percent-effort calculation is done inside calculateYearlyWagesWithFringeRateFromRowAsync
                const yearlyWages = await calculateYearlyWagesWithFringeRateFromRowAsync(row);
                if (!yearlyWages || yearlyWages === 0) continue;

                const totalWagesForBudgetDuration = yearlyWages * numBudgetYears;

                // Insert: [ Role, Year1, Year2, ..., Total ]
                spreadsheetData.splice(i+6,0,[piType,...Array(numBudgetYears).fill(toDollar(yearlyWages)),toDollar(totalWagesForBudgetDuration)]);
            }


            async function pushOtherPersonnelAggregationDataAsync(t1Id, t2Id, rowOffset) {
                const t1Rows = document.querySelector(`#${t1Id} tbody`).children;
                const t2Rows = document.querySelector(`#${t2Id} tbody`).children;

                let aggregatedYearlyWages = Array(numBudgetYears).fill(0);
                let allPromises = [];

                for (const row of [...t1Rows, ...t2Rows]) {
                    for (let i = 0; i < numBudgetYears; i++) {
                        const p = calculateYearlyWagesWithFringeRateFromRowAsync(row, i)
                            .then(yearlyWages => {
                                aggregatedYearlyWages[i] += yearlyWages;
                            });
                        allPromises.push(p);
                    }
                }

                await Promise.all(allPromises);

                if (aggregatedYearlyWages[0] > 0) {
                    let totalWagesForBudgetDuration = aggregatedYearlyWages.reduce((acc, val) => acc + val, 0);
                    let spreadsheetRow = spreadsheetData[getSpreadsheetRowIndexByLabel("Other Personnel") + rowOffset];

                    aggregatedYearlyWages = aggregatedYearlyWages.map(toDollar);

                    // Push only yearly columns + total (no hours, no hourly blank)
                    spreadsheetRow.push(
                        ...aggregatedYearlyWages,
                        toDollar(totalWagesForBudgetDuration)
                    );
                }
            }


            // Apply UI professional staff & Post Docs
            await pushOtherPersonnelAggregationDataAsync("pro-staff", "post-docs", 1);
            
            // Apply GRAs/UGrads
            await pushOtherPersonnelAggregationDataAsync("gras", "ugrads", 2);
            
            // Apply domestic & international travel costs
            const travelSpreadsheetRowIndex = getSpreadsheetRowIndexByLabel("Travel");
            const travelRows = document.querySelector("#travel tbody").children;
            let aggregatedDomesticCost = 0;
            let aggregatedInternationalCost = 0;
            for (const row of travelRows) {
                const select = row.querySelector("select");
                if (select.value === "International") {
                    aggregatedInternationalCost += calculateTotalTravelCostFromRow(row);
                } else if (select.value === "Domestic") {
                    aggregatedDomesticCost += calculateTotalTravelCostFromRow(row);
                }
            }
            pushRepeatYearlyCost(travelSpreadsheetRowIndex + 1, 3, aggregatedDomesticCost);
            pushRepeatYearlyCost(travelSpreadsheetRowIndex + 2, 3, aggregatedInternationalCost);

            // Apply itemized costs
            const itemizedRows = document.querySelector("#itemized-costs tbody").children;
            const itemTypeToRowLabel = {
                "Materials & Supplies": "Materials and supplies",
                "Publication Costs": "Publication costs",
                "Computer Services": "Computer services",
                "Software": "Software",
                "Facility Useage Fees": "Facility useage fees",
                "Conference Registration": "Conference registration",
                "Other": "Other"
            }
            const rowLabelToAggregatedCost = new Map();
            const bigEquipmentRows = [];
            for (const row of itemizedRows) {
                const select = row.querySelector("select");
                const itemType = select.value;
                if (itemType === "") continue;

                const rowCost = calculateTotalItemCostFromRow(row);

                if (itemType === "Equipment") {
                    const unitCost = Number(row.querySelector(".unit-cost").value);
                    if (unitCost >= 5000) {
                        bigEquipmentRows.push(row);
                    } else {
                        const label = "<$5K small equipment";
                        const old = rowLabelToAggregatedCost.get(label) ?? 0;
                        rowLabelToAggregatedCost.set(label, old + rowCost);
                    }
                } else {
                    const label = itemTypeToRowLabel[itemType];
                    const old = rowLabelToAggregatedCost.get(label) ?? 0;
                    rowLabelToAggregatedCost.set(label, old + rowCost);
                }
            }
            for (const [k, v] of rowLabelToAggregatedCost) {
                pushRepeatYearlyCost(getSpreadsheetRowIndexByLabel(k), 3, v);
            }

            const equipmentLabelRowIndex = getSpreadsheetRowIndexByLabel("Equipment > $5000.00");
            for (let i = 0; i < bigEquipmentRows.length; i++) {
                const row = bigEquipmentRows[i];
                const qty = row.querySelector(".quantity")?.value;
                let name = row.querySelector(".name").value;
                if (qty && qty > 1) {
                    name += " x" + qty;
                }
                const rowCost = calculateTotalItemCostFromRow(row);
                spreadsheetData.splice(equipmentLabelRowIndex + i + 1, 0, [name, null, null, ...Array(numBudgetYears).fill(toDollar(rowCost)), toDollar(rowCost * numBudgetYears)])
            }

            // Apply grad student tuition

            const worksheet = XLSX.utils.aoa_to_sheet(spreadsheetData);

            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Budget");

            // GENERATED //
            // ---------------------------------------------------------
            // 1. ADJUST COLUMN WIDTHS
            // ---------------------------------------------------------
            const colWidths = [];
            
            for (let r = 0; r < spreadsheetData.length; r++) {
                const row = spreadsheetData[r];
                for (let c = 0; c < row.length; c++) {
                    const cell = row[c];
                    if (cell === null || cell === undefined) continue; 
                    const len = cell.toString().length + 3; 
                    colWidths[c] = Math.max(colWidths[c] || 10, len);
                }
            }
            worksheet['!cols'] = colWidths.map(w => ({ wch: w }));

            // ---------------------------------------------------------
            // 2. DEFINE STYLE LISTS
            // ---------------------------------------------------------
            
            // A. DARK GRAY Row Background (D9D9D9)
            const grayRowTriggers = [
                "Personnel Compensation",
                "Other Personnel",
                "Fringe",
                "Equipment > $5000.00",
                "Travel",
                "Participant support costs (NSF only)",
                "Other Direct Costs",
                "Consortia/Subawards",
                "Total Project Cost"
            ];

            // B. LIGHT GRAY Row Background (F2F2F2)
            const lightGrayRowTriggers = [
                "Back out subawards totals",
            ];

            // C. ENTIRE ROW UNDERLINE (Bottom Border)
            const rowUnderlineTriggers = [
                "Indirect Costs"
            ];

            // D. TEXT: BOLD + UNDERLINE (Specific cells)
            const boldUnderlineLabels = [
                "Personnel Compensation",
                "Other Personnel",
                "Fringe",
                "Equipment > $5000.00",
                "Travel",
                "Participant support costs (NSF only)",
                "Other Direct Costs",
                "Consortia/Subawards",
                "Year 1 Salary",
                "FY26 Fringe Rates",
            ];

            // E. TEXT: BOLD ONLY (Specific cells)
            const boldOnlyLabels = [
                "Total Project Cost",
                "Salary",
                "Modified Total Direct Costs",
                "Indirect Costs",
                "Total",
                "Year 1", "Year 2", "Year 3", "Year 4", "Year 5"
            ];

            // ---------------------------------------------------------
            // 3. MAIN LOOP
            // ---------------------------------------------------------
            const range = XLSX.utils.decode_range(worksheet['!ref']);

            for (let R = range.s.r; R <= range.e.r; ++R) {
                
                // --- CHECK ROW-LEVEL TRIGGERS (Based on Column A value) ---
                let isGrayRow = false;
                let isLightGrayRow = false;
                let isRowUnderline = false;

                const firstColRef = XLSX.utils.encode_cell({c: 0, r: R});
                
                if (worksheet[firstColRef]) {
                    const label = worksheet[firstColRef].v;
                    if (grayRowTriggers.includes(label)) isGrayRow = true;
                    else if (lightGrayRowTriggers.includes(label)) isLightGrayRow = true; // Else-if prevents double coloring
                    
                    if (rowUnderlineTriggers.includes(label)) isRowUnderline = true;
                }

                // --- ITERATE COLUMNS ---
                for (let C = range.s.c; C <= range.e.c; ++C) {
                    const cell_ref = XLSX.utils.encode_cell({c: C, r: R});
                    
                    // Create stub cell if needed for background/borders to span whole row
                    if (!worksheet[cell_ref]) {
                        if (isGrayRow || isLightGrayRow || isRowUnderline) {
                            worksheet[cell_ref] = { t: 's', v: '' };
                        } else {
                            continue;
                        }
                    }
                    
                    const cell = worksheet[cell_ref];
                    const val = cell.v ? cell.v.toString().trim() : "";

                    if (!cell.s) cell.s = {};

                    // 1. Apply Background Color
                    if (isGrayRow) {
                        cell.s.fill = { fgColor: { rgb: "D9D9D9" } }; 
                    } else if (isLightGrayRow) {
                        cell.s.fill = { fgColor: { rgb: "F2F2F2" } }; 
                    }

                    // 2. Apply Row Bottom Border
                    if (isRowUnderline) {
                        if (!cell.s.border) cell.s.border = {};
                        cell.s.border.bottom = { style: "thin", color: { rgb: "000000" } };
                    }

                    // 3. Apply Text Styling
                    if (boldUnderlineLabels.includes(val)) {
                        if (!cell.s.font) cell.s.font = {};
                        cell.s.font.bold = true;
                        cell.s.font.underline = true;
                    } 
                    else if (boldOnlyLabels.includes(val)) {
                        if (!cell.s.font) cell.s.font = {};
                        cell.s.font.bold = true;
                    }

                    // 4. Apply Number Formatting
                    if (cell.t === 'n') {
                        cell.z = '0.00'; 
                        cell.s.alignment = { horizontal: "center", vertical: "center" };
                    }
                    else if (val.startsWith('$')) {
                        const rawNum = parseFloat(val.replace(/[$,]/g, ''));
                        if (!isNaN(rawNum)) {
                            cell.v = rawNum.toLocaleString("en-US", { 
                                style: "currency", 
                                currency: "USD", 
                                minimumFractionDigits: 2, 
                                maximumFractionDigits: 2 
                            });
                        }
                        cell.s.alignment = { horizontal: "center", vertical: "center" };
                    }
                    else if (val.endsWith('%')) {
                        const rawNum = parseFloat(val.replace(/[%]/g, ''));
                        if (!isNaN(rawNum)) {
                            cell.v = rawNum.toFixed(2) + "%";
                        }
                        cell.s.alignment = { horizontal: "center", vertical: "center" };
                    }
                }
            }
            // GENERATED //

            XLSX.writeFile(workbook, budgetTitle.value + (budgetTitle.value !== "" ? "_" : "")  + "EZBudgets.xlsx")
        })

        async function collectAndSaveAsync(clickedButton) {
            clearError();

            // Validate dates
            if (!budgetStartDate.value || !budgetEndDate.value) {
                showError("Please enter budget start and end dates before saving.");
                return;
            }

            function parseMoney(text) {
                if (!text) return 0;
                const s = ("" + text).replace(/[$,]/g, '').trim();
                const n = parseFloat(s);
                return isNaN(n) ? 0 : n;
            }

            const payload = {
                budget_id: window.currentBudgetId || 0,
                budget_name: budgetTitle.value || "",
                funding_source: budgetFundingSource.value || "",
                start_date: budgetStartDate.value,
                end_date: budgetEndDate.value,
                personnel: [],
                travels: [],
                items: []
            };

            // Collect personnel rows (keep your existing code)
            function collectTableRows(tableId) {
                const rows = [];
                const table = document.getElementById(tableId);
                if (!table) return rows;

                for (const r of table.querySelectorAll("tbody tr")) {
                    const picker = r.querySelector(".staff-picker");
                    const personnelId = picker ? parseInt(picker.value || 0) : 0;

                    const percentEl = r.querySelector(".percent-effort");
                    const percentVal = percentEl ? parseInt(percentEl.value || 0) : 0;
                    const stipendCheckbox = r.querySelector(".request-stipend");
                    const stipendRequested = stipendCheckbox ? (stipendCheckbox.checked ? 1 : 0) : 0;
                    const stipendAmountEl = r.querySelector(".stipend-amount");
                    const stipendAmount = stipendAmountEl ? parseMoney(stipendAmountEl.textContent || stipendAmountEl.value) : 0;

                    let ptype = "staff";
                    if (tableId === "pi-table") ptype = "PI";
                    else if (tableId === "pro-staff") ptype = "staff";
                    else if (tableId === "post-docs") ptype = "postdoc";
                    else if (tableId === "gras") ptype = "grad_assistant";
                    else if (tableId === "ugrads") ptype = "undergrad_assistant";

                    if (personnelId === 0 && percentVal === 0 && stipendRequested === 0 && stipendAmount === 0) continue;

                    rows.push({
                        personnel_type: ptype,
                        personnel_id: personnelId,
                        percent_effort: percentVal,
                        stipend_requested: stipendRequested,
                        stipend_amount: stipendAmount
                    });
                }
                return rows;
            }

            payload.personnel = payload.personnel.concat(
                collectTableRows("pi-table"),
                collectTableRows("pro-staff"),
                collectTableRows("post-docs"),
                collectTableRows("gras"),
                collectTableRows("ugrads")
            );

            // --- Travel ---
            const travelTable = document.getElementById("travel");
            if (travelTable) {
                for (const r of travelTable.querySelectorAll("tbody tr")) {
                    const type = r.querySelector(".type")?.value || "";
                    const nights = parseInt(r.querySelector(".num-nights")?.value || 0);
                    const travelers = parseInt(r.querySelector(".num-travelers")?.value || 0);
                    const id = r.dataset.travelId ? parseInt(r.dataset.travelId) : 0;

                    if (!type && nights === 0 && travelers === 0) continue;
                    payload.travels.push({
                        id,
                        travel_type: type,
                        num_nights: nights,
                        num_travelers: travelers
                    });
                }
            }

            // --- Itemized Costs ---
            const itemsTable = document.getElementById("itemized-costs");
            if (itemsTable) {
                for (const r of itemsTable.querySelectorAll("tbody tr")) {
                    const type = r.querySelector(".type")?.value || "";
                    const name = r.querySelector(".name")?.value || "";
                    const qty = parseInt(r.querySelector(".quantity")?.value || 0);
                    const unitCost = parseMoney(r.querySelector(".unit-cost")?.value || "0");
                    const id = r.dataset.itemId ? parseInt(r.dataset.itemId) : 0;

                    if (!type && !name && qty === 0 && unitCost === 0) continue;
                    payload.items.push({
                        id,
                        item_type: type,
                        name,
                        quantity: qty,
                        unit_cost: unitCost
                    });
                }
            }

            const saveBtn = document.getElementById("saveBudget");
            if (clickedButton === saveBtn) {
                saveBtn.disabled = true;
                saveBtn.value = "Saving...";
            }
            
            console.log("Saving budget payload:", payload);

            try {
                const resp = await fetch('save_budget.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await resp.json();
                if (!result.success) throw new Error(result.error || 'Unknown server error');

                if (clickedButton === saveBtn) {
                    saveBtn.value = "Saved ✓";
                    setTimeout(() => {
                        saveBtn.disabled = false;
                        saveBtn.value = "Save budget";
                    }, 1200);
                }

                if (result.budget_id) {
                    payload.budget_id = result.budget_id;
                    window.currentBudgetId = result.budget_id;
                }

            } catch (err) {
                showError("Save failed: " + err.message);
                saveBtn.disabled = false;
                saveBtn.value = "Save budget";
                return;
            }

            return true;
        }

        document.getElementById("saveBudget").addEventListener("click", () => {
            collectAndSaveAsync(document.querySelector("#saveBudget"));
        });
        document.getElementById("save-and-close").addEventListener("click", () => {
            collectAndSaveAsync(document.querySelector("#save-and-close"))
                .then(success => {
                    if (success) {
                        location.href = "dashboard.php";
                    }
                });
        });
        
        </script>
    </body>
</html>