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
        .header{
            max-width: 1000px;
           margin: auto;
            position: relative;

        }
        img
        {

        width: 1000px;
        height: 400px;
        }

        h2{
            margin-top: 40px;
        }
table {
    margin-top: 20px;
    margin-bottom: 60px;
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
        <h2><center> Books </center></h2>
        <div class="header">
            <img src="pic2.jpg" style="width:100%">
        </div>

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
