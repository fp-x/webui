<?php

function getCcspMap() {
	if(!$_SESSION['ccsp_map']) {
		$_SESSION['ccsp_map'] = array();
		$map = $_SESSION['ccsp_map'];
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
	return $_SESSION['ccsp_map'];
}

function ccsp_getStr($str) {
	$resp = getStr($str);
	$map = getCcspMap();
	$_SESSION['ccsp_map']['getStr'][$str] = $resp;
	return $resp;
}
function ccsp_setStr($str1, $str2, $bool) {
	$resp = setStr($str1, $str2, $bool);
	$map = getCcspMap();
	$_SESSION['ccsp_map']['setStr'][$str1] = $str2;
	return $resp;
}
function ccsp_getInstanceIds($str) {
	$resp = getInstanceIds($str);
	$map = getCcspMap();
	$_SESSION['ccsp_map']['getInstanceIds'][$str] = $resp;
	return $resp;
}
function ccsp_getInstanceIds2($str) {
	$resp = DmExtGetInstanceIds($str);
	$map = getCcspMap();
	$_SESSION['ccsp_map']['DmExtGetInstanceIds'][$str] = $resp;
	return $resp;
}
function ccsp_getStrsWithRootObj($root, $array) {
	$resp = DmExtGetStrsWithRootObj($root, $array);
	$map = getCcspMap();
	$_SESSION['ccsp_map']['DmExtGetStrsWithRootObj'][$root."{\n".implode("\n\t", $array)."\n}"] = $resp;
	return $resp;
}
function ccsp_setStrsWithRootObj($root, $bool, $array) {
	$resp = DmExtSetStrsWithRootObj($root, $bool, $array);
	$map = getCcspMap();
	$_SESSION['ccsp_map']['DmExtSetStrsWithRootObj'][$root."{\n".implode("\n\t", $array)."\n}"] = $resp;
	return $resp;
}
function ccsp_addTblObj($str) {
	$resp = addTblObj($str);
	$map = getCcspMap();
	$_SESSION['ccsp_map']['addTblObj'][$str] = $resp;
	return $resp;
}
function ccsp_delTblObj($str) {
	$resp = delTblObj($str);
	$map = getCcspMap();
	$_SESSION['ccsp_map']['delTblObj'][$str] = $resp;
	return $resp;
}
function ccsp_getUseMap() {
	$map = getCcspMap();
	$_SESSION['ccsp_map']['useMapDisplayCount']++;
	return $_SESSION['ccsp_map'];//$map;
}
?>