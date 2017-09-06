<?php


function ChangeStatusToService($toUpdate)
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
Update  temp_crime
set
 statusID = 2
 WHERE 
crime_id = " . $toUpdate->CrimeId;


if ($conn->query($sql) === TRUE) {
    echo "Updated record successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


}

function DeleteCrimeByID($crime_id)
{
  $servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql="delete from temp_crime
where crime_id = " . $crime_id;

if ($conn->query($sql) === TRUE) {
    echo "Updated record successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

}

function UpdateCrimeRequestByID($toUpdate)
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
Update  temp_crime
set
 block_detail= '".$toUpdate->BlockDetail."',
 IUCR_Id= ".$toUpdate->IUCR.",
 location_desc= '". $toUpdate->LocationDesc."',
 descriptionId= " .$toUpdate->DescriptionId.",
 latitude= " .$toUpdate->Lat .",
 longitude= " .$toUpdate->Lon .",
 PrimaryTypeId= ".$toUpdate->PrimaryTypeId."
 WHERE 
crime_id = " . $toUpdate->CrimeId;


if ($conn->query($sql) === TRUE) {
    echo "Updated record successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

}

function GetTempCrimeByCrimeID($CrimeID){

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "select
  crime_id,
  crime_date,
  block_detail,
  location_desc,
  descriptionId,
  latitude,
  longitude,
  statusID,
  PrimaryTypeId,
  p.PrimaryType_desc,
  d.DescriptionCode,
  LinkedId
  FROM
  temp_crime t
  join PrimaryType p
  on t.PrimaryTypeId = p.PrimaryType_id
  join Description d 
  on t.descriptionId = d.Description_id
  WHERE crime_id = " . $CrimeID;


$result = $conn->query($sql);





if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
      $toAdd = new TempCrime();
    
    $toAdd->CrimeId = $row["crime_id"];
    $toAdd->CrimeDate = $row["crime_date"];
    $toAdd->BlockDetail = $row["block_detail"];
    $toAdd->LocationDesc = $row["location_desc"];
    $toAdd->DescriptionId = $row["descriptionId"];
    $toAdd->Lat = $row["latitude"];
    $toAdd->Lon = $row["longitude"];
    $toAdd->StatusId = $row["statusID"];
    $toAdd->PrimaryTypeId = $row["PrimaryTypeId"];
    $toAdd->PrimaryType = $row["PrimaryType_desc"];
    $toAdd->Description = $row["DescriptionCode"];
    $toAdd->LinkedId = $row["LinkedId"];

    
       return $toAdd;
      
       
    }
   
}
$conn->close();


}


function GetAllTempCrimes()
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
  crime_id,
  crime_date,
  block_detail,
  location_desc,
  descriptionId,
  latitude,
  longitude,
  statusID,
  PrimaryTypeId,
  p.PrimaryType_desc,
  d.DescriptionCode,
  concat(u.first_name , ' ' , u.last_name) as fullName
  FROM
  temp_crime t
  join PrimaryType p
  on t.PrimaryTypeId = p.PrimaryType_id
  join Description d 
  on t.descriptionId = d.Description_id
  join users u
  on t.user_id = u.user_id  order by statusID asc, crime_date asc";




$result = $conn->query($sql);



$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
      $toAdd = new TempCrime();
    
    $toAdd->CrimeId = $row["crime_id"];
    $toAdd->CrimeDate = $row["crime_date"];
    $toAdd->BlockDetail = $row["block_detail"];
    $toAdd->LocationDesc = $row["location_desc"];
    $toAdd->DescriptionId = $row["descriptionId"];
    $toAdd->Lat = $row["latitude"];
    $toAdd->Lon = $row["longitude"];
    $toAdd->StatusId = $row["statusID"];
    $toAdd->PrimaryTypeId = $row["PrimaryTypeId"];
    $toAdd->PrimaryType = $row["PrimaryType_desc"];
    $toAdd->Description = $row["DescriptionCode"];
    $toAdd->UserName = $row["fullName"];
    
        $itemsData[] = $toAdd;
      
       
    }return $itemsData;
   
}
$conn->close();



}

function GetMyTempAddedCrimes($UserID)
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
  crime_id,
  crime_date,
  block_detail,
  location_desc,
  descriptionId,
  latitude,
  longitude,
  statusID,
  PrimaryTypeId,
  p.PrimaryType_desc,
  d.DescriptionCode
  FROM
  temp_crime t
  join PrimaryType p
  on t.PrimaryTypeId = p.PrimaryType_id
  join Description d 
  on t.descriptionId = d.Description_id
  WHERE user_id = " . $UserID;


$result = $conn->query($sql);



$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
    	$toAdd = new TempCrime();
		
		$toAdd->CrimeId = $row["crime_id"];
		$toAdd->CrimeDate = $row["crime_date"];
		$toAdd->BlockDetail = $row["block_detail"];
		$toAdd->LocationDesc = $row["location_desc"];
		$toAdd->DescriptionId = $row["descriptionId"];
		$toAdd->Lat = $row["latitude"];
		$toAdd->Lon = $row["longitude"];
		$toAdd->StatusId = $row["statusID"];
		$toAdd->PrimaryTypeId = $row["PrimaryTypeId"];
		$toAdd->PrimaryType = $row["PrimaryType_desc"];
		$toAdd->Description = $row["DescriptionCode"];

		
        $itemsData[] = $toAdd;
      
       
    }return $itemsData;
   
}
$conn->close();



}

	function InserIntoTempCrime($toInsert)
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
insert into temp_crime
(user_id,crime_date,block_detail,IUCR_Id,location_desc,
 descriptionId, latitude, longitude, statusID, PrimaryTypeId
)
values 
(" . $toInsert->UserId . ",
'" . $toInsert->CrimeDate . "',
'" . $toInsert->BlockDetail . "',
" . $toInsert->IUCR . ",
'" . $toInsert->LocationDesc . "',
" . $toInsert->DescriptionId . ",
" . $toInsert->Lat . ",
" . $toInsert->Lon . ",
1  , "
 . $toInsert->PrimaryTypeId . ")";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
	}

?>