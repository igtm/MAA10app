<?php

  // WebAPI 仕様
  // https://dev.smt.docomo.ne.jp/?p=docs.api.page&api_docs_id=71#tag01
  
  // コード参考
  // http://www.d-labo.net/laboratory/php/7001.php
  // http://stackoverflow.com/questions/9412650/how-to-fix-411-length-required-error-with-file-get-contents-and-the-expedia-xml
  // http://okwave.jp/qa/q8782761.html

  class voiceAPI{

    /*
    * @param:$xml: webapiの仕様に沿ったxmlを入れる
    * 参考：https://dev.smt.docomo.ne.jp/?p=docs.api.page&api_docs_id=71#tag01
    * @return:(binary)音声データ: どう処理したら良いかはまだ不明.
    * 拡張子がmp3のファイルとして保存すればいいのかな.
    ****/
    private function xml_to_voice($xml) {
      if (!ini_get('allow_url_fopen')) throw new Exception("Not Allowed URL Open!");
      if (!isset($xml)) throw new Exception("Empty XML!");

      $url = 'https://api.apigw.smt.docomo.ne.jp/aiTalk/v1/textToSpeech?APIKEY='.
      '666568614c4b594946526b314f4d37656b724c537a4344354c502f68314a574c6642384942425455427032';

      $headers = array(
        'Content-Type:application/ssml+xml',
        'Accept:audio/L16',
        'Content-Length: '.sprintf("%d",strlen($xml))
        );
      $stream = stream_context_create(array('http' => array(
        'method' => 'POST',
        'header' => implode("\r\n",$headers),
        'content' => $xml
      )));
      return file_get_contents($url, false, $stream);
    }

    /*
    * @param:
    * $speaker:話者名．この中から選べる（http://www.ai-j.jp/）例：nozomi
    * $text:しゃべる言葉．
    * @return: $xml 
    ***/
    public function text_to_xml($speaker,$text){
      $xml = '<?xml version="1.0" encoding="utf-8" ?>';
      $voice = '<voice name="'.$speaker.'">';
      $xml .= '<speak version="1.1">'.$voice.$text.'</voice></speak>';
      return $xml;
    }

    public function getVoice($xml){
      try {
        $hoge = $this->xml_to_voice($xml);
        var_dump($hoge);
        return $hoge;
      } catch (Exception $e) {
        var_dump($e);
      }
    }
    /* binaryデータを保存
     ***/
    public function saveVoiceBi($binary){

    }

  }
  
/*
////// usage sample
$test = new voiceAPI();
$xml = $test->text_to_xml("nozomi","お腹すいたわ．なんかちょーだい");
print $xml;
$voice_bi = $test->getVoice($xml);

//多分この次は，$voice_biをファイルに保存するのかな．
*/


  

 
?>