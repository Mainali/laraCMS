@extends('cms.master')



@section('content')

@include('errors/errors')


<!-- page start-->
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                <header class="panel-heading">
                	<ul class="breadcrumbs-alt">
                        <li>
                            <a href="javascript:void(0)">Admin Config</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">General Settings</a>
                        </li>
                    </ul>
                </header>
                        <div class="panel-body">
                            <section id="unseen">
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

                          </section>  
                            <div>
                                {!!Form::open(['files'=>true,'method'=>'POST','url'=>PREFIX.'/adminConfig/pages/settings/update'])!!}
                              <!-- Nav tabs -->
                              <div class="form-group pull-right" style="margin-top:0px; margin-bottom:0;">
                          
                              {!!Form::submit('Save',['class'=>'btn btn-primary','style'=>'float:right; width:125px; margin-bottom:4px;']) !!}
                          
                         </div>

                              <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#website" aria-controls="website" role="tab" data-toggle="tab">Website</a></li>
                                <li role="presentation"><a href="#opengraph" aria-controls="opengraph" role="tab" data-toggle="tab">Opengraph</a></li>
                                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
                                <li role="presentation"><a href="#social" aria-controls="social" role="tab" data-toggle="tab">Social Media</a></li>
                                <li role="presentation"><a href="#popups" aria-controls="popups" role="tab" data-toggle="tab">Popups</a></li>
                              </ul>

                              <!-- Tab panes -->
                              <div class="tab-content" style="border:solid 1px #dddddd; border-top:none; padding-top:20px;">
                                
                                
                                <div role="tabpanel" class="tab-pane active" id="website">
                                    <div class=" form">
                                        @include('cms.modules.adminConfig.CmsGeneralSettings.websiteform',['submitText'=>'Update language'])
                                    </div>
                                </div>
                                

                                
                                <div role="tabpanel" class="tab-pane " id="opengraph">
                                    <div class=" form">
                                        @include('cms.modules.adminConfig.CmsGeneralSettings.opengraphform',['submitText'=>'Update language'])
                                    </div>
                                </div>
                                

                                
                                <div role="tabpanel" class="tab-pane " id="settings">
                                    <div class=" form">
                                        @include('cms.modules.adminConfig.CmsGeneralSettings.settingsform',['submitText'=>'Update language'])
                                    </div>
                                </div>
                                

                                
                                <div role="tabpanel" class="tab-pane " id="social">
                                    <div class=" form">
                                        @include('cms.modules.adminConfig.CmsGeneralSettings.socialform',['submitText'=>'Update language'])
                                    </div>
                                </div>
                                

                                
                                <div role="tabpanel" class="tab-pane " id="popups">
                                    <div class=" form">
                                        @include('cms.modules.adminConfig.CmsGeneralSettings.popupform',['submitText'=>'Update language'])
                                    </div>
                                </div>
                                
                              <div class="clearfix"></div> </div>
                                {!!Form::close() !!}
                            
                            </div>
                            
                  </section>
            </div>
</div>       
<!-- page end-->



															@stop