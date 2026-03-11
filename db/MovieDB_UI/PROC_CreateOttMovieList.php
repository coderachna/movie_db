<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>OTT Movie List (Cursor)</title>

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
        white-space: break-spaces;
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

<div class="navbar">🎬 MovieDB — Cursor: CreateOttMovieList</div>

<div class="container">

    <h2>OTT Movie List (Cursor Output)</h2>

    <form method="POST">

        <label>Enter OTT ID:</label>
        <input type="number" name="ott" required>

        <button type="submit" name="go">Get Movie List</button>
    </form>

    <?php
    if(isset($_POST['go'])){
        $ott = $_POST['ott'];

        mysqli_query($connection, "SET @list := ''");

        mysqli_query($connection, "CALL CreateOttMovieList($ott, @list)");

        $movies = mysqli_fetch_assoc(
            mysqli_query($connection, "SELECT @list AS movies")
        )['movies'];

        if($movies == ""){
            $movies = "<i>No movies found for this OTT platform.</i>";
        }

        echo "<div class='result-box'>
                <b>Movies on OTT ID $ott:</b><br>$movies
              </div>";
    }
    ?>

    <a href="index.php">⬅ Back to Dashboard</a>

</div>

</body>
</html>

