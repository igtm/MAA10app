<?php

require 'edit_voice.php';

////// usage sample

//＠音声結合をする＠

$w1 = new Wavedata();
$f1 = 'http://api.twilio.com/2010-04-01/Accounts/AC5b10badadd6e95dd38c77c9bf3982201/Recordings/RE8a4e157f6240f3877756dad6eb5e304b';
$w1->LoadFile($f1);
$w2 = new Wavedata();
$f2 = 'http://api.twilio.com/2010-04-01/Accounts/AC5b10badadd6e95dd38c77c9bf3982201/Recordings/RE2d3028f886a4ff3f1221821b369f24de';
$w2->LoadFile($f2);

//$w1->WaveCombine($w2); //音声合成
$w1->WaveConnect($w2); //音声結合
$w1->SaveFile('result.wav');


?>