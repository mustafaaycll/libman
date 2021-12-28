<?php 

if (isset($_POST['records']))
    {    
        include "config.php";

        $bid = $_POST['records'];

        $borrowed_sql = "DELETE FROM borrowed WHERE bid = '$bid'";
        $borrowed_result = mysqli_query($db, $borrowed_sql);

        $book_sql = "UPDATE books SET exist=1 WHERE bid = '$bid'";
        $book_result = mysqli_query($db, $book_sql);
        
    }
    header("Location: removerecord.php");

?>