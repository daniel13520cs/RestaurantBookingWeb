<?php
   // This file is the same as example 6-7, but includes mysqlclean() and shellclean() 

   $hostName = "127.0.0.1";
   $databaseName = "RestaurantBooking";
   $username = "root";
   $password = "password";

   function showerror()
   {     
      die("Error " . mysql_errno() . " : " . mysql_error());
   }

   function mysqlclean($array, $index, $maxlength, $connection)
   {
     if (isset($array["{$index}"]))
     {
        $input = substr($array["{$index}"], 0, $maxlength);
        $input = mysql_real_escape_string($input, $connection);
        return ($input);
     }
     return NULL;
   }

   function shellclean($array, $index, $maxlength)
   {
     if (isset($array["{$index}"]))
     {
       $input = substr($array["{$index}"], 0, $maxlength);
       $input = EscapeShellCmd($input);
       return ($input);
     }
     return NULL;
   }

   function dbResult($result)
   {
      echo "<table border = \"1\">\n";
      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
          echo "\t<tr>\n";
          foreach ($line as $col_value) {
              echo "\t\t<td>$col_value</td>\n";
          }
          echo "\t</tr>\n";
      }
      echo "</table>\n";
   }

   function isdbResultEmpty($result)
   {
      return (mysql_num_rows($result) == 0);
   }

?>
