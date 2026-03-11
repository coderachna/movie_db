<?php
include "db.php";

$query = "
SELECT DISTINCT P.First_Name, P.Last_Name
FROM Person P, Actor A, Actor_Skills S
WHERE P.Person_Id = A.Person_Id
AND A.Actor_Id = S.Actor_Id
AND S.Skill_Name = 'Drama'
UNION
SELECT DISTINCT P2.First_Name, P2.Last_Name
FROM Person P2, Actor A2, Movie_Actor MA2, Movie_Award AW
WHERE P2.Person_Id = A2.Person_Id
AND A2.Actor_Id = MA2.Actor_Id
AND MA2.Movie_Id = AW.Movie_Id
";

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Drama Skill OR Award Actors</title>

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
        padding: 15px 40px;
        font-size: 22px;
        font-weight: 600;
        color: #ffce54;
        box-shadow: 0 2px 20px rgba(0,0,0,0.6);
    }

    .container {
        max-width: 950px;
        margin: 40px auto;
        padding: 30px;
        background: #1a1a1d;
        border-radius: 14px;
        box-shadow: 0 0 40px rgba(0,0,0,0.5);
        animation: fadeIn 0.5s ease-in-out;
    }

    h1 {
        font-size: 28px;
        margin-bottom: 20px;
        text-align: center;
        color: #ffce54;
        letter-spacing: 1px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #26262b;
        border-radius: 10px;
        overflow: hidden;
    }

    th {
        background: #333338;
        padding: 12px;
        text-align: left;
        color: #ffce54;
        letter-spacing: .5px;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #3b3b42;
    }

    tr:hover {
        background: #2f2f36;
    }

    a.btn {
        display: inline-block;
        padding: 12px 20px;
        margin-top: 25px;
        background: #ffce54;
        color: #000;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }

    a.btn:hover {
        background: #ffdb79;
        transform: translateY(-2px);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

</head>

<body>

<div class="navbar">🎬 MovieDB</div>

<div class="container">

    <h1>Actors With Drama Skill OR Awarded Movie Participation</h1>

    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>

        <?php while($r = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $r['First_Name'] ?></td>
            <td><?= $r['Last_Name'] ?></td>
        </tr>
        <?php } ?>
    </table>

    <a href="index.php" class="btn">⬅ Back to Dashboard</a>

</div>

</body>
</html>

