<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="<?php echo "UTF-8"; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "My First PHP Page"; ?></title>
  </head>
  <body>
    <div><?php echo "We Love "; ?></div>
    <div><?php echo "Elzero Channel"; ?></div>
  </body>
</html>
<!-- ============================= -->
<?php
## mahmoud awad 
/*
output 
*/
// dwdwdde
// ===================
/* My Application
 Version 1.0
Created By Elzero*/
// ======================================Week 2 =====================
// assinment1
echo (int)( 15.2 + 14.7 + (10.5 + 10.5)) ."<br>"; // 50
echo gettype((int)(15.2 + 14.7 + (10.5 + 10.5)))."<br>"; // Integer
// assinment2


// Method One
echo gettype(100)."<br>";   
// Method Two
 var_dump(100)."<br>";
// Method Three => Optional
echo is_int(100) ? "Integer" : "Not Integer";
//assinment3
echo "<br>";
echo " Hello " . "\"Elzero\"" . " \\\\ " . "\"\"\" We Love " . "\"\$\$PHP\"";

// Needed Output
// Hello "Elzero" \\ """ We Love "$$PHP"

?>
