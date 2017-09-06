<?php

function getWard()
{

  
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    $sql = "select ward_id,WardCode from Ward
where wardcode != ''";

$result = $conn->query($sql);
$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
         $Desc = new DropdownType();
        
        $Desc->Id = $row["ward_id"];
        $Desc->Desc = $row["WardCode"];
        
        $itemsData[] = $Desc;
      
       
    }return $itemsData;
   
}
$conn->close();
    
}

function getFbiCode()
{


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    $sql = "Select FBI_Code_id,description
from  FBI_Codes";

$result = $conn->query($sql);
$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
         $Desc = new DropdownType();
        
        $Desc->Id = $row["FBI_Code_id"];
        $Desc->Desc = $row["description"];
        
        $itemsData[] = $Desc;
      
       
    }return $itemsData;
   
}
$conn->close();

    
}

function getCommunity()
{


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    $sql = "Select CommunityArea_id,CommunityAreaCode
from CommunityArea where CommunityAreaCode != ''";

$result = $conn->query($sql);
$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
         $Desc = new DropdownType();
        
        $Desc->Id = $row["CommunityArea_id"];
        $Desc->Desc = $row["CommunityAreaCode"];
        
        $itemsData[] = $Desc;
      
       
    }return $itemsData;
   
}
$conn->close();

}


function getDisctrict()
{

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    $sql = "Select District_id,DistrictCode
from District where DistrictCode != ''";

$result = $conn->query($sql);
$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
         $Desc = new DropdownType();
        
        $Desc->Id = $row["District_id"];
        $Desc->Desc = $row["DistrictCode"];
        
        $itemsData[] = $Desc;
      
       
    }return $itemsData;
   
}
$conn->close();

}


function getBeat()
{
    $servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    $sql = "Select Beat_id,BeatCode
from Beat";

$result = $conn->query($sql);
$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
         $Desc = new DropdownType();
        
        $Desc->Id = $row["Beat_id"];
        $Desc->Desc = $row["BeatCode"];
        
        $itemsData[] = $Desc;
      
       
    }return $itemsData;
   
}
$conn->close();
}


function getDesc()
{
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

	$sql = "Select Description_id, DescriptionCode
from Description";

$result = $conn->query($sql);
$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
    	 $Desc = new Description();
		
		$Desc->DescId = $row["Description_id"];
		$Desc->Description = $row["DescriptionCode"];
		
        $itemsData[] = $Desc;
      
       
    }return $itemsData;
   
}
$conn->close();


}


function getIUCRCode($PrimaryTypeId, $DescId)
{
	echo "Pri: ". $PrimaryTypeId . " dec: " . $DescId ;

	$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

	$sql = "Select IUCR_match_id from IUCR_match
where PrimaryTypeId = " . $PrimaryTypeId . "
and DescriptionId = " . $DescId ;

$result = $conn->query($sql);


if ($result->num_rows > 0) {
  echo "string";
    while($row = $result->fetch_assoc()) {
    	 
       return $row["IUCR_match_id"];
   }
    
   
}
else
{
	return 'null';
}
$conn->close();


}


function getPrimaryType()
{
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Project04";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

	$sql = "Select PrimaryType_id,PrimaryType_desc
		from PrimaryType";

$result = $conn->query($sql);
$itemsData = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
    	 $PrimaryType = new PrimaryType();
		
		$PrimaryType->PrimaryTypeId = $row["PrimaryType_id"];
		$PrimaryType->PrimaryTypeDesc = $row["PrimaryType_desc"];
		
        $itemsData[] = $PrimaryType;
      
       
    }return $itemsData;
   
}
$conn->close();


}

?>