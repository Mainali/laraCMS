@extends('cms.master')

@section('content')

<!-- page start-->
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <a href="{{URL::to(PREFIX.'/multicms/pages/gallery/multiUpload')}}?gallery_id={{$id}}" class="btn btn-primary btn-sm" style="float:right; margin-top:5px;"> + Multi Upload Photos </a>
                        <a href="{{URL::to(PREFIX.'/multicms/pages/gallery/photoCreate')}}?gallery_id={{$id}}" class="btn btn-primary btn-sm" style="float:right; margin:5px 5px 0px 0px;"> + Add New Photos </a>
                        <ul class="breadcrumbs-alt">
                            <li>
                            <a href="{{URL::to(PREFIX.'/multicms/pages/gallery')}}">Photo Galleries</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">{{$gallery->title}}</a>
                        </li>
                        </ul>
                          
                    </header>
                    <div class="row">
                    <div class="col-lg-12">
                        
                        
                         <style type="text/css">
                            .ul-manage{
                                float: left;
                                margin: 5px 0 20px 20px;
                                padding: 0;
                            }
                            .ul-manage li {
                                list-style: none;
                                margin-bottom: 5px;
                            }
                         </style>
                        <ul class="ul-manage">
                            <li style=" font-size:22px;">Gallery Name : {{$gallery->title}}</li>
                            <li>Slug : {{$gallery->slug}}</li>
                            <li>Updated date : {{$gallery->updated_at}}</li>
                            @if($gallery->status == "inactive")<li style="color:red;">@else<li>@endif Status : {{$gallery->status}}</li>
                        </ul>

                        

                    </div>
                </div>
                    <div class="panel-body">
                        <section id="unseen">
                            @if($errors->first('msg'))
                            <div class="alert alert-success fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                You successfully added new page. 
                            </div>
                            @endif
                            @if($errors->first('edit'))
                            <div class="alert alert-success fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                You successfully edited admin. 
                            </div>
                            @endif
                            @if($errors->first('delmsg'))
                            <div class="alert alert-block alert-danger fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                You successfully deleted admin. 
                            </div>
                            @endif
                            @if($errors->first('errEdit'))
                            <div class="alert alert-danger fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                You successfully edited admin. 
                            </div>
                            @endif
                            @if($errors->first('errDelete'))
                            <div class="alert alert-danger fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                You successfully edited admin. 
                            </div>
                            @endif
                            @if($errors->first('errAdd'))
                            <div class="alert alert-danger fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                You successfully edited admin. 
                            </div>
                            @endif
                       
                        <div class="adv-table">
                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                <tr>
                                    <th style="width:5%">S.N</th>
                                    <th style="width:40%" class="numeric">Photos</th>
                                    <th style="width:45%" class="numeric">captions</th>
                                    <th style="width:10%" class="numeric">Actions</th>
                                </tr>
                                </thead>
                                <tbody>






                            {{--*/$a=0;/*--}}
                            @foreach($photos as $data)
                                {{--*/$a++;/*--}}

                                <tr>
                                    <td>{{$a}}</td>
                                    
                                   
                                    <td>
                                        <img src="{{asset('/uploads')}}/gallery/pictures/{{$data->picture}}" height="150" >
                                    </td>
                                        
                                    
                                   

                                    
                                    <td class="numeric">
                                        <?php $i=0;foreach($data->picturesLg as $lgdata):$i++;?>
                                        @if($lgdata->caption !== "")
                                        <img src="{{asset('/uploads')}}/flags/{{$lgdata->languages->flag}}" height="20" width="20" >
                                         {{ ucfirst($lgdata->caption) }}
                                        @else
                                        <img src="{{asset('/uploads')}}/flags/{{$lgdata->languages->flag}}" height="20" width="20" >
                                        N/A
                                        <br/><hr>
                                        @endif
                                        <?php endforeach;?>
                                    </td>
                                    <td class="numeric"><a href="{{ URL::to(PREFIX.'/multicms/pages/gallery/photoManage')}}?picture_id=<?= $data->id;?>" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i> Update</a> 
                                    <a href="#" data-href="{{ URL::to(PREFIX.'/multicms/pages/gallery/photoDestroy')}}?id=<?= $data->id;?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete </a>
                                    </td>
                                        
                                    
                                    
                                </tr>
                                @endforeach

                                
                                </tbody>
                            </table>
                        </div>
                        </section>
                       
                    </div>
                </section>
            </div>
        </div>
    


    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
            
                <div class="modal-body">
                    <p>You are about to delete the picture.</p>
                    <p>Do you want to proceed?</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>    
<!-- page end-->
{!! Html::script('public/cms/sm-function/jsFunction.js')!!}

@stop