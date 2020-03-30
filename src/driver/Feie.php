<?php
/**
 * The following code, none of which has BUG.
 *
 * @author: BD<houruipeng@duoguan.com>
 * @date: 2020/3/24 10:57
 */

namespace hrp\driver;

use hrp\libs\HttpClient;

/**
 * 飞鹅打印机驱动类
 * Class Feie
 *
 * @property string user
 * @property string ukey
 * @package hrp\driver
 */
class Feie implements PrinterInterface{

	protected $config = [];

	private $reqTime;

	public function __construct(array $config){
		$this->config = $config;
		$this->reqTime = time();
	}

	/**
	 * [打印订单接口 Open_printMsg]
	 * @from http://www.feieyun.com/open/index.html?name=3
	 *
	 * @param string $sn 打印机编号sn
	 * @param string $content 打印内容
	 * @param int    $times 打印次数
	 * @return string [string]          [接口返回值]
	 */
	public function printMsg($sn, $content, $times){
		$msgInfo = array(
			'user'    => $this->user,
			'stime'   => $this->reqTime,
			'sig'     => $this->signature(),
			'apiname' => 'Open_printMsg',
			'sn'      => $sn,
			'content' => $content,
			'times'   => $times//打印次数
		);
		$client = new HttpClient();
		if(!$client->post($msgInfo)){
			return $client->errormsg;
		}else{
			//服务器返回的JSON字符串，建议要当做日志记录起来
			$result = $client->getContent();
			return $result;
		}
	}

	/**
	 * 为某个账号添加打印机
	 * @from http://www.feieyun.com/open/index.html?name=3
	 *
	 * @param array $printers
	 * @return string
	 */
	public function printerAddList(array $printers){
		$msgInfo = array(
			'user'           => $this->user,
			'stime'          => $this->reqTime,
			'sig'            => $this->signature(),
			'apiname'        => 'Open_printerAddlist',
			'printerContent' => $this->formatterPrinters($printers),
		);
		$client = new HttpClient();
		if(!$client->post($msgInfo)){
			return $client->errormsg;
		}else{
			$result = $client->getContent();
			return $result;
		}
	}

	/**
	 * @param string $str 要切割的字符串
	 * @param int $len 每行字节长度
	 * @return array 返回切割后的字符串,数组
	 */
	public static function spliceStr($str, $len){
		$blankNum = $len;//名称控制为14个字节
		$lan = mb_strlen($str, 'utf-8');
		$m = 0;
		$j = 1;
		$blankNum = $blankNum - 4;
		$result = array();
		$kw3 = '';
		$tail = '';
		for($i = 0; $i < $lan; $i++){
			//第二层
			$new = mb_substr($str, $m, $j, 'utf-8');
			$j++;
			if(mb_strwidth($new, 'utf-8') < $blankNum){
				if($m + $j > $lan){
					$m += $j;
					$tail = $new;
					$length = iconv("UTF-8", "GBK//IGNORE", $new);
					$k = $len - strlen($length);
					for($q = 0; $q < $k; $q++){
						$kw3 .= ' ';
					}
					$tail .= $kw3;
					break;
				}else{
					$next_new = mb_substr($str, $m, $j, 'utf-8');
					if(mb_strwidth($next_new, 'utf-8') < $blankNum) continue;
					else{
						$m = $i + 1;
						$result[] = $new;
						$j = 1;
					}
				}
			}
		}
		array_push($result, $tail);
		return $result;
	}

	/**
	 * @param int $len 字符串目标字节长度
	 * @param string $str 处理的字符串
	 * @return string 返回格式化以后的字符串
	 */
	public static function makeLen($str,$len){
		$repeat = $len - mb_strwidth($str, 'utf-8');
		$kw = '';
		for($q = 0; $q < $repeat; $q++){
			$kw .= ' ';
		}
		return $str.$kw;
	}


	/**
	 * 待添加的打印机格式化处理
	 *
	 * @param array $printers
	 * @return string
	 */
	private function formatterPrinters(array $printers){
		$tmp = '';
		foreach($printers as $printer){
			$tmp .= '\n'.$printer['sn'].'#'.$printer['key'];
			isset($printer['mark']) && $tmp .= '#'.$printer['mark'];
			isset($printer['number']) && $tmp .= '#'.$printer['number'];
		}
		return substr($tmp, 2);
	}

	private function signature(){
		return sha1($this->user.$this->ukey.$this->reqTime);//公共参数，请求公钥
	}

	public function __get($name){
		// TODO: Implement __get() method.
		return $this->config[$name] ?? false;
	}
}
