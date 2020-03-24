<?php
/**
 * The following code, none of which has BUG.
 *
 * @author: BD<houruipeng@duoguan.com>
 * @date: 2020/3/24 17:42
 */

/**
 * todo:后期开发
 */

namespace hrp\driver;

/**
 * 易联云打印机驱动
 * Class Yilianyun
 *
 * @package hrp\driver
 */
class Yilianyun implements PrinterInterface{

	protected $config;

	private $reqTime;

	public function __construct(array $config){
		$this->config = $config;
		$this->reqTime = time();
	}

	public function printerAddList(array $printers){
		// TODO: Implement printerAddList() method.
	}

	public function printMsg($sn, $content, $times){
		// TODO: Implement printMsg() method.
	}

	public function __get($name){
		// TODO: Implement __get() method.
		return $this->config[$name] ?? false;
	}
}
