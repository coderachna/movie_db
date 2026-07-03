<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trigger Test – Movie Insert Audit</title>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #0d0d0f;
        margin: 0;
        padding: 0;
        color: #e4e4e4;
    }

    .navbar {
        width: 100%;
        background: #111;
        padding: 18px 40px;
        font-size: 24px;
        font-weight: 600;
        color: #ffce54;
        letter-spacing: 1px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.6);
    }

    .container {
        max-width: 750px;
        margin: 40px auto;
        background: #1a1a1d;
        padding: 35px;
        border-radius: 14px;
        box-shadow: 0 0 40px rgba(0,0,0,0.55);
        animation: fadeIn .4s ease-in-out;
    }

    h1 {
        text-align: center;
        color: #ffce54;
        margin-bottom: 25px;
        font-size: 26px;
    }

    label {
        font-weight: 500;
        font-size: 15px;
        margin-top: 10px;
        display: block;
    }

    input {
        width: 100%;
        padding: 11px;
        margin-top: 6px;
        margin-bottom: 16px;
        background: #2b2b31;
        border: none;
        color: #fff;
        border-radius: 8px;
        font-size: 15px;
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #ffce54;
        color: #000;
        border: none;
        border-radius: 8px;
        font-size: 17px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #ffe083;
        transform: translateY(-2px);
    }

    .output-box {
        margin-top: 30px;
        padding: 22px;
        background: #26262b;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.35);
    }

    .success {
        color: #9cffb3;
        font-weight: bold;
    }

    .error {
        color: #ff6b6b;
        font-weight: bold;
    }

    .back-btn {
        display: inline-block;
        margin-top: 25px;
        padding: 10px 18px;
        background: #444;
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: .3s;
    }

    .back-btn:hover {
        background: #555;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px);}
        to { opacity: 1; transform: translateY(0);}
    }
</style>

</head>
<body>

<div class="navbar">🎬 Trigger Test – Movie Insert Audit</div>

<div class="container">

<h1>Add New Movie (Trigger Creates Audit Log)</h1>

<form method="POST">

    <label>Title:</label>
    <input type="text" name="title" required>

    <label>Release Year:</label>
    <input type="number" name="year" required>

    <label>Genre:</label>
    <input type="text" name="genre" required>

    <label>Language:</label>
    <input type="text" name="lang" required>

    <label>Duration (Minutes):</label>
    <input type="number" name="duration" required>

    <label>Budget:</label>
    <input type="number" name="budget" required>

    <label>Studio ID:</label>
    <input type="number" name="studio" required>

    <label>Director ID:</label>
    <input type="number" name="director" required>

    <button type="submit" name="submit">Add Movie</button>

</form>

<?php
if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $lang = $_POST['lang'];
    $duration = $_POST['duration'];
    $budget = $_POST['budget'];
    $studio = $_POST['studio'];
    $director = $_POST['director'];

    echo "<div class='output-box'>";

    // Check duplicate
    $check = mysqli_query($connection,
        "SELECT * FROM Movie WHERE Title='$title' AND Release_Year=$year"
    );

    if(mysqli_num_rows($check) > 0){
        echo "<p class='error'>❌ This movie already exists.</p>";
        echo "</div>";
    } else {

        // Insert → Trigger Runs
        $insertSQL = "
            INSERT INTO Movie
            (Title, Release_Year, Genre, Language, Duration_Min, Budget, Studio_Id, Director_Id)
            VALUES
            ('$title', $year, '$genre', '$lang', $duration, $budget, $studio, $director)
        ";

        if(mysqli_query($connection, $insertSQL)){
            echo "<p class='success'>✔ Movie inserted successfully!<br>
                  ✔ AFTER INSERT trigger added a record to Movie_Audit.</p>";
        } else {
            echo "<p class='error'>Database Error: " . mysqli_error($connection) . "</p>";
            echo "</div>";
            return;
        }

        // Fetch latest audit log
        $auditResult = mysqli_query($connection,
            "SELECT * FROM Movie_Audit ORDER BY Action_Time DESC LIMIT 1"
        );

        if(mysqli_num_rows($auditResult) > 0){
            $audit = mysqli_fetch_assoc($auditResult);

            echo "<h3 style='color:#ffce54;'>Latest Audit Log Entry</h3>";
            echo "<p><b>Movie ID:</b> {$audit['Movie_Id']}</p>";
            echo "<p><b>Title:</b> {$audit['Title']}</p>";
            echo "<p><b>Action:</b> {$audit['Action']}</p>";
            echo "<p><b>Time:</b> {$audit['Action_Time']}</p>";
            echo "<p><b>Movie Age:</b> {$audit['Movie_Age_Years']} years</p>";
        }
        echo "</div>";
    }
}
?>

<a href="index.php" class="back-btn">⬅ Back to Dashboard</a>

</div>

</body>
</html>


