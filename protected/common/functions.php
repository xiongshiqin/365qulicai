<?php
/**
* 公共方法
* @author porter 2014年9月15日 10:24:33
**/
/**
* 打印带有格式的详细信息，并exit 可做调试用
*@param mix $var 要打印的变量
**/
function mydebug($var){
	echo '<meta charset="utf-8"></meta>';
	echo '<pre>';
	print_r($var);
	echo '</pre>';
	exit();
}

/** 
*打印CActiveRecord记录
*@param CActiveRecord @ar ar记录
**/
function dumpAR($ar){
	echo '<meta charset="utf-8"></meta>';	
	echo '<pre>';
	foreach($ar as $v){
		print_r($v->attributes);
	}
	echo '</pre>';
	exit();
}

/**
* 将传入的ar转换成数组
* @param CActiveRecord ar记录
**/
function arToArray($ar){
	$arr = array();
	foreach($ar as $v){
		$arr[] = $v->attributes;
	}
	return $arr;
}

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function p($var, $echo=true, $label=null, $strict=true) {
        	$label = ($label === null) ? '' : rtrim($label) . ' ';
    	if (!$strict) {
        		if (ini_get('html_errors')) {
            			$output = print_r($var, true);
            			$output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        		} else {
            			$output = $label . print_r($var, true);
        		}
    	} else {
        		ob_start();
        		var_dump($var);
        		$output = ob_get_clean();
        		if (!extension_loaded('xdebug')) {
            			$output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            			$output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        		}
    	}
    	if ($echo) {
        		echo($output);
        		return null;
    	}else
        		return $output;
}





?>