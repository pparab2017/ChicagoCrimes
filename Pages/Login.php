
<!DOCTYPE html>
<htmlcontainer-fluid">
<head>
<link rel="stylesheet" href="css/bootstrap.css">
<script type="text/javascript" src="js/jquery-1.7.1.js"></script>
<style type="text/css" >

.header
{
background-color: #FFC107;
-webkit-box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);
-moz-box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);
box-shadow: inset -1px -11px 21px -13px rgba(0,0,0,0.65);

}

   </style>


   <script type="text/javascript">
    </script>
<title>Login Page </title>
</head>


    <?php 
    require("./Entities/User.php");
    require("./DataAccess/UserDB.php");

        
        
    //echo "hello";

 if(isset($_REQUEST['submit']))
    {
         $username = $_REQUEST['email'];
         $password = $_REQUEST['password'];
        
         $newUser = getUserByUserName($username);

         if($newUser->Password == $password )
         {
            session_start();
            $_SESSION["LOGGEDINUSER"] = serialize($newUser) ;


              if($newUser->RoleID == 1)
              {
                  echo  "<script type='text/javascript'>location.href = 'Pages/AdminHome.php';</script>";
              }
              else 
              {
                 echo  "<script type='text/javascript'>location.href = 'Pages/UserHome.php';</script>";
              }

           
         }
    }


    ?>


<body>


<form name="form" action="" method="POST" >

<div class="container-fluid header" style="position:relative;width:100%" >
<div class="col-md-12" style="color:#fff !important"> <h5><img src="images/g.png" style="height:40px;bottom:0xp; " >     Members: Pushparaj, Rujuta, Urmil </h5></div>
<div class="col-md-3"></div>
<div class="col-md-1"><img src="images/crime.png" style="height:150px;bottom:0xp"></div>
 <div class="col-md-7" style="padding-left:60px">  <h1> Chicago crimes </h1>
  </div>
<div class="col-md-7" style="padding-left:60px">  <b style="font-size:12px;">  a system which stores crime data since 2001.
  </b> </div>
 </div>
<br/>

<br/> 
<div class="container" >

 <div class="col-md-3"></div>
    <div class="col-md-6 " >
        <div class="container-fluid">
       


<div class="panel panel-success">
  <div class="panel-heading"> <b>Log in</b></div>
  <div class="panel-body">
      

       <div class="form-group">
            <label for="exampleInputEmail1">User Name</label>
            <input type="email" name="email" class="form-control" id="txtEmail1" placeholder="User Name">
            </div>
            <div class="form-group">
             <div class="form-group">
            <label for="exampleInputEmail1">Password</label>
            <input type="password"  name="password" class="form-control" id="txtPassword" placeholder="Password">
            </div>
            <div class="form-group">


<input type="submit" name="submit" value="LOGIN"  class="btn btn-success"/>
  </div>
</div>

            


        </div>


    </div>
<div class="col-md-6"></div>


</form>

</body>
</html>






