<?php 

function GetAllSuggestions()
{

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = " select concat( u.first_name,' ' ,u.last_name) as name,s.text from Suggestions s
 join users u
 on u.user_id = s.UserId";


$result = $conn->query($sql);



$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
        $toAdd = new Suggestion();
        
        $toAdd->text = $row["text"];
        $toAdd->Name = $row["name"];
            
        $itemsData[] = $toAdd;
      
       
    }return $itemsData;
   
}
$conn->close();
}

function GetMySugesstions($userID)
{


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "select text from Suggestions
where userId = ". $userID;


$result = $conn->query($sql);



$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
    	$toAdd = new Suggestion();
		
		$toAdd->text = $row["text"];
			
        $itemsData[] = $toAdd;
      
       
    }return $itemsData;
   
}
$conn->close();

}

function InsertSuggestion($toInsert)
{

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "
insert into 
Suggestions
( UserId,Text)
values
(
".$toInsert->UserId.",
'".$toInsert->text."'
)";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

}

?>