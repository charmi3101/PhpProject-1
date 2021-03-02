<?php
session_start();
$_SESSION['book']= True;

global $id;
$id=$_GET['id'];
ini_set('display_errors',1);
$nameErr= $mailErr = $addErr = $cardErr =  $cnumErr = $expiryErr = $cvvErr= "";
$fullname = $email = $address = $cardname = $cardnumber = $expmonth = $expyear = $cvv = "";

function validatecard($cardnumber)
 {
    global $type;

    $cardtype = array(
        "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex"       => "/^3[47][0-9]{13}$/",
        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
    );

    if (preg_match($cardtype['visa'],$cardnumber))
    {
	$type= "visa";
        return 'visa';

    }
    else if (preg_match($cardtype['mastercard'],$cardnumber))
    {
	$type= "mastercard";
        return 'mastercard';
    }
    else if (preg_match($cardtype['amex'],$cardnumber))
    {
	$type= "amex";
        return 'amex';

    }
    else if (preg_match($cardtype['discover'],$cardnumber))
    {
	$type= "discover";
        return 'discover';
    }
    else
    {
       $cnumErr="wrong number";
    }
 }

function isCardExpired($expmonth, $expyear)
{
    $expires = $expyear.str_pad($expmonth, 2, '0', STR_PAD_LEFT);
    $now = date('Ym');
    if($expires < $now){
        $expiryErr= "Card Expired!!!";
    }

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["fullname"])) {
    $nameErr = "Name is required";
  } else {
    $fullname = test_input($_POST["fullname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$fullname)) {
      $nameErr = "Only letters and white space allowed";
    }

  }

    if(empty($_POST["email"])) {
        $mailErr = "mail is required";
    } else {
        $email = test_input($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $mailErr = "Invalid email entered!";
        }
    }

    if(empty($_POST["address"])){
        $addErr = "Without address how will you get your Book?!";
    } else{
        $address = test_input($_POST["address"]);
    }

    if(empty($_POST["cardname"])){
        $cardErr = "Card name is required";
    }else {
        $cardname = test_input($_POST["cardname"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$cardname)) {
      $cardErr = "Only letters and white space allowed";
    }

        if(empty($_POST["cardnumber"])){
            $cnumErr = "your card must have a number";
        }else{
            $cardnumber = test_input($_POST["cardnumber"]);
          if( validatecard($cardnumber) == false){
              $cnumErr="wrong number";
          }

        }

    }

    if(empty($_POST["expmonth"]) && empty($_POST["expyear"])) {

        $expiryErr = "Expiry year is required.";
    }else{
        $expmonth = test_input($_POST["expmonth"]);
        $expyear = test_input($_POST["expyear"]);
       if( isCardExpired($expmonth, $expyear)){
            $expiryErr= "Card Expired!!!";

       }
    }

    if(empty($_POST["cvv"])){
        $cvvErr = "cvv required";
    }else{
        $cvv = test_input($_POST["cvv"]);
         if (!preg_match("/^[0-9]{3,4}$/",$cvv)) {
           $cvvErr = "Only letters allowed";
        }
        else{
            require('mysqli_connect.php');

     $sql = "CREATE TABLE IF NOT EXISTS BookInventryOrder (order_id INT PRIMARY KEY AUTO_INCREMENT,
     order_name VARCHAR(20) NOT NULL,
     order_quantity INT)";
     $r1= @mysqli_query($connect,$sql);
        if($r1){
               // echo "<p>suceess</p>";
         $c = "select id,bookname,quantity from bookinventory where id=$id ";
         $r2= @mysqli_query($connect,$c);
             if($c){
                 while($w = $r2->fetch_assoc()) {
                   $i = $w['id'];
                   $name = $w['bookname'];
                   $count = $w['quantity'];
                     $count--;
                 }
                 $q2 = "INSERT INTO BookInventryOrder (order_id,order_name,order_quantity) VALUES ('$i','$name','$count')";
                 $r3= @mysqli_query($connect,$q2);
                if($r3){
       header('Location:http://localhost:8080/project1/action_page.php');
    }
    else {
        echo '<p> Error inserting </p>';
    }

    }
    else {
        echo '<p> Error fetching data  </p>';
    }


     }
            else{
                echo '<p> Error creating table</p>';

            }
            }



        }


    }

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
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
.error {color: #FF0000;}
        .green {color: green;}
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



if(is_numeric($id))
{
      echo "<h2><center> Selected Book </center></h2>";
 foreach($_SESSION['rows'] as $row){
     if ($id == $row['id']){
       //  echo $row['id'].' '.$row['bookname'].' '.$row['quantity'].'<br />';
         echo "<tr><td>" . $row["id"]. " </td><td>". $row["bookname"]."</a></td><td> 1 </td></tr>";
         echo "</table>";

        }

    }

}
else{
    echo "Data Error";
exit;
}

?>
        </table>
<h2><center> Checkout Form </center>  </h2>

<div class="row">
  <div class="col-75">
    <div class="container">

<form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>">
        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <label for="fullname"><i class="fa fa-user"></i> Full Name</label>  <span class="error">* <?php echo $nameErr;?></span>
            <input type="text" id="fullname" name="fullname" value="<?php if (isset($_POST['fullname'])) echo $_POST['fullname']; ?>" placeholder="John More Doe" >

            <label for="email"><i class="fa fa-envelope"></i> Email</label> <span class="error">* <?php echo $mailErr;?></span>
            <input type="text" id="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  placeholder="john@example.com">
            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>  <span class="error">* <?php echo $addErr;?></span>
            <input type="text" id="adr" name="address" value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>" placeholder="542 W. 15th Street">
            <label for="city"><i class="fa fa-institution"></i> City</label>
            <input type="text" id="city" name="city" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>"  placeholder="New York">

            <div class="row">
              <div class="col-50">
                <label for="state">State</label>
                <input type="text" id="state" name="state" value="<?php if (isset($_POST['state'])) echo $_POST['state']; ?>" placeholder="NY">
              </div>
              <div class="col-50">
                <label for="zip">Zip</label>
                <input type="text" id="zip" name="zip" value="<?php if (isset($_POST['zip'])) echo $_POST['zip']; ?>"  placeholder="10001">
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
            <label for="cname">Name on Card</label> <span class="error">* <?php echo $cardErr;?></span>
            <input type="text" id="cname" name="cardname" value="<?php if (isset($_POST['cardname'])) echo $_POST['cardname']; ?>"   placeholder="John More Doe">
            <label for="ccnum">Credit card number</label> <span class="error">* <?php echo $cnumErr;?></span>
              <span class="green">
                  <?php if(!validatecard($cardnumber)==false){ echo " $type detected. credit card number is valid";}
                  ?>
              </span>
            <input type="text" id="ccnum" name="cardnumber" value="<?php if (isset($_POST['cardnumber'])) echo $_POST['cardnumber']; ?>"  placeholder="1111-2222-3333-4444">
            <label for="expmonth">Exp Month</label>  <span class="error">* <?php echo $expiryErr;?></span>
            <input type="text" id="expmonth" name="expmonth"  value="<?php if (isset($_POST['expmonth'])) echo $_POST['expmonth']; ?>"  placeholder="September">
            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label> <span class="error">* <?php echo $expiryErr;?></span>
                <input type="text" id="expyear" name="expyear"  value="<?php if (isset($_POST['expyear'])) echo $_POST['expyear']; ?>" placeholder="2018">
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label> <span class="error">* <?php echo $cvvErr;?></span>
                <input type="text" id="cvv" name="cvv"  value="<?php if (isset($_POST['cvv'])) echo $_POST['cvv']; ?>" placeholder="352">
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
