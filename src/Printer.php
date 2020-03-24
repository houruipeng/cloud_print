<?php
/**
 * The following code, none of which has BUG.
 *
 * @author: BD<houruipeng@duoguan.com>
 * @date: 2020/3/24 10:58
 */

namespace hrp;

class Printer{

	/** @var \hrp\driver\Feie */
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
	 * @return bool
	 * @throws \Exception
	 */
	public function printerAddList(array $printers){
		$result = $this->driver->printerAddList($printers);
		if(!$result) throw new \Exception('call method before callable a function');
		$res = json_decode($result, true);
		if(isset($res['ret']) && $res['ret'] == 0){
			if($res['data']['no']) throw new \Exception(json_encode($res['data']['no'], JSON_UNESCAPED_UNICODE));
			return true;
		}
		throw new \Exception(json_encode($res, JSON_UNESCAPED_UNICODE));
	}

	/**
	 * 订单打印
	 *
	 * @param string $sn 打印机编号
	 * @param string $content 打印内容
	 * @param int    $times 打印次数
	 * @return  $this
	 */
	public function printMsg($sn, $content, $times = 1){
		$this->result = $this->driver->printMsg($sn, $content, $times);
		return $this;
	}
}
