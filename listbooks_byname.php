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
    <div align="center">

        <?php

        include "config.php";

        if (isset($_GET['bname'])) {
            $bname = $_GET['bname'];

            echo "<h1><br><br>Informatıons about book named '$bname':</h1><br>";
            echo '<table id="customers"><br><tr>
                    <th>BID</th>
                    <th>BOOK NAME</th>
                    <th>WRITER</th>
                    <th>PUBLISHER</th>
                    <th>YEAR</th>
                    <th>CURRENT HOLDER</th>
                    <th>RETURN DATE</th></tr>';

            $book_sql = "SELECT * FROM books WHERE bname = '$bname'";
            $book_result = mysqli_query($db, $book_sql);
            while ($book_row = mysqli_fetch_assoc($book_result)) {
                $bid = $book_row['bid'];
                $publisher = $book_row['publisher'];
                $exist = $book_row['exist'];
                $curhol = "-";
                $duedate = "-";
                $byear = 0;
                $aname = "";

                if ($exist == 0) {
                    $record_id = -1;
                    $borrow_sql = "SELECT * FROM borrowed WHERE bid='$bid'";
                    $borrow_result = mysqli_query($db, $borrow_sql);
                    while ($borrow_row = mysqli_fetch_assoc($borrow_result)) {
                        $record_id = $borrow_row['record_id'];
                    }

                    $email = "";
                    $who_sql = "SELECT * FROM who_is WHERE record_id = $record_id";
                    $who_result = mysqli_query($db, $who_sql);
                    while ($who_row = mysqli_fetch_assoc($who_result)) {
                        $email = $who_row['email'];
                        $duedate = $who_row['duedate'];
                    }

                    $user_sql = "SELECT * FROM users WHERE email = '$email'";
                    $user_result = mysqli_query($db, $user_sql);
                    while ($user_row = mysqli_fetch_assoc($user_result)) {
                        $curhol = $user_row['uname'];
                    }
                }

                $aid = -1;
                $written_sql = "SELECT * FROM written_by WHERE bid = '$bid'";
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
                echo "<tr>" . "<td>" . $bid . "</td>" . "<td>" . $bname . "</td>" . "<td>" . $aname . "</td>" . "<td>" . $publisher . "</td>" . "<td>" . $byear . "</td>" . "<td>" . $curhol . "</td>" . "<td>" . $duedate . "</td>" . "</tr>";
            }
            echo "</table>";
        }
        ?>

        <br><br>
        <form action="getitems.php">
            <button>SEARCH FOR ANOTHER THING</button>
        </form>
    </div>
</body>

</html>