<!DOCTYPE html>

<?php
  $name = 'World';

  include "navigation.php";
?>


<h1>Conditions</h1>
<h2><?php print("Hello " . $name); ?></h2>


<?php
    if ($name === "World") {
        print("<h3>This text is printed with print function</h3>"); 
    }

    if (0 == "0") {
        echo "'0' == 0";
    }

    if (0 === "0") {
        echo "'0' !== 0";
    }
    
    echo "<br>";
    
    if (false) {
      echo "false";
    }
    elseif (true) {
      echo true;
    }
    
    echo "<br>";

    $a = 4;
    switch ($a) {
      case 1:
        echo "One";
        break;
      case 2:
        echo "Two";
        break;
      case 3:
        echo "Three";
        break;
      case (2+2):
        echo "Four";
        break;
    }


    echo "<br>";
    $b = [1, 2, 3, 4, 5, 6, 7];
    foreach ($b as $value) {
      if ($value > 5 || $value < 3)  {
        continue;
      }
      echo $value . "  |  ";
    }
    

    for ($i=1;$i<=4;$i++) {
      echo "<br>";
      $b = [1, 2, 3, 4, 5, 6, 7];
      foreach ($b as $value) {
        if ($value > 5 && $i > 2)  {
          break 2;
        }
        echo $value . "  |  ";
      }
      echo "<br>";
    }


?>