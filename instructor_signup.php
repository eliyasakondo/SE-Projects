<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Registratin Form</title>
</head>
<body>
    

<form action="instructor_view.php" method="post" name="instructorRegister">
    <p>Name: <br>
    <input type="text" name="instructorName" id="instructorName" size="20" maxlength="40">
    </p>
    <p>
        Email Address: <br>
        <input type="email" name="instructorEmail" id="instructorEmail" size="20" maxlength="40">
    </p>
    <p>
        Father's Name <br>
        <input type="text" name="instructorFatherName" id="instructorFatherName" size="20" maxlength="40">
    </p>

    <div><label for="instructorMotherName">Mother's Name</label><input type="text" name="instructorMotherName" id="instructorMotherName"></div>
    <div><label for="instructorId">NID/Passport/Driving License </label><input type="text" name="instructorId" id="instructorId"></div>
    <div><label for="instructorDob">Date of Birth</label><input type="date" name="instructorDob" id="instructorDob"></div>



    <!--- Educational Qualificatino ------>
    <h1>Educational Qualification</h1>
        <div>
        <label for="instructorDegee">Degree : </label>
            <input type="text" name="instructorDegee" id="instructorDegee">
            </div>
        <div>
            <label for="instructorDegreeOfUniversity">University</label>
            <input type="text" name="instructorDegreeOfUniversity" id="instructorDegreeOfUniversity">
        </div>
        <div>
            <label for="instructorMajorforDegree"> Major
                
            </label>
            <input type="text" name="instructorMajorforDegree" id="instructorMajorforDegree">
        </div>
            <div>
        <label for="instructorDegreeDuration">Duration (Years): </label>
        <input type="number" name="instructorDegreeDuration" id="instructorDegreeDuration">
        </div>
        <div>
        <label for="instructorCgpa">Cgpa</label>
        <input type="text" name="instructorCgpa" id="instructorCgpa">
        <select name="instructorCgpaOutOf" id="instructorCgpaOutOf" multiple="multiple">
            <option value=" ">  </option>
            <option value="5.00">5.00</option>
            <option value="4.00">4.00</option>
            <option value="3.00">3.00</option>
        </select>
</div>
        <div>
            <h1>Experiences</h1>
            <div><label for="instructorOrganization">Organization</label><input type="text" name="instructorOrganization" id="instructorOrganization"></div>
            <div><label for="instructorserviceRole">Job Responsibilites</label><input type="text" name="instructorserviceRole" id="instructorserviceRole"></div>
            <div><label for="instructorDurationOfService">Duration</label><input type="date" name="instructorDurationOfService" id="instructorDurationOfService"> </div>
        </div>


    <input type="submit" value="Save" name="save" id="save">
</form>

</body>
</html>
