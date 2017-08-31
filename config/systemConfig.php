<?php
return [
    'config' => [
        'timeStamp'=>86400,'config'=>"email",'userRegistrationBlockTime'=>86400,'userNotificationMedium'=>'email','moduleFolder'=>'cms','cmsPrefix'=>"cms"
    ],
	'loginApiConfig'=>['dbFields'=>['id'=>'id','firstname'=>'firstName','middlename'=>'middleName','lastname'=>'lastName','gender'=>'gender','address'=>'address','mobile'=>'mobileNumber','profile_picture'=>'image','thumb_image'=>'thumb_image','last_login'=>'last_login','status'=>'status','pin'=>'pinNumber','no_of_attempt'=>'no_of_attempt','email'=>'email','username'=>'userName','password'=>'password','created_at'=>'created_at','modified_at'=>'modified_at'],
					   'signupFields'=>['firstname'=>'Mandatory','mobile'=>'Mandatory','middlename'=>'Not Mandatory','username'=>'Mandatory','password'=>'Mandatory','email'=>'Mandatory','lastname'=>'Not Mandatory'],
					   'loginFields'=>['username','email','mobile'],
					   'signUpVerfication'=>'none'//none,email,sms
	
	],
		'activationApiConfig'=>['dbFields'=>['id'=>'id','status'=>'status','fullname'=>'fullName','passport_num'=>'passportNumber','citizenship_num'=>'citizenshipNumber','country'=>'country','created_at'=>'created_at','user_image'=>'userImage','passport_image_1'=>'passportImage1','passport_image_2'=>'passportImage2','visa_image'=>'visaImage','form_image'=>'formImage','sim_image'=>'simImage','country_id_image_1'=>'countryIdImage1','country_id_image_2'=>'countryIdImage2'],
					   'activationFields'=>['fullname'=>'Not Mandatory','passport_num'=>'Not Mandatory','citizenship_num'=>'Not Mandatory','country'=>'Not Mandatory'],
					   'passportFields'=>['passport_num'],
					   'citizenshipFields'=>['citizenship_num'],
					   'imagePath'=>['user_image'=>'uploads/user_image/','form_image'=>'uploads/form/','country_id_image_2'=>'uploads/country_image/image2/','sim_image'=>'uploads/sim_image/','visa_image'=>'uploads/visa_image/','country_id_image_1'=>'uploads/country_image/image1/','passport_image_1'=>'uploads/passport_image/image1/','passport_image_2'=>'uploads/passport_image/image2/']
	],
    'apiv1'=> [
				'login'=>['apiPrefix'=>"api/login/v1",'apiModule'=>'api\login\\v1'],
				'device'=>['apiPrefix'=>"api/devices/v1",'apiModule'=>'api\devices\\v1'],
				'user'=>['apiPrefix'=>"api/user/v1",'apiModule'=>'api\user\\v1'],
				'activation'=>['apiPrefix'=>"api/activation/v1",'apiModule'=>'api\activation\\v1'],
				'paypal'=>['apiPrefix'=>"api/paypal/v1",'apiModule'=>'api\paypal\\v1'],
				'download'=>['apiPrefix'=>"api/download/v1",'apiModule'=>'api\paypal\\v1']
				],

		'apiv2'=> [
				'login'=>['apiPrefix'=>"api/login/v2",'apiModule'=>'api\login\\v2'],
				'paypal'=>['apiPrefix'=>"api/paypal/v2",'apiModule'=>'api\paypal\\v2']
				]
			
];

?>