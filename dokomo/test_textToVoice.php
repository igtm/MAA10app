<?php

  // WebAPI 仕様
  // https://dev.smt.docomo.ne.jp/?p=docs.api.page&api_docs_id=71#tag01
  
  // コード参考
  // http://www.d-labo.net/laboratory/php/7001.php
  // http://stackoverflow.com/questions/9412650/how-to-fix-411-length-required-error-with-file-get-contents-and-the-expedia-xml
  // http://okwave.jp/qa/q8782761.html

  class voiceAPI{

    private $url = 'https://api.apigw.smt.docomo.ne.jp/aiTalk/v1/textToSpeech?APIKEY=666568614c4b594946526b314f4d37656b724c537a4344354c502f68314a574c6642384942425455427032';

    function xml_to_voice($url, $xml) {
      if (!ini_get('allow_url_fopen')) 
        throw new Exception("Not Allowed URL Open!");

      $headers = array(
        'Content-Type:application/ssml+xml',
        'Accept:audio/L16',
        'Content-Length:'.sprintf("%d",strlen($xml))
        );
      $stream = stream_context_create(array('http' => array(
        'method' => 'POST',
        'header' => implode("\r\n",$headers),
        'content' => $xml
      )));
      return file_get_contents($url, false, $stream);
    }
    
    public function text_to_xml($speaker,$text){
      $xml = '<?xml version="1.0" encoding="utf-8" ?>';
      $voice = '<voice name="'.$speaker.'">';
      $xml .= '<speak version="1.1">'.$voice.$text.'</voice></speak>';
      return $xml;
    }

    ////// usage sample
    #<speak version="1.1"><voice name="nozomi">エーアイの音声合成エンジンによる音声です。</voice>

    public function fetch_voice($xml){
      try {
        $hoge = xml_to_voice($url,$xml);
        var_dump($hoge);
      } catch (Exception $e) {
        var_dump($e);
      }
    }
    
  }
 
?>