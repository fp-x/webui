<!--
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

$ripInfo = json_decode($_REQUEST['ripInfo'], true);

function setRIPconfig($ripInfo){

	$authType = $ripInfo['AuthType'];

	ccsp_setStr("Device.Routing.RIP.Enable", "true", false);
	ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.Enable", "true", false);	

	ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.Interface", $ripInfo['IfName'], false);	

	if($ripInfo['SendVer'] == "NA") {
		ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.SendRA", "false", false);	
	} 
	else {
		ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.SendRA", "true", false);	
		ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.X_CISCO_COM_SendVersion", $ripInfo['SendVer'], false);	
	}

	if($ripInfo['RecVer'] == "NA") {
		ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.AcceptRA", "false", false);	
	} 
	else {
		ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.AcceptRA", "true", false);	
		ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.X_CISCO_COM_ReceiveVersion", $ripInfo['RecVer'], false);	
	}
	
	ccsp_setStr("Device.Routing.RIP.X_CISCO_COM_UpdateInterval", $ripInfo['Interval'], false);
	ccsp_setStr("Device.Routing.RIP.X_CISCO_COM_DefaultMetric", $ripInfo['Metric'], false);

	if(!strcasecmp($authType, "SimplePassword")) {
		ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.X_CISCO_COM_SimplePassword", $ripInfo['auth_key'], false);
	}
	elseif (!strcasecmp($authType, "MD5")) {
		ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.X_CISCO_COM_Md5KeyValue", $ripInfo['auth_key'], false);
		ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.X_CISCO_COM_Md5KeyID", $ripInfo['auth_id'], false);		//doesn't work?
	}

	ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.X_CISCO_COM_AuthenticationType", $ripInfo['AuthType'], false);
	ccsp_setStr("Device.Routing.RIP.InterfaceSetting.1.X_CISCO_COM_Neighbor", $ripInfo['NeighborIP'], true);

}

setRIPconfig($ripInfo);

	
?>
