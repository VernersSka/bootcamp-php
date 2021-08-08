<?php
  include "navigation.php";

define('MAX', 6);
define('MIN', 1);

for ($i = MIN; $i <= MAX; ++$i) {
    echo  "<h$i>$i</h$i>";
  }

$i = MAX;
while  ($i >= MIN) {
  echo  "<h$i>$i</h$i>";
  $i--;
}

$cars = ['Volvo', 'BMW', 'Audi', 'Tesla'];
foreach ($cars as $car) {
  echo "<br><strong>$car</strong>";
}

$cities = [
  'riga' => 'Rīga',
  'tallin' => 'Tallina',
  'vilnius' => 'Viļņa',
  'Jūrmala'
];

echo "<pre>";
foreach ($cities as $key => $city) {
  echo "$key => <strong>$city</strong>" . PHP_EOL;

}
echo "</pre>";


echo "<br>";
function a1(int $number) {
  echo $number . " | ";

  if ($number > 1) {
    a1(--$number);
  }

}

a1(20);

$func2 = function ($b1) {
    return $b1 ** 3 + 1;
};


echo "<h3>Func2 = " . func1(6, 7) . "</h3>";
echo "<h3>Func2 = " . $func2(6) . "</h3>";



function func1($b1, $c = 1) {
    return $b1 * $b1 + $c;
}

$c = func1(5);

function func3($b1) {
    global $c, $d;
    return $b1 + $c + $GLOBALS['c'] . $d;
}

echo "<h3>Func3 = " . func3(6) . "</h3>";
