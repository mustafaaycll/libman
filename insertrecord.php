<?php 

if (isset($_POST['bid'])      and
    isset($_POST['email'])    and
    isset($_POST['bdate'])    and
    isset($_POST['duedate']))
    {    
        include "config.php";

        $bid = $_POST['bid'];
        $email = $_POST['email'];
        $btime = $_POST['bdate'];
        $duetime = $_POST['duedate'];

        if ($btime != "") {
            if ($duetime != "") {
                $sql_book = "SELECT * FROM BOOKS WHERE bid = UPPER('$bid')";
                $result_book = mysqli_query($db, $sql_book);
                if ( false===$result_book ) {
                    printf("error: %s\n", mysqli_error($db));
                }
                $exist = 0;
                while ($row = mysqli_fetch_assoc($result_book)){
                    $exist = $row['exist'];
                }

                $sql_user = "SELECT * FROM USERS WHERE email = UPPER('$email')";
                $result_user = mysqli_query($db, $sql_user);
                if ( false===$result_user ) {
                    printf("error: %s\n", mysqli_error($db));
                }
                

                if (mysqli_num_rows($result_book) != 0 and $exist==1 and mysqli_num_rows($result_user) != 0){
                    $sql_whois = "INSERT INTO who_is (bid, bdate, duedate, email) VALUES (UPPER('$bid'),'$btime', '$duetime', UPPER('$email'))";
                    $result_whois = mysqli_query($db, $sql_whois);
                    if ( false===$result_whois ) {
                        printf("error: %s\n", mysqli_error($db));
                    }

                    $result_auto = mysqli_query($db, "SELECT AUTO_INCREMENT FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'libman_db' AND TABLE_NAME= 'who_is';");
                    if ( false===$result_auto ) {
                        printf("error: %s\n", mysqli_error($db));
                    }
                    $record_id = 0;

                    while ($row2 = mysqli_fetch_assoc($result_auto)){
                        $record_id = $row2['AUTO_INCREMENT'];
                    }

                    $sql_borrow = "INSERT INTO borrowed (bid, record_id) VALUES (UPPER('$bid'), $record_id-1)";
                    $result_borrow = mysqli_query($db, $sql_borrow);
                    if ( false===$result_borrow ) {
                        printf("error: %s\n", mysqli_error($db));
                    }
                    
                    $sql_update = "UPDATE BOOKS SET exist=0 WHERE bid='$bid'";
                    $result_update = mysqli_query($db, $sql_update);
                    if ( false===$result_update ) {
                        printf("error: %s\n", mysqli_error($db));
                    }
                }
            } 
            else {
                echo 'Invalid Date: ' . $_POST['duedate'];
            }
        }
        else {
            echo 'Invalid Date: ' . $_POST['bdate'];
        }
    }
    header("Location: insertrecord.html");

?>