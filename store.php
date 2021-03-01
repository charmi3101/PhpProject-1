<?php

session_start();

require('mysqli_connect.php');
 $q1 = "select * from bookinventory";
 $r= @mysqli_query($connect,$q1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Store Page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
body {

  margin: 0;

}
table {
    margin-top: 150px;
  background-color: white;
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}


tr:nth-child(even){background-color: #f2f2f2}
    </style>

    </head>


    <body>
    <div style="overflow-x:auto;">
  <table>
    <tr>
      <th> ID </th>
      <th> BookName </th>
      <th> Qunatity </th>
    </tr>
    <?php
        if($r->num_rows>0){
          $_SESSION['rows'] = array();
            while($row = $r->fetch_assoc())
            {
               $_SESSION['rows'][] = $row;
                echo "<tr><td>" . $row["id"]. " </td><td><a href='checkout.php?id=$row[id]'>". $row["bookname"]."</a></td><td>".$row["quantity"]."</td></tr>";
            }

            echo "</table>";

        }
        else{
            echo "No book available";
        }

        	$connect->close();
    ?>

  </table>
</div>

    </body>
</html>
