<?php

function ccsp_resetUseMap() {
	$_SESSION['ccsp_map'] = array();
	$_SESSION['ccsp_map']['useMapDisplayCount'] = 0;
	$_SESSION['ccsp_map']['getStr'] = array();
	$_SESSION['ccsp_map']['setStr'] = array();
	$_SESSION['ccsp_map']['getInstanceIds'] = array();
	$_SESSION['ccsp_map']['DmExtGetInstanceIds'] = array();
	$_SESSION['ccsp_map']['DmExtGetStrsWithRootObj'] = array();
	$_SESSION['ccsp_map']['DmExtSetStrsWithRootObj'] = array();
	$_SESSION['ccsp_map']['addTblObj'] = array();
	$_SESSION['ccsp_map']['delTblObj'] = array();
}
function getCcspMap() {
	if(!$_SESSION['ccsp_map']) {
		ccsp_resetUseMap();
	}
	return $_SESSION['ccsp_map'];
}
function ccsp_fileExists($f) {
	if(file_exists($f) {
		return true;
	}
	if(file_exists("/var/ccsp/".$f) {
		return true;
	}
	if(file_exists("/fss/gw/var/ccsp/".$f) {
		return true;
	}
	return false;
}

function ccsp_isReady() {
	getCcspMap();
	if(isset($GLOBALS["cosa-ready"])) {
		return $GLOBALS["cosa-ready"];
	}
	if(!extension_loaded("cosa")) {
		$GLOBALS["cosa-ready"] = false;
		return false;
	}
	$resp = shell_exec("ps | grep dbus");
	if(strstr($resp, "basic.conf")) {
		$GLOBALS["cosa-ready"] = true;
		return true;
	}
	$resp = shell_exec("ps -ef | grep dbus");
	if(strstr($resp, "basic.conf")) {
		$GLOBALS["cosa-ready"] = true;
		return true;
	}
	$GLOBALS["cosa-ready"] = false;
	return false;
}
function ccsp_getStr($str) {
	if(!ccsp_isReady()) { return ""; }
	$resp = getStr($str);
	$_SESSION['ccsp_map']['getStr'][$str] = $resp;
	return $resp;
}
function ccsp_setStr($str1, $str2, $bool) {
	if(!ccsp_isReady()) { return ""; }
	$resp = setStr($str1, $str2, $bool);
	$_SESSION['ccsp_map']['setStr'][$str1] = $str2;
	return $resp;
}
function ccsp_getInstanceIds($str) {
	if(!ccsp_isReady()) { return ""; }
	$resp = getInstanceIds($str);
	$_SESSION['ccsp_map']['getInstanceIds'][$str] = $resp;
	return $resp;
}
function ccsp_getInstanceIds2($str) {
	if(!ccsp_isReady()) { return ""; }
	$resp = DmExtGetInstanceIds($str);
	$_SESSION['ccsp_map']['DmExtGetInstanceIds'][$str] = $resp;
	return $resp;
}
function ccsp_getStrsWithRootObj($root, $array) {
	if(!ccsp_isReady()) { return ""; }
	$resp = DmExtGetStrsWithRootObj($root, $array);
	$arrayStr = json_encode($array, JSON_PRETTY_PRINT);
	// $arrayStr = "{\n".implode("\n\t", $array)."\n}";
	$_SESSION['ccsp_map']['DmExtGetStrsWithRootObj'][$root.":".md5($arrayStr)] = $array;
	return $resp;
}
function ccsp_setStrsWithRootObj($root, $bool, $array) {
	if(!ccsp_isReady()) { return ""; }
	$resp = DmExtSetStrsWithRootObj($root, $bool, $array);
	$arrayStr = json_encode($array, JSON_PRETTY_PRINT);
	// $arrayStr = "{\n".implode("\n\t", $array)."\n}";
	$_SESSION['ccsp_map']['DmExtSetStrsWithRootObj'][$root.":".md5($arrayStr)] = $array;
	return $resp;
}
function ccsp_addTblObj($str) {
	if(!ccsp_isReady()) { return ""; }
	$resp = addTblObj($str);
	$_SESSION['ccsp_map']['addTblObj'][$str] = $resp;
	return $resp;
}
function ccsp_delTblObj($str) {
	if(!ccsp_isReady()) { return ""; }
	$resp = delTblObj($str);
	$_SESSION['ccsp_map']['delTblObj'][$str] = $resp;
	return $resp;
}
function ccsp_getUseMap() {
	if(!ccsp_isReady()) { return ""; }
	$_SESSION['ccsp_map']['useMapDisplayCount']++;
	return $_SESSION['ccsp_map'];//$map;
}
?>