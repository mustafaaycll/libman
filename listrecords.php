<!DOCTYPE html>
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
    <br>
    <br>
    <br>
    <div align="center">
        <br>
        <form method="POST">
            <h1>Please type in the name of the book you'd like to search for.<br><br>
                <input type="text" name="bnamesearch" placeholder="Book Name"><br><br>
                <button>SEARCH BOOK BY BOOK NAME</button>
        </form>
        <form method="POST">
            <br>
            <br>

            <h1>Please type in the name of the author you'd like to search for.<br><br>
                <input type="text" name="anamesearch" placeholder="Author Name"><br><br>
                <button>SEARCH BOOK BY AUTHOR NAME</button>
        </form>
        <form method="POST">
            <br>
            <br>

            <h1>Please type in the username you'd like to search for records of.<br><br>
                <input type="text" name="recordsearch" placeholder="Username"><br><br>
                <button>SEARCH RECORD BY USERNAME</button>
        </form>


        <?php

        include "config.php";

        if (isset($_REQUEST['bnamesearch'])) {
            $bname = $_REQUEST['bnamesearch'];

            $sql_checker = "SELECT * FROM BOOKS WHERE bname='$bname'";
            $result_checker = mysqli_query($db, $sql_checker);
            if (mysqli_num_rows($result_checker) == 0) {
                echo '<script>alert("The book does not exist in our database, please make sure that the book name is correct")</script>';
            } else {
                header("Location: listbooks_byname.php?bname=$bname");
            }
        }

        if (isset($_REQUEST['anamesearch'])) {
            $aname = $_REQUEST['anamesearch'];

            $author_sql = "SELECT * FROM writers WHERE aname = '$aname'";
            $author_result = mysqli_query($db, $author_sql);
            if (mysqli_num_rows($author_result) == 0) {
                echo '<script>alert("The author does not exist in our database, please make sure that the author name is correct")</script>';
            } else {
                header("Location: listauthors_byname.php?aname=$aname");
            }
        }

        if (isset($_REQUEST['recordsearch'])) {
            $uname = $_REQUEST['recordsearch'];
            $user_sql = "SELECT * FROM users WHERE uname = '$uname'";
            $user_result = mysqli_query($db, $user_sql);
            $email = "";

            while ($user_row = mysqli_fetch_assoc($user_result)) {
                $email = $user_row['email'];
            }

            $record_sql = "SELECT * FROM who_is WHERE email = '$email'";
            $record_result = mysqli_query($db, $record_sql);
            if (mysqli_num_rows($record_result) == 0) {
                echo "<script>alert('There is no record linked to $uname')</script>";
            } else {
                header("Location: listrecord_byuname.php?uname=$uname");
            }
        }
        ?>
    </div>
    <div align="center">
        <br>
        <br>
        <br>
        <br>
        <a href="listbook.php">
            <button id="allbooks">
                List All Books
            </button>
        </a>
        <a href="getitems.php">
            <button>
                List All Records
            </button>
        </a>
    </div>

    <div align="center">
        <?php

        include "config.php";

        $who_sql = "SELECT * FROM books";
        $who_result = mysqli_query($db, $who_sql);

        echo "<br><h1>Listing all records</h1>";

        if (mysqli_num_rows($who_result) != 0) {

            echo "<br><h2>Displaying records that are currently active:</h2>";
            $record_sql = "SELECT * FROM who_is";
            $record_result = mysqli_query($db, $record_sql);
            $record_found = false;

            $table_drawn = false;

            while ($record_row = mysqli_fetch_assoc($record_result)) {
                $record_id = $record_row['record_id'];
                $bdate = $record_row['bdate'];
                $duedate = $record_row['duedate'];
                $email = $record_row['email'];

                $borrow_sql = "SELECT * FROM borrowed WHERE record_id = $record_id";
                $borrow_result = mysqli_query($db, $borrow_sql);

                if (mysqli_num_rows($borrow_result) != 0) {
                    $record_found = true;
                    if ($table_drawn == false) {
                        echo '<table id="customers"><br><tr>
                        <th>BID</th>
                        <th>BOOK NAME</th>
                        <th>WRITER</th>
                        <th>PUBLISHER</th>
                        <th>YEAR</th>
                        <th>BORROWED ON</th>
                        <th>TO BE RETURNED ON</th>
                        <th>BORROWED BY</th>
                        </tr>';
                        $table_drawn = true;
                    }
                    while ($borrow_row = mysqli_fetch_assoc($borrow_result)) {
                        $bid = $borrow_row['bid'];
                        $aid = -1;
                        $byear = -1;
                        $aname = "";
                        $bname = "";
                        $publisher = "";
                        $uname = "";

                        $user_sql = "SELECT * FROM users WHERE email='$email'";
                        $user_result = mysqli_query($db, $user_sql);
                        while ($user_row = mysqli_fetch_assoc($user_result)) {
                            $uname = $user_row['uname'];
                        }

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

                        echo "<tr>" . "<td>" . $bid . "</td>" . "<td>" . $bname . "</td>" . "<td>" . $aname . "</td>" . "<td>" . $publisher . "</td>" . "<td>" . $byear . "</td>" . "<td>" . $bdate . "</td>" . "<td>" . $duedate . "</td>" . "<td>" . $uname . "</td>" . "</tr>";
                    }
                }
            }
            if ($record_found == false) {
                echo "<br><h2>There is no active record</h2> <br> <br>";
            } else {
                echo "</table>";
            }
        }
        ?>
    </div>
</body>

</html>