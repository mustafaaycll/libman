
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

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
    </head>
    <body>
        <header>
            <h1>libman</h1>
            <nav>
                <ul class="nav__links">
                    <li><a href="insertrecord.html">Add/Remove Borrow Record</a></li>
                    <li><a href="insertbook.html">Add/Remove Book</a></li>
                    <li><a href="insertuser.html">Add/Remove User</a></li>
                    <li><a href="getitems.html">List Items</a></li>
                </ul>
            </nav>
        </header>
        <br>
        <br>
        <br>
        <div align="center">
            <a href="listbook.php">
                <button>
                    List Books  
                </button>
            </a>
            <a href="listwriters.php">
                <button>
                    List Authors  
                </button>
            </a>
            <a href="listrecords.php">
                <button>
                    List Records  
                </button>
            </a>
        </div>
        <br>
        <br>
        <br>
        <div align="center">
            <table id="customers">

                <tr> <th> BID </th> <th> BOOK NAME </th> <th>PUBLISHER</th> <th>EXIST</th> </tr> 

                <?php

                    include "config.php";

                    $sql_statement = "SELECT * FROM books";

                    $result = mysqli_query($db, $sql_statement);

                    while($row = mysqli_fetch_assoc($result))
                    {
                        $bid = $row['bid'];
                        $bname = $row['bname'];
	                    $publisher = $row['publisher'];
                        $exist = $row['exist'];


	                    echo "<tr>" . "<th>" . $bid . "</th>" . "<th>" . $bname . "</th>" . "<th>" . $publisher . "</th>" . "<th>" . $exist . "</th>"."</tr>";
                    }

                ?>

            </table>
        </div>
    </body>
</html>