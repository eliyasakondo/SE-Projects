<?php

$instructorName=$_POST['instructorName'];
$instructorEmail=$_POST['instructorEmail'];
$instructorFatherName=$_POST['instructorFatherName'];
$instructorMotherName=$_POST['instructorMotherName'];
$instructorId=$_POST['instructorId'];
$instructorDob=$_POST['instructorDob'];

$instructorDegee=$_POST['instructorDegee'];
$instructorDegreeOfUniversity=$_POST['instructorDegreeOfUniversity'];
$instructorMajorforDegree=$_POST['instructorMajorforDegree'];
$instructorDegreeDuration=$_POST['instructorDegreeDuration'];
$instructorCgpa=$_POST['instructorCgpa'];
$instructorCgpaOutOf=$_POST['instructorCgpaOutOf'];

$instructorOrganization=$_POST['instructorOrganization'];
$instructorserviceRole=$_POST['instructorserviceRole'];
$instructorDurationOfService=$_POST['instructorDurationOfService'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View of Instructor Form</title>
    <style>
        body{
            background:rgb(220,240,250,0.5);
        }
        h1{
            color:rgb(70,180,70,1);
        }
        .red{
            color:rgb(245,30,0,1);
        }
    </style>
</head>
<body>
  


<h1 class="">Congratulations!</h1>
<h2>You registration has successfully completeded.</h2>
<p>
    Your email address is <b class="red"><?php echo $instructorEmail;?> </b> and your password is <b class="red">1234</b>
</p>
<p>Please collect your email addresses and password for login. </p>
<p class="red">Keep in mind that do not share this credentials with others.</p>


<table>
    <tbody>
        <tr>
            <td>Name</td>
            <td><?php echo $instructorName; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $instructorEmail;?></td>
        </tr>
        <tr>
            <td>Father's Name</td>
            <td><?php echo $instructorFatherName;?></td>
        </tr>
        <tr>
            <td>Mother's Name</td>
            <td><?php echo $instructorMotherName;?></td>
        </tr>
        <tr>
            <td>NID/Passport/Driving License</td>
            <td><?php echo $instructorId;?></td>
        </tr>
        <tr>
            <td>Date of Birth</td>
            <td><?php echo $instructorDob?></td>
        </tr>
    </tbody>
</table>
<table>
    <caption>Educational Qualification</caption>
    
    <tr>
        <td>Degree Name: </td>
        <td><?php echo $instructorDegee?></td>
    </tr>
    <tr>
        <td>University: </td>
        <td><?php echo $instructorDegreeOfUniversity?></td>
    </tr>
    <tr>
        <td>Major: </td>
        <td><?php echo $instructorMajorforDegree?></td>
    </tr>
    <tr>
        <td>Duration</td>
        <td><?php echo $instructorDegreeDuration?></td>
    </tr>
        <td>CGPA: </td>
        <td><?php echo $instructorCgpa?></td>
        <td>Out Of: </td>
        <td><?php echo $instructorCgpaOutOf?></td>
    </tr>
    <tr>
        <td>Organization Name</td>
        <td><?php echo $instructorOrganization?> </td>
    </tr>
    <tr>
        <td>Job Responsibility</td>
        <td><?php echo $instructorserviceRole;?></td>
    </tr>
    <tr>
        <td>Job Duration</td>
        <td><?php echo $instructorDurationOfService;?></td>
    </tr>
</table>
</body>
</html>