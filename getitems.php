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
                <li><a href="insertuser.html">Add User</a></li>
                <li><a href="removeuser.php">Remove User</a></li>
                <li><a href="getitems.php">List Items</a></li>
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
        <br>
        <br>
        <br>
        <br>
        <a href="listbook.php">
            <button>
                List All Books
            </button>
        </a>
        <a href="listwriters.php">
            <button>
                List All Authors
            </button>
        </a>
        <a href="listrecords.php">
            <button>
                List All Records
            </button>
        </a>

        <?php

        include "config.php";

        if (isset($_REQUEST['bnamesearch'])) {
            $bname = $_REQUEST['bnamesearch'];

            $sql_checker = "SELECT * FROM BOOKS WHERE bname='$bname'";
            $result_checker = mysqli_query($db, $sql_checker);
            if (mysqli_num_rows($result_checker) == 0) {
                echo '<script>alert("The book does not exist in our database, please make sure that the book name is correct")</script>';
            } else {
                header('Location: index.html');
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
            
            $record_sql = "SELECT * FROM writers WHERE aname = '$aname'";
            $author_result = mysqli_query($db, $author_sql);
            if (mysqli_num_rows($author_result) == 0) {
                echo '<script>alert("The author does not exist in our database, please make sure that the author name is correct")</script>';
            } else {
                header("Location: listauthors_byname.php");
            }
        }



        ?>
    </div>
</body>

</html>