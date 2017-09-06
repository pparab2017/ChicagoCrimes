<?php 

require("../Entities/LineChartData.php");

if (isset($_POST['GetLineChartData'])) {
        echo GetLineChartData($_POST['GetLineChartData']);
    }


function GetLineChartData($year)
{

    $servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "Project04";
	$conn = mysqli_connect($servername, $username, $password, $dbname);


	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$sql = " select p.PrimaryType_desc, count(ID)
			as Total, 
			COUNT(CASE WHEN Arrest = 'true' THEN ID END) AS Done
			from Crimes c
            join  PrimaryType p on
            c.PrimaryTypeId = p.PrimaryType_id
			where year = ". $year. " 
 			 GROUP BY p.PrimaryType_desc";

	$result = $conn->query($sql);
	$name = array();
	$xData1 = array();
	$yData1 = array();
	$xData2 = array();
	$yData2 = array();

	if ($result->num_rows > 0) {
		
	    while($row = $result->fetch_assoc()) {
	    	$name[] = $row["PrimaryType_desc"];
	    	$yData1[] = $row["Total"] * 1;
	    	$yData2[] = $row["Done"] * 1;
	    }
	}
	$toReturn = array();
	$toAdd = new  LineChartData();
	$toAdd->Name = "Total number of Crimes";
	$toAdd->Color = "#2196F3";
	$toAdd->x_Data = $name;
	$toAdd->y_Data = $yData1;

	$toAdd2 = new  LineChartData();
	$toAdd2->Name = "Total number of Arrests";
	$toAdd2->Color = "#8BC34A";
	$toAdd2->x_Data = $name;
	$toAdd2->y_Data = $yData2;

	$toReturn[] = $toAdd;
	$toReturn[] = $toAdd2;

	echo json_encode($toReturn);



}



// select primaryType, count(ID)
// as total, 
// COUNT(CASE WHEN Arrest = 'true' THEN ID END) AS With_Reconnect
// from Crimes
// where year = 2001 
// GROUP BY primaryType;

?>