<?php
// =========================
// DATABASE CONNECTION
// =========================
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ezbudgets";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$error = "";

// Load staff titles for dropdown
$staff_titles = [];
$result = $conn->query("
    SELECT staff_title 
    FROM fringe_rate
    WHERE staff_title NOT IN ('Grad Student', 'Undergrad Student', 'Post Doc')
    ORDER BY staff_title ASC
");
while ($row = $result->fetch_assoc()) {
    $staff_titles[] = $row['staff_title'];
}

// =========================
// HANDLE ADDING A NEW JOB TITLE
// =========================
if (isset($_POST["add_new_job"])) {
    $new_title = trim($_POST["new_staff_title"]);
    $new_rate = floatval($_POST["new_fringe_rate"]);

    if ($new_title === "" || $new_rate <= 0) {
        $error = "Please enter a valid title and fringe rate.";
    } else {
        // Check duplicate
        $check = $conn->prepare("SELECT COUNT(*) FROM fringe_rate WHERE staff_title = ?");
        $check->bind_param("s", $new_title);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();

        if ($count > 0) {
            $error = "This job already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO fringe_rate (staff_title, fringe_rate) VALUES (?, ?)");
            $stmt->bind_param("sd", $new_title, $new_rate);
            if ($stmt->execute()) {
                $message = "New job title added!";
                $staff_titles[] = $new_title;
                sort($staff_titles);
            } else {
                $error = "Error adding new job: " . $stmt->error;
            }
        }
    }
}

