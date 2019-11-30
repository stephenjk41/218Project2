<?php

require('pdo.php');

$fname= filter_input(INPUT_POST, "fname");
$lname= filter_input(INPUT_POST, "lname");
$birthday=filter_input(INPUT_POST, "birthday");
$email= filter_input(INPUT_POST, "email");
$password= filter_input(INPUT_POST, "password");
$doubleCheck=strpos($email,'a');

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
    $validate=true;
    if (empty($fname)) {
        $firstNameError = "First Name required.";
        $validate=false;
    }
    if (empty($lname)) {
        $lastNameError = "Last Name required.";
        $validate=false;
    }
    if (empty($birthday)) {
        $birthdayError = "Date of birth required.";
        $validate=false;
    }
    if (empty($email)) {
        $emailError = "Valid email required.";
        $validate=false;
    } elseif ($doubleCheck == false) {
        $emailError = "Email is not valid.";
        $validate=false;
    }
    if (empty($password)) {
        $passwordError = "Password is not valid.";
        $validate=false;
    } elseif (strlen($password) <= 8) {
        $passwordError = "Password required at least 8 characters.";
        $validate=false;
    }
    if($validate==true)
    {
        $query = 'INSERT INTO accounts
                     (email, fname, lname, birthday, password)
                VALUES 
                    (:email, :fname, :lname, :birthday, :birthday, :password)';


        $statement = $db->prepare($query);

        $statement->bindValue(':email',$email);
        $statement->bindValue(':fName',$fname);
        $statement->bindValue(':lName',$lname);
        $statement->bindValue(':birthday',$birthday);
        $statement->bindValue(':password',$password);
        $statement->execute();
        $statement->closeCursor();
    }
}
?>

<html lang="en">

<head><title> Registration Form </title></head>
<body>

<h2> Registration Information </h2>

<div>
    First Name: <?php echo $fname; ?>
    <span <span class="error"> <?php echo $firstNameError; ?> </span>
</div>
<div>
    Last Name: <?php echo $lname; ?>
    <span <span class="error"> <?php echo $lastNameError; ?> </span>
</div>
<div>
    Birthday: <?php echo $birthday; ?>
    <span <span class="error"> <?php echo $birthdayError; ?> </span>
</div>
<div>
    Email: <?php echo $email; ?>
    <span <span class="error"> <?php echo $emailError;?></span>
</div>
<div>
    Password: <?php echo $password; ?>
    <span <span class="error"> <?php echo $passwordError;?></span>
</div>
</body>
</html>
