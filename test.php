<?php
$url = 'http://videogames.pricecharting.com/game/gameboy/pokemon-yellow?q=pokemon+yellow';
$string = file_get_contents($url);
$pattern = '/(?<=complete_price">\n {16}<span class="price">\n {16})\$[\d\.]+/';
$string = preg_match ($pattern, $string, $array);
echo $array[0];
?>