// =========================
// HANDLE PERSONNEL INSERT
// =========================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["personnel_type"])) {

    $type = $_POST["personnel_type"];
    $name = trim($_POST["name"]);

    // DUPLICATE CHECK — same name in same table
    function checkDuplicate($conn, $table, $column, $value) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM $table WHERE $column = ?");
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }

    if ($type === "staff") {

        if (checkDuplicate($conn, "university_employee", "name", $name)) {
            $error = "A staff member with this name already exists.";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO university_employee (name, hourly_rate, job, staff_title, is_pi_eligible)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "sdssi",
                $name,
                $_POST["hourly_rate"],
                $_POST["job"],
                $_POST["staff_title"],
                $_POST["is_pi_eligible"]
            );

            if ($stmt->execute()) $message = "Staff member added!";
            else $error = "Error: " . $stmt->error;
        }
    }

    else if ($type === "undergrad") {

        if (checkDuplicate($conn, "undergraduate_research_assistants", "name", $name)) {
            $error = "An undergraduate RA with this name already exists.";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO undergraduate_research_assistants
                (name, major, residency, max_fte, stipend_per_academic_year)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "sssdd",
                $name,
                $_POST["major"],
                $_POST["residency"],
                $_POST["max_fte"],
                $_POST["stipend"]
            );

            if ($stmt->execute()) $message = "Undergraduate RA added!";
            else $error = "Error: " . $stmt->error;
        }
    }

    else if ($type === "grad") {

        if (checkDuplicate($conn, "graduate_research_assistants", "name", $name)) {
            $error = "A graduate RA with this name already exists.";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO graduate_research_assistants
                (name, program, residency, max_fte, stipend_per_academic_year)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "sssdd",
                $name,
                $_POST["program"],
                $_POST["residency"],
                $_POST["max_fte"],
                $_POST["stipend"]
            );

            if ($stmt->execute()) $message = "Graduate RA added!";
            else $error = "Error: " . $stmt->error;
        }
    }

    else if ($type === "postdoc") {

        if (checkDuplicate($conn, "post_doctoral_researchers", "name", $name)) {
            $error = "A post-doctoral researcher with this name already exists.";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO post_doctoral_researchers
                (name, field, appointment_type, max_fte, stipend_per_academic_year)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "sssdd",
                $name,
                $_POST["field"],
                $_POST["appointment_type"],
                $_POST["max_fte"],
                $_POST["stipend"]
            );

            if ($stmt->execute()) $message = "Post-Doctoral Researcher added!";
            else $error = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Personnel</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .hidden { display: none; }
        .msg { font-weight: bold; margin-bottom: 20px; color: green; }
        .error { font-weight: bold; margin-bottom: 20px; color: red; }
        fieldset { margin-top: 30px; }
    </style>
</head>
<body>

<h2>Add Personnel</h2>

<?php if ($message): ?><div class="msg"><?= $message ?></div><?php endif; ?>
<?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>

<form method="POST">

    <label>Personnel Type:</label>
    <select name="personnel_type" onchange="showFields()" id="personnel_type" required>
        <option value="">Select type...</option>
        <option value="staff">Staff</option>
        <option value="undergrad">Undergraduate RA</option>
        <option value="grad">Graduate RA</option>
        <option value="postdoc">Post-Doctoral Researcher</option>
    </select>

    <br><br>

    <!-- UNIVERSAL NAME FIELD -->
    <label>Name:</label>
    <input type="text" name="name" required><br><br>

    <!-- STAFF FIELDS -->
    <div id="staff_fields" class="hidden">

        <label>Hourly Rate:</label>
        <input type="number" step="0.01" name="hourly_rate"><br><br>

        <label>Job (description):</label>
        <input type="text" name="job"><br><br>

        <label>Staff Title:</label>
        <select name="staff_title">
            <?php foreach ($staff_titles as $t): ?>
                <option value="<?= $t ?>"><?= $t ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label>PI Eligible:</label>
        <select name="is_pi_eligible">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>

        <br><br>
    </div>

    <!-- UNDERGRAD FIELDS -->
    <div id="undergrad_fields" class="hidden">
        <label>Major:</label>
        <input type="text" name="major"><br><br>

        <label>Residency:</label>
        <select name="residency">
            <option value="In-State">In-State</option>
            <option value="Out-of-State">Out-of-State</option>
        </select><br><br>

        <label>Max FTE:</label>
        <input type="number" step="0.01" name="max_fte"><br><br>

        <label>Stipend Per Academic Year:</label>
        <input type="number" step="0.01" name="stipend"><br><br>
    </div>

    <!-- GRAD FIELDS -->
    <div id="grad_fields" class="hidden">
        <label>Program:</label>
        <input type="text" name="program"><br><br>

        <label>Residency:</label>
        <select name="residency">
            <option value="In-State">In-State</option>
            <option value="Out-of-State">Out-of-State</option>
        </select><br><br>

        <label>Max FTE:</label>
        <input type="number" step="0.01" name="max_fte"><br><br>

        <label>Stipend Per Academic Year:</label>
        <input type="number" step="0.01" name="stipend"><br><br>
    </div>

    <!-- POSTDOC FIELDS -->
    <div id="postdoc_fields" class="hidden">
        <label>Field:</label>
        <input type="text" name="field"><br><br>

        <label>Appointment Type:</label>
        <select name="appointment_type">
            <option value="Full-Time">Full-Time</option>
            <option value="Part-Time">Part-Time</option>
        </select><br><br>

        <label>Max FTE:</label>
        <input type="number" step="0.01" name="max_fte"><br><br>

        <label>Stipend Per Academic Year:</label>
        <input type="number" step="0.01" name="stipend"><br><br>
    </div>

    <button type="submit">Add Personnel</button>
</form>


<fieldset>
<legend>Add New Job Title</legend>

<form method="POST">
    <label>New Staff Title:</label>
    <input type="text" name="new_staff_title" required><br><br>

    <label>Fringe Rate (%):</label>
    <input type="number" step="0.01" name="new_fringe_rate" required><br><br>

    <button type="submit" name="add_new_job">Add Job Title</button>
</form>
</fieldset>

<p style="color: red;">⚠ Warning: Please double-check entries before adding!</p>
<p style="color: red;">EzBudgets is not meant to support custom entries. If you think a mistake has been made, contact your financial department to update our databases with your university's personnel information and rates.</p>

<!-- Back to Dashboard Button -->
<a href="dashboard.php" style="display:inline-block;">
    <button type="button" style="background-color: rgb(200,200,200); border: 1px solid black; border-radius: 0; width: 100px; height: 28px; cursor: pointer;">
        Back
    </button>
</a>


<script>
function showFields() {
    let type = document.getElementById("personnel_type").value;

    document.getElementById("staff_fields").style.display = "none";
    document.getElementById("undergrad_fields").style.display = "none";
    document.getElementById("grad_fields").style.display = "none";
    document.getElementById("postdoc_fields").style.display = "none";

    if (type === "staff") document.getElementById("staff_fields").style.display = "block";
    if (type === "undergrad") document.getElementById("undergrad_fields").style.display = "block";
    if (type === "grad") document.getElementById("grad_fields").style.display = "block";
    if (type === "postdoc") document.getElementById("postdoc_fields").style.display = "block";
}
</script>

</body>
</html>
