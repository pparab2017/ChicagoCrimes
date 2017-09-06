<!DOCTYPE html>
<htmlcontainer-fluid">
<head>

<script type="text/javascript" src="../js/jquery-3.1.1.js"></script>
<script type="text/javascript" src="../js/NewDowChart.js"></script>
<script type="text/javascript" src="../js/SVGShapes.js"></script>
<script type="text/javascript" src="../js/LineChart.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>

<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="../js/jquery.geocomplete.js"></script>

 <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkXsZDOik4-cQu5TLL39YAkGaaARIN3Kg&libraries=places">
    </script>

<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.css">

<style type="text/css"> 

.header
{
background-color: #FFC107;
-webkit-box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);
-moz-box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);
box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);

}

.map_canvas { 
  width: 100%; 
  height: 400px; 
  
}
</style>

<script type="text/javascript">

 $(function(){
        $("#geocomplete").geocomplete({
          map: ".map_canvas"
        });

      //  var lat_and_long = "35.3159070000, -80.7427730000";
        //$("#geocomplete").geocomplete("find", lat_and_long);  

      });



window.onload = function () {



$("#txtautocomplete").geocomplete({
componentRestrictions: { country: 'US' }
})
  .bind("geocode:result", function(event, result){
    console.log(result);
    alert(result.address_components[0].short_name);


alert(result.adr_address);
    alert("lat: " + result.geometry.location.lat() + " lon: "+ result.geometry.location.lng());

    $("#hdnLat").val(result.geometry.location.lat());
     $("#hdnLon").val(result.geometry.location.lng());
  });

}
</script>

</head>
<?php 
	require("../Entities/User.php"); 
	require("../Entities/TempCrime.php"); 
	require("../Entities/PrimaryType.php"); 
	require("../DataAccess/DropDowns.php"); 
	require("../DataAccess/TempCrime.php"); 
require("../DataAccess/CrimeDB.php"); 
require("../Entities/Crime.php"); 

	session_start();
	$newUser  = unserialize( $_SESSION["LOGGEDINUSER"]); 

    $PrimaryType = getPrimaryType();
    $Description = getDesc();
    $Beat = getBeat();
    $Disctrict = getDisctrict();
    $Community = getCommunity();
    $FbiCodes = getFbiCode();
    $ward = getWard();


//echo  $_SERVER['QUERY_STRING'];

parse_str($_SERVER['QUERY_STRING'], $query);
$Id=  $query['id'];
$selectedCrime = GetTempCrimeByCrimeID($Id);

$btnService ="hidden";
if($selectedCrime->StatusId == 1)
{
$btnService = "submit";
}


$btnComplete ="hidden";
if($selectedCrime->StatusId == 2)
{
$btnComplete = "submit";
}

//var lat_and_long = "35.3159070000, -80.7427730000";
//$("#geocomplete").geocomplete("find", lat_and_long);  
$latLon = $selectedCrime->Lat. ", " .$selectedCrime->Lon;
//echo $latLon;
$String = '$("#geocomplete").geocomplete("find", "' .$latLon .'")';
//echo $String ;
echo "<script type='text/javascript'> $(function(){". $String . "   });</script>";


