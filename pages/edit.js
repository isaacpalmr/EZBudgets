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
                <button class="rem_row dark-border">
                    <img src="../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
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
                <button class="rem_row dark-border">
                    <img src="../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
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
                <button class="rem_row dark-border">
                    <img src="../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
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
                <button class="rem_row dark-border">
                    <img src="../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
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
                <button class="rem_row dark-border">
                    <img src="../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
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
                <button class="rem_row dark-border">
                    <img src="../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
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
                <button class="rem_row dark-border">
                    <img src="../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
                </button>
            </td>
        </tr>
    `,
    "subawards": `
        <tr>
            <td><input class="name" type="text"></td>
            <td class="total-cost">$0.00</td>
            <td>
                <button class="edit_subaward dark-border" style="width: 32px; height: 32px">
                    <img src="../images/pencil.png" width="20" height="20">
                </button>
            </td>
            <td>
                <button class="rem_row dark-border">
                    <img src="../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
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
                <button class="rem_row dark-border">
                    <img src="../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png" width="24" height="24">
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

// URL Params
const urlParams = new URLSearchParams(window.location.search);
const currentBudgetId = Number(urlParams.get("budget_id")) || 0;
console.log(currentBudgetId)
const primeBudgetId = Number(urlParams.get("primeBudgetId")) || 0;
const subawardInstitution = urlParams.get("subawardInstitution") || "";
const budgetStartDateStr = urlParams.get("budgetStartDateStr") || ""
const budgetEndDateStr = urlParams.get("budgetStartDateStr") || ""
const budgetFundingSourceStr = urlParams.get("budgetFundingSourceStr") || ""
const numBudgetYears = Number(urlParams.get("numBudgetYears")) || 0;

const maxYearlyBillableHours = 2080
const yearlyCostsTableBodyRow = document.querySelector("#yearly_costs tbody tr");
const yearlyCostsTableCaption = document.querySelector("#yearly_costs caption");
const yearlyCostsTableHeaderRow = document.querySelector("#yearly_costs thead tr");
const budgetTitle = document.querySelector("#budget-title input");
const isPrimeBudget = Boolean(budgetTitle);
const downloadButton = document.getElementById("downloadspreadsheet");
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

