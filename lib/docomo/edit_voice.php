<?php

// 参考サイト
// http://yorozu-1.com/index.php?MEMO/PHP/WAVE

class WaveData {

	var $_d		= '';	// データ

	var $datasize	= 0;	// データサイズ
	var $fmtid	= 0;	// フォーマットID
	var $chsize	= 0;	// チャンネル数
	var $freq	= 0;	// サンプリング周波数

	function noData(){
		if($this->_d == '')
			return true;
		else
			return false;
	}

	function LoadFile($fn) {

		$this->_d = file_get_contents($fn);
		// 識別コード RIFF が存在するかどうか調査
		if (substr($this->_d, 0, 4) != 'RIFF') return false;
		// chunk 識別コード WAVE が存在するかどうか調査
		if (substr($this->_d, 8, 4) != 'WAVE') return false;
		// chunk 識別コード fmt が存在するかどうか調査
		if (substr($this->_d, 12, 4) != 'fmt ') return false;
		// chunk 識別コード data が存在するかどうか調査
		if (substr($this->_d, 36, 4) != 'data') return false;
		
		// フォーマットID を取得します
		// リニアPCMだけを対象にするので、それ以外はエラー
		$d = unpack('v', substr($this->_d, 20, 2));
		$this->fmtid = $d[1];
		if ($this->fmtid != 1) return false;
		
		// チャンネル数を取得
		// モノラルチャンネルだけを対象にします
		$d = unpack('v', substr($this->_d, 22, 2));
		$this->chsize = $d[1];

		if ($this->fmtid != 1) return false;
		
		// サンプリング周波数を取得
		// 44100hz のみを対象とします
		$d = unpack('V', substr($this->_d, 24, 4));
		$this->freq = $d[1];

		// データサイズを取得
		$d = unpack('V', substr($this->_d, 40, 4));
		$this->datasize = $d[1];

	}

	function SaveFile($p1) {
    	file_put_contents($p1, $this->_d);
	}

	//音声結合のメソッド
	function WaveConnect(&$p1) {

		// WAVE ファイルのデータ部分だけ結合します
		$this->_d = $this->_d . substr($p1->_d, 44, $p1->datasize);
		// データサイズを更新します
		$this->datasize = strlen($this->_d) - 44;

		// 実際のデータのサイズも更新します
		$d = pack('V', strlen($this->_d) - 8);
		$this->_d[4] = $d[0];
		$this->_d[5] = $d[1];
		$this->_d[6] = $d[2];
		$this->_d[7] = $d[3];

		$d = pack('V', $this->datasize);
		$this->_d[40] = $d[0];
		$this->_d[41] = $d[1];
		$this->_d[42] = $d[2];
		$this->_d[43] = $d[3];
	}

	//音声合成のメソッド
	function WaveCombine(&$p1) {
		$f2 = 0;
		while(1) {
			$src1 = 0;
			$src2 = 0;
			if ($f2 < $this->datasize) {
				$d = unpack('s', substr($this->_d, 44 + $f2, 2));
				$src1 = $d[1];
			}
			if ($f2 < $p1->datasize) {
				$d = unpack('s', substr($p1->_d,   44 + $f2, 2));
				$src2 = $d[1];
			}
			// 合成します
			$src3 = floor($src1 + $src2);
			// 音割れ防止
			if ($src3 < -32768) $src3 = -32768;
			// 音割れ防止
			if ($src3 > 32767) $src3 = 32767;
			
			$d = pack('v', $src3);
			$this->_d[44 + $f2    ] = $d[0];
			$this->_d[44 + $f2 + 1] = $d[1];

			if (($f2 > $this->datasize) and ($f2 > $p1->datasize)) break;
			
			$f2 += 2;

		}
	}

	//音階調整
	function WaveShift($p1) {
		$f1 = $p1 / 440;
		$f2 = 0;
		$dst = substr($this->_d, 0, 44);

		while(1) {
			$d = substr($this->_d, 44 + floor($f2) * 2, 2);
			$dst .= $d[0];
			$dst .= $d[1];
			if ($f2 > $this->datasize) break;
			$f2 += $f1;
		}

		// データ更新
		$this->_d = $dst;
		$this->datasize = strlen($this->_d) - 44;
		
		// 実際のデータのサイズも更新します
		$d = pack('V', strlen($this->_d) -  8);
		$this->_d[4] = $d[0];
		$this->_d[5] = $d[1];
		$this->_d[6] = $d[2];
		$this->_d[7] = $d[3];

		$d = pack('V', $this->datasize);
		$this->_d[40] = $d[0];
		$this->_d[41] = $d[1];
		$this->_d[42] = $d[2];
		$this->_d[43] = $d[3];

		// 編集開放
		unset($dst);
	}
	
}



////// usage sample
/*
//＠音声結合をする＠

$w1 = new Wavedata();
$f1 = 'http://api.twilio.com/2010-04-01/Accounts/AC5b10badadd6e95dd38c77c9bf3982201/Recordings/RE8a4e157f6240f3877756dad6eb5e304b';
$w1->LoadFile($f1);
$w2 = new Wavedata();
$f2 = 'http://api.twilio.com/2010-04-01/Accounts/AC5b10badadd6e95dd38c77c9bf3982201/Recordings/RE2d3028f886a4ff3f1221821b369f24de';
$w2->LoadFile($f2);

//$w1->WaveCombine($w2); //音声合成
$w1->WaveConnect($w2);
$w1->SaveFile('result.wav');

*/



/*
・二つのwavファイルを合成してわかったこと
WaveCombineメソッドで合成することはできるが，
それぞれ再生時間が大きく異なるため，音程にヅレが生じる．
再生時間が同じwavファイルを合成すれば，音程のヅレがなくなるかも．
*/

?>