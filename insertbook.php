<?php 

    include "config.php";

    if (isset($_POST['bname'])      and
        isset($_POST['aname'])      and
        isset($_POST['byear'])      and
        isset($_POST['publisher'])  and
        isset($_POST['blockname'])  and
        isset($_POST['sno']) and 
        isset($_POST['exist']))
    {
        
        $aid = 0;
        $bname = $_POST['bname'];
        $aname = $_POST['aname'];
        $byear = $_POST['byear'];
        $publisher = $_POST['publisher'];
        $blockname = $_POST['blockname'];
        $sno = $_POST['sno'];
        $exist = $_POST['exist'];
        $bid = $blockname.$sno;


        //check if the location is available before adding book, this is for further INSERT clauses
        //intention is to prevent the case that book is not added but its writer and written_by couple is added
        $sql_checker = "SELECT * FROM BOOKS WHERE bid='$bid'";
        $result_checker = mysqli_query($db, $sql_checker);

        $sql_statement_for_books = "INSERT IGNORE INTO BOOKS (bid, bname, publisher, blockname, sno, exist)
                                    VALUES (UPPER('$bid'), UPPER('$bname'), UPPER('$publisher'), UPPER('$blockname'), $sno, $exist)";       
        $result_books = mysqli_query($db, $sql_statement_for_books);

        if (mysqli_num_rows($result_checker) == 0){
            $sql_statement_for_writers = "INSERT INTO WRITERS (aname) VALUES (UPPER('$aname'))
                                            ON DUPLICATE KEY UPDATE aname='$aname'";

            $result_writers = mysqli_query($db, $sql_statement_for_writers);

            $sql_statement_for_aid = "SELECT * FROM WRITERS WHERE aname=UPPER('$aname')";

            $result_aid = mysqli_query($db, $sql_statement_for_aid);

            while ($row = mysqli_fetch_assoc($result_aid)){
                $aid = $row['aid'];
            }

            $sql_statement_for_writtenby = "INSERT INTO written_by (aid, bid, byear) VALUES ($aid, UPPER('$bid'), $byear)";
            $result_writtenby = mysqli_query($db, $sql_statement_for_writtenby);

            if ( false===$result_writtenby ) {
                printf("error: %s\n", mysqli_error($db));
            }
        }
    }
    header("Location: insertbook.html");
?>