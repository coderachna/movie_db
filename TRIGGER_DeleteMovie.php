<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trigger Test – Delete Movie</title>

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
        max-width: 600px;
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
        cursor: pointer;
        transition: .3s;
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
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: .3s;
    }

    .back-btn:hover { background: #555; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px);}
        to { opacity: 1; transform: translateY(0);}
    }
</style>

</head>
<body>

<div class="navbar">🎬 Trigger Test – Delete Movie</div>

<div class="container">

<h1>Delete Movie (Trigger Logs Deletion)</h1>

<form method="POST">

    <label>Movie ID:</label>
    <input type="number" name="mid" required>

    <button type="submit" name="del">Delete Movie</button>

</form>

<?php
if(isset($_POST['del'])){

    $mid = $_POST['mid'];

    echo "<div class='output-box'>";

    // DELETE movie → BEFORE DELETE trigger fires
    $sql = "DELETE FROM Movie WHERE Movie_Id = $mid";

    if(mysqli_query($connection, $sql)){
        echo "<p class='success'>
                ✔ Movie deleted successfully!<br>
                ✔ BEFORE DELETE trigger inserted old data into Movie_Delete_Log.
              </p>";
    } else {
        echo "<p class='error'>SQL Error: " . mysqli_error($connection) . "</p>";
        echo "</div>";
        exit;
    }

    // Fetch latest delete log
    $log = mysqli_query($connection,
        "SELECT * FROM Movie_Delete_Log ORDER BY Deleted_On DESC LIMIT 1"
    );

    if(mysqli_num_rows($log) > 0){
        $row = mysqli_fetch_assoc($log);

        echo "<h3 style='color:#ffce54;'>Latest Delete Log Entry</h3>";
        echo "<p><b>Movie ID:</b> $row[Movie_Id]</p>";
        echo "<p><b>Title:</b> $row[Title]</p>";
        echo "<p><b>Deleted On:</b> $row[Deleted_On]</p>";
    }

    echo "</div>";
}
?>

<a href="index.php" class="back-btn">⬅ Back to Dashboard</a>

</div>

</body>
</html>

