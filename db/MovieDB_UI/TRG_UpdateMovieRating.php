<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trigger Test – Update Movie Rating</title>

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

<div class="navbar">🎬 Trigger Test – Rating Change Log</div>

<div class="container">

<h1>Update Movie Rating (Trigger Logs Change)</h1>

<form method="POST">

    <label>Movie ID:</label>
    <input type="number" name="mid" required>

    <label>New Rating:</label>
    <input type="number" step="0.1" name="rating" required>

    <button type="submit" name="upd">Update Rating</button>

</form>

<?php
if(isset($_POST['upd'])){

    $mid = $_POST['mid'];
    $rating = $_POST['rating'];

    echo "<div class='output-box'>";

    // Update rating → Trigger fires
    $sql = "UPDATE Movie SET Rating = $rating WHERE Movie_Id = $mid";

    if(mysqli_query($connection, $sql)){
        echo "<p class='success'>
                ✔ Rating updated successfully!<br>
                ✔ AFTER UPDATE trigger logged rating change.
              </p>";
    } else {
        echo "<p class='error'>SQL Error: " . mysqli_error($connection) . "</p>";
        echo "</div>";
        exit;
    }

    // Show latest log entry
    $log = mysqli_query($connection,
        "SELECT * FROM Rating_Changes_Log ORDER BY Change_Time DESC LIMIT 1");

    if(mysqli_num_rows($log) > 0){
        $row = mysqli_fetch_assoc($log);

        echo "<h3 style='color:#ffce54;'>Latest Rating Change Log</h3>";
        echo "<p><b>Movie ID:</b> $row[Movie_Id]</p>";
        echo "<p><b>Old Rating:</b> $row[Old_Rating]</p>";
        echo "<p><b>New Rating:</b> $row[New_Rating]</p>";
        echo "<p><b>Logged At:</b> $row[Change_Time]</p>";
    }

    echo "</div>";
}
?>

<a href="index.php" class="back-btn">⬅ Back to Dashboard</a>

</div>

</body>
</html>

