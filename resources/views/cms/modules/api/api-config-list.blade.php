@extends('cms.master')

@section('content')

<!-- page start-->


<div class="row">

<div class="col-sm-12">
<section class="panel">
    <header class="panel-heading">
                    <button onClick="javascript:loadAddNew('{{$addUrl}}')" class="btn btn-primary btn-sm" style="float:right; margin-top:5px;"> + Add New </button>

                        <ul class="breadcrumbs-alt">
                        <li>
                        <a href="javascript:void(0)">API</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">API Config</a>
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
<div class="adv-table">
<table  class="display table table-bordered table-striped" id="dynamic-table">
<thead>
<tr>
    <th >#</th>
    <th >Api Key</th>
    <th >Title</th>
    <th >Date Started</th>
    <th >Hits</th>
    <th>Status</th>
    <th >Action</th>

</tr>
</thead>
<tbody>
<?php $i=1; ?>
@foreach($apiConfigData as $api)
<tr>
<td>{{$i++}}</td>
<td> <button title="Copy API Key" class="btn btn-sm clip_{{$api->id}}" aria-label="Key copied !!" onclick="javascript:clipCopy({{$api->id}})" data-clipboard-target="#key_{{$api->id}}"><i class="fa fa-clipboard"></i></button><span id='key_{{$api->id}}'>{{$api->api_keys}}</span></td>
<td>{{$api->title}}</td>
<td>{{$api->date_started}}</td>
<td>{{$api->hits}}</td>
<td class="numeric"><span id="status_txt{{$api->id}}" class="status_{{$api->status}}">@if($api->status=="inactive")<button id="status_btn{{$api->id}}" title="Change Status" onClick="javascript:toggleStatus('{{$toggleUrl}}',{{$api->id}})" class="btn btn-danger btn-xs">@else<button id="status_btn{{$api->id}}" title="Change Status" onClick="javascript:toggleStatus('{{$toggleUrl}}',{{$api->id}})" class="btn btn-primary btn-xs">@endif<i class="fa fa-refresh"></i>&nbsp;{{ ucfirst($api->status) }}</button></span></td>
                                         
<td><button  title="Edit" onClick="javascript:loadEdit('{{$editUrl}}',{{$api->id}})" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</button>
<a href="#" data-href="{{ $deleteUrl}}?id=<?= $api->id;?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete </a>
</td>
</tr>
@endforeach
</tbody>

</table>
</div>
</div>
    
                

    
    </section>

</div>

</div>
    
    

            

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editModal" class="modal fade" data-backdrop="static">
        @if(isset($showEdit))
            @include('cms.modules.api.api-config-edit')
        @elseif(isset($showAdd))
            @include('cms.modules.api.api-config-add')
        @endif
        </div>

            <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
            
                <div class="modal-body">
                    <p>You are about to delete this.</p>
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


function clipCopy(id)
{
    var clipboard = new Clipboard('.clip_'+id);
   $('.clip_'+id).addClass('tooltipped tooltipped-sm');
    window.setTimeout(function(){
    $('.clip_'+id).removeClass('tooltipped tooltipped-sm');
    },2000);

}

@if(isset($showEdit) || isset($showAdd))
    $('#editModal').modal('show');
@endif
</script>

<script src="{{URL::asset('public/cms/js/clipboard.min.js')}}"></script>       
<!-- page end-->

@stop


