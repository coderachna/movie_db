<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trigger Test – Award Points</title>

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
        max-width: 700px;
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
        font-size: 26px;
        margin-bottom: 25px;
    }

    label {
        font-size: 16px;
        margin-top: 10px;
        display: block;
        font-weight: 500;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 6px;
        margin-bottom: 18px;
        border: none;
        border-radius: 8px;
        background: #2b2b31;
        color: #fff;
        font-size: 15px;
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #ffce54;
        color: #000;
        border: none;
        font-size: 17px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: .3s;
        margin-top: 10px;
    }

    button:hover {
        background: #ffe083;
        transform: translateY(-2px);
    }

    .output-box {
        margin-top: 30px;
        padding: 20px;
        background: #26262b;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.3);
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

<div class="navbar">🎬 Trigger Test – Award Points</div>

<div class="container">

<h1>Insert Award (Trigger Will Auto-Update Points)</h1>

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
if (isset($_POST['submit'])) {

    $mid = $_POST['movie_id'];
    $aid = $_POST['award_id'];
    $year = $_POST['award_year'];
    $result = $_POST['result'];

    echo "<div class='output-box'>";

    $sql = "INSERT INTO Movie_Award (Movie_Id, Award_Id, Award_Year, Result)
            VALUES ($mid, $aid, $year, '$result')";

    if (mysqli_query($connection, $sql)) {
        echo "<p><b style='color:#9cffb3;'>✔ Award inserted successfully!</b><br>
              Trigger automatically updated Award_Points.</p>";
    } else {
        echo "<p><b style='color:#ff6b6b;'>✖ Error: </b>" . mysqli_error($connection) . "</p>";
        echo "</div>";
        return;
    }

    $q = mysqli_query($connection, "SELECT * FROM Award_Points WHERE Movie_Id = $mid");

    if (mysqli_num_rows($q) > 0) {
        $row = mysqli_fetch_assoc($q);

        echo "<h3 style='color:#ffce54;'>Updated Award Points</h3>";
        echo "<p><b>Movie ID:</b> $row[Movie_Id]</p>";
        echo "<p><b>Total Points:</b> $row[Total_Points]</p>";

    } else {
        echo "<p>No Award_Points row existed earlier. Trigger inserted the first one.</p>";
    }

    echo "</div>";
}
?>

<a href="index.php" class="back-btn">⬅ Back to Dashboard</a>

</div>

</body>
</html>

