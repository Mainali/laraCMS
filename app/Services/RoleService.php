<?php 

namespace App\Services;

use Auth;

use App\Admin;

use Config;

class RoleService
{
  public function getPermissionModules(){
   	$userPermission=Auth::user()->modules_permission;
    $moduleData['adminType'] = Auth::user()->type;
   	$moduleData['zcmsmodules'] = Config::get('zcmsconfig.zcmsmodules');
		$moduleData['zcmsmodulepages'] = Config::get('zcmsconfig.zcmsmodulepages');
    $moduleData['zcmsmoduleicons'] = Config::get('zcmsconfig.zcmsmoduleicons');
   	$allData = array();
   	if($userPermission=='all'){
   		foreach ($moduleData['zcmsmodules'] as $moduleID => $moduleTitle) {
        $arrayData['type'] = $moduleData['adminType'];
   			$arrayData['id'] = $moduleID;
        $arrayData['title'] = $moduleTitle;
        $arrayData['pages'] = count($moduleData['zcmsmodulepages'][$moduleID]);
        $arrayData['subPages'] = $moduleData['zcmsmodulepages'][$moduleID];
        $arrayData['icon'] = $moduleData['zcmsmoduleicons'][$moduleID];
        array_push($allData, $arrayData);
   		}	
   	}
   	else{
   		$userModule=explode(',',$userPermission);
   		foreach ($moduleData['zcmsmodules'] as $moduleID => $moduleTitle) {
			  foreach ($userModule as $moduleValue) {
		      if($moduleID == $moduleValue) {
            $arrayData['type'] = $moduleData['adminType'];
		        $arrayData['id'] = $moduleValue;
		        $arrayData['title'] = $moduleTitle;
		        $arrayData['icon'] = $moduleData['zcmsmoduleicons'][$moduleValue];
		        $arrayData['pages'] = count($moduleData['zcmsmodulepages'][$moduleValue]);
		        $arrayData['subPages'] = $moduleData['zcmsmodulepages'][$moduleValue];
		        $arrayData['logo'] = Config::get('zcmsconfig.logotitle');
		        array_push($allData, $arrayData);
		      }
		    }
		  }
   	}
   	return $allData;
  }

}