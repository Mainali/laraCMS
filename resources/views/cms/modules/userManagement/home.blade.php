@extends('cms.master')

@section('content')

<!-- page start-->
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                    <a href="{{URL::to(PREFIX.'/userManagement/add')}}" class="btn btn-primary btn-sm" style="float:right; margin-top:5px;"> + Add New </a>
                        <ul class="breadcrumbs-alt">
                        <li>
                            <a class="current" href="javascript:void(0)">Admin Users</a>
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
                            @if($errors->first('msg'))
                            <div class="alert alert-success fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                You successfully added new admin. 
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
                            
                            @if(Auth::user()->type == "superadmin")
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th style="width:15px;">S.N</th>
                                    <th>Super Admin</th>
                                    <th class="numeric">Status</th>
                                    <th class="numeric">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    
                                @if($superAdmin->middle_name!='')
                                    {{--*/$fullname = $superAdmin->first_name." ".$superAdmin->middle_name." ".$superAdmin->last_name;/*--}}
                                @else
                                    {{--*/$fullname = $superAdmin->first_name." ".$superAdmin->last_name;/*--}}
                                @endif

                                <tr>
                                    <td><?php echo '1';?></td>
                                    <td><a href="Javascript: void(0)" onclick="Javascript: toggle_visibility('<?=$superAdmin->id?>')">{{ $fullname }}</a></td>
                                    <td class="numeric">{{ ucfirst($superAdmin->status) }}</td>
                                    <td class="numeric"><a href="{{ URL::to(PREFIX.'/userManagement/edit')}}?id=<?= $superAdmin->id?>" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i> Update</a>
                                    <a href="{{ URL::to(PREFIX.'/userManagement/changePass')}}?id=<?= $superAdmin->id?>" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i> Change Password</a>
                    
                                    
                                    </td>
                                </tr>
                                   
                            </tbody>

                            @endif

                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th style="width:15px;">S.N</th>
                                    <th>Users</th>
                                    <th class="numeric">Status</th>
                                    <th class="numeric">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(Input::has('page'))
                                    <?php $start=Input::get('page')*10-10;?>
                                @else
                                    <?php $start=0;?>    
                                @endif

                                <?php $a=$start;foreach($adminData as $data):$a++;
                                    $allmodules = Config::get('zcmsconfig.zcmsmodules');
                                    $modules = $data->getModulePermissions($data->id);
                                ?>
                                @if($data->middle_name!='')
                                    {{--*/$fullname = $data->first_name." ".$data->middle_name." ".$data->last_name;/*--}}
                                @else
                                    {{--*/$fullname = $data->first_name." ".$data->last_name;/*--}}
                                @endif

                                <tr>
                                    <td><?php echo $a;?></td>
                                    <td><a href="Javascript: void(0)" onclick="Javascript: toggle_visibility('<?=$data->id?>')">{{ $fullname }}</a></td>
                                    <td class="numeric">{{ ucfirst($data->status) }}</td>
                                    <td class="numeric"><a href="{{ URL::to(PREFIX.'/userManagement/edit')}}?id=<?= $data->id?>" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i> Update</a>
                                    <a href="{{ URL::to(PREFIX.'/userManagement/changePass')}}?id=<?= $data->id?>" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i> Change Password</a>
                                     
                                    <a href="{{ URL::to(PREFIX.'/userManagement/delete')}}?id=<?= $data->id;?>" onclick="Javascript: return confirm('Are you sure you want to delete this admin?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete </a>
                                    
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="data-td">
                                    <div style="display:none;" id="<?=$data->id?>" class="data-row">
                                    <table class="table table-bordered nomargin">
                                    <tbody><tr><td width="30%"> Name </td><td>{{ $fullname }}</td></tr>
                                        <tr><td width="30%"> Profile Picture</td><td>
                                        <?php 
                                        if(!empty($data->profile_edit_pic)&&File::exists('userUploads/admin/'.$data->profile_edit_pic)):?>
                                            {!!Html::image('userUploads/admin/'.$data->profile_edit_pic, 'alt', array( 'width' => 200, 'height' => 200 )) !!}
                                        <?php endif;?>
                                        </td></tr>
                                        <tr><td width="30%"> Module Permission </td><td>
                                        <?php
                                        foreach ($allmodules as $k => $v) {
                                            $check = '';
                                            $search_array = $modules;
                                            if (preg_match("/\b$k\b/i", $search_array )) {
                                                echo '<i class="fa fa-long-arrow-right"></i>&nbsp;'.$v.'<br>';
                                            }
                                        }
                                        ?>
                                        </td></tr>
                                        <tr><td width="30%"> Username </td><td>{{ $data->username }} </td></tr>
                                        <tr><td> Email </td><td>{{ $data->email }} </td></tr>
                                        <tr><td> Date create </td><td>{{ $data->date_create }} </td></tr>
                                    </tbody></table>
                                    </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>

                                
                                </tbody>
                            </table>
                        </section>
                        <ul class="pagination">
                            {!! str_replace('/?', '?', $adminData->render()) !!}
                        </ul>
                    </div>
                </section>
            </div>
        </div>
        
<!-- page end-->
{!! Html::script('public/cms/sm-function/jsFunction.js')!!}

@stop