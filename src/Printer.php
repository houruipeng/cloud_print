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
}
