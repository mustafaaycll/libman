<html>

<head>
    <title>libman - Library Management System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 50%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: transparent;
        }

        #customers tr:hover {
            background-color: black;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #941313;
            color: white;
        }

        #customers td {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: transparent;
            color: white;
        }

        #customers2 {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 50%;
        }

        #customers2 td,
        #customers2 th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers2 tr:nth-child(even) {
            background-color: transparent;
        }

        #customers2 tr:hover {
            background-color: black;
        }

        #customers2 th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

        #customers2 td {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: transparent;
            color: white;
        }
    </style>
</head>

<body>
    <header>
        <h1>libman</h1>
        <nav>
            <ul class="nav__links">
                <li><a href="insertrecord.html">Add Borrow Record</a></li>
                <li><a href="removerecord.php">Remove Borrow Record</a></li>
                <li><a href="insertbook.html">Add Book</a></li>
                <li><a href="insertuser.html">Add User</a></li>
                <li><a href="removeuser.php">Remove User</a></li>
                <li><a href="getitems.php">Explore Database</a></li>
            </ul>
        </nav>
    </header>
    <div align="center">

        <?php

        include "config.php";

        if (isset($_GET['uname'])) {
            $uname = $_GET['uname'];

            echo "<h1><br><br>Books that are currently being hold by $uname:</h1> <br>";
            $user_sql = "SELECT * FROM users WHERE uname = '$uname'";
            $user_result = mysqli_query($db, $user_sql);
            $email = "";

            while ($user_row = mysqli_fetch_assoc($user_result)) {
                $email = $user_row['email'];
            }

            $record_sql = "SELECT * FROM who_is WHERE email = '$email'";
            $record_result = mysqli_query($db, $record_sql);
            $record_found = false;

            while ($record_row = mysqli_fetch_assoc($record_result)) {
                $record_id = $record_row['record_id'];
                $bdate = $record_row['bdate'];
                $duedate = $record_row['duedate'];

                $borrow_sql = "SELECT * FROM borrowed WHERE record_id = $record_id";
                $borrow_result = mysqli_query($db, $borrow_sql);

                if (mysqli_num_rows($borrow_result) != 0) {
                    $record_found = true;
                    echo '<table id="customers"><br><tr>
                        <th>BID</th>
                        <th>BOOK NAME</th>
                        <th>WRITER</th>
                        <th>PUBLISHER</th>
                        <th>YEAR</th>
                        <th>BORROWED ON</th>
                        <th>TO BE RETURNED ON</th></tr>';
                    while ($borrow_row = mysqli_fetch_assoc($borrow_result)) {
                        $bid = $borrow_row['bid'];
                        $aid = -1;
                        $byear = -1;
                        $aname = "";
                        $bname = "";
                        $publisher = "";

                        $year_sql = "SELECT * FROM written_by WHERE bid='$bid'";
                        $year_result = mysqli_query($db, $year_sql);
                        while ($year_row = mysqli_fetch_assoc($year_result)) {
                            $aid = $year_row['aid'];
                            $byear = $year_row['byear'];
                        }
                        $author_sql = "SELECT * FROM writers WHERE aid=$aid";
                        $author_result = mysqli_query($db, $author_sql);
                        while ($author_row = mysqli_fetch_assoc($author_result)) {
                            $aname = $author_row['aname'];
                        }

                        $book_sql = "SELECT * FROM books WHERE bid = '$bid'";
                        $book_result = mysqli_query($db, $book_sql);

                        while ($book_row = mysqli_fetch_assoc($book_result)) {
                            $bname = $book_row['bname'];
                            $publisher = $book_row['publisher'];
                        }

                        echo "<tr>" . "<td>" . $bid . "</td>" . "<td>" . $bname . "</td>" . "<td>" . $aname . "</td>" . "<td>" . $publisher . "</td>" . "<td>" . $byear . "</td>" . "<td>" . $bdate . "</td>" . "<td>" . $duedate . "</td>" . "</tr>";
                    }
                }
            }
            if ($record_found == false) {
                echo "<h2>There is no book that is currently being hold by $uname</h2> <br> <br>";
            } else {
                echo "</table>";
            }

            echo "<br><br><br><h1><br><br>Books that are previously hold by $uname:</h1> <br>";

            $record_found = false;
            $record_sql = "SELECT * FROM who_is WHERE email = '$email'";
            $record_result = mysqli_query($db, $record_sql);

            if (mysqli_num_rows($record_result) != 0) {
                $table_is_drawn = false;
                while ($record_row = mysqli_fetch_assoc($record_result)) {
                    $record_id = $record_row['record_id'];
                    $bid = $record_row['bid'];
                    $bdate = $record_row['bdate'];
                    $duedate = $record_row['duedate'];

                    $borrow_sql = "SELECT * FROM borrowed WHERE record_id = $record_id";
                    $borrow_result = mysqli_query($db, $borrow_sql);
                    if (mysqli_num_rows($borrow_result) == 0) {
                        $record_found = true;
                        if ($table_is_drawn == false) {
                            echo '<table id="customers2"><br><tr>
                            <th>BID</th>
                            <th>BOOK NAME</th>
                            <th>WRITER</th>
                            <th>PUBLISHER</th>
                            <th>YEAR</th>
                            <th>BORROWED ON</th>
                            <th>RETURNED ON</th>
                            <th>CURRENTLY HOLD BY</th></tr>';
                            $table_is_drawn = true;
                        }
                        $bname = "";
                        $publisher = "";
                        $byear = -1;
                        $aid = -1;
                        $aname = "";
                        $exist = 1;
                        $email2 = "";
                        $uname2 = "-";
                        $record_id2 = 0;

                        $book_sql = "SELECT * FROM books WHERE bid='$bid'";
                        $book_result = mysqli_query($db, $book_sql);
                        while ($book_row = mysqli_fetch_assoc($book_result)) {
                            $bname = $book_row['bname'];
                            $publisher = $book_row['publisher'];
                            $exist = $book_row['exist'];
                        }

                        $written_sql = "SELECT * FROM written_by WHERE bid='$bid'";
                        $written_result = mysqli_query($db, $written_sql);
                        while ($written_row = mysqli_fetch_assoc($written_result)) {
                            $aid = $written_row['aid'];
                            $byear = $written_row['byear'];
                        }

                        $writer_sql = "SELECT * FROM writers WHERE aid=$aid";
                        $writer_result = mysqli_query($db, $writer_sql);
                        while ($writer_row = mysqli_fetch_assoc($writer_result)) {
                            $aname = $writer_row['aname'];
                        }

                        if ($exist == 0) {
                            $borrowed_sql = "SELECT * FROM borrowed WHERE bid = '$bid'";
                            $borrowed_result = mysqli_query($db, $borrowed_sql);
                            while ($borrowed_row = mysqli_fetch_assoc($borrowed_result)) {
                                $record_id2 = $borrowed_row['record_id'];
                            }

                            $who_sql = "SELECT * FROM who_is WHERE record_id=$record_id2";
                            $who_result = mysqli_query($db, $who_sql);
                            while ($who_row = mysqli_fetch_assoc($who_result)) {
                                $email2 = $who_row['email'];
                            }

                            $user_sql = "SELECT * FROM users WHERE email='$email2'";
                            $user_result = mysqli_query($db, $user_sql);
                            while ($user_row = mysqli_fetch_assoc($user_result)) {
                                $uname2 = $user_row['uname'];
                            }
                        }
                        echo "<tr>" . "<td>" . $bid . "</td>" . "<td>" . $bname . "</td>" . "<td>" . $aname . "</td>" . "<td>" . $publisher . "</td>" . "<td>" . $byear . "</td>" . "<td>" . $bdate . "</td>" . "<td>" . $duedate . "</td>" . "<td>" . $uname2 . "</td>" . "</tr>";
                    }
                }
            }
            if ($record_found == false) {
                echo "<h2>There is no book that is previously hold by $uname</h2> <br> <br>";
            } else {
                echo "</table>";
            }
        }
        ?>

        <br><br>
        <form action="getitems.php">
            <button>SEARCH FOR ANOTHER THING</button>
        </form>
    </div>
</body>

</html>