if(isset($_REQUEST['SubmitNext']))
{
 if($selectedCrime->StatusId == 2)
 {

   $toInsert = new Crime();

   $toInsert->arrest  = "false";
   $toInsert->domestic = "false";
        $toInsert->CrimeId = $Id;
        $toInsert->CrimeDate = $_REQUEST['CrimeDate'];
        $toInsert->PrimaryTypeId = $_REQUEST['PrimaryType'];
        $toInsert->DescriptionId =$_REQUEST['Desc'];
        $toInsert->IUCR =  getIUCRCode($toInsert->PrimaryTypeId,$toInsert->DescriptionId);
        $toInsert->Lat = $_REQUEST['lblLat'];
        $toInsert->Lon = $_REQUEST['lblLon'];
        $toInsert->LocationDesc =  $_REQUEST['LocDesc'];
        $toInsert->BlockDetail = $_REQUEST['BlockDetails'];

        $toInsert->BeatId =$_REQUEST['Beat'];
        $toInsert->DistrictId =  $_REQUEST['Disctrict'];
        $toInsert->CommunityId = $_REQUEST['Community'];
        $toInsert->fbiCodeId = $_REQUEST['fbicode'];
        $toInsert->arrest =  $_REQUEST['Arrest']  == "true" ? "true" : "false";
        $toInsert->domestic = $_REQUEST['Domestic']  == "true" ? "true" : "false";
        $toInsert->year = date("Y");
        $toInsert->wardID = $_REQUEST['ward'];
        


//echo "arrest" . $toInsert->arrest. " year " . $toInsert->year;
//echo "close";
InserIntoCrime($toInsert);

 echo  "<script type='text/javascript'>location.href = 'AdminHome.php';</script>";
}
elseif ($selectedCrime->StatusId == 1)
{
//echo "next";

  $toInsert = new Crime();
        $toInsert->CrimeId = $Id;


    
try
{
      ChangeStatusToService($toInsert);
}
catch(Exception $e)
{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
    finally{
         echo  "<script type='text/javascript'>location.href = 'AdminHome.php';</script>";
    }
}

}



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


<div class='col-sm-6' style="font-size:10px !important">
  <a href="AdminHome.php"> Home</a> > Edit request

</div>

  <hr/>

	<div class="col-md-11"><p>Welcome, <?php echo $newUser->getFullName()?></p></div>
	<div class="col-md-1" >  <a href="/ChicagoCrimes/Index.php">Log out </a></div>

</div>



<div class="container">
<hr/>
<h3>Edit crime request</h3>
<hr/>
</div> 




<div class="container">



    <div class="row">

<div class='col-sm-6'>

        <div class="form-group">
    <label for="user">Full Name</label>
    <input type="text" class="form-control" value="<?php echo $newUser->getFullName()?>" id="exampleInputEmail1" placeholder="User Name" disabled>
  </div>
  </div>

        <div class='col-sm-6'>
            <div class="form-group">
             <label for="date">Crime Date time</label>
                <div class='input-group date' id='datetimepicker1'>
                
                    <input type='text' name="CrimeDate" value="<?php echo $selectedCrime->CrimeDate  ?>" class="form-control" placeholder="Date time" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>

    </div>


<div class="row">

		 <div class='col-sm-6'>
		 	<div class="form-group">
				<label for="user">Primary Type </label>
				
<select class="form-control" name="PrimaryType" id="PrimaryType" >
<?php 
foreach($PrimaryType as $item) {

$selectedType ="";
    if($selectedCrime->PrimaryTypeId == $item->PrimaryTypeId)
    {
        $selectedType = "selected='selected'";
    }

	echo "<option ".$selectedType." value=".$item->PrimaryTypeId .">" . $item->PrimaryTypeDesc . "</option>";
}

?>
</select>


				</div>

		 </div>

		  <div class='col-sm-6'>
		 	<div class="form-group">
				<label for="user">Description </label>
				<select class="form-control" name="Desc" id="Desc" > 
<?php 
foreach($Description as $item) {
$selected ="";
    if($selectedCrime->DescriptionId == $item->DescId)
    {
        $selected = "selected='selected'";
    }
	echo "<option ".$selected."  value=".$item->DescId .">" . $item->Description . "</option>";
}

?>
</select>

				</div>

		 </div>
</div>




 


<div class="row">

 <div class='col-sm-6'>
				<div class="form-group">
				<label for="user">Location Description </label>

<input type="text" class="form-control" name="LocDesc" 
value="<?php echo $selectedCrime->LocationDesc  ?>" id="exampleInputEmail1" placeholder="Location Description" >

				
				</div>
		 </div>


		 <div class='col-sm-6'>
				<div class="form-group">
				<label for="user">Address </label>
				<input type="text" class="form-control" name="BlockDetails" id="txtautocomplete" placeholder="Write complete Address" value="<?php echo $selectedCrime->BlockDetail  ?>" >
				</div>
		 </div>
</div>


<?php 
$extrInfo ;
if($selectedCrime->StatusId == 2)
{
  $extrInfo = "inline";
}
else
{
  $extrInfo = "none";
}
?>

<div style="display:<?php echo $extrInfo ?>">



<div class="row">

 <div class='col-sm-6'>
 <div class="form-group">
<b> Beat</b> 
 <select class="form-control" name="Beat" id="Desc">
<?php 
foreach($Beat as $item) {

    echo "<option   value=".$item->Id .">" . $item->Desc . "</option>";
}

?>


 </select></div>
 </div>
    
     <div class='col-sm-6'>
         <div class="form-group">
<b> Disctrict</b> 
 <select class="form-control" name="Disctrict" id="Desc">
<?php 
foreach($Disctrict as $item) {

    echo "<option   value=".$item->Id .">" . $item->Desc . "</option>";
}

?>

 </select>

     </div></div>
</div>


<div class="row">

 <div class='col-sm-6'><div class="form-group">
<b> Community</b> 
 <select class="form-control" name="Community" id="Desc">
<?php 
foreach($Community as $item) {

    echo "<option   value=".$item->Id .">" . $item->Desc . "</option>";
}

?>

 </select>
 </div></div>
    
     <div class='col-sm-6'>
         <div class="form-group">
<b> FBI Codes</b> 
 <select class="form-control" name="fbicode" id="Desc">
<?php 
foreach($FbiCodes as $item) {

    echo "<option   value=".$item->Id .">" . $item->Desc . "</option>";
}

?>

 </select>

     </div></div>

</div>

<div class="row">

 <div class='col-sm-6'><div class="form-group">
 <b> Ward</b> 
 <select class="form-control" name="ward" id="Desc">
<?php 
foreach($ward as $item) {

    echo "<option   value=".$item->Id .">" . $item->Desc . "</option>";
}

?>

 </select>
 </div></div>


 <div class='col-sm-3'><div class="form-group">
 <b> Domestic</b> 
 <input type="checkbox" class="checkbox" name="Domestic" value="true">
 </div></div>



 <div class='col-sm-3'><div class="form-group">
 <b> Arrest</b> 
 <input type="checkbox" class="checkbox" name="Arrest" value="true">
 </div></div>
</div>






</div>





      <div class="panel panel-default">
  <div class="panel-heading">Map</div>
  <div class="panel-body">
<div class="row" style="">   <div class="map_canvas" style="width:100%"></div></div>
</div>
</div>
<div class="row">
<div class="col-sm-12">

<input type="hidden" name="lblLat" id="hdnLat" value="<?php echo $selectedCrime->Lat  ?>">
<input type="hidden" name="lblLon" id="hdnLon" value="<?php echo $selectedCrime->Lon  ?>">

</div>
</div>




<div class="row">
<div class='col-sm-6' style="margin-bottom:50px">


<input type="<?php echo $btnService?>" class="btn btn-success" name="SubmitNext" value="Pick up for Service">



<input type="<?php echo $btnComplete?>" class="btn btn-danger" name="SubmitNext" value="Complete Request">
</div>
</div>


</div>







<input id="geocomplete" type="hidden"/>
   

 


</form>

</body>