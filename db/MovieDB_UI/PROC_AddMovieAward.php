<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Movie Award (Procedure)</title>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #0d0d0f;
        margin: 0;
        padding: 0;
        color: #e4e4e4;
    }
    .navbar {
        background: #111;
        padding: 18px 40px;
        font-size: 22px;
        font-weight: 600;
        color: #ffce54;
        box-shadow: 0 2px 20px rgba(0,0,0,0.5);
    }
    .container {
        max-width: 650px;
        margin: 60px auto;
        background: #1a1a1d;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 0 40px rgba(0,0,0,0.6);
        animation: fadeIn .4s ease-in-out;
    }
    h2 {
        text-align: center;
        color: #ffce54;
        margin-bottom: 25px;
        letter-spacing: 1px;
    }

    label {
        font-size: 15px;
        font-weight: 500;
        display: block;
        margin-bottom: 8px;
    }
    input {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #333;
        background: #222;
        color: #fff;
        margin-bottom: 18px;
        font-size: 15px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #ffce54;
        color: #000;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: .3s;
    }
    button:hover {
        background: #ffdf7a;
        transform: translateY(-2px);
    }

    .result-box {
        margin-top: 22px;
        padding: 18px;
        background: #26262b;
        border-radius: 12px;
        border: 1px solid #444;
    }
    a {
        display: block;
        text-align: center;
        margin-top: 25px;
        color: #ffce54;
        text-decoration: none;
        font-size: 16px;
    }

    @keyframes fadeIn {
        from {opacity:0; transform: translateY(12px);}
        to {opacity:1; transform: translateY(0);}
    }
</style>

</head>

<body>

<div class="navbar">🎬 MovieDB — Procedure: AddMovieAward</div>

<div class="container">

    <h2>Add Movie Award</h2>

    <form method="POST">
        <label>Movie ID:</label>
        <input type="number" name="mid" required>

        <label>Award ID:</label>
        <input type="number" name="aid" required>

        <label>Award Year:</label>
        <input type="number" name="year" required>

        <label>Result (Won / Nominated):</label>
        <input type="text" name="result" required>

        <button type="submit" name="add">Add Award</button>
    </form>

    <?php
    if(isset($_POST['add'])){
        $mid = $_POST['mid'];
        $aid = $_POST['aid'];
        $year = $_POST['year'];
        $result = $_POST['result'];

        mysqli_query($connection, "SET @msg = ''");

        $sql = "CALL AddMovieAward($mid, $aid, $year, '$result', @msg)";
        mysqli_query($connection, $sql);

        $status = mysqli_fetch_assoc(
            mysqli_query($connection, 'SELECT @msg AS status')
        )['status'];

        echo "<div class='result-box'><b>$status</b></div>";
    }
    ?>

    <a href="index.php">⬅ Back to Dashboard</a>

</div>

</body>
</html>
