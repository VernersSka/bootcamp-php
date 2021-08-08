<!DOCTYPE html>
<link rel="stylesheet" href="style.css">
<?php  
  // pievieno navigāciju
  include "navigation.php";

  //Pārbaude vai ir uzspiesta reset poga
  if (array_key_exists('reset', $_GET) && $_GET['reset'] == 'true') {
    resetGame();
    $moves = [];
  }
  else {
    // poga nav nospiesta - $moves mainīgajā ieliek izdarītos gājienus
    $moves = get();
  }

  if (array_key_exists('bot-first', $_GET)) {
    $symbol = count($moves) % 2 == 0 ? 'x' : 'o';
    if (@$moves['winner'] === null && @$moves['draw'] === null) {
      
      bot_moves($moves, $symbol);
      
      checkWinner($symbol);
      checkDraw();
    }
  }

  // pārbauda vai ir padota id vērtība (vai click uz kāda lauka)
  if (array_key_exists('id', $_GET)) {
    // pēc skaita nosaka vai jāliek X vai O
    $symbol = count($moves) % 2 == 0 ? 'x' : 'o';
    
    // pārbauda vai NAV noteikts uzvarētājs
    if (@$moves['winner'] === null && @$moves['draw'] === null) {
      // uzvarētājs nav noteikts - pievieno simbolu json failā
      add($_GET['id'], $symbol);
      checkWinner($symbol);
      checkDraw();
    }
    
    $moves = get();
    
    if (@$moves['winner'] === null && @$moves['draw'] === null) {
      
      bot_moves($moves, $symbol);
      
      $bot_symbol = $symbol == 'x' ? 'o' : 'x';
      checkWinner($bot_symbol);
      checkDraw();
    }
  }
?>


<div class="game_board">

  <?php 

  for ($i = 1; $i <= 9; $i++) {
    $symbol = array_key_exists($i, $moves) ? $moves[$i] : '';
    // ievieto simbolu iekš <a>
    echo "<a href='?id=$i'>" . $symbol . "</a>";
  }
  ?>

</div>

<div class="game-options">
  <div class="bot-first-btn">
    <a href="?bot-first">Bot moves first</a>
  </div>

  <div class="reset-btn">
    <a href="?reset=true">RESET BOARD</a>
  </div>
</div>

<?php

function get() {
  // pārbauda vai eksistē fails
  if (!file_exists('tic_data.json')) {
    // fails neeksistē
    // pārtrauc funkcijas izpildi izvadot tukšu masīvu
    return [];
  }

  // paņem gājienus json formātā no faila
  $content = file_get_contents('tic_data.json');

  // JSON formātu pārvērš masīvā
  $data = json_decode($content, true);
  if (!is_array($data)) {
    $data = [];
  }

  return $data;
}

function add($id, $symbol) {
  // pieslēdz globālo mainīgo
  global $moves;
  // ja ID NAV gājienu masīvā
  if (!array_key_exists($id, $moves)) {
    // tad saglabā jauno simbolu gājienu masīvā
    $moves[$id] = $symbol;
    // un pārvērš JSON formātā
    $json = json_encode($moves);
    // un visus gājienus saglabā failā
    file_put_contents('tic_data.json', $json);
  }
}

// sāk spēli no jauna
function resetGame() {
  // failā saglabā tukšu objektu (ti, ka gājieni nav izdarīti)
  file_put_contents('tic_data.json', '{}');
  // "nonullē" adrešu joslu
  header('Location: ?');
}

function bot_moves($except, $symbol) {
  $random = mt_rand(1,9);
  $bot_symbol = count($except) % 2 == 0 ? 'x' : 'o';;

  if (!array_key_exists($random, $except)) {
    add($random, $bot_symbol);
    return;
  }

  bot_moves($except, $symbol);
}


function checkWinner($symbol) {
  // pieslēdz globālo mainīgo
  global $moves;

  // nodefinē uzvarošās kombinācijas
  $win_combinations = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],

    [1, 4, 7],
    [2, 5, 8],
    [3, 6, 9],

    [1, 5, 9],
    [3, 5, 7],
  ];

  // salīdzina veiktos gājienus ar uzvarošajām kombinācijām
  foreach ($win_combinations as $c) {
      if (
        @$moves[$c[0]] == $symbol &&
        @$moves[$c[1]] == $symbol &&
        @$moves[$c[2]] == $symbol
      ) {
        echo "<h2>Winner is '$symbol'!</h2>";
        add('winner', $symbol);
        return;
      }
    }
  }

  function checkDraw() {
    global $moves;
    if (count($moves) == 9 && (!array_key_exists('winner', $moves))) {
      echo "<h2>DRAW</h2>";
      add('draw', '');
      return;
    } 
  }

?>


<!-- 
  Gļuki
  1. bota pogu jebkurā brīdī var nospiest un tiks izdarīts gājiens
  2. uzspiežot uz aizņemta lauciņa notriggerojas bots - vajadzētu notikt precīzi NEKAM! 
-->

<!-- 
  risinājums
  1.
  - uztaisīt bota trigger pogu ("state") ar ko pirms partijas var aktivizēt botu. partijas laikā poga neaktīva.
  
 -->