function getTodayString() {
    const d = new Date();
    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, '0'); // months are 0-based
    const dd = String(d.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
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

function getStaffPickerSelectedName(row) {
    const select = row.querySelector(".staff-picker");
    const staffId = select.tom.getValue()
    const staffName = staffId && select.tom.getOption(staffId).textContent.trim()
    return staffName
}

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
            // console.log("unhide", lastStaffName)
            unhideStaffPickerOpt(otherSelect, lastStaffId, lastStaffName, lastStaffUniqueKey)})
    }

    if (!staffUniqueKey) {
        emptyData = {}
        populatePersonnelRow(row, emptyData)
    } else {
        staffPickerSelected.set(staffUniqueKey, [staffId, staffName, staffUniqueKey])

        otherStaffPickers.forEach(otherSelect => {
            // console.log("hide", staffName)
            hideStaffPickerOpt(otherSelect, staffId, staffName, staffUniqueKey)})

        fetch(`../php/get_single_personnel.php?personnelType=${personnelType}&personnelId=${staffId}`)
            .then(r => r.json())
            .then(data => populatePersonnelRow(row, data))
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

    return fetch(`../php/get_personnel_list.php?html_table_id=${table.id}`)
        .then(res => res.json())
        .then(rows => {
            rows.forEach(r => {
                select.tom.addOption({
                    value: r.id,
                    text: r.name
                })
            });

            Array.from(staffPickerSelected.values()).forEach(([staffId, staffName, staffUniqueKey]) => {
                // console.log(staffId, staffName, staffUniqueKey)
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
// Only asynchronous if the row has a staff picker
async function addRow(table, pos) {
    const tbody = table.querySelector("tbody");

    if (pos && tbody.children.length > 0) {
        tbody.children[pos]?.insertAdjacentHTML("beforebegin", templateRows[table.id]);
    } else {
        tbody.insertAdjacentHTML("beforeend", templateRows[table.id]);
    }
    
    const row = tbody.lastElementChild

    const staffPickerSelect = row.querySelector(".staff-picker");
    if (staffPickerSelect) {
        await initializeStaffPicker(staffPickerSelect);
    }
    
    const editSubaward = row.querySelector(".edit_subaward")
    if (editSubaward) {
        editSubaward.addEventListener("click", async () => {
            await collectAndSave();

            const primeBudgetTitle = document.querySelector("#budget-title input").value
            const subawardInstitution = row.querySelector(".name").value
            const subbudgetId = row.dataset.subbudget_id
            
            const params = new URLSearchParams({
                primeBudgetTitle: primeBudgetTitle,
                primeBudgetId: currentBudgetId,
                budget_id: subbudgetId,
                subawardInstitution: subawardInstitution,
                numBudgetYears: getNumBudgetYears(),
                budgetStartDateStr: document.querySelector("#budget-start-date input").value || getTodayString(),
                budgetEndDateStr: document.querySelector("#budget-end-date input").value || getTodayString(),
                budgetFundingSourceStr: budgetFundingSource.value || ""
            });

            window.location.href = `edit_subaward.php?${params.toString()}`;
        })
    }

    const itemTypeSelect = row.querySelector(".item-picker");
    if (itemTypeSelect) {
        initializeItemPicker(itemTypeSelect);
    } 

    return row;
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

function calculateYearlyHoursWorkedFromRow(row) {
    // const weeklyHoursWorked = Number(getPercentEffortFromRow(row) * 40);
    // const yearlyHoursWorked = weeklyHoursWorked * 52.1429;
    // return yearlyHoursWorked;
    return getPercentEffortFromRow(row) * maxYearlyBillableHours;
}

async function getFringeRateFromRow(row) {
    const [personnelType, personnelId] = getPersonnelIdFromRow(row);
    const response = await fetch(`../php/get_single_personnel.php?personnelType=${personnelType}&personnelId=${personnelId}`);
    const data = await response.json();
    return (data.fringe_rate ?? 0) / 100;
}

async function calculateHourlyRateWithFringeRateFromRow(row) {
    const salary = row.querySelector(".salary");
    const stipendAmount = row.querySelector(".stipend-amount p");
    if (salary) {
        const salaryNum = dollarToNumber(salary.textContent.trim())
        const fringeRate = await getFringeRateFromRow(row);
        const yearlyPay = salaryNum * (1+fringeRate);
        const hourlyRate = yearlyPay / maxYearlyBillableHours;

        return hourlyRate;
    } else if (stipendAmount) {
        const stipendAmountNum = dollarToNumber(stipendAmount.textContent);
        const fringeRate = await getFringeRateFromRow(row);
        const yearlyPay = stipendAmountNum * (1+fringeRate);
        const hourlyRate = yearlyPay / maxYearlyBillableHours;

        return hourlyRate;
    }
}

async function calculateYearlyWagesWithFringeRateFromRow(row, yearIndex) {
    const salary = row.querySelector(".salary");
    if (salary) {
        const salaryNum = dollarToNumber(salary.textContent.trim())
        const percentEffort = getPercentEffortFromRow(row);
        const fringeRate = await getFringeRateFromRow(row);
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

            fringeRate = await getFringeRateFromRow(row);
            yearlyWages = (percentEffort*stipendAmountNum) * (1+fringeRate);
        }

        if (tuitionAmount && tuitionAmount.parentElement.querySelector(".include-check").checked) {
            const tuitionIncreasePct = Number(tuitionAmount.dataset.tuitionIncreasePct)
            const tuitionAmountNum = dollarToNumber(tuitionAmount.textContent);

            fringeRate = fringeRate || await getFringeRateFromRow(row);
            yearlyWages += tuitionAmountNum * (1 + tuitionIncreasePct)**(yearIndex ?? 0);
        }

        return yearlyWages;
    }
}

async function getTotalWagesForYearWithFringeRate(yearIndex) {
    let totalWagesPerYear = 0;
    const usedRows = []

    const payFields = [...document.querySelectorAll(".salary"), ...document.querySelectorAll(".stipend-amount p"), ...document.querySelectorAll(".tuition-amount p")];
    for (const td of payFields) {
        const row = td.closest("tr");
        
        if (usedRows.indexOf(row) !== -1) {
            continue
        }
        usedRows.push(row)

        const yearlyWages = await calculateYearlyWagesWithFringeRateFromRow(row, yearIndex);

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

function populatePersonnelRow(row, data) {
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
}

function updateYearlyCosts() {
    const yearlyTotalItemizedCosts = getTotalItemizedCosts();
    const yearlyTotalTravelCosts = getTotalTravelCosts();

    for (let yearIndex = 0; yearIndex < getNumBudgetYears(); yearIndex++) {
        getTotalWagesForYearWithFringeRate(yearIndex)
            .then(yearlyTotalWages => {
                const td = yearlyCostsTableBodyRow.children[yearIndex];
                td.textContent = toDollar(yearlyTotalWages + yearlyTotalItemizedCosts + yearlyTotalTravelCosts);
            });
    }
}

async function getBudgetTotalCost() {
    const yearlyTotalItemizedCosts = getTotalItemizedCosts();
    const yearlyTotalTravelCosts = getTotalTravelCosts();
    const numBudgetYears = getNumBudgetYears()

    let budgetTotalCost = yearlyTotalItemizedCosts*numBudgetYears + yearlyTotalTravelCosts*numBudgetYears

    for (let yearIndex = 0; yearIndex < getNumBudgetYears(); yearIndex++) {
        const yearlyTotalWages = await getTotalWagesForYearWithFringeRate(yearIndex)

        budgetTotalCost += yearlyTotalWages
    }

    return budgetTotalCost
}

function updateRowPercentEffortState(row) {
    const stipendIncludeCheckbox = row.querySelector(".stipend-amount .include-check"); // As opposed to tuition type
    if (!stipendIncludeCheckbox) return

    const percentEffort = row.querySelector(".percent-effort");

    if (stipendIncludeCheckbox.checked) {
        percentEffort.disabled = false;
    } else {
        percentEffort.value = 0;
        percentEffort.disabled = true;
    }
}

// Calculates the number of budget years based off of start and end dates (default is 1)
function getNumBudgetYears() {
    if (numBudgetYears) {
        return numBudgetYears;
    } else {
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
}

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

async function loadBudget() {
    const budgetId = currentBudgetId
    if (!budgetId) return;

    try {
        const data = isPrimeBudget 
        ? await fetchJson(`../php/get_budget.php?budget_id=${budgetId}`)
        : await fetchJson(`../php/get_subbudget.php?subbudget_id=${budgetId}`)

        console.log("loading budget:", data)

        if (!data.success) throw new Error(data.error || "Budget not found");

        const budget = data.budget || {};
        const personnel = data.personnel || [];
        const travels = data.travels || [];
        const items = data.items || [];
        const subawards = data.subawards || [];

        if (isPrimeBudget) {
            // Populate top-level fields
            budgetTitle.value = budget.budget_name ?? "";
            budgetFundingSource.value = budget.funding_source ?? "";
            budgetStartDate.value = budget.start_date || budgetStartDate.value
            budgetEndDate.value = budget.end_date || budgetEndDate.value
        }

        // Recompute number of years (will recreate yearly-costs columns)
        onNumBudgetYearsChanged();

        // --- Populate personnel tables ---
        const promises = []
        for (const personnelData of personnel) {
            const table = document.getElementById(personnelData.html_table_id);
            if (!table) continue;

            promises.push(
                addRow(table)
                    .then(row => {
                        // Force select the personnel
                        const tomselect = row.querySelector(".staff-picker").tom
                        tomselect.setValue(personnelData.id);

                        // Auto-populates row with personnel metadata
                        tomselect.trigger("change");

                        // Set stipend include checkbox
                        const stipendIncludeCheckbox = row.querySelector(".stipend-amount .include-check")
                        if (stipendIncludeCheckbox) {
                            stipendIncludeCheckbox.checked = Boolean(personnelData.stipend_requested)
                        }

                        // Set tuition include checkbox
                        const tuitionIncludeCheckbox = row.querySelector(".tuition-amount .include-check")
                        if (tuitionIncludeCheckbox) {
                            tuitionIncludeCheckbox.checked = Boolean(personnelData.tuition_requested)
                        }

                        // Set percent effort
                        const percentEffort = row.querySelector(".percent-effort")
                        if (percentEffort) {
                            percentEffort.value = Number(personnelData.percent_effort)
                        }

                        updateRowPercentEffortState(row)
                    })
            )
        }
        await Promise.all(promises)

        // --- Populate travel table ---
        const travelTableEl = document.getElementById("travel");
        if (travelTableEl) {
            for (const t of travels) {
                const row = await addRow(travelTableEl);                    // <-- pass the table
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

        // --- Populate itemized costs table ---
        const itemsTableEl = document.getElementById("itemized-costs");
        if (itemsTableEl) {
            for (let i of items) {
                const row = await addRow(itemsTableEl);
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
        
        // --- Populate subawards table ---
        console.log("populating subawards table.")
        const subawardsTable = document.getElementById("subawards");
        if (subawardsTable) {
            for (const s of subawards) {
                const row = await addRow(subawardsTable);
                if (s.subbudget_id) row.dataset.subbudget_id = s.subbudget_id;

                const nameEl = row.querySelector(".name");
                if (nameEl) {
                    nameEl.value = s.subaward_institution ?? "";
                }
                
                const totalCostEl = row.querySelector(".total-cost");
                if (totalCostEl) {
                    totalCostEl.textContent = toDollar(s.total_cost ?? 0)
                }
            }
        }

        // Recalculate totals
        updateYearlyCosts();
    } catch (err) {
        console.error("Error loading budget:", err);
        showError("Failed to load budget: " + (err.message || err));
    }
}

async function collectAndSave(clickedButton) {
    clearError();

    const payload = isPrimeBudget ? {
        budget_id: currentBudgetId || 0,
        budget_name: budgetTitle.value || "",
        funding_source: budgetFundingSource.value || "",
        start_date: budgetStartDate.value || getTodayString(), // default if empty
        end_date: budgetEndDate.value || getTodayString(),     // default if empty
        personnel: [],
        travels: [],
        items: [],
        subawards: []
    } : {
        subbudget_id: currentBudgetId || 0,
        prime_budget_id: primeBudgetId || 0,
        subaward_institution: subawardInstitution || "",
        total_cost: await getBudgetTotalCost() || 0,
        personnel: [],
        travels: [],
        items: []
    }

    function collectPersonnelRows(tableId) {
        const rows = [];
        const table = document.getElementById(tableId);
        if (!table) return rows;

        for (const r of table.querySelectorAll("tbody tr")) {
            const picker = r.querySelector(".staff-picker");
            const personnelId = picker ? parseInt(picker.value || 0) : 0;

            const percentEl = r.querySelector(".percent-effort");
            const percentVal = percentEl ? parseInt(percentEl.value || 0) : 0;
            const stipendCheckbox = r.querySelector(".stipend-amount .include-check");
            const stipendRequested = stipendCheckbox ? (stipendCheckbox.checked ? 1 : 0) : 0;
            const tuitionCheckbox = r.querySelector(".tuition-amount .include-check");
            const tuitionRequested = tuitionCheckbox ? (tuitionCheckbox.checked ? 1 : 0) : 0;

            rows.push({
                personnel_type: tableIdToPersonnelType[tableId],
                html_table_id: tableId,
                personnel_id: personnelId,
                percent_effort: percentVal,
                tuition_requested: tuitionRequested,
                stipend_requested: stipendRequested,
            });
        }
        return rows;
    }

    payload.personnel = payload.personnel.concat(
        collectPersonnelRows("pi-table"),
        collectPersonnelRows("pro-staff"),
        collectPersonnelRows("post-docs"),
        collectPersonnelRows("gras"),
        collectPersonnelRows("ugrads")
    );

    // --- Travel ---
    const travelTable = document.getElementById("travel");
    if (travelTable) {
        for (const r of travelTable.querySelectorAll("tbody tr")) {
            const type = r.querySelector(".type")?.value || "";
            const nights = parseInt(r.querySelector(".num-nights")?.value || 0);
            const travelers = parseInt(r.querySelector(".num-travelers")?.value || 0);
            const id = r.dataset.travelId ? parseInt(r.dataset.travelId) : 0;

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
            const unitCost = dollarToNumber(r.querySelector(".unit-cost")?.value || "0");
            const id = r.dataset.itemId ? parseInt(r.dataset.itemId) : 0;

            payload.items.push({
                id,
                item_type: type,
                name,
                quantity: qty,
                unit_cost: unitCost
            });
        }
    }

    // --- Subawards ---
    const subawardsTable = document.getElementById("subawards");
    if (subawardsTable) {
        for (const r of subawardsTable.querySelectorAll("tbody tr")) {
            const subaward_institution = r.querySelector(".name")?.value || "";
            const total_cost = dollarToNumber(r.querySelector(".total-cost")?.textContent) || 0;
            const subbudget_id = Number(r.dataset.subbudget_id) || 0 

            console.log("subbudget_id:", subbudget_id)

            payload.subawards.push({
                subbudget_id,
                subaward_institution,
                total_cost
            });
        }
    }

    const saveBtn = document.getElementById("saveBudget");
    if (saveBtn && clickedButton === saveBtn) {
        saveBtn.disabled = true;
        saveBtn.value = "Saving...";
    }
    
    console.log("saving budget:", payload);

    try {
        const resp = isPrimeBudget
        ? await fetch('../php/save_budget.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        : await fetch('../php/save_subbudget.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })

        const result = await resp.json();
        if (!result.success) throw new Error(result.error || 'Unknown server error');

        if (saveBtn && clickedButton === saveBtn) {
            saveBtn.value = "Saved ✓";
            setTimeout(() => {
                saveBtn.disabled = false;
                saveBtn.value = "Save budget";
            }, 1200);
        }
    } catch (err) {
        showError("Save failed: " + err.message);
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.value = "Save budget";
        }
        return;
    }

    return true;
}

// Set dates to today (default)
document.querySelectorAll("input[type='date']").forEach(el => el.value = getTodayString())

// Initialize yearly costs table
onNumBudgetYearsChanged();

// Initialize current staff pickers
document.querySelectorAll(".staff-picker").forEach(initializeStaffPicker);

// Listen for budget num years changed
document.querySelectorAll("input[type='date']").forEach(el => el.addEventListener("input", onNumBudgetYearsChanged))

// Remove row button
document.addEventListener("click", async (event) => {
    const button = event.target.closest("button")
    if (button && button.classList.contains("rem_row")) {
        const row = button.closest("tr");
        if (row) {
            const select = row.querySelector("select.staff-picker")
            if (select && select.tom) {
                select.tom.clear() // Deselect in order to allow other staff pickers to use name
            }

            const table = button.closest("table");
            if (table.id === "subawards") {
                const res = await fetch("../php/delete_subaward.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ subbudget_id: row.dataset.subbudget_id })
                });

                const data = await res.json();
                if (!data.success) {
                    console.error("Delete failed:", data.error);
                }
            }
            row.remove()
        };
        updateYearlyCosts();
    }
});

// Add row button
document.querySelectorAll(".add_row").forEach(button =>  {
    const table = button.closest("table");

    button.addEventListener("click", async () => {
        let subbudget_id
        if (table.id === "subawards") {
            const res = await fetch("../php/create_subaward.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ prime_budget_id: currentBudgetId })
            });

            const data = await res.json();
            subbudget_id = data.subbudget_id
        }

        const row = await addRow(table);

        if (subbudget_id) {
            row.dataset.subbudget_id = Number(subbudget_id)
        }
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
fetch("../php/get_travel_profiles.php")
.then(res => res.json())
.then(data => {
    travelProfiles = data;
    
    // Listen for travel type/num days/num travelers changed
    document.addEventListener("input", event => {
        const table = event.target.closest("table");
        if (!table || table.id !== "travel") return;

        const row = event.target.closest("tr");
        const totalCost = row.querySelector(".total-cost");

        totalCost.textContent = toDollar(calculateTotalTravelCostFromRow(row));

        updateYearlyCosts();
    })
})

// Listen for include checkbox button clicked
document.addEventListener("input", event => {
    const checkbox = event.target;
    if (!checkbox.classList.contains("include-check")) return;

    const row = checkbox.closest("tr");

    updateRowPercentEffortState(row);
    updateYearlyCosts();
})

// Download spreadsheet
downloadButton.addEventListener("click", async () => {
    const numBudgetYears = getNumBudgetYears();

    // -------------------------------------------------
    // 1. Build base spreadsheet
    // -------------------------------------------------
    const spreadsheetData = [
        ["Title: "],
        ["Funding Source: "],
        ["PI: ", "Co-PIs: "],
        ["Project Start and End Dates: "],
        ["", "", "Hourly rate at start date"],
        ["Personnel Compensation", "Year 1 hours"],
        [],
        ["Other Personnel"],
        ["UI professional staff & Post Docs"],
        ["GRAs/UGrads"],
        ["Temp Help"],
        [],
        ["Indirect Costs", "F&A Rate:", "50%"],
        [],
        ["Fringe", "", "FY26 Fringe Rates"],
        ["UI professional staff & Post Docs", "", "36.7%"],
        ["Faculty", "", "29.5%"],
        ["Temp Help", "", "10.5%"],
        ["GRAs/UGrads", "", "3.2%"],
        [],
        ["Equipment > $5000.00"],
        [],
        ["Travel"],
        ["Domestic"],
        ["International"],
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
        ["Total Project Cost"],
    ];

    // Insert year headers
    const headerRow = spreadsheetData[4];
    for (let i = 0; i < numBudgetYears; i++) headerRow.push("Year " + (i + 1));
    headerRow.push("Total");

    function getSpreadsheetRowIndexByLabel(label) {
        return spreadsheetData.findIndex(row => row[0] === label);
    }

    function toDollar(value) {
        return "$" + Number(value).toFixed(2);
    }

    function pushRepeatYearlyCost(rowIndex, insertColumnIndex, yearlyCost) {
        if (yearlyCost === 0) return;

        const spreadsheetRow = spreadsheetData[rowIndex];
        const gapSize = insertColumnIndex - spreadsheetRow.length;
        if (gapSize > 0) spreadsheetRow.push(...Array(gapSize).fill(""));
        spreadsheetRow.splice(insertColumnIndex, 0, ...Array(numBudgetYears).fill(toDollar(yearlyCost)), toDollar(yearlyCost * numBudgetYears));
    }

    // -------------------------------------------------
    // 2. Apply main budget info
    // -------------------------------------------------
    const subbudgetTitle = document.querySelector("#budget-title label")?.textContent.trim();
    if (isPrimeBudget) {
        spreadsheetData[0][0] += budgetTitle.value;
        spreadsheetData[1][0] += budgetFundingSource.value;
    } else {
        spreadsheetData[0][0] += subbudgetTitle;
        spreadsheetData[1][0] += budgetFundingSourceStr;
    }

    // Apply PI
    let name = getStaffPickerSelectedName(piTableBody.firstElementChild);
    if (name) spreadsheetData[2][0] += name;

    const coPiNames = [];
    for (let i = 1; i < piTableBody.children.length; i++) {
        let name = getStaffPickerSelectedName(piTableBody.children[i]);
        if (name) coPiNames.push(name);
    }
    spreadsheetData[2][1] += coPiNames.join(", ");

    // Start/End dates
    if (isPrimeBudget) {
        spreadsheetData[3][0] += budgetStartDate.value + " – " + budgetEndDate.value;
    } else {
        spreadsheetData[3][0] += budgetStartDateStr + " – " + budgetEndDateStr;
    }

    // -------------------------------------------------
    // 3. Apply PI and other personnel wages
    // -------------------------------------------------
    const piRows = piTableBody.children;
    let piInsertIndex = 6;
    for (const row of piRows) {
        const piType = row.querySelector(".type").textContent.trim();
        const year1HoursWorked = calculateYearlyHoursWorkedFromRow(row);
        if (year1HoursWorked === 0) continue;

        const hourlyRate = await calculateHourlyRateWithFringeRateFromRow(row);
        let yearlyWagesArray = [];
        for (let y = 0; y < numBudgetYears; y++) {
            yearlyWagesArray.push(await calculateYearlyWagesWithFringeRateFromRow(row, y));
        }
        const totalWages = yearlyWagesArray.reduce((acc, val) => acc + val, 0);

        spreadsheetData.splice(
            piInsertIndex,
            0,
            [piType, year1HoursWorked, toDollar(hourlyRate), ...yearlyWagesArray.map(toDollar), toDollar(totalWages)]
        );
        piInsertIndex++;
    }

    async function pushOtherPersonnelAggregationData(t1Id, t2Id, rowOffset) {
        const t1Rows = document.querySelector(`#${t1Id} tbody`).children;
        const t2Rows = document.querySelector(`#${t2Id} tbody`).children;

        let aggregatedYear1HoursWorked = 0;
        let aggregatedYearlyWages = Array(numBudgetYears).fill(0);
        let promises = [];

        for (const row of [...t1Rows, ...t2Rows]) {
            const year1Hours = calculateYearlyHoursWorkedFromRow(row);
            aggregatedYear1HoursWorked += year1Hours;

            for (let i = 0; i < numBudgetYears; i++) {
                promises.push(
                    calculateYearlyWagesWithFringeRateFromRow(row, i).then(val => {
                        aggregatedYearlyWages[i] += val;
                    })
                );
            }
        }

        await Promise.all(promises);

        if (aggregatedYearlyWages.some(v => v > 0)) {
            const total = aggregatedYearlyWages.reduce((a, b) => a + b, 0);
            const row = spreadsheetData[getSpreadsheetRowIndexByLabel("Other Personnel") + rowOffset];
            spreadsheetRow = row;
            spreadsheetRow.push(aggregatedYear1HoursWorked, null, ...aggregatedYearlyWages.map(toDollar), toDollar(total));
        }
    }

    await pushOtherPersonnelAggregationData("pro-staff", "post-docs", 1);
    await pushOtherPersonnelAggregationData("gras", "ugrads", 2);

    // -------------------------------------------------
    // 4. Travel
    // -------------------------------------------------
    const travelRows = document.querySelector("#travel tbody").children;
    let domesticTotal = 0;
    let internationalTotal = 0;
    for (const row of travelRows) {
        const type = row.querySelector("select").value;
        if (type === "Domestic") domesticTotal += calculateTotalTravelCostFromRow(row);
        else if (type === "International") internationalTotal += calculateTotalTravelCostFromRow(row);
    }
    const travelIndex = getSpreadsheetRowIndexByLabel("Travel");
    pushRepeatYearlyCost(travelIndex + 1, 3, domesticTotal);
    pushRepeatYearlyCost(travelIndex + 2, 3, internationalTotal);

    // -------------------------------------------------
    // 5. Itemized costs
    // -------------------------------------------------
    const itemRows = document.querySelector("#itemized-costs tbody").children;
    const itemMap = {
        "Materials & Supplies": "Materials and supplies",
        "Publication Costs": "Publication costs",
        "Computer Services": "Computer services",
        "Software": "Software",
        "Facility Useage Fees": "Facility useage fees",
        "Conference Registration": "Conference registration",
        "Other": "Other"
    };
    const rowCosts = new Map();
    const bigEquipmentRows = [];
    for (const row of itemRows) {
        const type = row.querySelector("select").value;
        if (!type) continue;
        const cost = calculateTotalItemCostFromRow(row);

        if (type === "Equipment") {
            const unitCost = Number(row.querySelector(".unit-cost").value);
            if (unitCost >= 5000) bigEquipmentRows.push(row);
            else {
                const old = rowCosts.get("<$5K small equipment") || 0;
                rowCosts.set("<$5K small equipment", old + cost);
            }
        } else {
            const label = itemMap[type];
            const old = rowCosts.get(label) || 0;
            rowCosts.set(label, old + cost);
        }
    }
    for (const [label, val] of rowCosts) {
        pushRepeatYearlyCost(getSpreadsheetRowIndexByLabel(label), 3, val);
    }

    // Big equipment
    const eqIndex = getSpreadsheetRowIndexByLabel("Equipment > $5000.00");
    for (let i = 0; i < bigEquipmentRows.length; i++) {
        const row = bigEquipmentRows[i];
        const qty = row.querySelector(".quantity")?.value;
        let name = row.querySelector(".name").value;
        if (qty && qty > 1) name += " x" + qty;
        const cost = calculateTotalItemCostFromRow(row);
        spreadsheetData.splice(eqIndex + i + 1, 0, [name, null, null, ...Array(numBudgetYears).fill(toDollar(cost)), toDollar(cost * numBudgetYears)]);
    }

    // -------------------------------------------------
    // 6. Subawards
    // -------------------------------------------------
    if (isPrimeBudget) {
        const subawardRows = document.querySelector("#subawards tbody").children;
        let i = 1;
        for (const row of subawardRows) {
            const inst = row.querySelector(".name").value;
            const totalCost = row.querySelector(".total-cost").textContent;
            if (!inst || dollarToNumber(totalCost) === 0) continue;
            spreadsheetData.splice(getSpreadsheetRowIndexByLabel("Consortia/Subawards") + i, 0, [inst, null, null, ...Array(numBudgetYears), totalCost]);
            i++;
        }
    }

    // -------------------------------------------------
    // 7. Total Project Cost
    // -------------------------------------------------
    const totalRowIndex = getSpreadsheetRowIndexByLabel("Total Project Cost");
    const yearStartCol = 3;
    const yearTotals = Array(numBudgetYears + 1).fill(0);

    for (let r = 0; r < spreadsheetData.length; r++) {
        if (r === totalRowIndex) continue;
        const row = spreadsheetData[r];
        for (let y = 0; y <= numBudgetYears; y++) {
            const col = yearStartCol + y;
            if (col < row.length) {
                let val = row[col];
                if (typeof val === "string" && val.startsWith("$")) {
                    val = parseFloat(val.replace(/[$,]/g, ""));
                }
                if (!isNaN(val)) yearTotals[y] += val;
            }
        }
    }

    const totalRow = spreadsheetData[totalRowIndex];
    const gapSize = yearStartCol - totalRow.length;
    if (gapSize > 0) totalRow.push(...Array(gapSize).fill(""));
    for (let i = 0; i <= numBudgetYears; i++) totalRow.push(toDollar(yearTotals[i]));

    // -------------------------------------------------
    // 8. F&A / Indirect Costs (use existing row in layout)
    // -------------------------------------------------
    const FA_RATE = 0.5; // 50% F&A

    // Find the row for Indirect Costs
    const indirectIndex = getSpreadsheetRowIndexByLabel("Indirect Costs");
    if (indirectIndex === -1) {
        console.warn("No Indirect Costs row found in layout");
    } else {
        const indirectRow = spreadsheetData[indirectIndex];

        // Fill F&A values for each year and calculate total
        let totalFA = 0;
        const yearStartCol = 3; // adjust if your layout changes
        for (let y = 0; y < numBudgetYears; y++) {
            const faAmount = yearTotals[y] * FA_RATE;
            indirectRow[yearStartCol + y] = toDollar(faAmount);
            totalFA += faAmount;
        }
        indirectRow[yearStartCol + numBudgetYears] = toDollar(totalFA);

        // Include F&A in final Total Project Cost row
        const totalProjectRowIndex = getSpreadsheetRowIndexByLabel("Total Project Cost");
        if (totalProjectRowIndex === -1) {
            console.warn("No Total Project Cost row found in layout");
        } else {
            const totalProjectRow = spreadsheetData[totalProjectRowIndex];
            for (let y = 0; y < numBudgetYears; y++) {
                const existing = dollarToNumber(totalProjectRow[yearStartCol + y] || 0);
                totalProjectRow[yearStartCol + y] = toDollar(existing + dollarToNumber(indirectRow[yearStartCol + y]));
            }
            const existingTotal = dollarToNumber(totalProjectRow[yearStartCol + numBudgetYears] || 0);
            totalProjectRow[yearStartCol + numBudgetYears] = toDollar(existingTotal + totalFA);
        }
    }


    // -------------------------------------------------
    // 9. Convert to worksheet & style
    // -------------------------------------------------
    const worksheet = XLSX.utils.aoa_to_sheet(spreadsheetData);

    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Budget");

    // Styling parameters
    const grayRowTriggers = [
        "Personnel Compensation", "Other Personnel", "Fringe",
        "Equipment > $5000.00", "Travel", "Other Direct Costs",
        "Consortia/Subawards", "Total Project Cost", "Indirect Costs",
    ];
    const lightGrayRowTriggers = ["Back out subawards totals"];
    const rowUnderlineTriggers = ["Indirect Costs"];
    const boldUnderlineLabels = ["Personnel Compensation","Other Personnel","Fringe","Equipment > $5000.00","Travel","Year 1 hours","FY26 Fringe Rates"];
    const boldOnlyLabels = ["Total Project Cost","Hourly rate at start date","Indirect Costs","Total"];

    // Apply styles
    const range = XLSX.utils.decode_range(worksheet['!ref']);
    for (let R = range.s.r; R <= range.e.r; R++) {
        let isGrayRow = false, isLightGrayRow = false, isRowUnderline = false;
        const firstCellRef = XLSX.utils.encode_cell({ c: 0, r: R });
        if (worksheet[firstCellRef]) {
            const val = worksheet[firstCellRef].v?.toString().trim() || "";
            isGrayRow = grayRowTriggers.includes(val);
            isLightGrayRow = lightGrayRowTriggers.includes(val);
            isRowUnderline = rowUnderlineTriggers.includes(val);
        }
        for (let C = range.s.c; C <= range.e.c; C++) {
            const cellRef = XLSX.utils.encode_cell({ c: C, r: R });
            if (!worksheet[cellRef]) {
                if (isGrayRow || isLightGrayRow || isRowUnderline) worksheet[cellRef] = { t: 's', v: '' };
                else continue;
            }
            const cell = worksheet[cellRef];
            const val = cell.v?.toString().trim() || "";
            if (!cell.s) cell.s = {};
            if (isGrayRow) cell.s.fill = { fgColor: { rgb: "D9D9D9" } };
            else if (isLightGrayRow) cell.s.fill = { fgColor: { rgb: "F2F2F2" } };
            if (isRowUnderline) { if (!cell.s.border) cell.s.border = {}; cell.s.border.bottom = { style:"thin", color:{rgb:"000000"} }; }
            if (boldUnderlineLabels.includes(val)) { if(!cell.s.font) cell.s.font={}; cell.s.font.bold=true; cell.s.font.underline=true; }
            else if (boldOnlyLabels.includes(val)) { if(!cell.s.font) cell.s.font={}; cell.s.font.bold=true; }
            if (typeof cell.v === "string" && cell.v.startsWith("$")) {
                const numVal = parseFloat(cell.v.replace(/[$,]/g,""));
                if (!isNaN(numVal)) cell.v = numVal.toLocaleString("en-US",{style:"currency",currency:"USD"});
                cell.s.alignment = { horizontal:"center", vertical:"center" };
            } else if (typeof cell.v === "number") {
                cell.s.alignment = { horizontal:"center", vertical:"center" };
            } else if (cell.v?.toString().endsWith("%")) {
                const numVal = parseFloat(cell.v.replace("%",""));
                if(!isNaN(numVal)) cell.v = numVal.toFixed(2) + "%";
                cell.s.alignment = { horizontal:"center", vertical:"center" };
            }
        }
    }

    // -------------------------------------------------
    // 10. Fill empty year/total cells with "-"
    // -------------------------------------------------
    for (let R = 0; R <= range.e.r; R++) {
        const firstCellVal = worksheet[XLSX.utils.encode_cell({ c:0, r:R })]?.v?.toString().trim() || "";
        if (grayRowTriggers.includes(firstCellVal) || firstCellVal === "") continue;
        for (let C = yearStartCol; C <= yearStartCol + numBudgetYears; C++) {
            const cellRef = XLSX.utils.encode_cell({c:C, r:R});
            if (!worksheet[cellRef] || worksheet[cellRef].v === null || worksheet[cellRef].v === "") {
                worksheet[cellRef] = { t:'s', v:'-', s:{ alignment:{horizontal:"center", vertical:"center"} } };
            }
        }
    }

    // -------------------------------------------------
    // 11. Write file
    // -------------------------------------------------
    const fileName = isPrimeBudget ? budgetTitle.value : subbudgetTitle;
    XLSX.writeFile(workbook, fileName + (fileName !== "" ? "_" : "") + "EZBudgets.xlsx");
});



document.addEventListener("DOMContentLoaded", async () => {
    await loadBudget()

    // Updating/adding first PI row
    const piTable = document.querySelector("#pi-table");
    const piBody = piTable.querySelector("tbody");
    let piRow;
    if (piBody.children.length === 0) {
        piRow = await addRow(piTable, 1);
    } else {
        piRow = piBody.firstElementChild;
    }
    piRow.querySelector(".type").textContent = "PI";
    const tom = piRow.querySelector(".staff-picker").tom
    tom.settings.placeholder = "Select PI";
    tom.inputState();
    piRow.lastElementChild.remove() // Remove the remove button
});
document.getElementById("saveBudget")?.addEventListener("click", () => collectAndSave(document.querySelector("#saveBudget")));