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
            background-color: #04AA6D;
            color: white;
        }

        #customers td {
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
                header("Location: listbooks_byname.php?baname=$bname");
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
        <a href="getitems.php">
            <button id="allbooks">
                List All Books
            </button>
        </a>
        <a href="listrecords.php">
            <button>
                List All Records
            </button>
        </a>
    </div>

    <div align="center">
        <?php

        include "config.php";

        $book_sql = "SELECT * FROM books";
        $book_result = mysqli_query($db, $book_sql);

        echo "<br><h1>Listing all books</h1>";

        if (mysqli_num_rows($book_result) != 0) {
            echo '<table id="customers"><br><tr>
                    <th>BID</th>
                    <th>BOOK NAME</th>
                    <th>WRITER</th>
                    <th>PUBLISHER</th>
                    <th>YEAR</th>
                    <th>CURRENT HOLDER</th>
                    <th>RETURN DATE</th></tr>';

            while ($book_row = mysqli_fetch_assoc($book_result)) {
                $bid = $book_row['bid'];
                $bname = $book_row['bname'];
                $publisher = $book_row['publisher'];
                $exist = $book_row['exist'];
                $aname = "";
                $byear = -1;
                $currhol = "-";
                $duedate =  "-";

                $aid = -1;

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
                    $record_id = -1;

                    $borrow_sql = "SELECT * FROM borrowed WHERE bid='$bid'";
                    $borrow_result = mysqli_query($db, $borrow_sql);
                    while ($borrow_row = mysqli_fetch_assoc($borrow_result)) {
                        $record_id = $borrow_row['record_id'];
                    }

                    $email = "";
                    $who_sql = "SELECT * FROM who_is WHERE record_id=$record_id";
                    $who_result = mysqli_query($db, $who_sql);
                    while ($who_row = mysqli_fetch_assoc($who_result)) {
                        $duedate = $who_row['duedate'];
                        $email = $who_row['email'];
                    }

                    $user_sql = "SELECT * FROM users WHERE email='$email'";
                    $user_result = mysqli_query($db, $user_sql);
                    while ($user_row = mysqli_fetch_assoc($user_result)) {
                        $currhol = $user_row['uname'];
                    }
                }
                echo "<tr>" . "<td>" . $bid . "</td>" . "<td>" . $bname . "</td>" . "<td>" . $aname . "</td>" . "<td>" . $publisher . "</td>" . "<td>" . $byear . "</td>" . "<td>" . $currhol . "</td>" . "<td>" . $duedate . "</td>" . "</tr>";
            }
            echo "</table>";
        } else {
            echo "<br><br><h2>There are no book to list</h2>";
        }


        ?>
    </div>
</body>

</html>