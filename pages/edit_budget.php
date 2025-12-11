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

// Handle subaward creation
if (isset($_POST['create_subaward'])) {
    $budget_name = $_POST['budget_name'] ?? 'New Budget';

    $sql_insert = "INSERT INTO budgets (user_id, budget_name) VALUES ($user_id, '$budget_name')";
    if ($conn->query($sql_insert) === TRUE) {
        $new_budget_id = $conn->insert_id;
        header("Location: edit_budget.php?budget_id=$new_budget_id");
        exit();
    } else {
        $message = "Error creating budget: " . $conn->error;
    }
}

// Handle subaward deletion
if (isset($_POST['delete_budget'])) {
    $delete_id = intval($_POST['delete_budget']);
    $sql_delete = "DELETE FROM budgets WHERE budget_id = $delete_id AND user_id = $user_id";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Error deleting budget: " . $conn->error;
    }
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
    <link rel="stylesheet" href="styles.css">

    <title>
        EZBudgets
    </title>

    <style>
       
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
                <div class="card-container">
                    <table id="pi-table">
                        <caption>
                            Principle investigators
                            <button class="add_row dark-border" >
                                <img src="../images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
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
                
                <div class="card-container">
                    <table id="pro-staff">
                        <caption>
                            UI professional staff
                            <button class="add_row dark-border" >
                                <img src="../images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
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
                
                <div class="card-container">
                    <table id="post-docs">
                        <caption>
                            Post doctoral researchers
                            <button class="add_row dark-border" >
                                <img src="../images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
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
                
                <div class="card-container">
                    <table id="gras">
                        <caption>
                            Graduate research assistants
                            <button class="add_row dark-border" >
                                <img src="../images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
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
                
                <div class="card-container">
                    <table id="ugrads">
                        <caption>
                            Undergraduate research assistants
                            <button class="add_row dark-border" >
                                <img src="../images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
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

                <div class="card-container">
                    <table id="travel">
                        <caption>
                            Travel
                            <button class="add_row dark-border" >
                                <img src="../images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
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

                <div class="card-container">
                    <table id="itemized-costs">
                        <caption>
                            Itemized costs
                            <button class="add_row dark-border" >
                                <img src="../images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
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
                
                <div class="card-container">
                    <table id="subawards">
                        <caption>
                            Subawards
                            <button class="add_row dark-border" >
                                <img src="../images/add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png"
                                width="24" height="24">
                            </button>
                        </caption>
                        <thead>
                            <tr>
                                <th>Institution</th>
                                <th>Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-container" id="right-side">
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
                    <input id="save-and-close" type="button" value="Close" style="margin-left:10px;">
                    <!-- <input id="saveBudget" type="button" value="Save" style="margin-left:10px;"> -->
                </div>
            </div>
        </div>
    </main>

    <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
    <script>
        const budgetStartDate = document.getElementById("budget-start-date").querySelector("input");
        const budgetEndDate = document.getElementById("budget-end-date").querySelector("input");
    </script>
    <script src="edit.js"></script>
    <script>
        document.querySelector("#save-and-close").addEventListener("click", () => {
            collectAndSave()
                .then(success => {
                    if (success) {
                        location.href = "dashboard.php";
                    }
                });
        });
    </script>
</body>
</html>