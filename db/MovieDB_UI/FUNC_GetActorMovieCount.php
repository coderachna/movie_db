<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Get Actor Movie Count</title>

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
        display: block;
        margin-top: 10px;
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
        font-size: 15px;
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #ffce54;
        color: #000;
        font-size: 17px;
        border: none;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: .3s;
    }

    button:hover {
        background: #ffe083;
        transform: translateY(-2px);
    }

    .output-box {
        margin-top: 25px;
        background: #26262b;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 25px rgba(0,0,0,0.35);
        animation: fadeIn .4s ease-in-out;
    }

    .result-label {
        color: #ffce54;
        font-size: 18px;
        font-weight: bold;
    }

    .back-btn {
        display: inline-block;
        margin-top: 25px;
        padding: 10px 18px;
        background: #444;
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: .3s;
    }

    .back-btn:hover { background: #555; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

</head>
<body>

<div class="navbar">🎬 Get Actor Movie Count</div>

<div class="container">

<h1>Check How Many Movies an Actor Has Done</h1>

<form method="POST">

    <label>Actor ID:</label>
    <input type="number" name="aid" required>

    <button type="submit" name="go">Get Movie Count</button>

</form>

<?php
if(isset($_POST['go'])){
    $aid = $_POST['aid'];

    $sql = "SELECT GetActorMovieCount($aid) AS movieCount";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

    echo "<div class='output-box'>";
    echo "<p class='result-label'>Total Movies Performed:</p>";
    echo "<p style='font-size:22px; font-weight:bold; color:#9cffb3;'>{$row['movieCount']}</p>";
    echo "</div>";
}
?>

<a href="index.php" class="back-btn">⬅ Back to Dashboard</a>

</div>

</body>
</html>

