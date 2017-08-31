@extends('cms.master')

@section('content')

<!-- page start-->
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                <header class="panel-heading">
                	<ul class="breadcrumbs-alt">
                        <li>
                            <a href="{{URL::to(PREFIX.'/userManagement')}}">Admin Users</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">Edit User <?=$adminData['first_name'];?></a>
                        </li>
                    </ul>
                </header>
                        <div class="panel-body">
                            <div class=" form">
                            	
                            	{!! Form::open(array('url' => PREFIX.'/userManagement/editAdmin', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm', 'files'=>true)) !!}
                                <input type="hidden" name="action" id="action" value="edit">
                                <input type="hidden" name="id" value="<?php echo $adminData['id'];?>" />
                          
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-3">Username</label>
                                        <div class="col-lg-6">
                                            <input class=" form-control" name="username" type="text" value="<?=$adminData['username'] ?>" />
                                            @if($errors->any())
                                                <label class="error" for="cname">{!!$errors->first('username')!!}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-3">Modules Permission</label>
                                        <div class="col-lg-6">
                                        	<?php
                                            $permission = $adminData['modules_permission'];
                                        	$allmodules = Config::get('zcmsconfig.zcmsmodules');
                                        	foreach ($allmodules as $k => $v){
                                                $check = ''; 
                                                if (preg_match("/\b$k\b/i", $permission)) {
                                                    $check = 'checked="checked"';
                                                }
                                        	?>
                                            <div class="checkbox">
		                                        <label>
		                                            <input name="modules_permission[]" type="checkbox" <?=$check; ?> value="<?=$k; ?>"><?=$v; ?>
		                                        </label>
		                                    </div>
		                                    <?php } ?>
                                            @if($errors->any())
                                                <label class="error" for="cname">{!!$errors->first('modules_permission')!!}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-lg-3">E-Mail</label>
                                        <div class="col-lg-6">
                                            <input class="form-control" type="email" name="email" value="<?=$adminData['email'] ?>" />
                                            @if($errors->any())
                                            	<label class="error" for="cname">{!!$errors->first('email')!!}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">First Name</label>
                                        <div class="col-lg-6">
                                            <input class="form-control" type="text" name="first_name" value="<?=$adminData['first_name'] ?>" />
                                            @if($errors->any())
                                            	<label class="error" for="cname">{!!$errors->first('first_name')!!}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Middle Name</label>
                                        <div class="col-lg-6">
                                            <input class="form-control" type="text" name="middle_name" value="<?=$adminData['middle_name'] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Last Name</label>
                                        <div class="col-lg-6">
                                            <input class="form-control" type="text" name="last_name" value="<?=$adminData['last_name'] ?>" />
                                            @if($errors->any())
                                            	<label class="error" for="cname">{!!$errors->first('last_name')!!}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                		<label class="control-label col-md-3">Profile Picture</label>
                                		<div class="controls col-md-9">
                                            <?php if($adminData['profile_pic']!='')
                                            {
                                            ?>
                                            <a type="button" onclick="return hs.expand(this)" style="margin-top:5px" class="btn btn-primary btn-xs highslide" href="{{URL::to('userUploads/admin')}}<?php echo "/".$adminData['profile_edit_pic'];?>" target="_blank">View Previous</a>
                                            <a type="button" class="btn btn-danger btn-xs" style="margin-top:5px" href="{{ URL::to(PREFIX.'/userManagement/deleteFile')}}?id=<?php echo $adminData['id']?>" onClick="Javascript: return confirm('Are you sure you want to remove this image?')">Remove</a>
                                            <?php
                                            }else{
                                            ?>
                                    		<div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-white btn-file">
                                                	<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
                                                	<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                	<input type="file" name="profile_pic" class="default" />
                                                </span>
                                        		<span class="fileupload-preview" style="margin-left:5px;"></span>
                                        		<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                    		</div>
                                            <?php } ?>
                                            @if($errors->any())
                                                <label class="error" for="cname">{!!$errors->first('profile_pic')!!}</label>
                                            @endif
                                		</div>
                            		</div>
                                     <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Status</label>
                                        <div class="col-lg-6">
                                            <label class="radio-inline">
                                                <input name="status" value="active" <?php if($adminData['status']=='active') echo 'checked';?> type="radio">Active
                                            </label>
                                            <label class="radio-inline">
                                                <input name="status" value="inactive" <?php if($adminData['status']=='inactive') echo 'checked'; ?> type="radio">Inactive
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-success" type="submit">Save</button>
                                            <a href="{{URL::to(PREFIX.'/floatpoolAdmin/pages/adminUsers')}}" class="btn btn-default">Cancel</a>
                                        </div>
                                    </div>
                                {!! Form::close()!!}

                            </div>

                        </div>
                    </section>
                </div>
            </div>       
<!-- page end-->

@stop