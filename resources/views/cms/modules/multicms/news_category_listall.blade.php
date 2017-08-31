@extends('cms.master')

@section('content')

<!-- page start-->
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                    <a href="{{URL::to(PREFIX.'/multicms/pages/news/categoryCreate')}}" class="btn btn-primary btn-sm" style="float:right; margin-top:5px;"> + Add New </a>

                        <ul class="breadcrumbs-alt">
                        <li>
                            <a href="{{URL::to(PREFIX.'/multicms/pages/news')}}" class="current" > News </a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">News Category</a>
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

                        <div class="adv-table">
                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                <tr>
                                    <th style="width:5%">S.N</th>
                                    
                                    <th style="width:35%" class="numeric">Default Title</th>
                                    <th style="width:35%" class="numeric">Slug</th>
                                    <th style="width:5%" class="numeric">Position</th>
                                    <th style="width:10%" class="numeric">Status</th>
                                    <th style="width:10%" class="numeric">Actions</th>
                                </tr>
                                </thead>
                                <tbody>






                                
                                {{--*/$a=0;/*--}}
                                @foreach($pageData as $data)
                                    {{--*/$a++;/*--}}
                                    
                                    <tr>
                                        

                                        <td>{{$a}}</td>

                                       
                                        <td>
                                            {{$data->default_title}}
                                        </td>

                                        <td>
                                            {{$data->slug}}
                                        </td>

                                        <td>
                                            {{$data->position}}
                                        </td>
                                        
                                        
                                       

                                        
                                        <td class="numeric"><span id="status_txt{{$data->id}}" class="status_{{$data->status}}">@if($data->status=="inactive")<button id="status_btn{{$data->id}}" title="Change Status" onClick="javascript:toggleStatus('{{$toggleUrl}}',{{$data->id}})" class="btn btn-danger btn-xs">@else<button id="status_btn{{$data->id}}" title="Change Status" onClick="javascript:toggleStatus('{{$toggleUrl}}',{{$data->id}})" class="btn btn-primary btn-xs">@endif<i class="fa fa-refresh"></i>&nbsp;{{ ucfirst($data->status) }}</button></span></td>
                                        <td class="numeric">
                                        <a href="{{ URL::to(PREFIX.'/multicms/pages/news/manageNewsCategory')}}?id=<?= $data->id;?>" class="btn btn-primary btn-xs">Manage</a> 
                                        
                                        <a href="#" data-href="{{ URL::to(PREFIX.'/multicms/pages/news/categoryDestroy')}}?id=<?= $data->id;?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete </a>
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
      //           url: "{{ URL::to(PREFIX.'/multicms/pages/news/categoryToggleStatus')}}?id="+id,
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
        

    </script>

<!-- page end-->
{!! Html::script('public/cms/sm-function/jsFunction.js')!!}

@stop