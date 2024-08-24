<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#" method="post">
        <fieldset>
            <legend>    </legend>
            <div id="addname">
                <label for="name">Name</label>
                <input type="text" name="name" id="name">
            </div>
                <input type="button" onClick="addInput()" value="Add More...">

        </fieldset>
    </form>

    <script>
        
        function addInput(){
            var str='<div>';
            str+='<label for="newname">New Name</label>';
            str+='<input type="text" name="newname" id="newname">';
            str+='</div>';
            document.getElementById('addname')=str;
          //  document.write(str);
        }
    </script>
</body>
</html>