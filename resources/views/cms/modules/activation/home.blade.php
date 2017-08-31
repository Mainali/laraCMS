@extends('cms.master')

@section('content')

<!-- page start-->
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                      <a href="{{$excelgenerateUrl}}" class="btn btn-primary btn-sm" style="float:right; margin-top:5px;">Export to excel</a>
                        <ul class="breadcrumbs-alt">
                        <li>
                            <a class="current" href="javascript:void(0)">Sim Users</a>
                        </li>
                        </ul>
                        <div class="col-lg-6" style="float:right;">
                            <div class="form-group">
                                {!!Form::open(['files'=>true,'method'=>'GET','url'=>PREFIX.'/activation/index'])!!}
                                <div class="col-lg-12">
                                    <div class="col-lg-7"></div>
                                    <div class="col-lg-5">
                                        {!! Form::select('filterCat',['live'=>'Live', 'all'=>'All','trashed'=>'Trashed ','Activated'=>'Activated','Cancelled'=>'Cancelled','Pending'=>'Pending'],$filterCat,['class'=>'form-control','onChange' => 'this.form.submit()']) !!}
                                    </div>
                                    
                                
                                    <noscript><input type="submit" value="Submit"></noscript>
                                </div>
                                {!!Form::close() !!}
                            </div>
                        </div>
                    </header>

                    <div class="panel-body">
                       {!! Form::open(array('url' => PREFIX.'/activation/filtered', 'method'=>'GET', 'name'=>'myFilterForm', 'class'=>'cmxform form-horizontal', 'id'=>'1commentForm','files'=>true)) !!}
                        <?php if(isset($keyword)) $keyword =$keyword; else $keyword=''; if(isset($datefilter)) $datefilter=$datefilter; else $datefilter=''; ?>
                        <div class="row">
                                 <div class="col-lg-6 pull-right">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4">
                                              <input type="hidden" name="filterCat" value="{{$filterCat}}">
                                              <input type="text" placeholder="enter keyword"  name="keyword" value="{{$keyword}}" class="form-control ">
                                            </div>
                                             <div class="col-lg-4">
                                              <input type="text" placeholder="select Date"  name="date" value="{{$datefilter}}" class="form-control datepicker">
                                            </div>
                                             <div class="col-lg-2">
                                              <button type="submit" class="btn btn-primary btn-sm ">filter</button>
                                            </div>
                                            </div>
                                             {!! Form::close()!!}  
                                      @if($filterCat !=="trashed")
                                       {!!Form::open(['files'=>true,'method'=>'POST','url'=>PREFIX.'/activation/multitrash'])!!}
                                       <div class="col-lg-6">
                                       {!!Form::submit('Move to Trash',['class'=>'btn btn-primary','style'=>'float:left; width:125px; margin-top:5px;','onClick'=>'Javascript: return confirm("Are you sure you want to Move multiple items to Trash?")']) !!}
                                     </div>
                                         @endif     

                                  </div>
                       
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
                        <section id="unseen">
                          
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th style="width:15px;">S.N @if($filterCat !=="trashed")<p><input type="checkbox" id="checkAll"/></p>@endif</th>
                                    <th>Full Name</th>
                                     <th class="numeric">Passport Number</th>
                                      <th class="numeric">Citizenship Number</th>
                                       <th class="numeric">Country</th>
                                    <th class="numeric">Status</th>
                                    <th><i title="Image sync Status" style="font-size:20px; color:blue" class="fa fa-cloud-upload"></i></th>
                                    <th class="numeric">Action</th>
                                    <th class="numeric">Details</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(Input::has('page'))
                                    <?php $start=Input::get('page')*10-9;?>
                                @else
                                    <?php $start=1;?>    
                                @endif

                                <?php $a=$start;foreach($adminData as $data):;
                                ?>
                                <?php endforeach;?>
                    @foreach($activationDatas as $activationData)

                                <tr>
                                    <td><?php echo $a++;?> @if($filterCat !=="trashed")<p><input type='checkbox' name='multi-select[]' value="{{$activationData->id}}"></p>@endif</td>
                                    <td>@if(!empty($activationData->fullname)){{ $activationData->fullname }}@else N/A @endif</td>
                                    @if(empty($activationData->passport_num))
                                    <td class="numeric">N/A</td>
                                    @else
                                    <td class="numeric">{{$activationData->passport_num}}</td>
                                    @endif
                                    @if(empty($activationData->citizenship_num))
                                    <td class="numeric">N/A</td>
                                    @else
                                    <td class="numeric">{{$activationData->citizenship_num}}</td>
                                     @endif
                                      @if(empty($activationData->country))
                                      <td class="numeric">N/A</td>
                                      @else
                                    <td class="numeric">{{$activationData->country}}</td>
                                    @endif
                                    <td class="numeric"><span id="status_txt{{$activationData->id}}" class="status_{{$activationData->status}}">@if($activationData->status=="Pending" || $activationData->status=="")<button type="button" id="status_btn{{$activationData->id}}" title="Change Status" onClick="javascript:toggleSimStat('{{$toggleUrl}}',{{$activationData->id}})" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i>@elseif($activationData->status == 'Cancelled')<button type="button" id="status_btn{{$activationData->id}}" title="Cancelled"  class="btn btn-danger btn-xs"> @else<button type="button" id="status_btn{{$activationData->id}}" title="Change Status" onClick="javascript:toggleSimStat('{{$toggleUrl}}',{{$activationData->id}})" class="btn btn-primary btn-xs"><i class="fa fa-refresh"></i>@endif&nbsp;@if(!empty($activationData->status)){{ $activationData->status }}@elseif($activationData->status=="") Pending @endif </button></span></td>
  
                                   <td> @if($activationData->image_synced == 1)<i style="font-size:18px; color:green" title="images synced" class="fa fa-check-circle"></i>@else<i style="font-size:18px; color:red" title="images not synced" class="fa fa-exclamation-circle"></i>@endif</td>
                                    <td class="numeric">
                                      @if($filterCat !=="trashed")
                                      <a href="{{ URL::to(PREFIX.'/activation/trash')}}?id=<?= $activationData->id?>" onClick="Javascript: return confirm('Are you sure you want to Move this data to Trash?')" title="Move To Trash" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Trash</a>
                                      @endif
                                      <button type="button"  title="Edit" onClick="javascript:loadEdit('{{$editUrl}}',{{$activationData->id}})" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</button>
                                    </td>
                                <td><a href="{{ URL::to(PREFIX.'/activation/view')}}?id=<?= $activationData->id?>&&status=Viewed" class="btn btn-info btn-xs" >Edit photo</a>
                                   
                                </td>
                                </tr>

                                
                                @endforeach
                  
                                

                                
                                </tbody>
                            </table>
                           
                        </section>
                         <!-- Modal -->
  
                        <ul class="pagination">
                          @if(!empty($keyword) || !empty($datefilter))
                          {!! str_replace('/?', '?', $activationDatas->appends(['filterCat'=>$filterCat,'date'=>$datefilter,'keyword'=>$keyword])->render()) !!}
                          @else
                            {!! str_replace('/?', '?', $activationDatas->appends(['filterCat'=>$filterCat])->render()) !!}
                          @endif
                        </ul>
                         @if($filterCat !=="trashed")
                            {!!Form::close() !!}
                            @endif
                    </div>
                </section>
            </div>
        </div>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editModal" class="modal fade" data-backdrop="static">
        @if(isset($showEdit))
          dsfsdgag
            @include('cms.modules.activation.sim-users-edit')

        @endif
        </div>

        
