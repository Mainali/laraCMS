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
                            <a class="current" href="javascript:void(0)">API Type</a>
                        </li>
                        </ul>
                        <div class="col-lg-6" style="float:right;">
                            <div class="form-group">
                                {!!Form::open(['files'=>true,'method'=>'GET','url'=>PREFIX.'/api/pages/types/index'])!!}
                                <div class="col-lg-12">
                                    <div class="col-lg-7"></div>
                                    <div class="col-lg-5">
                                        {!! Form::select('filterCat',$apiCategories,$filterCat,['class'=>'form-control','onChange' => 'this.form.submit()']) !!}
                                    </div>
                                    
                                
                                    <noscript><input type="submit" value="Submit"></noscript>
                                </div>
                                {!!Form::close() !!}
                            </div>
                        </div>

                        
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
    <th>#</th>
   <th>Api Name</th>
    <th>Api Id</th>
    <th>Api Method</th>
    <th>Api Url</th>
    <th>Api Version</th>
    <th>Category</th>
    <th>Total Calls</th>
    <th>Status</th>
    <th> Action</th>
</tr>
</thead>
<tbody>
<?php $i=1; ?>
@foreach($apiTypeData as $data)
<tr>
<td>{{$i++}}</td>
<td>{{ $data->api_name }}</td>
<td>{{ $data->api_id }}</td>
<td>{{ $data->api_method }}</td>
<td>{{ $data->api_url }}</td>
<td>{{ $data->version }}</td>
<td>{{ $data->api_category['title']}}</td>
<td>{{ $data->total_calls }}</td>
<td class="numeric"><span id="status_txt{{$data->id}}" class="status_{{$data->status}}">@if($data->status=="inactive")<button id="status_btn{{$data->id}}" title="Change Status" onClick="javascript:toggleStatus('{{$toggleUrl}}',{{$data->id}})" class="btn btn-danger btn-xs">@else<button id="status_btn{{$data->id}}" title="Change Status" onClick="javascript:toggleStatus('{{$toggleUrl}}',{{$data->id}})" class="btn btn-primary btn-xs">@endif<i class="fa fa-refresh"></i>&nbsp;{{ ucfirst($data->status) }}</button></span></td>

<td><button  title="Edit" onClick="javascript:loadEdit('{{$editUrl}}',{{$data->id}})" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</button>
<a href="#" data-href="{{ $deleteUrl}}?id=<?= $data->id;?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete </a>
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
            @include('cms.modules.api.api-type-edit')
        @elseif(isset($showAdd))
            @include('cms.modules.api.api-type-add')
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


@if(isset($showEdit) || isset($showAdd))
    $('#editModal').modal('show');
@endif

</script>
<!-- page end-->

@stop


