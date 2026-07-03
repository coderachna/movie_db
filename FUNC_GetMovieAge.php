<?php
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Get Movie Age</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #0d0d0f;
            color: #e4e4e4;
        }

        .navbar {
            background: #111111;
            padding: 18px 40px;
            font-size: 22px;
            font-weight: 600;
            color: #ffce54;
            letter-spacing: 1px;
            box-shadow: 0 2px 18px rgba(0,0,0,0.7);
        }

        .container {
            max-width: 500px;
            margin: 60px auto;
            background: #1b1b1d;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 0 25px rgba(0,0,0,0.6);
            animation: fadeIn 0.5s ease-in-out;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
            color: #ffce54;
        }

        label {
            font-size: 15px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            margin-bottom: 18px;
            border: none;
            border-radius: 8px;
            background: #2a2a2d;
            color: #fff;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            background: #ffce54;
            color: #000;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #ffdb79;
            transform: translateY(-2px);
        }

        .result-box {
            margin-top: 25px;
            background: #262629;
            padding: 18px;
            border-radius: 8px;
            font-size: 17px;
        }

        a.btn-back {
            display: block;
            margin-top: 25px;
            text-align: center;
            padding: 12px;
            background: #333;
            color: #ffce54;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
        }

        a.btn-back:hover {
            background: #444;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

</head>
<body>

<div class="navbar">🎬 MovieDB — Function: Get Movie Age</div>

<div class="container">
    <h2>Get Movie Age (Years Since Release)</h2>

    <form method="POST">
        <label>Movie ID:</label>
        <input type="number" name="mid" required>

        <button type="submit" name="go">Get Movie Age</button>
    </form>

    <?php
    if(isset($_POST['go'])){
        $mid = $_POST['mid'];

        $sql = "SELECT GetMovieAge($mid) AS age";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);

        echo "<div class='result-box'>
                <b>Movie Age:</b> {$row['age']} years
              </div>";
    }
    ?>

    <a href="index.php" class="btn-back">⬅ Back to Dashboard</a>
</div>

</body>
</html>

