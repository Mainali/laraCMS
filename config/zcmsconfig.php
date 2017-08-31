<?php
return [
  'zcmsmodules' => [
    'home' => "Dashboard",
      'simRecord' =>'Sim Record',
    'activation' => "Activation",
    'api'=>"API",
    //'multicms' => 'Multi Language CMS',
    'userManagement'=> "User Management",
    'apiusers' =>'Api Users',
    'mobileBuilt' =>'Mobile Built',

  ],
	
  'zcmsmodulepages' => [
    'home' => ['dashboard' => 'Dashboard'],
      'simRecord'=>['highlandSim'=>'Highland Sim Data','vodafoneSim'=>'Vodafone Data'],
    'activation' => ['activation' => 'Activation'],
    'api'=>['config'=>'Api Config','types'=>'Api Types','categories'=>'Api Categories'],
    //'multicms'=>['banner'=>'Banner Management','pages'=>'Page Management','gallery'=>'Photo Gallery','news'=>'News & Events','languages'=>'Language Setting'],
    'userManagement'=> [ 'userManagement' => 'User Management' ],
    'apiusers' => ['apiusers' => 'Api Users'],
    'mobileBuilt' =>['mobileBuilt'=>'Mobile Built'],

  ],

  'zcmsmoduleicons' => [
    'home' => 'fa-home',
    'activation' => 'fa-users',
    'api'=>'fa-table',
    //'multicms'=>'fa-table',
    'userManagement'=>'fa fa-user-plus',
    'apiusers'=>'fa fa-user-plus',
    'mobileBuilt'=>'fa fa-mobile',
      'simRecord' =>'fa fa-database'
  ],

  'adminaccessiblemodules' => [
    'home' => "Dashboard",
      'simRecord' =>'Sim Record',
    'activation' => "Activation",
    
    //'multicms' => 'Multi Language CMS',
    'userManagement'=> "User Management",
    'mobileBuilt' =>'Mobile Built',

  ],


  'zcmstitle' => 'Cms',
  'logotitle' => 'Simactivation',
  'page_template' => [''=>'Select']

];

?>