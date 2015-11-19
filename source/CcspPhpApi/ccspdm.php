<?php
/**********************************************************************
    Module:
        CCSP Data Model Access PHP API

    Description:
        This module provides the PHP API data model access. The
        requests are routed to Data Model PHP extension APIs.

**********************************************************************/

/**********************************************************************

    caller:     PHP modules

    description:

        This function is for retrieving multiple parameter values at once,
    but with common root object specified for locating the owner component.

    argument:
        $rootObjName
            name of the common root object name for all paramters, 
            e.g., “Device.NAT.”

        $paramNameArray
            array of DM parameter names

    return: an array,
        the first element is status code, 0 – success, other values – errors
        The rest is the array of data model parameter values, in the same
        order as $paramNameArray.

**********************************************************************/

function DmGetStrsWithRootObj($rootObjName, $paramNameArray)
{
    return ccsp_getStrsWithRootObj($rootObjName, $paramNameArray);
}

/**********************************************************************

    caller:     PHP modules

    description:

        This function is for setting multiple parameter values at once,
    but with common root object specified for locating the owner component.

    argument:
        $rootObjName
            name of the common root object name for all paramters, 
            e.g., “Device.NAT.”

        $bCommit
            Whether commit flag is set

        $paramArray
            array of DM parameter name, type and value.

    return: status code

**********************************************************************/

function DmSetStrsWithRootObj($rootObjName, $bCommit = TRUE, $paramArray)
{
    return ccsp_setStrsWithRootObj($rootObjName, $bCommit, $paramArray);
}

/**********************************************************************

    caller:     PHP modules

    description:

        This function is for retrieving the instance IDs under an object table.

    argument:
        $objTableName
            The name of the object table, e.g., “Device.NAT.PortMapping.” 

    return: an array,
        the first element is status code, 0 – success, other values – errors
        The rest is the array of instance numbers.

**********************************************************************/

function DmGetInstanceIds($objTableName)
{
    return ccsp_getInstanceIds2($objTableName);
}

/**********************************************************************

    caller:     PHP modules

    description:

        This function is for adding an instance under an object table.

    argument:
        $objTableName
            The name of the object table, e.g., “Device.NAT.PortMapping.” 

    return: status code / instance ID
        0 – error
        “>0” – the instance ID of the newly added object. This instance
        ID is needed for calling DmSetStrsWithRootObj().

**********************************************************************/

function DmAddObj($objTableName)
{
    return ccsp_addTblObj($objTableName);
}

/**********************************************************************

    caller:     PHP modules

    description:

        This function is for removing an instance under an object table.

    argument:
        $objName
            name of the object, e.g., “Device.NAT.PortMapping.11.” 
    
    return: status code -- 0: success; non-zero: errors

**********************************************************************/

function DmDelObj($objName)
{
    return ccsp_delTblObj($objName);
}

?>
