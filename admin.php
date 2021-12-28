<html>
<?php 

include "config.php";

?>

<form action="delete.php" method="POST">
<select name="ids">

<?php

$sql_command = "SELECT * FROM borrowed";

$myresult = mysqli_query($db, $sql_command);

    while($id_rows = mysqli_fetch_assoc($myresult))
    {
        $bid = $id_rows['bid'];
        $record_id = $id_rows['record_id'];
        $book_sql = "SELECT * FROM books WHERE bid = '$bid'";
        $book_result = mysqli_query($db, $book_result);
        $bname = mysqli_fetch_assoc($book_result)['bname'];
        echo "<option value=$bid>". $bname . " - " . $record_id. "</option>";
    }

?>

</select>
<button>DELETE</button>
</form>
</html>