<?php
//if the name field is filled in 

$name=$_POST['name'];
$email=$_POST['email'];
printf("Hi%s! <br>",$name);
printf("The address %s will soon be a spam-magnet! <br>", $email);
?>