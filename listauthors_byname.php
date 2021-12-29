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
                <li><a href="getitems.php">List Items</a></li>
            </ul>
        </nav>
    </header>
    <div align="center">
        <table id="customers">

            <?php
            if (isset($_GET['aname'])) {
                $aname = $_GET['aname'];
                echo "<h1><br><br>Books written by $aname</h1> <br> <br>";
            }
            ?>

            <tr>
                <th>BID</th>
                <th>BOOK NAME</th>
                <th>PUBLISHER</th>
                <th>YEAR</th>
                <th>AVAILABLE AFTER</th>
                <th>HOLD BY</th>
                <th>EMAIL</th>
            </tr>

            <?php

            include "config.php";

            if (isset($_GET['aname'])) {
                $aname = $_GET['aname'];

                $author_sql = "SELECT * FROM writers WHERE aname = '$aname'";
                $author_result = mysqli_query($db, $author_sql);
                $aid = -1;

                while ($author_row = mysqli_fetch_assoc($author_result)) {
                    $aid = $author_row['aid'];
                }

                $written_sql = "SELECT * FROM written_by WHERE aid = $aid";
                $written_result = mysqli_query($db, $written_sql);

                while ($written_row = mysqli_fetch_assoc($written_result)) {
                    $bid = $written_row['bid'];
                    $byear = $written_row['byear'];
                    $book_sql = "SELECT * FROM books WHERE bid = '$bid'";
                    $book_result = mysqli_query($db, $book_sql);
                    while ($book_row = mysqli_fetch_assoc($book_result)) {
                        $bname = $book_row['bname'];
                        $publisher = $book_row['publisher'];
                        $exist = $book_row['exist'];
                        if ($exist == 1) {
                            $date = "Returned";
                            $email = "-";
                            $name = "-";
                        } else {
                            $email = "";
                            $name = "";
                            $date = "";
                            $borrow_sql = "SELECT * FROM borrowed WHERE bid = '$bid'";
                            $borrow_result = mysqli_query($db, $borrow_sql);
                            while ($borrow_row = mysqli_fetch_assoc($borrow_result)) {
                                $record_id = $borrow_row['record_id'];
                                $record_sql = "SELECT * FROM who_is WHERE record_id = $record_id";
                                $record_result = mysqli_query($db, $record_sql);
                                while ($record_row = mysqli_fetch_assoc($record_result)) {
                                    $email = $record_row['email'];
                                    $date = $record_row['duedate'];
                                    $user_sql = "SELECT * FROM users WHERE email = '$email'";
                                    $user_result = mysqli_query($db, $user_sql);
                                    while ($user_row = mysqli_fetch_assoc($user_result)) {
                                        $name = $user_row['uname'];
                                    }
                                }
                            }
                        }
                        echo "<tr>" . "<td>" . $bid . "</td>" . "<td>" . $bname . "</td>" . "<td>" . $publisher . "</td>" . "<td>" . $byear . "</td>" . "<td>" . $date . "</td>" . "<td>" . $name . "</td>" . "<td>" . $email . "</td>" . "</tr>";
                    }
                }
            }
            ?>
        </table>
        <br><br>
        <form action="getitems.php">
            <button>SEARCH FOR ANOTHER THING</button>
        </form>
    </div>
</body>

</html>