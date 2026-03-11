<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trigger Test – Movie Award Insert</title>

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
        box-shadow: 0 4px 25px rgba(0,0,0,0.6);
        letter-spacing: 1px;
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
        color: #ffce54;
        text-align: center;
        margin-bottom: 25px;
        font-size: 26px;
    }

    label {
        font-size: 15px;
        font-weight: 500;
        margin-top: 10px;
        display: block;
    }

    input {
        width: 100%;
        padding: 11px;
        background: #2b2b31;
        border: none;
        margin-top: 6px;
        margin-bottom: 16px;
        border-radius: 8px;
        color: #fff;
        outline: none;
        font-size: 15px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #ffce54;
        color: #000;
        font-size: 17px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        margin-top: 10px;
        cursor: pointer;
        transition: .3s;
    }

    button:hover {
        background: #ffe083;
        transform: translateY(-2px);
    }

    .output-box {
        background: #26262b;
        padding: 22px;
        border-radius: 10px;
        margin-top: 30px;
        box-shadow: 0 0 20px rgba(0,0,0,0.35);
    }

    .success { color: #9cffb3; font-weight: bold; }
    .error { color: #ff6b6b; font-weight: bold; }

    .back-btn {
        display: inline-block;
        margin-top: 25px;
        padding: 10px 18px;
        background: #444;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: .3s;
    }
    .back-btn:hover { background: #555; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

</head>
<body>

<div class="navbar">🎬 Trigger Test – Insert Movie Award</div>

<div class="container">

<h1>Add Award for Movie (Triggers Fire Automatically)</h1>

<form method="POST">

    <label>Movie ID:</label>
    <input type="number" name="movie_id" required>

    <label>Award ID:</label>
    <input type="number" name="award_id" required>

    <label>Award Year:</label>
    <input type="number" name="award_year" required>

    <label>Result (Won / Nominated):</label>
    <input type="text" name="result" required>

    <button type="submit" name="submit">Insert Award</button>
</form>

<?php
if(isset($_POST['submit'])){

    $mid = $_POST['movie_id'];
    $aid = $_POST['award_id'];
    $year = $_POST['award_year'];
    $result = $_POST['result'];

    echo "<div class='output-box'>";

    // STEP 1 — Check duplicate PK
    $checkSQL = "
        SELECT * FROM Movie_Award 
        WHERE Movie_Id=$mid 
        AND Award_Id=$aid 
        AND Award_Year=$year
    ";

    $check = mysqli_query($connection, $checkSQL);

    if(mysqli_num_rows($check) > 0){
        echo "<p class='error'>
                ❌ ERROR: This combination already exists.<br>
                PRIMARY KEY prevents duplicates.
              </p>";
        echo "</div>";
    }
    else {

        // STEP 2 — Insert Award → triggers fire
        $insertSQL = "
            INSERT INTO Movie_Award (Movie_Id, Award_Id, Award_Year, Result)
            VALUES ($mid, $aid, $year, '$result')
        ";

        if(mysqli_query($connection, $insertSQL)){
            echo "<p class='success'>
                    ✔ Award inserted successfully!<br>
                    ✔ BEFORE INSERT trigger corrected invalid year<br>
                    ✔ AFTER INSERT trigger updated Award_Points table
                  </p>";
        }
        else {
            echo "<p class='error'>SQL Error: ".mysqli_error($connection)."</p>";
            echo "</div>";
            return;
        }

        // STEP 3 — Show updated Award Points
        $points = mysqli_query($connection,
            "SELECT * FROM Award_Points WHERE Movie_Id=$mid"
        );

        if(mysqli_num_rows($points) > 0){
            $row = mysqli_fetch_assoc($points);

            echo "<h3 style='color:#ffce54;'>Updated Award Points</h3>";
            echo "<p><b>Movie ID:</b> $row[Movie_Id]</p>";
            echo "<p><b>Total Points:</b> $row[Total_Points]</p>";
        }
    }

    echo "</div>";
}
?>

<a href="index.php" class="back-btn">⬅ Back to Dashboard</a>

</div>

</body>
</html>
