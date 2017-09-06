<!DOCTYPE html>
<htmlcontainer-fluid">
<head>
<link rel="stylesheet" href="../css/bootstrap.css">
<script type="text/javascript" src="../js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../js/NewDowChart.js"></script>
<script type="text/javascript" src="../js/SVGShapes.js"></script>
<script type="text/javascript" src="../js/LineChart.js"></script>
<script type="text/javascript" src="../js/jquery.geocomplete.js"></script>

<style type="text/css"> 

.header
{
background-color: #FFC107;
-webkit-box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);
-moz-box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);
box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);

}

.createNew
{
	background-color:#66ccff ; padding:10px; 
  color: #fff ; text-align: center;  border-radius: 5px;
  padding-top:20px;padding-bottom:20px
}

.createNew:hover
{
	background-color:#0099ff ; padding:10px; 
  color: #fff ; text-align: center;  border-radius: 5px;
  padding-top:20px;padding-bottom:20px
}

.CreateSug
{
	background-color:#8c8cd9; text-align: center; margin-left:10px; padding:10px; color:#fff; border-radius: 5px;padding-bottom:20px; padding-top:20px
}

.CreateSug:hover
{
	background-color:#6666cc; text-align: center; margin-left:10px; padding:10px; color:#fff; border-radius: 5px;padding-bottom:20px; padding-top:20px
}

</style>
</head>

<?php 
	require("../Entities/User.php");
	require("../Entities/TempCrime.php");
	require("../DataAccess/TempCrime.php");

	    require ("../Entities/Suggestions.php");
        require ("../DataAccess/Sugestions.php");
	 
	session_start();
	$newUser  = unserialize( $_SESSION["LOGGEDINUSER"]); 


     $myAddedCrime = GetMyTempAddedCrimes($newUser->UserID);
     $mySuggestions = GetMySugesstions($newUser->UserID);

?>

<body>


<form name="form" action="" method="POST" >

<div class="container-fluid header" style="position:relative;width:100%" >
	<div class="col-md-12" style="color:#fff !important"> <h5><img src="../images/g.png" style="height:40px;bottom:0xp; " >     Members: Pushparaj, Rujuta, Urmil </h5>
	</div>
	<div class="col-md-3"></div>
	<div class="col-md-1"><img src="../images/crime.png" style="height:150px;bottom:0xp"></div>
	<div class="col-md-7" style="padding-left:60px">  <h1> Chicago crimes </h1>
	</div>
	<div class="col-md-7" style="padding-left:60px">  <b style="font-size:12px;">  a system which stores crime data since 2001.</b> 
	</div>
</div>


<div class="container breadCrums" style="background-color:#fff; padding-top:10px" >

	<div class="col-md-11"><p>Welcome, <?php echo $newUser->getFullName()?></p></div>
	<div class="col-md-1" >  <a href="/ChicagoCrimes/Index.php">Log out </a></div>

</div>





<div class="container" > 
<hr/>
 <a href="CreateNewRequest.php"><div class="col-md-3 createNew" > 
 <p style="font-size:60px"> <span class="glyphicon glyphicon-edit" ></span></p>
 
 Create new request </div>
</a>

<a href="CreateNewSug.php">
 <div class="col-md-3 CreateSug"  > 


<p style="font-size:60px"> <span class="glyphicon glyphicon-bullhorn" ></span></p>
 Create new suggestion </div>
 </a>


<div class="col-md-5 "  style="height:150px; overflow-y:scroll">
<?php 
echo "<table class='table table-hover'>";
echo "<tr style='border-top:none !important'><th>My Suggestions</th> </tr>";


foreach($mySuggestions as $item) {
 			echo "<tr>";
 			echo "<td> " . $item->text."</td>";
 			echo "</tr>";
 		}

echo "</table >";
?>

 </div>







 </div>
<div class="container" > 
<br/>
<div class="col-sm-12">
<div class="panel panel-warning row">
  <div class="panel-heading"><b> Requests added by you</b></div>
  <div class="panel-body">
  	

 	<?php 
echo "<table class='table table-hover'>";
echo "<tr style='border-top:none !important'><th>Edit</th><th>Block</th><th>Crime Type</th><th>Description</th><th>Location Description</th><th>Status</th> </tr>";

 		foreach($myAddedCrime as $item) {
 			echo "<tr>";

 if($item->StatusId == 3)
      {
$q = "closedFile.php?id=".$item->CrimeId. "";
      }else
      {
     $q = "EditMyRequest.php?id=".$item->CrimeId. "";
    }
 			
 	$text= "View"	;
 			
if($item->StatusId  == 1)
{
	$Status = "<span class='label label-info'>Active</span>";
	$text= "Edit";
}
else if($item->StatusId  == 2)
{
  $Status = "<span class='label label-success'>In Service</span>";

}
else if($item->StatusId  == 3)
{
  $Status = "<span class='label label-default'>Closed</span>";
}


 			echo "<td> <a href=". $q .">  ".$text."  </a></td>";
	echo "<td>" . $item->BlockDetail ." </td>";
	echo "<td>" . $item->PrimaryType ." </td>";
	echo "<td>" . $item->Description ." </td>";
	echo "<td>" . $item->LocationDesc ." </td>";
	echo "<td>".$Status. "</td>";

}
echo "</table >";
 	?>

  </div>
  </div>
</div></div>




</form>

</body>