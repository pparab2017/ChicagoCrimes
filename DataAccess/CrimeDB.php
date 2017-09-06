<?php 


function GetByCrimeID($CrimeId)
{

	//echo "passed id  ". $CrimeId;

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "select 
    Arrest,
    Domestic,
    CommunityAreaID,
    WardID,
    DistrictID,
    BeatID,
    FbiID,
    IUCRID
FROM Crimes
where  ID = " . $CrimeId;


$result = $conn->query($sql);



	  $toAdd = new Crime();

if ($result->num_rows > 0) {
 // echo "accsssss id  ". $CrimeId;
    while($row = $result->fetch_assoc()) {
    
   // echo "accsssss id  ". $CrimeId;
    $toAdd->Arrest = $row["Arrest"];
    $toAdd->domestic = $row["Domestic"];
    $toAdd->CommunityId = $row["CommunityAreaID"];
    $toAdd->wardID = $row["WardID"];
    $toAdd->DistrictId = $row["DistrictID"];
    $toAdd->BeatId = $row["BeatID"];
    $toAdd->fbiCodeId = $row["FbiID"];
    $toAdd->IUCR = $row["IUCRID"];
   

    
       return $toAdd;
      
       
    }
   
}
$conn->close();



}


	function InserIntoCrime($toInsert)
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

CALL InsertIntoCrimeD(
'" . $toInsert->CrimeId . "',
'" . $toInsert->CrimeDate . "',
'" . $toInsert->BlockDetail . "',
'" . $toInsert->LocationDesc . "',
'" . $toInsert->arrest . "',
'" . $toInsert->domestic . "',
" . $toInsert->year . ",
" . $toInsert->Lat . ",
" . $toInsert->Lon . ",
" . $toInsert->CommunityId . ",
" . $toInsert->wardID . ",
" . $toInsert->DistrictId . ",
" . $toInsert->BeatId . ",
" . $toInsert->PrimaryTypeId . ",
" . $toInsert->DescriptionId . ",
" . $toInsert->fbiCodeId . ",
" . $toInsert->IUCR .

")";

 

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
	}


?>