<?php 

    include "config.php";

    if (isset($_POST['uname']) and
        isset($_POST['email']) and
        isset($_POST['type']))    
    {
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        
        if (isset($_POST['age'])) {
            $age = $_POST['age'];
            $sql_statement_for_users = "INSERT IGNORE INTO USERS (uname, age, email)
                                        VALUES (UPPER('$uname'), $age, UPPER('$email'))";
        }
        else {
            $sql_statement_for_users = "INSERT IGNORE INTO USERS (uname, age, email)
                                        VALUES (UPPER('$uname'), NULL, UPPER('$email'))";
        }

        //$sql_statement_for_users = "INSERT IGNORE INTO USERS (uname, age, email)
        //VALUES (UPPER('$uname'), $age, UPPER('$email'))";
        $result_users = mysqli_query($db, $sql_statement_for_users);
        if ( false===$result_users ) {
            printf("error: %s\n", mysqli_error($db));
        }

        if (0 == $_POST['type'] and isset($_POST['position']))
        {
            $position = $_POST['position'];
            $sql_statement_for_staff = "INSERT INTO IS_A_STAFF(email, position)
            VALUES (UPPER('$email'), UPPER('$position'))"; 
              
            $result_staff = mysqli_query($db, $sql_statement_for_staff);
            if ( false===$result_staff ) {
                printf("error: %s\n", mysqli_error($db));
            }

        }
        else if (1 == $_POST['type'] and isset($_POST['major']))
        {
            $major = $_POST['major'];
            $sql_statement_for_students = "INSERT INTO IS_A_STUDENT(email, major)
            VALUES (UPPER('$email'), UPPER('$major'))"; 
            $result_students= mysqli_query($db, $sql_statement_for_students);
            if ( false===$result_students ) {
                printf("error: %s\n", mysqli_error($db));
            }

        }
          
        
    }

    header("Location: insertuser.html");

?>

