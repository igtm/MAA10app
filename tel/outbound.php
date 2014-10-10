<?php
require '../lib/twilio-php/Services/Twilio.php';
require '../app/models/config.php';
require '../app/models/model.php';

$tel_to = '+818044813217';


$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN);

$message = $client->account->calls->create(
    TEL_FROM,
    $tel_to,
    "http://i-and-i.main.jp/API/MAA10app/tel/outbound_call.php"
);
?>