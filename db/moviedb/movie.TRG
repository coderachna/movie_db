TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER TRG_Insert_Movie\nAFTER INSERT ON Movie\nFOR EACH ROW\nBEGIN\n    INSERT INTO Movie_Audit\n    (Movie_Id, Title, Action, Action_Time, Movie_Age_Years)\n    VALUES\n    (NEW.Movie_Id, NEW.Title, \'INSERT\', NOW(),\n     fn_GetMovieAge(NEW.Release_Year));\nEND' 'CREATE DEFINER=`root`@`localhost` TRIGGER TRG_UpdateMovieRating\nAFTER UPDATE ON Movie\nFOR EACH ROW\nBEGIN\n    IF NEW.Rating <> OLD.Rating THEN\n        INSERT INTO Rating_Changes_Log\n        (Movie_Id, Old_Rating, New_Rating, Change_Time)\n        VALUES\n        (NEW.Movie_Id, OLD.Rating, NEW.Rating, NOW());\n    END IF;\nEND' 'CREATE DEFINER=`root`@`localhost` TRIGGER TRIGGER_DeleteMovie\nBEFORE DELETE ON Movie\nFOR EACH ROW\nBEGIN\n    INSERT INTO Movie_Delete_Log\n    (Movie_Id, Title, Deleted_On)\n    VALUES\n    (OLD.Movie_Id, OLD.Title, NOW());\nEND'
sql_modes=1098907648 1098907648 1098907648
definers='root@localhost' 'root@localhost' 'root@localhost'
client_cs_names='utf8mb4' 'utf8mb4' 'utf8mb4'
connection_cl_names='utf8mb4_unicode_ci' 'utf8mb4_unicode_ci' 'utf8mb4_unicode_ci'
db_cl_names='utf8mb4_general_ci' 'utf8mb4_general_ci' 'utf8mb4_general_ci'
created=1764229953539975 1764230001696156 1764230015362217
