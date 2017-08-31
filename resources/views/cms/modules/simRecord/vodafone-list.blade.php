@extends('cms.master')

@section('content')

        <!-- page start-->


<div class="row">

    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <button data-toggle="modal" data-target="#uploadmodal" class="btn btn-primary btn-sm" style="float:right; margin-top:5px;"> + Upload Excel </button>

                <ul class="breadcrumbs-alt">
                    <li>
                        <a href="javascript:void(0)">Sim Record</a>
                    </li>
                    <li>
                        <a class="current" href="javascript:void(0)">{{$thisPageId}}</a>
                    </li>
                </ul>

            </header>



            <div class="panel-body">
                @if(Session::has('success'))
                    <div class="alert alert-success fade in">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                        {{Session::get('success')}}
                    </div>
                @endif

                @if(Session::has('success'))
                        <div class="alert alert-success fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            {{Session::get('success')}}
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
                            <th >Vd Id</th>
                            <th >Transaction Type</th>
                            <th >Vodafone Number</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @foreach($vodafoneSimDatas as $data)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$data->vd_id}}</td>
                                <td>{{$data->transaction_type}}</td>
                                <td>{{$data->vf_number}}</td>

                                <td><button  title="Check" onClick="javascript:loadCheck('{{$checkUrl.'?id='.$data->id}}')" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Check</button>
                                    <button onClick="javascript:loadDetails('{{$detailsUrl.'?id='.$data->id}}')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Details </button>
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



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="uploadmodal" class="modal fade" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Upload Excel</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-sm-12">
                            {!! Form::open(array('url' => PREFIX.'/simRecord/pages/vodafoneSim/postData','method'=>'POST', 'name'=>'myForm','files'=>true,'class'=>'cmxform form-horizontal')) !!}
                            <div class="col-lg-12">

                                <label class="control-label col-lg-9" >The excel file must be according to the sample</label>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <a class="btn-success" href="{{url(PREFIX.'/simRecord/pages/vodafoneSim/downloadSample')}}">Download sample</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="control-label col-lg-4" >Choose xcel file</label>

                                <div class="col-lg-8">
                                    <div class="form-group">

                                        <input type="file" class="form-control" name="highland_xcel">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8"><button type="submit" class="btn btn-primary">Submit</button></div>
                            </div>
                            {!! Form::close()!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="infoModal" class="modal fade" data-backdrop="static">

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

<script>
    function loadDetails(detailsurl)
    {
        $.ajax({
            url: detailsurl,
            type: 'get',
            success: function(result)
            {

                $('#infoModal').html(result);
                $('#infoModal').modal('show');

            },
            error: function()
            {
                $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2>Could not complete the request.</h2></div></div>');
                $('#modalinfo').modal('show');
            }
        })


    }

    function loadCheck(checkurl)
    {
        $.ajax({
            url: checkurl,
            type: 'get',
            success: function(result)
            {

                $('#infoModal').html(result);
                $('#infoModal').modal('show');

            },
            error: function()
            {
                $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2>Could not complete the request.</h2></div></div>');
                $('#modalinfo').modal('show');
            }
        })

    }

</script>
@stop


