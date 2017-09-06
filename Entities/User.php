<?php

  class User
{
  var $UserID;
  var $FirstName;
  var $LastName;
  var $Age;
  var $UserName;
  var $Password;
  var $RoleID;

  public function getFullName() {
        return $this->FirstName. " " . $this->LastName;
    }
  
}

?>