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
    <div align="center">
        <br>

        <form method="POST">
            <select name="users">

                <?php
                include "config.php";

                $sql_command = "SELECT uname, age, email FROM users";

                $myresult = mysqli_query($db, $sql_command);
                while ($user_row = mysqli_fetch_assoc($myresult)) {
                    $uname = $user_row['uname'];
                    $age = $user_row['age'];
                    $email = $user_row['email'];

                    echo "<option value=$email>" . $uname . " (" . $age . ") - " . $email . "</option>";
                }
                ?>
            </select> <br><br>
            <button>REMOVE USER</button>
        </form>

        <?php

        include "config.php";


        $user_can_be_deleted = true;

        if (isset($_REQUEST['users'])) {

            $email = $_POST['users'];

            $who_sql = "SELECT * FROM who_is WHERE email = '$email'";
            $who_result = mysqli_query($db, $who_sql);

            while (mysqli_num_rows($who_result) != 0 && $who_row = mysqli_fetch_assoc($who_result)) {
                $record_id = $who_row['record_id'];

                $borrow_sql = "SELECT * FROM borrowed WHERE record_id = $record_id";
                $borrow_result = mysqli_query($db, $borrow_sql);

                if (mysqli_num_rows($borrow_result) != 0) {
                    $user_can_be_deleted = false;
                }
            }

            if ($user_can_be_deleted == false) {
                echo '<script>alert("User you are trying to remove has unreturned books!")</script>';
            } else {
                $remove_sql = "DELETE FROM users WHERE email = '$email'";
                $remove_result = mysqli_query($db, $remove_sql);
                header("Location: removeuser.php");
            }
        }



        ?>



    </div>
</body>

</html>