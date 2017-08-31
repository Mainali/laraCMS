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
                            <a class="current" href="javascript:void(0)">Add New User</a>
                        </li>
                    </ul>
                </header>
                        <div class="panel-body">
                            <div class=" form">
                            	
                            	{!! Form::open(array('url' => PREFIX.'/userManagement/addAdmin', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                <input type="hidden" name="action" id="action" value="add">
                          
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-3">Username *</label>
                                        <div class="col-lg-6">
                                            {!! Form::text('username','',['class'=>'form-control']) !!}
                                            
                                            @if($errors->any())
                                                <label class="error" for="cname">{{$errors->first('username')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-3">Password *</label>
                                        <div class="col-lg-3">
                                            <input type="password" class="form-control" name="password">
                                            
                                            @if($errors->any())
                                            	<label class="error" for="cname">{{$errors->first('password')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-3">Modules Permission *</label>
                                        <div class="col-lg-6">
                                        	<?php
                                        	$allmodules = Config::get('zcmsconfig.zcmsmodules');
                                        	foreach ($allmodules as $k => $v) {
                                        	?>
                                            <?php 
                                                if ($k == "home" || $k=='adminConfig' || $k=='userManagement') {
                                                    continue;
                                                }
                                            ?>
                                            <div class="checkbox">
		                                        <label>
                                                     {!! Form::checkbox('modules_permission[]', $k,Input::old('modules_permission[]')); !!}&nbsp;{{$v}}
		                                            <!-- <input name="modules_permission[]" type="checkbox" value="<?=$k; ?>"><?=$v; ?> -->
		                                        </label>
		                                    </div>
		                                    <?php } ?>
                                            @if($errors->any())
                                                <label class="error" for="cname">{{$errors->first('modules_permission')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-lg-3">E-Mail *</label>
                                        <div class="col-lg-6">
                                             {!! Form::text('email','',['class'=>'form-control']) !!}
                                            
                                            @if($errors->any())
                                            	<label class="error" for="cname">{{$errors->first('email')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">First Name *</label>
                                        <div class="col-lg-6">
                                            {!! Form::text('first_name','',['class'=>'form-control']) !!}
                                            @if($errors->any())
                                            	<label class="error" for="cname">{{$errors->first('first_name')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Middle Name</label>
                                        <div class="col-lg-6">
                                            {!! Form::text('middle_name','',['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Last Name *</label>
                                        <div class="col-lg-6">
                                            {!! Form::text('last_name','',['class'=>'form-control']) !!}
                                            @if($errors->any())
                                            	<label class="error" for="cname">{{$errors->first('last_name')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                		<label class="control-label col-md-3">Profile Picture</label>
                                		<div class="controls col-md-9">
                                    		      {!! Form::file('profile_pic',['class'=>'form-control']) !!}
                                                	                                                
                                    		</div>
                                            @if($errors->any())
                                                <label class="error" for="cname">{{$errors->first('profile_pic')}}</label>
                                            @endif
                                		</div>
                            		</div> -->
                                     <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Status</label>
                                        <div class="col-lg-6">
                                            {!! Form::radio('status', 'active', true) !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('status', 'inactive') !!}&nbsp;Inactive
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            <a href="{{URL::to(PREFIX.'/userManagement')}}" class="btn btn-default">Cancel</a>
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