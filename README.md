# cloud_print
打印机驱动
~~~~~~~~
//使用方法

require_once '../vendor/autoload.php';
use hrp\Printer;

//开发者信息
$config = [
	'user' => '#########',
	'ukey' => '#####',
];

//驱动类型(目前仅支持飞鹅,后期会加入易联云)
$driverType='feie';


//实例化打印机
$printer = new Printer($driverType, $config);



/**
* 添加多个打印机
* 二维数组,每一个数组表示一个打印机 [sn(编号),key(开发者key),mark(选填,备注),number(选填,流量卡)]
*/
$printer->printerAddList([
	['sn' => $sn, 'key' => $key, 'mark' => 'this is mark', 'number' => 'this is number'],
]);


/**
* 执行打印命令
* $sn:执行打印命名的打印机编号
* $content:打印内容
* $times:打印次数
*/
$printer->printMsg($sn, $content, $times=1);

//编辑指定sn打印机的名字
$printer->printerEdit($sn, $name);

//删除打印机,多个使用数组表示
$printer->printerDelList($snlist);

//清空打印机待打印任务
$printer->delPrinterSqs($sn);

~~~~~~~~

