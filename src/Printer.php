<?php
/**
 * The following code, none of which has BUG.
 *
 * @author: BD<houruipeng@duoguan.com>
 * @date: 2020/3/24 10:58
 */

namespace hrp;

class Printer{

	/** @var \hrp\driver\PrinterInterface */
	protected $driver;

	private $result;

	/**
	 * Printer constructor.
	 *
	 * @param string $driver
	 * @param array  $config 打印机配置信息
	 * @throws \Exception
	 */
	public function __construct($driver, array $config){
		if(!is_string($driver)) throw new \Exception('driver must be string,eg.feie,yilianyun');
		$class = '\\hrp\\driver\\'.ucwords($driver);
		$this->driver = new $class($config);
	}

	/**
	 * 添加打印机
	 *
	 * @param array $printers
	 * @return mixed
	 */
	public function printerAddList(array $printers){
		return $this->driver->printerAddList($printers);
	}

	/**
	 * 打印内容
	 *
	 * @param string $sn 打印机编号
	 * @param string $content 打印内容
	 * @param int    $times 打印次数
	 * @return  mixed
	 */
	public function printMsg($sn, $content, $times = 1){
		return $this->driver->printMsg($sn, $content, $times);
	}

	/**
	 * 字符串切割
	 *
	 * @param string $str 字符串
	 * @param    int $len 字节长度
	 * @param string $driver 驱动类
	 * @return array
	 */
	public static function spliceStr($str,$len,$driver="feie"){
		/** @var \hrp\driver\Feie $class */
		$class = '\\hrp\\driver\\'.ucwords($driver);
		return $class::spliceStr($str,$len);
	}

	/**
	 * 字符串转为指定字节的长度
	 *
	 * @param string $str
	 * @param int    $len
	 * @param string $driver
	 * @return string
	 */
	public static function makeLen($str,$len,$driver="feie"){
		/** @var \hrp\driver\Feie $class */
		$class = '\\hrp\\driver\\'.ucwords($driver);
		return $class::makeLen($str,$len);
	}
}
