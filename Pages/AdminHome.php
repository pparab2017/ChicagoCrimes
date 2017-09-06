
<!DOCTYPE html>
<htmlcontainer-fluid">
<head>
<link rel="stylesheet" href="../css/bootstrap.css">
<script type="text/javascript" src="../js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../js/NewDowChart.js"></script>
<script type="text/javascript" src="../js/SVGShapes.js"></script>
<script type="text/javascript" src="../js/LineChart.js"></script>
<script type="text/javascript" src="../js/jquery.geocomplete.js"></script>

 <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkXsZDOik4-cQu5TLL39YAkGaaARIN3Kg&libraries=places">
    </script>

<style type="text/css" >

.header
{
background-color: #FFC107;
-webkit-box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);
-moz-box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);
box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);

}

 .ToolTip
      {
          border-radius: 3px;
          position: absolute;
          width: auto;
          height: auto;
          background: white;
          font-family: sans-serif;
          font-size: 12px;
          box-shadow: 0 0 5px #555;
          -webkit-box-shadow: 0 0 5px #555;
          padding: 3px;
          padding-right: 10px;
          padding-left: 10px;
          opacity: 0.85;
          text-align:center;
  }


.colorDiv
{
    height:12px;
    max-width:12px;
    border-radius:50%;
    
}

.breadCrums
{
border-bottom: 1px solid #ddd;
}

   </style>




   <script type="text/javascript">



window.onload = function () {

$("#infodiv").hide();

// var geocoder = new google.maps.Geocoder();
// var address = "new york";

// geocoder.geocode( { 'address': address}, function(results, status) {

// if (status == google.maps.GeocoderStatus.OK) {
//     var latitude = results[0].geometry.location.lat();
//     var longitude = results[0].geometry.location.lng();
//     alert(latitude);
//     } 
// }); 

$( "#piecon" ).append( "<div class='col-md-12 table' style='height:570px; width:1150px; background:rgba(185,185,185,0.5); position:absolute; z-index:999; border-radius: 4px;' id='waitDiv' >  <img src='../images/pre.gif' style='padding-left:0%; padding-top:10%'/>  </div> " );

   	$.ajax({
                type: 'POST',
                url: '../DataAccess/GraphDataDB.php',
                data: { "GetPieChartData": "0" },
                success: function(out) {
                   
$('#waitDiv').remove();
$("#infodiv").show();
				s = out.replace("Array","");
				//alert(s);
				obj = JSON.parse(s);
				p = new DowChart(135, obj, "graph", "280", "280");
                p.Draw();
test();


                }
            });
   }


function callRecors(status, name)
{
  //alert(status);
$('#waitDiv').remove();

$( "#myLineContainer" ).append( "<div class='col-md-12 table' style='height:570px; width:1150px; background:rgba(185,185,185,0.5); position:absolute; z-index:999; border-radius: 4px;' id='waitDiv' >  <img src='../images/pre.gif' style='padding-left:35%; padding-top:10%'/>  </div> " );



    $.ajax({
                type: 'POST',
                url: '../DataAccess/LineChartDB.php',
                data: { "GetLineChartData": status },
                success: function(out) {

                $('#LineChart').remove();

$("#lbllineChart").empty();


$("#lbllineChart").append("Data loaded for year: " + status);

                   $('#waitDiv').remove();
$( "#myLineContainer" ).append( "<div class='col-md-12 table' id='LineChart' ></div> </div>" );
        //s = out.replace("Array","");
        //alert(out);
        obj = JSON.parse(out);

        var click2 = function (e, obj, currentGroup, pointValue) {
         //  alert(e.target.id);
                     //alert("Pro2 clicked" + pointValue + currentGroup + obj.divID +  obj.data[0].x_Data[pointValue]);
                 }

         var _aesthetics = { BackGroundColor: "#fff", GridLine: "true", GridLineColor: "#eee", Margin: 70, maxDivisions: 5 };

                 var LineChart1 = new LineChart(obj, "LineChart", 1200, 400, _aesthetics, click2);
                 LineChart1.Draw();
        



                }
            });


}

   function test()
   {

   }


    </script>
<title>Login Page </title>
</head>


<?php 
	require("../Entities/User.php");
	require("../Entities/TempCrime.php");
  require("../DataAccess/TempCrime.php");
   require ("../Entities/Suggestions.php");
        require ("../DataAccess/Sugestions.php");
  $myAddedCrime = GetAllTempCrimes();
	  

	session_start();
	$newUser  = unserialize( $_SESSION["LOGGEDINUSER"]); 

   $mySuggestions = GetAllSuggestions();
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


<div class="container tileDiv" >
<br/>
<div class="col-md-8">
<div class="panel panel-danger" >
  <div class="panel-heading"><b> Crime Requests</b></div>
  <div class="panel-body" style="height:300px; overflow-y:scroll">


<?php 
echo "<table class='table table-hover'>";
echo "<tr style='border-top:none !important'><th>Edit</th><th>User</th><th>Block</th><th>Crime Type</th><th>Status</th> </tr>";

    foreach($myAddedCrime as $item) {
      echo "<tr>";
      if($item->StatusId == 3)
      {
$q = "closedFile.php?id=".$item->CrimeId. "";
      }else
      {
      $q = "EditCrime.php?id=".$item->CrimeId. "";
    }
     
$text= "Edit" ;

if($item->StatusId  == 1)
{
  $Status = "<span class='label label-info'>Active</span>";
}
else if($item->StatusId  == 2)
{
  $Status = "<span class='label label-success'>In Service</span>";
}
else if($item->StatusId  == 3)
{
  $Status = "<span class='label label-default'>Closed</span>";
  $text= "View" ;
}


      echo "<td> <a href=". $q .">  ".$text."  </a></td>";
      echo "<td>" . $item->UserName ." </td>";
  echo "<td>" . $item->BlockDetail ." </td>";
  echo "<td>" . $item->PrimaryType ." </td>";
  
  echo "<td>".$Status. "</td>";

}
echo "</table >";
  ?></div>


</div>

  </div>

<div class="col-md-4">
<div class="panel panel-warning">
  <div class="panel-heading"><b>Suggestions</b></div>
  <div class="panel-body" style="height:300px; overflow-y:scroll">
    

    <?php 
echo "<table class='table table-hover'>";



foreach($mySuggestions as $item) {
      echo "<tr>";
       echo "<td> " . $item->Name."</td>";
      echo "<td> " . $item->text."</td>";
      echo "</tr>";
    }

echo "</table >";
?>
  </div>
</div></div>



          <div class="col-lg-12" style="text-align:center"  id="piecon">

<hr/>
          <h5> Crime: <label id="lblYear"> All Records</label> </h5> </div>
     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"   >
         <div class="row" >
            
             <div class="col-lg-12 " id="graph"></div>
             

               
         </div>
         <div class="panel panel-info" id="infodiv">
  <div class="panel-heading">Note</div>
  <div class="panel-body">
    Click on each of the sectors, or each column on the tool tip table to 
    get more info about each year.
  </div>
</div>

         </div>

          <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 align"  id="TableDiv" >
     
         </div>
        </div>

        <div class="container tileDiv" >
        <hr/>
        <div id="myLineContainer"  class="table-responsive">
        <div class="col-md-12"> 
        <label id="lbllineChart"></label>
        </div>
 


</div>
</form>

</body>
</html>