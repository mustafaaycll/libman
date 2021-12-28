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
                <li><a href="removerecord.html">Remove Borrow Record</a></li>
                <li><a href="insertbook.html">Add Book</a></li>
                <li><a href="removebook.html">Remove Book</a></li>
                <li><a href="insertuser.html">Add/Remove User</a></li>
                <li><a href="getitems.html">List Items</a></li>
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
                <input type="text" name="bname" placeholder="Book Name"><br><br>
                <button>SEARCH</button>
        </form>

        <?php

        include "config.php";
        
        if (isset($_REQUEST['bname'])) {
            $bname = $_REQUEST['bname'];

            $sql_checker = "SELECT * FROM BOOKS WHERE bname='$bname'";
            $result_checker = mysqli_query($db, $sql_checker);
            if (mysqli_num_rows($result_checker) == 0) {
                echo '<script>alert("The book does not exist in our database, please make sure that the book name is correct")</script>';
            } else {
                header('Location: index.html');
            }
        }
        ?>
    </div>
</body>

</html>