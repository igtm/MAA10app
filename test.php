<?php
require 'twilio-php/Services/Twilio.php';
require 'define.php';
// set your AccountSid and AuthToken from www.twilio.com/user/account
$tel_to = '+81-80-4481-3217';

$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN);

$message = $client->account->calls->create(
    TEL_FROM,
    $tel_to,
    "http://i-and-i.main.jp/API/MAA10app/test_call.php"
);

?>