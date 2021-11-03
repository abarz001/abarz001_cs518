<?php
session_start();

//Check if a list has been pasted
if (isset($_POST['btnUpdateKeywords'])){
	echo "<h1>Success! Inserted the following into the database.</h1><br>";
require 'update_keywords.php';
}
?>


<html>

<head>
    <title>(Admin) Insert into the keywords table in the database</title>
</head>

<body>
    <div class="myform">
    <form action="" method="post" name="frmKeywords" id="frmKeywords">
        <table border="0" align="center" cellpadding="2" cellspacing="2">
            <tr>
                <td><br><br><br><br><br>Click 'Update Keywords' below to insert the pending keywords files into the database. <br><br>The keywords generated by TextRank are in /files/keywords/.<br><br></td>
			</tr>
			<tr>
			<td><input name="btnUpdateKeywords" type="submit" id="btnUpdateKeywords" value="Update Keywords" class="buttons"></td>
			</tr>
        </table>
    </form>
    </div>
</body>

</html>