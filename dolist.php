<?php

if(isset($_POST["submit"])) {

	$user=$_POST["username"];
	$pass=$_POST["password"];

	if ($user!="" && $pass!="") { 
		$connectionDB=mysqli_connect("localhost","root","","dolistuser");
		$query=mysqli_query($connectionDB,"SELECT * FROM utenti WHERE username='$user' ") or die(mysqli_error($connectionDB));


		if ($query-> num_rows){ 
			$rows=mysqli_fetch_array($query);
			if ($pass==$rows["password"]) { 
				session_start();
				$_SESSION["user"]=$user;
				$_SESSION["password"]=$pass;
				$_SESSION["ID"]= $rows["ID"]; 

				header("location: dolistenter.php");
			}else{

				echo "<script> alert('Your password or your username is wrong!');</script>";
			}
			
		}else{
			mysqli_query($connectionDB,"insert into utenti (username,password) values ('$user','$pass')  ") or die(mysqli_error($connectionDB));

			$query=mysqli_query($connectionDB,"SELECT * FROM utenti WHERE username='$user' ") or die(mysqli_error($connectionDB));
				session_start();
			
				$_SESSION["user"]=$user;
				$_SESSION["password"]=$pass;
				$_SESSION["ID"]= mysqli_fetch_array($query)["ID"]; 

				header("location: dolistenter.php");

		}
	}

}


?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Do List</title>
	<link href="dolist.css" rel="stylesheet">
</head>
<body>

<h1>Do list (git version)</h1>

<table>

  <tr>
    <td>Login</td>
  </tr>

  <tr>
    <td>
      <table>
        <form method="post" action="dolist.php">
      
        <tr>
          <td>Username</td>
          <td><input type="text" name="username"  autocomplete="off"></td>
        </tr>

        <tr>
          <td>Password</td>
          <td><input type="password" name="password"  autocomplete="off"></td>
        </tr>
        
        <tr>
          <td colspan="2"><input type="submit" name="submit" value="submit"></td>
        </tr>

        </form>
        </table>
      </td>
    </tr>
</table>

</div>



</body>
</html>
