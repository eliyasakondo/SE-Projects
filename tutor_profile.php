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
    <title>[Tutor Name ] Profile </title>
    <link rel="stylesheet" href="asset/css/style.css">
    <style>
        .round{
            padding:20px solid green;
            height:150px;
            width:150px;
            background: #def;
            border-radius:70px;
            position: absolute;
            left:45%;
            top:100px;
        }
    </style>
</head>
<body>
    <div class="round">
        <br>Profile Photo
    </div>
    <div>
        <h1>Personal Information</h1>

    </div>
    

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

<div>
    <button class="btn bgred text-white">Edit</button>
    <button type="submit" class="btn ">Update</button>
    

</div>
</body>
</html>