<?php

require("pdo.php");

$userID=filter_input(INPUT_GET,'userID');
$questionName=filter_input(INPUT_POST,'questionName');
$questionBody=filter_input(INPUT_POST,'questionBody');
$questionSkills=filter_input(INPUT_POST,'questionSkills');
$doubleCheckSkills=explode(',',$questionSkills);


if ($_SERVER["REQUEST_METHOD"]=="POST")
{
    $Validate=true;
    if (empty($questionName))
    {
        $NameError = "Question title is necessary.";
        $Validate=false;
    }
    elseif(strlen($questionName) <3)
    {
        $NameError= "Question title must be at least 3 characters.";
        $Validate=false;
    }
    if (empty($questionBody))
    {
        $bodyError = "Question body is required.";
        $Validate=false;
    }
    elseif(strlen($questionBody) >= 500)
    {
        $bodyError= "Question must be shorter than 500 characters";
        $Validate=false;
    }
    if (empty($questionSkills))
    {
        $skillError = "Skills are required.";
        $Validate=false;
    }
    elseif(count($doubleCheckSkills)<2)
    {
        $skillError= "Must have two or more skills.";
        $Validate=false;
    }

    if($Validate==true)
    {
        $query = 'INSERT INTO questions
                    (ownerID,title,body,skills)
                VALUES
                (:ownerID,:title,:body,:skills)';
        $statement = $db->prepare($query);
        $statement->bindValue('ownerID',$userID);
        $statement->bindValue('questionName',$questionName);
        $statement->bindValue('questionBody',$questionBody);
        $statement->bindValue('questionSkills',$questionSkills);
        $statement->execute();
        $statement->closeCursor();
    }
}
?>

<html lang="en">
<head><title> Question Form</title></head>
<h1> Questionnaire </h1>
<div>
    Question Name = <?php if(!$NameError) echo $questionName; ?>
    <span <span class="error"><?php echo $NameError; ?></span>
</div>
<div>
    Question Body = <?php if(!$bodyError) echo $questionBody; ?>
    <span <span class="error"><?php echo $bodyError; ?></span>
</div>
<div>
    Question Skills = <?php if (!$skillError) echo $questionSkills; ?>
    <span <span class="error"><?php echo $skillError; ?></span>
</div>
</html>
