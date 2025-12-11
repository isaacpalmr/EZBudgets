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

$primeBudgetTitle = $_GET["primeBudgetTitle"];
$subawardInstitution = $_GET["subawardInstitution"];
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
                <label id="subbudget-title"><?php echo "$primeBudgetTitle - $subawardInstitution Subaward" ?></label>
            </div>
        </div>
        
        <div id="tables">
            <div id="user_tables" style="text-align: center;">
                <div>
                    <table id="pi-table">
                        <caption>
                            Principle investigators
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
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
                
                <div>
                    <table id="pro-staff">
                        <caption>
                            UI professional staff
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
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
                
                <div>
                    <table id="post-docs">
                        <caption>
                            Post doctoral researchers
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
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
                
                <div>
                    <table id="gras">
                        <caption>
                            Graduate research assistants
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
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
                
                <div>
                    <table id="ugrads">
                        <caption>
                            Undergraduate research assistants
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
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

                <div>
                    <table id="travel">
                        <caption>
                            Travel
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
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

                <div>
                    <table id="itemized-costs">
                        <caption>
                            Itemized costs
                            <button class="add_row" style="background-color: rgb(1, 255, 136); border-width: 1px; margin-top: 20px;">
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
                    <!-- <input id="saveBudget" type="button" value="Save" style="margin-left:10px;"> -->
                    <input id="back-to-prime" type="button" value="Back" style="margin-left:10px;">
                </div>
            </div>
        </div>
    </main>

    <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
    <script src="edit.js"></script>
    <script>
        document.querySelector("#back-to-prime").addEventListener("click", () => {
            collectAndSave()
                .then(success => {
                    if (success) {
                        window.history.back();
                    }
                });
        });
    </script>
</body>
</html>