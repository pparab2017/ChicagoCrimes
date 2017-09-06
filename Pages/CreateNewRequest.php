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
</style>

<script type="text/javascript">



window.onload = function () {



$("#txtautocomplete").geocomplete({
componentRestrictions: { country: 'US' }
})
  .bind("geocode:result", function(event, result){
    console.log(result);
    //alert(result.address_components[0].short_name);


//alert(result.adr_address);
   // alert("lat: " + result.geometry.location.lat() + " lon: "+ result.geometry.location.lng());

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

	session_start();
	$newUser  = unserialize( $_SESSION["LOGGEDINUSER"]); 

    $PrimaryType = getPrimaryType();
    $Description = getDesc();



if(isset($_REQUEST['submit']))
    {

if($_REQUEST['CrimeDate']=="" | $_REQUEST['LocDesc'] =="" | $_REQUEST['BlockDetails'] == "")
{
  echo "<script type='text/javascript'>alert('Please fill in all the fields')</script>";
}

else
{
    	$toInsert = new TempCrime();
    	$toInsert->UserId = $newUser->UserID;
    	$toInsert->CrimeDate = $_REQUEST['CrimeDate'];
    	$toInsert->PrimaryTypeId = $_REQUEST['PrimaryType'];
    	$toInsert->DescriptionId =$_REQUEST['Desc'];
    	$toInsert->IUCR =  getIUCRCode($toInsert->PrimaryTypeId,$toInsert->DescriptionId);
    	$toInsert->Lat = $_REQUEST['lblLat'];
    	$toInsert->Lon = $_REQUEST['lblLon'];
    	$toInsert->LocationDesc =  $_REQUEST['LocDesc'];
    	$toInsert->BlockDetail = $_REQUEST['BlockDetails'];
    	//$toInsert->
    	echo $toInsert->CrimeDate . " " . $toInsert->UserId
    	. " " . $toInsert->PrimaryTypeId ." " . $toInsert->DescriptionId 
    	. " IUCR " . $toInsert->IUCR
    	. "Lat lon ". $toInsert->Lat. "  " . $toInsert->Lon 
    	. " Desc ". $toInsert->LocationDesc ;

    	InserIntoTempCrime($toInsert);

         echo  "<script type='text/javascript'>location.href = 'UserHome.php';</script>";
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
  <a href="UserHome.php"> Home</a> > Edit request

</div>

  <hr/>

	<div class="col-md-11"><p>Welcome, <?php echo $newUser->getFullName()?></p></div>
	   <div class="col-md-1" >  <a href="/ChicagoCrimes/Index.php">Log out </a></div>

</div>



<div class="container">
<hr/>
<h3>Create New crime request</h3>
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
                
                    <input type='text' name="CrimeDate" class="form-control" placeholder="Date time"/>
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
				
<select class="form-control" name="PrimaryType" id="PrimaryType">
<?php 
foreach($PrimaryType as $item) {
	echo "<option value=".$item->PrimaryTypeId .">" . $item->PrimaryTypeDesc . "</option>";
}

?>
</select>


				</div>

		 </div>

		  <div class='col-sm-6'>
		 	<div class="form-group">
				<label for="user">Description </label>
				<select class="form-control" name="Desc" id="Desc">
<?php 
foreach($Description as $item) {
	echo "<option value=".$item->DescId .">" . $item->Description . "</option>";
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

<input type="text" class="form-control" name="LocDesc"  id="exampleInputEmail1" placeholder="Location Description">

				
				</div>
		 </div>


		 <div class='col-sm-6'>
				<div class="form-group">
				<label for="user">Address </label>
				<input type="text" class="form-control" name="BlockDetails" id="txtautocomplete" placeholder="Write complete Address">
				</div>
		 </div>
</div>

<div class="row">
<div class="col-sm-12">

<input type="hidden" name="lblLat" id="hdnLat" value="">
<input type="hidden" name="lblLon" id="hdnLon" value="">

</div>
</div>

<div class="row">
<div class='col-sm-6'>
<input type="submit" class="btn btn-success" name="submit" value="Submit Request">



</div>
</div>


</div>




</form>

</body>