<!-- page end-->
<script type="text/javascript">
@if(isset($showEdit) || isset($showAdd))
    $('#editModal').modal('show');
@endif


$("#checkAll").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });



  function generateExcel(url)
{
    $.ajax({
         url: url,
            type: 'get',
            success: function(result)
            {
                
                $('#editModal').html(result);
                $('#editModal').modal('show');
             
            },
            error: function()
            {
               $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2>Could not complete the request.</h2></div></div>');
                $('#modalinfo').modal('show'); 
            }
    })
}


 
function toggleSimStat(togurl,id)
      { 
        
        $.ajax
            ({ 
                url: togurl+"?id="+id,
                type: 'get',
                success: function(result)
                {
                    
                    if (result == 'Activated') {
                        $('#status_btn'+id).removeClass('btn btn-warning btn-xs').addClass('btn btn-primary btn-xs');
                        $('#status_btn'+id).html('<i class="fa fa-refresh"></i>&nbsp;'+result);
                    }else{
                        $('#status_btn'+id).removeClass('btn btn-primary btn-xs').addClass('btn btn-warning btn-xs');
                        $('#status_btn'+id).html('<i class="fa fa-refresh"></i>&nbsp;'+result);
                    };
                    //$('#status_txt'+id).attr('class', 'status_'+result);
                 
                },
                error: function()
                {
                   $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2>Could not complete the request.</h2></div></div>');
                    $('#modalinfo').modal('show'); 
                }
            });
      }

</script>

{!! Html::script('public/cms/sm-function/jsFunction.js')!!}

@stop
