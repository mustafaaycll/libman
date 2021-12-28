<!DOCTYPE html>
<html>

<head>
    <title>libman - Library Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>libman</h1>
        <nav>
            <ul class="nav__links">
                <li><a href="insertrecord.html">Add Borrow Record</a></li>
                <li><a href="removerecord.php">Remove Borrow Record</a></li>
                <li><a href="insertbook.html">Add Book</a></li>
                <li><a href="removebook.html">Remove Book</a></li>
                <li><a href="insertuser.html">Add/Remove User</a></li>
                <li><a href="getitems.html">List Items</a></li>
            </ul>
        </nav>
    </header>

    <div align="center">
        <br>
        <form action="removerecordaction.php" method="POST">
            <select name="records">

                <?php
                include "config.php";


                $sql_command = "SELECT bid, record_id FROM borrowed";

                $myresult = mysqli_query($db, $sql_command);

                while ($id_rows = mysqli_fetch_assoc($myresult)) {
                    $bid = $id_rows['bid'];
                    $record_id = $id_rows['record_id'];

                    $book_sql = "SELECT bid, bname, publisher, blockname, sno, exist FROM books WHERE bid = '$bid'";
                    $book_result = mysqli_query($db, $book_sql);
                    while ($book_row = mysqli_fetch_assoc($book_result)) {
                        $bname = $book_row['bname'];

                        $holder_sql = "SELECT * FROM who_is WHERE record_id = '$record_id'";
                        $holder_result = mysqli_query($db, $holder_sql);

                        while ($holder_row = mysqli_fetch_assoc($holder_result)) {
                            $bdate = $holder_row['bdate'];
                            $duedate = $holder_row['duedate'];
                            $email = $holder_row['email'];

                            $user_sql = "SELECT * FROM users WHERE email = '$email'";
                            $user_result = mysqli_query($db, $user_sql);

                            while ($user_row = mysqli_fetch_assoc($user_result)) {
                                $uname = $user_row['uname'];
                                echo "<option value=$bid>" . $bname . " - Borrowed by " . $uname . " on " . $bdate . "</option>";
                            }
                        }
                    }
                }
                ?>
            </select> <br><br>
            <button>MARK AS RETURNED</button>
        </form>
    </div>
</body>

</html>