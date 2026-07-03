<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MovieDB Dashboard</title>

<style>
    /* --------- GLOBAL ------- */
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background: #0d0d0d; /* Premium black */
        color: #e6e6e6; 
    }

    .header {
        padding: 50px 20px;
        text-align: center;
    }

    .header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #d4af37;   /* Gold */
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* -------- SECTION TITLES ------- */
    .section-title {
        text-align: center;
        margin-top: 45px;
        margin-bottom: 10px;
        font-size: 28px;
        font-weight: 600;
        color: #d4af37;
        border-bottom: 1px solid #333;
        width: 90%;
        margin-left: auto;
        margin-right: auto;
        padding-bottom: 10px;
    }

    /* -------- GRID CONTAINER ------- */
    .container {
        max-width: 1200px;
        margin: auto;
        padding: 20px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
        margin-top: 25px;
    }

    /* -------- MODERN PREMIUM CARD -------- */
    .card {
        background: #1a1a1a;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #2a2a2a;
        transition: 0.3s ease;
        cursor: pointer;
        box-shadow: 0 0 0 rgba(0,0,0,0);
    }

    .card:hover {
        border-color: #d4af37;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.5);
    }

    /* -------- LINKS INSIDE CARDS -------- */
    a {
        text-decoration: none;
        color: #e6e6e6;
        font-size: 18px;
        font-weight: 500;
        display: block;
    }

    .card:hover a {
        color: #d4af37;
    }

</style>
</head>

<body>

<div class="header">
    <h1>MovieDB Dashboard</h1>
</div>

<div class="container">

<!-- ========================== QUERIES ========================== -->
<h2 class="section-title">Queries</h2>

<div class="grid">
    <div class="card"><a href="q1.php">Movies After 2015</a></div>
    <div class="card"><a href="q2.php">Movies With Studio Name</a></div>
    <div class="card"><a href="q3.php">Cast List</a></div>
    <div class="card"><a href="q4.php">OTT Platforms</a></div>
    <div class="card"><a href="q5.php">Total Box Office</a></div>
    <div class="card"><a href="q6.php">Avg Rating by Genre</a></div>
    <div class="card"><a href="q7.php">Actors on Netflix Movies</a></div>
    <div class="card"><a href="q8.php">Awarded Movies</a></div>
    <div class="card"><a href="q9.php">Highest Box Office Movie</a></div>
    <div class="card"><a href="q10.php">Rating > Movies Before 2015</a></div>
    <div class="card"><a href="q11.php">Drama Skill Actors</a></div>
    <div class="card"><a href="q12.php">Drama OR Award Actors</a></div>
    <div class="card"><a href="q13.php">All Studios (Left Join)</a></div>
    <div class="card"><a href="q14.php">Search by Title + Rating</a></div>
    <div class="card"><a href="q15.php">Movies per OTT Platform</a></div>
</div>

<!-- ========================== PROCEDURES ========================== -->
<h2 class="section-title">Procedures</h2>

<div class="grid">
    <div class="card"><a href="PROC_AddMovieAward.php">Add Movie Award</a></div>
    <div class="card"><a href="PROC_AddMovieBasic.php">Add Movie Basic</a></div>
    <div class="card"><a href="PROC_CreateOttMovieList.php">Create OTT Movie List</a></div>
    <div class="card"><a href="PROC_SearchMovie.php">Search Movie</a></div>
<div class="card"><a href="CURSOR_SumBudgetByStudio.php">Sum Budget by Studio (Cursor)</a></div>


    <div class="card"><a href="PROC_UpdateMoviePerformance.php">Update Movie Performance</a></div>
</div>

<!-- ========================== FUNCTIONS ========================== -->
<h2 class="section-title">Functions</h2>

<div class="grid">
    <div class="card"><a href="FUNC_GetActorMovieCount.php">Actor Movie Count</a></div>
    <div class="card">
    <a href="FUNC_GetAverageRatingByGenre.php">Average Rating by Genre</a>
</div>

    <div class="card"><a href="FUNC_GetMovieAge.php">Movie Age (Years)</a></div>
    <div class="card"><a href="FUNC_GetMovieSuccessLevel.php">Movie Success Level</a></div>
    <div class="card"><a href="FUNC_GetPersonFullName.php">Full Person Name</a></div>
    
</div>

<!-- ========================== TRIGGERS ========================== -->
<h2 class="section-title">Triggers</h2>

<div class="grid">
    <div class="card"><a href="TRG_Insert_MovieAward.php">Before Insert – Movie Award (Year Fix)</a></div>
    <div class="card"><a href="TRG_Insert_Movie.php">After Insert – Movie Audit</a></div>
    <div class="card"><a href="TRG_UpdateMovieRating.php">After Update – Rating Log</a></div>
    <div class="card"><a href="TRIGGER_DeleteMovie.php">Before Delete – Movie Delete Log</a></div>
    <div class="card"><a href="TRG_Insert_AwardPoints.php">After Insert – Award Points</a></div>
</div>

</div>

</body>
</html>

