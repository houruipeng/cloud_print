<?php
/**
 * The following code, none of which has BUG.
 *
 * @author: BD<houruipeng@duoguan.com>
 * @date: 2020/3/24 17:43
 */

namespace hrp\driver;

interface PrinterInterface{

	/** 构造函数
	 *
	 * @param array $config
	 */
	public function __construct(array $config);
	public function printMsg($sn, $content, $times);
	public function printerAddList(array $printers);
}
