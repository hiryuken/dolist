<?php

if(isset($_POST["submit"])) {

	$user=$_POST["username"];
	$pass=$_POST["password"];

	if ($user!="" && $pass!="") { //SE non sono vuoti allora..
		$connectionDB=mysqli_connect("localhost","root","","dolistuser");// connetti il database
		$query=mysqli_query($connectionDB,"SELECT * FROM utenti WHERE username='$user' ") or die(mysqli_error($connectionDB));//la variabile query prende la query sul database


		if ($query-> num_rows){ //se query ha accesso al numero di righe 
			$rows=mysqli_fetch_array($query);//allora rows prende gli elementi dell array query
			if ($pass==$rows["password"]) { //
				session_start();
				$_SESSION["user"]=$user;
				$_SESSION["password"]=$pass;
				$_SESSION["ID"]= $rows["ID"]; 

				header("location: dolistenter.php");
			}else{

				echo "<script> alert('Your password or your username is wrong!');</script>";
			}
			
		}else{ //li aggiungi al database e li reindorizzi all altra pagina
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

/* $connectionDB=mysqli_connect("localhost","root","","dolistuser");

if($connectionDB){
	echo"your DB is connected";
}else{

	die("your DB is not connected");
}
//novi dati in tabella 

$test=mysqli_query($connectionDB,"INSERT INTO utenti(username,password)VALUES('$user','$pass')");

if(!$test){

	echo("Error".mysqli_error("$connectionDB"));
}

mysqli_close($connectionDB);
*/

//$user=$_POST["username"];
//$pass=$_POST["password"];
//if($user&&$pass) {
//	echo "Welcome  ".$user."  ".$pass;
//}else{
//	echo"you miss some data";
//}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Do List</title>
	<link href="dolist.css" rel="stylesheet" >
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
          <td><input type="text" name="username" size="20" autocomplete="off">
          </td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="text" name="password" size="40" autocomplete="off">
          </td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" name="submit" value="submit"></td>
        </tr>
        </form>
        </table>
      </td>
    </tr>
</table>

</div>



</body>
</html>
