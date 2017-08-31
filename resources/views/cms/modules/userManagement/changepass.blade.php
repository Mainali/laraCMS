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
                               
                            	{!! Form::open(array('url' => PREFIX.'/userManagement/updatePass', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm', 'files'=>true)) !!}
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
                                    
                                        
                                            <div class="form-group ">
                                                                                   
                                    
                                    
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">New Password*</label>
                                        <div class="col-lg-6">
                                            {!! Form::password('new_password','',['class'=>'form-control']) !!}
                                            
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Confirm Password*</label>
                                        <div class="col-lg-6">
                                            {!! Form::password('confirm_password','',['class'=>'form-control']) !!}
                                            
                                        </div>
                                    </div>
                                    
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