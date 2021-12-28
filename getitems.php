<?php

    include "config.php";

    if (isset($_POST['bname']))
    {   
        $bname = $_POST['bname'];

        $sql_checker = "SELECT * FROM BOOKS WHERE bname='$bname'";
        $result_checker = mysqli_query($db, $sql_checker);
        if (mysqli_num_rows($result_checker)==0){
            echo '<script>alert("The book does not exist in our database, please make sure that the book name is correct")</script>';
        }
        else {
            echo '<script>alert("Yes it exists!")</script>';
            
        }
        
        if (false===$result_checker) {
            printf("error: %s\n", mysqli_error($db));
        }
    }
    header("Location: getitems.html");
?>
