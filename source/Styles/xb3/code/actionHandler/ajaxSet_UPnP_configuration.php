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

//upnpInfo = '{"IsEnabledUPnP":"'+isEnabledUPnP+'", "Period":"'+period+'", "Live":"'+live+'", "IsEnabledZero":"'+isEnabledZero+'", "IsEnabledQosUPnP":"'+isEnabledQosUPnP+'"}';

$upnpInfo = json_decode($_REQUEST['upnpInfo'], true);

//var_dump($upnpInfo);
//echo $ddnsInfo['IsEnabled'];
//echo "<br />";

$isEnabledUPnP = $upnpInfo['IsEnabledUPnP'];
	
if(!strcmp($isEnabledUPnP, "true")) {
	ccsp_setStr("Device.UPnP.Device.UPnPIGD", $upnpInfo['IsEnabledUPnP'],true);
	ccsp_setStr("Device.UPnP.Device.X_CISCO_COM_IGD_AdvertisementPeriod", $upnpInfo['Period'],true);
	ccsp_setStr("Device.UPnP.Device.X_CISCO_COM_IGD_TTL", $upnpInfo['Live'],true);
} else if(!strcmp($isEnabledUPnP, "false")) {
	ccsp_setStr("Device.UPnP.Device.UPnPIGD", $upnpInfo['IsEnabledUPnP'],true);
}

ccsp_setStr("Device.X_CISCO_COM_DeviceControl.EnableZeroConfig", $upnpInfo['IsEnabledZero'],true);
//ccsp_setStr("", $upnpInfo['IsEnabledQosUPnP']); //? R3

?>
