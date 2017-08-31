@extends('cms.master')

@section('content')

<!-- page start-->
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">

                    <a href="{{URL::to(PREFIX.'/multicms/pages/news/create')}}" class="btn btn-primary btn-sm" style="float:right; margin-top:5px;"> + Add New </a>
                    <a href="{{URL::to(PREFIX.'/multicms/pages/news/categoryIndex')}}" class="btn btn-primary btn-sm" style="float:right; margin:5px 5px 0px 0px;"> Category </a>
                        <ul class="breadcrumbs-alt">
                        <li>
                            <a class="current" href="javascript:void(0)">News</a>
                        </li>
                        </ul>


                        <div class="col-lg-6" style="float:right;">

                            <div class="form-group">
                                {!!Form::open(['files'=>true,'method'=>'GET','url'=>PREFIX.'/multicms/pages/news/index'])!!}
                                <div class="col-lg-12">
                                    <div class="col-lg-6">  
                                        {!! Form::select('filter',$pinnedList,$filterPinned,['class'=>'form-control','onChange' => 'this.form.submit()']) !!}
                                    </div>
                                    <div class="col-lg-6">
                                        {!! Form::select('filterDept',$newsCategoryList,$filterDept,['class'=>'form-control','onChange' => 'this.form.submit()']) !!}
                                    </div>
                                
                                    <noscript><input type="submit" value="Submit"></noscript>
                                </div>
                                {!!Form::close() !!}


                            </div>
                        </div>
                        
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

                        <div class="adv-table">
                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                <tr>
                                    <th style="width:5%">S.N</th>
                                    <th style="width:5%" class="numeric">Title</th>
                                    <th style="width:20%" class="numeric">Slug</th>
                                    <th style="width:35%" class="numeric">News Categories</th>
                                    <th style="width:5%" class="numeric">Position</th>
                                    <th style="width:5%" class="numeric">Pinned</th>
                                    <th style="width:10%" class="numeric">Status</th>
                                    <th style="width:15%" class="numeric">Actions</th>
                                </tr>
                                </thead>
                                <tbody>






                                
                                {{--*/$a=0;/*--}}
                                @foreach($pageData as $data)
                                {{--*/$forLangContents=$data->newsLg;/*--}}
                                    {{--*/$a++;/*--}}
                                    
                                    <tr>
                                        

                                        <td>{{$a}}</td>

                                       
                                        <td>
                                            @if(!$forLangContents->isEmpty())
                                            {{$forLangContents[0]->title}}
                                            
                                        @else
                                            <p>N/A</p>
                                        @endif
                                        </td>

                                        <td>
                                            {{$data->slug}}
                                        </td>

                                        <td>
                                            {{$data->category_id}}
                                        </td>
                                        
                                        <td>
                                            {{$data->pinned_position}}
                                        </td>
                                        
                                       <td class="numeric"><span id="pinned_txt{{$data->id}}" >@if($data->pinned=="no")<button id="pinned_btn{{$data->id}}" title="Change Pinned" onClick="javascript:togglePinned({{$data->id}})" class="btn btn-danger btn-xs">@else<button id="pinned_btn{{$data->id}}" title="Change Pinned" onClick="javascript:togglePinned({{$data->id}})" class="btn btn-primary btn-xs">@endif<i class="fa fa-refresh"></i>&nbsp;{{ ucfirst($data->pinned) }}</button></span></td>

                                        
                                        <td class="numeric"><span id="status_txt{{$data->id}}" class="status_{{$data->status}}">@if($data->status=="inactive")<button id="status_btn{{$data->id}}" title="Change Status" onClick="javascript:toggleStatus('{{$toggleUrl}}',{{$data->id}})" class="btn btn-danger btn-xs">@else<button id="status_btn{{$data->id}}" title="Change Status" onClick="javascript:toggleStatus('{{$toggleUrl}}',{{$data->id}})" class="btn btn-primary btn-xs">@endif<i class="fa fa-refresh"></i>&nbsp;{{ ucfirst($data->status) }}</button></span></td>
                                        <td class="numeric">
                                        <a href="{{ URL::to(PREFIX.'/multicms/pages/news/manageNews')}}?id=<?= $data->id;?>" class="btn btn-primary btn-xs">Manage News</a> 
                                        
                                        <a href="#" data-href="{{ URL::to(PREFIX.'/multicms/pages/news/destroy')}}?id=<?php echo $data->id;?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete </a>
                                        </td>
                                            
                                        
                                        
                                    </tr>
                                    
                                @endforeach

                                
                                </tbody>
                            </table>
                        </div>
                        </section>
                        <!-- <ul class="pagination">
                            
                        </ul> -->
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
                    <p>You are about to delete this page.</p>
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

    <script type="text/javascript">
 

      // function toggleStatus(id)
      // { 
      //   $.ajax
      //       ({ 
      //           url: "{{ URL::to(PREFIX.'/multicms/pages/news/toggleStatus')}}?id="+id,
      //           type: 'get',
      //           success: function(result)
      //           {
                    
      //               if (result == 'Active') {
      //                   $('#status_btn'+id).removeClass('btn btn-danger btn-xs').addClass('btn btn-primary btn-xs');
      //                   $('#status_btn'+id).html('<i class="fa fa-refresh"></i>&nbsp;'+result);
      //               }else{
      //                   $('#status_btn'+id).removeClass('btn btn-primary btn-xs').addClass('btn btn-danger btn-xs');
      //                   $('#status_btn'+id).html('<i class="fa fa-refresh"></i>&nbsp;'+result);
      //               };
      //               //$('#status_txt'+id).attr('class', 'status_'+result);
                 
      //           },
      //           error: function()
      //           {
      //              $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2>Could not complete the request.</h2></div></div>');
      //               $('#modalinfo').modal('show'); 
      //           }
      //       });
      // }

      function togglePinned(id)
      {
        $.ajax
            ({ 
                url: "{{ URL::to(PREFIX.'/multicms/pages/news/togglePinned')}}?id="+id,
                type: 'get',
                success: function(result)
                {
                    
                    if (result == 'Yes') {
                        $('#pinned_btn'+id).removeClass('btn btn-danger btn-xs').addClass('btn btn-primary btn-xs');
                        $('#pinned_btn'+id).html('<i class="fa fa-refresh"></i>&nbsp;'+result);
                    }else{
                        $('#pinned_btn'+id).removeClass('btn btn-primary btn-xs').addClass('btn btn-danger btn-xs');
                        $('#pinned_btn'+id).html('<i class="fa fa-refresh"></i>&nbsp;'+result);
                    };
                    //$('#pinned_txt'+id).attr('class', 'pinned_'+result);
                 
                },
                error: function()
                {
                   $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2>Could not complete the request.</h2></div></div>');
                    $('#modalinfo').modal('show'); 
                }
            });
      }
        

    </script>


<!-- page end-->

@stop