<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Movie (Procedure)</title>

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

<div class="navbar">🎬 MovieDB — Procedure: AddMovieBasic</div>

<div class="container">

    <h2>Add Movie</h2>

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

        $sql = "CALL AddMovieBasic(
            '$title', $year, '$genre', '$lang',
            $duration, $budget, $studio, $director
        )";

        if(mysqli_query($connection, $sql)){
            echo "<div class='result-box'>
                    <b>✔ Movie Added Successfully!</b>
                  </div>";
        } else {
            echo "<div class='result-box'>
                    <b style='color:red;'>❌ Error: ".mysqli_error($connection)."</b>
                  </div>";
        }
    }
    ?>

    <a href="index.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
