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
                                     @if($errors->first('msgSuccess'))
                                <div class="alert alert-success fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    {{$errors->first('msgSuccess')}} 
                                </div>
                                @endif
                                
                                @if($errors->first('msgError'))
                                <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    {{$errors->first('msgError')}} 
                                </div>
                                @endif
                                @if($errors->first('current_password'))
                                <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    {!!$errors->first('current_password')!!} 
                                </div>
                                @endif
                                @if($errors->first('new_password'))
                                <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    {!!$errors->first('new_password')!!} 
                                </div>
                                @endif
                                @if($errors->first('confirm_password'))
                                <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    {!!$errors->first('confirm_password')!!} 
                                </div>
                                @endif
                                {!! Form::open(array('url' => PREFIX.'/userManagement/editAdmin', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm', 'files'=>true)) !!}
                                <input type="hidden" name="action" id="action" value="edit">

                                <input type="hidden" name="id" value="<?php echo $adminData['id'];?>" />
                          
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-3">Username *</label>
                                        <div class="col-lg-6">
                                            {!! Form::text('username',$adminData->username,['class'=>'form-control']) !!}
                                            
                                            @if($errors->any())
                                                <label class="error" for="cname">{!!$errors->first('username')!!}</label>
                                            @endif
                                        </div>
                                    </div>
                                    @if (Auth::user()->type == 'superadmin')
                                        @if($adminData->type == 'superadmin')
                                             <input type="hidden" value="all" name='modules_permission[]'/>
                                    
                                        @else
                                            <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-3">Modules Permission *</label>
                                            <div class="col-lg-6">
                                                <?php
                                                $permission = $adminData->modules_permission;
                                                
                                                $allmodules = Config::get('zcmsconfig.zcmsmodules');
                                                foreach ($allmodules as $k => $v){

                                                if ($k == "home" || $k=='adminConfig' || $k=='userManagement') {
                                                    continue;
                                                }
                                            
                                                    $check = ''; 
                                                    if (preg_match("/\b$k\b/i", $permission)) { ?>
                                                        <div class="checkbox">
                                                            <label>

                                                                {!! Form::checkbox('modules_permission[]', $k,Input::old('modules_permission[]',true)); !!}&nbsp;{{$v}}
                                                                
                                                            </label>
                                                        </div>

                                                    <?php }else{?>

                                                <div class="checkbox">
                                                    <label>

                                                        {!! Form::checkbox('modules_permission[]', $k,Input::old('modules_permission[]')); !!}&nbsp;{{$v}}
                                                        
                                                    </label>
                                                </div>
                                                <?php } ?>

                                                <?php } ?>
                                                @if($errors->any())
                                                    <label class="error" for="cname">{!!$errors->first('modules_permission')!!}</label>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                    @endif
                                       
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-lg-3">E-Mail *</label>
                                        <div class="col-lg-6">
                                            {!! Form::text('email',$adminData->email,['class'=>'form-control']) !!}
                                            
                                            @if($errors->any())
                                                <label class="error" for="cname">{!!$errors->first('email')!!}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">First Name *</label>
                                        <div class="col-lg-6">
                                            {!! Form::text('first_name',$adminData->first_name,['class'=>'form-control']) !!}
                                            
                                            @if($errors->any())
                                                <label class="error" for="cname">{!!$errors->first('first_name')!!}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Middle Name</label>
                                        <div class="col-lg-6">
                                            {!! Form::text('middle_name',$adminData->middle_name,['class'=>'form-control']) !!}
                                            
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Last Name *</label>
                                        <div class="col-lg-6">
                                            {!! Form::text('last_name',$adminData->last_name,['class'=>'form-control']) !!}
                                            
                                            @if($errors->any())
                                                <label class="error" for="cname">{!!$errors->first('last_name')!!}</label>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="form-group">
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
                                            
                                                    {!! Form::file('profile_pic',['class'=>'form-control']) !!}
                                                
                                            <?php } ?>
                                            @if($errors->any())
                                                <label class="error" for="cname">{!!$errors->first('profile_pic')!!}</label>
                                            @endif

                                		</div>
                            		</div> -->
                                    @if( (Auth::user()->id) != $adminData->id)

                                     <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Status</label>
                                        <div class="col-lg-6">
                                            @if($adminData->status == 'active')  
                                              {!! Form::radio('status', 'active',true) !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('status', 'inactive') !!}&nbsp;Inactive
                                            @else
                                              {!! Form::radio('status', 'active') !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('status', 'inactive', true) !!}&nbsp;Inactive
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-success" type="submit">Save</button>
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