<?php
require '../lib/twilio-php/Services/Twilio.php';
require '../app/models/model.php';

$voice = $_POST['RecordingUrl'];
  $updir = "../voices/";
  $filename = "inoue1.wav";
move_uploaded_file($voice, $updir.$filename)

?>