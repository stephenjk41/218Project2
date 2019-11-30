<?php

require("pdo.php");

$emailError = $passwordError ="";

$email= filter_input(INPUT_POST, 'email');
$password= filter_input(INPUT_POST, 'password');
$id = "";
$list = [];
$doubleCheck=strpos($email,'@');
$fname = $lname = "";

if ($_SERVER["REQUEST_METHOD"]== "POST")
{
    $Validate=true;
    if (empty($email))
    {
        $emailError="Must type in a valid email.";
        $Validate=false;
    }
    elseif ($doubleCheck == false)
    {
        $emailError = "Email is not valid.";
        $Validate=false;
    }
    if (empty($password))
    {
        $passwordError="Must type in a valid password.";
        $Validate=false;
    }
    elseif (strlen($password)<=8)
    {
        $passwordError="Password must be at least 8 characters long.";
        $Validate=false;
    }

    if($Validate==true)
    {
        $query = "SELECT * FROM accounts WHERE email = :email AND password = :password" ;
        $sql = "SELECT fname, lname, id FROM accounts WHERE email = :email AND password = :password";
        $statement=$db->prepare($query);

        $statement->bindValue(':email',$email);
        $statement->bindValue(':password',$password);
        $statement->bindValue(':fname',$fname);
        $statement->bindValue(':lname',$lname);
        $statement->bindValue(':id',$id);

        $questions = $link->query("SELECT title FROM questions WHERE ownerid = :id");
        while ($question_row) {
            $question_title = $question_row['question_title'];
            $list[$question_title] = $question_title;
        }
        
        foreach ($list as $question_title => $question_title) {
            echo "Question Title: $question_title <br />";
        }

        $statement->execute();
        $accounts=$statement->fetchAll();
        $statement->closeCursor();
        if (count($accounts)>0)
        {
            $userID=$accounts[0]['id'];
            header("Location: ../questList.php?userID=$userID");
        }
        else
        {
            header('Location: ../registration.html');
        }
    }
}
?>

<html lang="en">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.html">Open Forum</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="login.php">Login <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registration.html">Register</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
<head><title> Login Data </title></head>
<body>

<h2>Login Form </h2>
<div>
    Email: <?php echo $email; ?>
    <span <span class="error"> <?php echo $emailError;?></span>
</div>
<div>
    Password: <?php if (!$passwordError) echo $password; ?>
    <span <span class="error"> <?php echo $passwordError;?></span>
</div>
<div>
    First Name: <?php echo $fname; ?>
   
</div>
<div>
    Last Name: <?php echo $lname; ?>
   
</div>

<button><a href="question.html">New Question</a></button>

</body>
</html>