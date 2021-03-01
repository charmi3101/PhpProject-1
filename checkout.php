
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Checkout Page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}
        table {
  margin-top: 50px;
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

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}


@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
</head>
    <body>

    <table>
    <tr>
      <th> ID </th>
      <th> BookName </th>
      <th> Qunatity </th>
    </tr>

    <?php
    $id=$_GET['id'];
if(!is_numeric($id))
{
echo "Data Error";
exit;
}
    echo "<h2><center> Selected Book </center></h2>";
 foreach($_SESSION['rows'] as $row){
     if ($id == $row['id']){
    //  echo $row['id'].' '.$row['bookname'].' '.$row['quantity'].'<br />';
         echo "<tr><td>" . $row["id"]. " </td><td>". $row["bookname"]."</a></td><td> 1 </td></tr>";
         echo "</table>";
        }
    }

?>

<h2><center> Checkout Form </center>  </h2>

<div class="row">
  <div class="col-75">
    <div class="container">
      <form method="post"  action="action_page.php">

        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
            <input type="text" id="fname" name="firstname" value="<?php if (isset($_POST['firstname'])) ?>" placeholder="John M. Doe">
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input type="text" id="email" name="email"  value="<?php if (isset($_POST['email'])) ?>" placeholder="john@example.com">
            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
            <input type="text" id="adr" name="address"  value="<?php if (isset($_POST['address'])) ?>" placeholder="542 W. 15th Street">
            <label for="city"><i class="fa fa-institution"></i> City</label>
            <input type="text" id="city" name="city"  value="<?php if (isset($_POST['city'])) ?>" placeholder="New York">

            <div class="row">
              <div class="col-50">
                <label for="state">State</label>
                <input type="text" id="state" name="state"  value="<?php if (isset($_POST['state'])) ?>" placeholder="NY">
              </div>
              <div class="col-50">
                <label for="zip">Zip</label>
                <input type="text" id="zip" name="zip"  value="<?php if (isset($_POST['zip'])) ?>" placeholder="10001">
              </div>
            </div>
          </div>

          <div class="col-50">
            <h3>Payment</h3>
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname"  value="<?php if (isset($_POST['cardname'])) ?>" placeholder="John More Doe">
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber"  value="<?php if (isset($_POST['cardnumber'])) ?>" placeholder="1111-2222-3333-4444">
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth"  value="<?php if (isset($_POST['expmonth'])) ?>"  placeholder="September">
            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear"  value="<?php if (isset($_POST['expyear'])) ?>" placeholder="2018">
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv"  value="<?php if (isset($_POST['cvv'])) ?>" placeholder="352">
              </div>
            </div>
          </div>

        </div>
        <label>
          <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
        </label>
        <input type="submit" value="Continue to checkout" class="btn" >
      </form>
    </div>
  </div>
    </body>
</html>

<?php
require('mysqli_connect.php');
ini_set('display_errors',1);

$fullname = $_POST['fullname'];
$email = $_POST['email'];

     $address = $_POST['address'];
    $city = $_POST['city'];

     $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

session_destroy();
 ?>
