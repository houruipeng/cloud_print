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
	//打印
	public function printMsg($sn, $content, $times);
	//添加
	public function printerAddList(array $printers);
	//编辑
	public function printerEdit($sn, $name);
	//删除打印机
	public function printerDelList($snlist);
	//清空打印机任务
	public function delPrinterSqs($sn);

	public static function spliceStr($str,$len);
	public static function makeLen($str,$len);
}
