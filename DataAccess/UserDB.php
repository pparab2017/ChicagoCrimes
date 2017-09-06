<?php


function getUserByUserName($userName)
{

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



$sql = "select 
 user_id
,first_name
,last_name
,age
,username
,pass
,role_id
 FROM users WHERE username = '" . $userName. "'" ;


 $result = $conn->query($sql);


$newUser = new User();
if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
    	 
		
		$newUser->UserID = $row["user_id"];
		$newUser->FirstName = $row["first_name"];
		$newUser->LastName = $row["last_name"];
		$newUser->Age = $row["age"];
		$newUser->UserName = $row["username"];
		$newUser->Password = $row["pass"];
		$newUser->RoleID = $row["role_id"];
       
      
       return $newUser;
    }
   
}
$conn->close();

    
}



?>