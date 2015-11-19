﻿<!--
 If not stated otherwise in this file or this component's Licenses.txt file the
 following copyright and licenses apply:

 Copyright 2015 RDK Management

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
-->
<?php

function selectTable($sp) {
	$ids=explode(",",getInstanceIDs("Device.X_CISCO_COM_DDNS.Service."));
	foreach ($ids as $key=>$j) {
		$spArr[$j]=ccsp_getStr("Device.X_CISCO_COM_DDNS.Service.".$j.".ServiceName");
		if(strcasecmp($sp,$spArr[$j]) == 0)
			return $j;
	}
	return 0;
}

if (isset($_POST['set'])){
	$status=(($_POST['status']=="Enabled")?"true":"false");
	ccsp_setStr("Device.X_CISCO_COM_DDNS.Enable",$status,true);
	$status=ccsp_getStr("Device.X_CISCO_COM_DDNS.Enable");
	$status=($status=="true")?"Enabled":"Disabled";
	header("Content-Type: application/json");
	echo json_encode($status);
//	echo json_encode("Disabled");
}


if (isset($_POST['add'])){

	$sp=$_POST['sp'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$hostname=$_POST['hostname'];
	
	$result="";
	
	$id = selectTable($sp);
	if($id!=0) {
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$id.".ServiceName",$sp,false);
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$id.".Username",$username,false);
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$id.".Password",$password,false);
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$id.".Domain",$hostname,false);
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$id.".Enable","true",true);
		$result = "Success!";
	} else {
		$result = "Service Provider is not exist!";
	}
	header("Content-Type: application/json");
	echo json_encode($result);
/*	
	$ids=explode(",",getInstanceIDs("Device.X_CISCO_COM_DDNS.Service."));
	if (count($ids)==0) {	//no table, need test whether it equals 0
		ccsp_addTblObj("Device.X_CISCO_COM_DDNS.Service.");
		$IDs=explode(",",getInstanceIDs("Device.X_CISCO_COM_DDNS.Service."));
		$i=$IDs[count($IDs)-1];
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".ServiceName",$sp,false);
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Username",$username,false);
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Password",$password,false);
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Domain",$hostname,false);
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Enable","true",false);
		echo json_encode("Success!");
	} else {
		foreach ($ids as $key=>$j) {
			$arrayService[$j]=ccsp_getStr("Device.X_CISCO_COM_DDNS.Service.".$j.".ServiceName");
		}
		$result="";
		if (in_array($sp,$arrayService)) { $result.="Service Provider Name has been used!\n";}
		if ($result=="") {
			ccsp_addTblObj("Device.X_CISCO_COM_DDNS.Service.");
			$IDs=explode(",",getInstanceIDs("Device.X_CISCO_COM_DDNS.Service."));
			$i=$IDs[count($IDs)-1];
			ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".ServiceName",$sp,false);
			ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Username",$username,false);
			ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Password",$password,false);
			ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Domain",$hostname,false);
			ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Enable","true",true);
			$result="Success!";
		}
		echo json_encode($result);
	}
*/
}

if (isset($_POST['edit'])){
	$i=$_POST['ID'];
	$sp=$_POST['sp'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$hostname=$_POST['hostname'];
	
	//delete entry - we can't edit on same index so delete on one index and update on other index
	if(strcasecmp($sp,ccsp_getStr("Device.X_CISCO_COM_DDNS.Service.".$i.".ServiceName")) != 0){
		ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Enable","false",true);
	}

	$i = selectTable($sp);

	//ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".ServiceName",$sp,false);
	ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Username",$username,false);
	ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Password",$password,false);
	ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Domain",$hostname,false);
	ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Enable","true",true);
	$result="Success!";
	
	header("Content-Type: application/json");
	echo json_encode($result);
}

if (isset($_GET['del'])){
/*	ccsp_delTblObj("Device.X_CISCO_COM_DDNS.Service.".$_GET['del'].".");*/
	$i=$_GET['del'];
	ccsp_setStr("Device.X_CISCO_COM_DDNS.Service.".$i.".Enable","false",true);
	Header("Location:../dynamic_dns.php");
	exit;
}
?>
