@extends('cms.master')

@section('content')

<!-- page start-->
<div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <header class="panel-heading">
                        
                        <ul class="breadcrumbs-alt">
                            <li>
                            <a href="{{URL::to(PREFIX.'/multicms/pages/gallery')}}">Photo Galleries</a>

                        </li>
                        <li>
                            <a href="{{URL::to(PREFIX.'/multicms/pages/gallery/lists')}}?gallery_id={{$gallery->id}}">{{$gallery->title}}</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">Multi Add New Photos to: {{$gallery->title }}</a>
                        </li>
                        </ul>
                          
                    </header>
                    <div class="panel-body">
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
                        <h2 class="lead">Basic Plus UI version</h2>
                        <!-- The file upload form used as target for the file upload widget -->
                        {!!Form::open(['files'=>true,'method'=>'POST','url'=>PREFIX.'/multicms/pages/gallery/multiUploadHandler','class'=>'form-horizontal','id'=>'multiUpForm'])!!}
                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                            <!-- <noscript>
                                <input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/">
                            </noscript> -->
                            <input type="hidden" name="gallery_id" value="{{$gallery->id}}">
                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                               <div class="row fileupload-buttonbar">
                                    <div class="col-lg-7">
                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                        
                                             <span class="btn btn-success fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Add files...</span>
                                                {!! Form::file('files[]', array('multiple'=>true,'class'=>'btn btn-success','id'=>'multiUp')) !!}

                                            </span>


                                            
                                        <p id="multiUpCounter"></p>
                                        <button type="submit" class="btn btn-primary start">
                                            <i class="glyphicon glyphicon-upload"></i>
                                            <span>Start upload</span>
                                        </button>
                                    </div>
                                </div>
                                        
                            {!!Form::close() !!}
                            <br>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Demo Notes</h3>
                                </div>
                                <div class="panel-body">
                                    <ul>
                                        <li>The maximum file size for uploads in this demo is <strong>999 KB</strong> (default file size is unlimited).</li>
                                        <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo (by default there is no file type restriction).</li>
                                        <li>Uploaded files will be deleted automatically after <strong>5 minutes or less</strong> (demo files are stored in memory).</li>
                                        <li>You can <strong>drag &amp; drop</strong> files from your desktop on this webpage (see <a href="https://github.com/blueimp/jQuery-File-Upload/wiki/Browser-support">Browser support</a>).</li>
                                        <li>Please refer to the <a href="https://github.com/blueimp/jQuery-File-Upload">project website</a> and <a href="https://github.com/blueimp/jQuery-File-Upload/wiki">documentation</a> for more information.</li>
                                        <li>Built with the <a href="http://getbootstrap.com/">Bootstrap</a> CSS framework and Icons from <a href="http://glyphicons.com/">Glyphicons</a>.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
<!-- page end-->
{!! Html::script('public/cms/sm-function/jsFunction.js')!!}

@stop