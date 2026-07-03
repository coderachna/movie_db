<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Search Movie (Procedure)</title>

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
        max-width: 800px;
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

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        background: #26262b;
        border-radius: 10px;
        overflow: hidden;
    }
    th {
        background: #333338;
        padding: 12px;
        color: #ffce54;
        font-size: 15px;
    }
    td {
        padding: 12px;
        border-bottom: 1px solid #3b3b42;
    }
    tr:hover {
        background: #2f2f36;
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

<div class="navbar">🎬 MovieDB — Procedure: SearchMovie</div>

<div class="container">

    <h2>Search Movie</h2>

    <form method="POST">
        <label>Enter Title / Genre keyword:</label>
        <input type="text" name="term" required>

        <button type="submit" name="search">Search Movie</button>
    </form>

    <?php
    if(isset($_POST['search'])){
        $term = $_POST['term'];

        $sql = "CALL SearchMovie('$term')";
        $result = mysqli_query($connection, $sql);

        echo "<h2 style='margin-top:35px;'>Search Results</h2>";
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Year</th>
                    <th>Genre</th>
                    <th>Budget</th>
                </tr>";

        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>
                    <td>{$row['Movie_Id']}</td>
                    <td>{$row['Title']}</td>
                    <td>{$row['Release_Year']}</td>
                    <td>{$row['Genre']}</td>
                    <td>{$row['Budget']}</td>
                </tr>";
        }

        echo "</table>";
    }
    ?>

    <a href="index.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>

