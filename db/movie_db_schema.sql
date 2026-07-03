SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE Person (
  Person_Id INT NOT NULL AUTO_INCREMENT,
  First_Name VARCHAR(100),
  Last_Name VARCHAR(100),
  Gender CHAR(1),
  Date_Of_Birth DATE,
  Nationality VARCHAR(100),
  PRIMARY KEY (Person_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Actor (
  Actor_Id INT NOT NULL AUTO_INCREMENT,
  Person_Id INT,
  Debut_Year INT,
  PRIMARY KEY (Actor_Id),
  UNIQUE KEY Person_Id (Person_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Director (
  Director_Id INT NOT NULL AUTO_INCREMENT,
  Person_Id INT,
  Style VARCHAR(150),
  PRIMARY KEY (Director_Id),
  UNIQUE KEY Person_Id (Person_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Employee (
  Employee_Id INT NOT NULL AUTO_INCREMENT,
  Person_Id INT,
  Job_Title VARCHAR(100),
  Hire_Date DATE,
  Salary DECIMAL(12,2),
  PRIMARY KEY (Employee_Id),
  UNIQUE KEY Person_Id (Person_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Producer (
  Producer_Id INT NOT NULL AUTO_INCREMENT,
  Person_Id INT,
  Company_Name VARCHAR(150),
  PRIMARY KEY (Producer_Id),
  UNIQUE KEY Person_Id (Person_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Technician (
  Technician_Id INT NOT NULL AUTO_INCREMENT,
  Person_Id INT,
  Specialization VARCHAR(150),
  PRIMARY KEY (Technician_Id),
  UNIQUE KEY Person_Id (Person_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Manager (
  Manager_Id INT NOT NULL AUTO_INCREMENT,
  Department VARCHAR(100),
  PRIMARY KEY (Manager_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Studio (
  Studio_Id INT NOT NULL AUTO_INCREMENT,
  Studio_Name VARCHAR(150),
  Headquarters_City VARCHAR(100),
  Founded_Year INT,
  PRIMARY KEY (Studio_Id),
  UNIQUE KEY Studio_Name (Studio_Name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Location (
  Location_Id INT NOT NULL AUTO_INCREMENT,
  City VARCHAR(100),
  Country VARCHAR(100),
  PRIMARY KEY (Location_Id),
  UNIQUE KEY City (City)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE OttPlatform (
  Ott_Id INT NOT NULL AUTO_INCREMENT,
  Platform_Name VARCHAR(100),
  Subscription_Type VARCHAR(20),
  Website_URL VARCHAR(255),
  PRIMARY KEY (Ott_Id),
  UNIQUE KEY Platform_Name (Platform_Name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Award (
  Award_Id INT NOT NULL AUTO_INCREMENT,
  Award_Name VARCHAR(150),
  Category VARCHAR(100),
  Awarding_Body VARCHAR(150),
  PRIMARY KEY (Award_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Movie (
  Movie_Id INT NOT NULL AUTO_INCREMENT,
  Title VARCHAR(255),
  Release_Year INT,
  Genre VARCHAR(100),
  Language VARCHAR(50),
  Duration_Min INT,
  Budget DECIMAL(15,2),
  Box_Office DECIMAL(15,2),
  Rating DECIMAL(3,1),
  Studio_Id INT,
  Manager_Id INT,
  Director_Id INT,
  PRIMARY KEY (Movie_Id),
  KEY Studio_Id (Studio_Id),
  KEY Manager_Id (Manager_Id),
  KEY Director_Id (Director_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Award_Points (
  Movie_Id INT NOT NULL,
  Total_Points INT,
  PRIMARY KEY (Movie_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Actor_Skills (
  Actor_Id INT NOT NULL,
  Skill_Name VARCHAR(100) NOT NULL,
  Proficiency_Level VARCHAR(20),
  PRIMARY KEY (Actor_Id, Skill_Name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Movie_Actor (
  Movie_Id INT NOT NULL,
  Actor_Id INT NOT NULL,
  Role_Name VARCHAR(150),
  Billing_Order INT,
  PRIMARY KEY (Movie_Id, Actor_Id),
  KEY Actor_Id (Actor_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Movie_Audit (
  Audit_Id INT NOT NULL AUTO_INCREMENT,
  Movie_Id INT,
  Title VARCHAR(255),
  Action VARCHAR(20),
  Action_Time DATETIME,
  Movie_Age_Years INT,
  PRIMARY KEY (Audit_Id),
  KEY Movie_Id (Movie_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Movie_Award (
  Movie_Id INT NOT NULL,
  Award_Id INT NOT NULL,
  Award_Year INT,
  Result VARCHAR(20),
  PRIMARY KEY (Movie_Id, Award_Id),
  KEY Award_Id (Award_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Movie_Delete_Log (
  Log_Id INT NOT NULL AUTO_INCREMENT,
  Movie_Id INT,
  Title VARCHAR(255),
  Deleted_On DATETIME,
  PRIMARY KEY (Log_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Movie_Location (
  Movie_Id INT NOT NULL,
  Location_Id INT NOT NULL,
  Shooting_Start DATE,
  Shooting_End DATE,
  PRIMARY KEY (Movie_Id, Location_Id),
  KEY Location_Id (Location_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Movie_Ott (
  Movie_Id INT NOT NULL,
  Ott_Id INT NOT NULL,
  Release_Date DATE,
  PRIMARY KEY (Movie_Id, Ott_Id),
  KEY Ott_Id (Ott_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Movie_Producer (
  Movie_Id INT NOT NULL,
  Producer_Id INT NOT NULL,
  PRIMARY KEY (Movie_Id, Producer_Id),
  KEY Producer_Id (Producer_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Rating_Changes_Log (
  Log_Id INT NOT NULL AUTO_INCREMENT,
  Movie_Id INT,
  Old_Rating DECIMAL(3,1),
  New_Rating DECIMAL(3,1),
  Change_Time DATETIME,
  PRIMARY KEY (Log_Id),
  KEY Movie_Id (Movie_Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS=1;

-- =========================================================
-- TRIGGERS (recovered verbatim from the original database)
-- =========================================================
DELIMITER ;;

CREATE TRIGGER TRG_Insert_Movie AFTER INSERT ON Movie FOR EACH ROW
BEGIN
    INSERT INTO Movie_Audit
    (Movie_Id, Title, Action, Action_Time, Movie_Age_Years)
    VALUES
    (NEW.Movie_Id, NEW.Title, 'INSERT', NOW(),
     fn_GetMovieAge(NEW.Release_Year));
END;;

CREATE TRIGGER TRG_UpdateMovieRating AFTER UPDATE ON Movie FOR EACH ROW
BEGIN
    IF NEW.Rating <> OLD.Rating THEN
        INSERT INTO Rating_Changes_Log
        (Movie_Id, Old_Rating, New_Rating, Change_Time)
        VALUES
        (NEW.Movie_Id, OLD.Rating, NEW.Rating, NOW());
    END IF;
END;;

CREATE TRIGGER TRIGGER_DeleteMovie BEFORE DELETE ON Movie FOR EACH ROW
BEGIN
    INSERT INTO Movie_Delete_Log
    (Movie_Id, Title, Deleted_On)
    VALUES
    (OLD.Movie_Id, OLD.Title, NOW());
END;;

CREATE TRIGGER TRG_Insert_MovieAward BEFORE INSERT ON Movie_Award FOR EACH ROW
BEGIN
    DECLARE v_year INT;
    SELECT Release_Year INTO v_year
    FROM Movie
    WHERE Movie_Id = NEW.Movie_Id;

    IF NEW.Award_Year < v_year THEN
        SET NEW.Award_Year = v_year;
    END IF;
END;;

CREATE TRIGGER trg_AwardPoints_Insert AFTER INSERT ON Movie_Award FOR EACH ROW
BEGIN
    DECLARE v_points INT DEFAULT 0;

    IF NEW.Result = 'Won' THEN
        SET v_points = 10;
    ELSEIF NEW.Result = 'Nominated' THEN
        SET v_points = 5;
    ELSE
        SET v_points = 0;
    END IF;

    IF EXISTS (SELECT 1 FROM Award_Points WHERE Movie_Id = NEW.Movie_Id) THEN
        UPDATE Award_Points
        SET Total_Points = Total_Points + v_points
        WHERE Movie_Id = NEW.Movie_Id;
    ELSE
        INSERT INTO Award_Points (Movie_Id, Total_Points)
        VALUES (NEW.Movie_Id, v_points);
    END IF;
END;;

CREATE TRIGGER TRG_Insert_AwardPoints AFTER INSERT ON Movie_Award FOR EACH ROW
BEGIN
    DECLARE v_points INT;
    DECLARE v_current INT;

    SET v_points = fn_CalcAwardPoints(NEW.Result);

    SET v_current = (
        SELECT Total_Points
        FROM Award_Points
        WHERE Movie_Id = NEW.Movie_Id
    );

    IF v_current IS NULL THEN
        INSERT INTO Award_Points VALUES (NEW.Movie_Id, v_points);
    ELSE
        UPDATE Award_Points
        SET Total_Points = v_current + v_points
        WHERE Movie_Id = NEW.Movie_Id;
    END IF;
END;;

DELIMITER ;

-- =========================================================
-- STORED FUNCTIONS
-- NOTE: These 5 functions are called by the PHP app (FUNC_*.php)
-- but were NOT present in the recovered database (SHOW FUNCTION
-- STATUS returned empty) -- they were already missing/lost before
-- this recovery. Rebuilt here with sensible logic so the app and
-- triggers run; adjust thresholds/logic to match your original intent.
-- =========================================================
DELIMITER ;;

CREATE FUNCTION GetMovieAge(p_release_year INT) RETURNS INT DETERMINISTIC
BEGIN
    RETURN YEAR(CURDATE()) - p_release_year;
END;;

-- Alias used internally by the recovered triggers
CREATE FUNCTION fn_GetMovieAge(p_release_year INT) RETURNS INT DETERMINISTIC
BEGIN
    RETURN GetMovieAge(p_release_year);
END;;

CREATE FUNCTION GetActorMovieCount(p_actor_id INT) RETURNS INT DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_count INT;
    SELECT COUNT(*) INTO v_count FROM Movie_Actor WHERE Actor_Id = p_actor_id;
    RETURN v_count;
END;;

CREATE FUNCTION GetAverageRatingByGenre(p_genre VARCHAR(100)) RETURNS DECIMAL(3,1)
READS SQL DATA
BEGIN
    DECLARE v_avg DECIMAL(3,1);
    SELECT AVG(Rating) INTO v_avg FROM Movie WHERE Genre = p_genre;
    RETURN v_avg;
END;;

CREATE FUNCTION GetMovieSuccessLevel(p_movie_id INT) RETURNS VARCHAR(20)
READS SQL DATA
BEGIN
    DECLARE v_budget DECIMAL(15,2);
    DECLARE v_box_office DECIMAL(15,2);
    DECLARE v_level VARCHAR(20);

    SELECT Budget, Box_Office INTO v_budget, v_box_office
    FROM Movie WHERE Movie_Id = p_movie_id;

    IF v_budget IS NULL OR v_budget = 0 THEN
        SET v_level = 'Unknown';
    ELSEIF v_box_office >= v_budget * 2 THEN
        SET v_level = 'Blockbuster';
    ELSEIF v_box_office >= v_budget THEN
        SET v_level = 'Hit';
    ELSE
        SET v_level = 'Flop';
    END IF;

    RETURN v_level;
END;;

CREATE FUNCTION GetPersonFullName(p_person_id INT) RETURNS VARCHAR(200)
READS SQL DATA
BEGIN
    DECLARE v_name VARCHAR(200);
    SELECT CONCAT(First_Name, ' ', Last_Name) INTO v_name
    FROM Person WHERE Person_Id = p_person_id;
    RETURN v_name;
END;;

CREATE FUNCTION fn_CalcAwardPoints(p_result VARCHAR(20)) RETURNS INT DETERMINISTIC
BEGIN
    IF p_result = 'Won' THEN
        RETURN 10;
    ELSEIF p_result = 'Nominated' THEN
        RETURN 5;
    END IF;
    RETURN 0;
END;;

DELIMITER ;
