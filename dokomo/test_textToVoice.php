<?php

  // WebAPI 仕様
  // https://dev.smt.docomo.ne.jp/?p=docs.api.page&api_docs_id=71#tag01
  
  // コード参考
  // http://www.d-labo.net/laboratory/php/7001.php
  // http://stackoverflow.com/questions/9412650/how-to-fix-411-length-required-error-with-file-get-contents-and-the-expedia-xml
    
  function post($url, $data = array()) {
    if (!ini_get('allow_url_fopen')) 
      throw new Exception("Not Allowed URL Open!");
    $encoded = http_build_query($data);
    $headers = array(
      'Content-Type: application/ssml+xml',
      'Accept: audio/L16',
      'Content-Length: '.sprintf("%d",strlen($encoded))
      );
    $stream = stream_context_create(array('http' => array(
      'method' => 'POST',
      'header' => implode("\n",$headers),
      'content' => $encoded,
    )));
    return file_get_contents($url, false, $stream);
    //TODO:返り値がfalseになる. おそらくheaderの問題.
  }
  
  ////// usage sample
  # https://api.apigw.smt.docomo.ne.jp/aiTalk/v1/textToSpeech?APIKEY=666568614c4b594946526b314f4d37656b724c537a4344354c502f68314a574c6642384942425455427032
  try {
    $url = 'https://api.apigw.smt.docomo.ne.jp/aiTalk/v1/textToSpeech?APIKEY=666568614c4b594946526b314f4d37656b724c537a4344354c502f68314a574c6642384942425455427032';
    
    $xml = array('-'=>'<?xml version="1.0" encoding="utf-8" ?><speak version="1.1"><voice name="nozomi">エーアイの音声合成エンジンによる音声です。</voice><break time="1000ms" /><voice name="seiji">エーアイの音声合成エンジンによる音声です。</voice></speak>');
    
    $hoge = post($url,$xml);
    var_dump($hoge);
  } catch (Exception $e) {
    var_dump($e);
  }
?>