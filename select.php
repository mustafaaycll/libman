<?php 

    include "config.php";

    $sqlstatement = "SELECT * FROM books";
    $result = mysqli_query($db, $sql_statement); 
    while($row = mysqli_fetch_assoc($result)) {
        $bname = $row['bname'];
        $publisher = $row['publisher'];
        $blockname =  $row['blockname'];
        $sno =  $row['sno'];
        echo "BOOK NAME: " . $bname . "      " . "PUBLISHER: " . $publisher . "      " . "LOCATION: " . $blockname . $sno . "<br>";
    }

?>