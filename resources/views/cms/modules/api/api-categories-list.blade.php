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
                            <a class="current" href="javascript:void(0)">API Categories</a>
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
    <th >Title</th>
    <!-- <th >Date Created</th> -->
    <th >Action</th>

</tr>
</thead>
<tbody>
<?php $i=1; ?>
@foreach($apiCatData as $api)
<tr>
<td>{{$i++}}</td>
<td>{{$api->title}}</td>
                                        
<td><button  title="Edit" onClick="javascript:loadEdit('{{$editUrl}}',{{$api->id}})" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</button>
<a href="#" data-href="{{$deleteUrl}}?id=<?= $api->id;?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete </a>
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
            @include('cms.modules.api.api-categories-edit')
        @elseif(isset($showAdd))
            @include('cms.modules.api.api-categories-add')
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
                    <p>You are about to delete this Category.</p>
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

@if(isset($showEdit) || isset($showAdd))
    $('#editModal').modal('show');
@endif
</script>
<script src="{{URL::asset('public/cms/js/clipboard.min.js')}}"></script>       
<!-- page end-->

@stop


