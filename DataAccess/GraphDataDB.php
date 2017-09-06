<?php
require("../Entities/PieChartData.php");

 if (isset($_POST['GetPieChartData'])) {
        echo GetPieChartData();
    }


function GetPieChartData()
{
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "Project04";
	$conn = mysqli_connect($servername, $username, $password, $dbname);


	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "Select Year,COUNT(ID) AS Val FROM Crimes 
	GROUP BY year";
    
    $array = array("#F44336","#E91E63","#9C27B0","#673AB7","#3F51B5","#2196F3",
	  				    "#00BCD4","#009688","#4CAF50","#8BC34A","#CDDC39","#FFEB3B",
	  				    "#FFC107","#FF9800","#795548","#9E9E9E");
    
	
	//echo json_encode($array);
	$result = $conn->query($sql);
	$itemsData = array();
	if ($result->num_rows > 0) {
		
	    while($row = $result->fetch_assoc()) {
	    		$i =  ($row["Year"]*1) - 2001;
	    		$toAdd = new PieChartData();
	    		$toAdd->StatusID = $row["Year"];
	    		$toAdd->Name = $row["Year"]. " count ";
				$toAdd->Val = $row["Val"]*1;
				$toAdd->Color = $array[$i];
				$toAdd->ExtraParams = "No Extra this";
				$itemsData[] = $toAdd;
				
	    }

	}

return json_encode($itemsData);
//echo $itemsData;

$conn->close();
}

?>