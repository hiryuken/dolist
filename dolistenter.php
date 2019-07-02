<?php
 session_start();

 if (!isset($_SESSION['user']) || !isset($_SESSION['password'])) {
   header("location: dolist.php");
 }

 $connectionDB=mysqli_connect("localhost","root","","dolistuser");

 $query= mysqli_query($connectionDB,"SELECT * FROM list WHERE userid='".$_SESSION["ID"]."' " ) or die(mysqli_error($connectionDB));
 
 $list="";
 $count=1;

  
 while ($rows=mysqli_fetch_array($query)): 
  $del="delete".$rows['ID'];
  $list.="<tr><td>$count</td><td>".$rows['title']."</td><td><button class='deletebtm' name='$del'>X</button></td></tr>";


if (isset($_POST[$del])){

  $querydelete=mysqli_query($connectionDB,"DELETE FROM list WHERE ID='".$rows['ID']."' ") or die(mysqli_error($connectionDB));

    header("refresh:0");
}
  $count++;
  
 endwhile;
 


  if ($list!="") {
    $list.="<tr> <td colspan='3'><button name='alldelete' class='alldeletebtn'>Delete all</botton></td></tr>";
     $list="<form method='POST'>  <table><tr><th>n°</th><th>NOTA</th><th>Delete</th></tr>".$list."</table> </form>";

  }else{
   
    $list="<p class='emptylist'>Your list is empty, create a note</p>";

  }
 if (isset($_POST['alldelete'])) { 
 
 $querydall=mysqli_query($connectionDB,"DELETE FROM list WHERE userid='".$_SESSION['ID']."' ") or die (mysqli_error($connectionDB)); 
    header("refresh: 0");
  }

 if (isset($_POST['enter'])) { 

  $thingstodo=$_POST["thingstodo"];
  if($thingstodo!=""){
    mysqli_query($connectionDB,"insert into list (title,userid) values ('$thingstodo','".$_SESSION["ID"]."')") or die (mysqli_error($connectionDB)); 
    header("refresh: 0");
  }
}

if (isset($_POST["signoff"])) {
   session_destroy();
   header("refresh: 0");
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
 
<h1>Do list</h1> 

  <form method="POST">
    <button name="signoff" class="singoff">sign out</button>
  </form>  

  <form method="POST">
    <input name="thingstodo" type="text" placeholder="enter the text here"  maxlength="200" autocomplete="off" />
    <button name="enter" id="enter" class="enterbtn">ENTER</button>
 </form>
  <?php echo $list;?>

</body>
</html>