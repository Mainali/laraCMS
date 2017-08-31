@extends('cms.master')

@section('content')

<!-- page start-->
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                    <!--<a href="{{URL::to(PREFIX.'/userManagement/add')}}" class="btn btn-primary btn-sm" style="float:right; margin-top:5px;"> + Add New </a>-->
                    <div class="head-right-block">
                    	<form class="form-inline" role="form">
                            <div class="form-group">
                                <label>Medical Data Term Search</label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label>Search Filter</label>
                                <select class="form-control">
                                	<option>Term Name</option>
                                	<option>Short Term</option>
                                	<option>Long Term</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Search</button>
                            <button type="reset" class="btn btn-success">Clear Search</button>
                        </form>
                    </div>
                        <ul class="breadcrumbs-alt">
                        <li>
                            <a class="current" href="javascript:void(0)">MDA ADD</a>
                        </li>
                        </ul>
                        
                    </header>

                    <div class="panel-body">
                        <section id="unseen">
                            @if($errors->first('msg'))
                            <div class="alert alert-success fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                You successfully added new MDA. 
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
                       		
                       		<div id="searchResult" style="display:none">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th style="width:15px;">S.N</th>
                                    <th>Name</th>
                                    <th class="numeric">Activation Date</th>
                                    <th class="numeric">Expiration Date</th>
                                    <th class="numeric">Term Action Type</th>
                                    <th class="numeric">Term Type</th>
                                    <th class="numeric">Term Language</th>
                                </tr>
                                </thead>
                                <tbody>

                                
                                
                                </tbody>
                            </table>
                            <div class="blank-section clearfix">
                    		
                    		</div>
                    		</div><!-- end of search result -->

                    		<a href="Javascript::void()" onclick="Javascript:toggle_visibility('addMda');" class="btn btn-info">Add MDA</a>
                        </section>

                        <div id="addMda" style="display:none;" class="add-mda"> 
                        {!! Form::open(array('url' => PREFIX.'/config/pages/mda/addMda', 'method'=>'POST', 'class'=>'cmxform form-horizontal')) !!}
                          
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-3">Mda Term Name</label>
                                        <div class="col-lg-4">
                                            <input class=" form-control" name="term_name" type="text" required/>
                                            @if($errors->any())
                                                <label class="error" for="cname">{{$errors->first('username')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-3">Mda Short Term</label>
                                        <div class="col-lg-4">
                                            <input class=" form-control" name="short_term" type="text" required/>
                                            @if($errors->any())
                                            	<label class="error" for="cname">{{$errors->first('password')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Mda Long Term</label>
                                        <div class="col-lg-4">
                                            <input class="form-control" type="text" name="long_term" required/>
                                            @if($errors->any())
                                            	<label class="error" for="cname">{{$errors->first('first_name')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Activation Date</label>
                                        <div class="col-lg-4">
                                            <input class="form-control datepicker" data-date-format="yyyy-mm-dd" type="text" name="activation" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Expiration Date</label>
                                        <div class="col-lg-4">
                                            <input class="form-control datepicker" data-date-format="yyyy-mm-dd" type="text" name="expiration" required/>
                                            @if($errors->any())
                                            	<label class="error" for="cname">{{$errors->first('last_name')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Mde Term Action Type</label>
                                        <div class="col-lg-4">
				                                <select class="form-control" name="mde_action_type">
				                                	<option value="">--Select--</option>
                                                    <?php foreach($actions as $action){?>
				                                	<option value="{{ $action->id }}"><?=$action->title ?></option>
                                                    <?php } ?>
				                                </select>
                                            @if($errors->any())
                                            	<label class="error" for="cname">{{$errors->first('last_name')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                     <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Mde Function Type</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" name="mde_fuction_type">
				                                	<option value="">--Select--</option>
                                                    <?php foreach($functions as $function){?>
				                                	<option value="{{$function->id }}"><?=$function->title ?></option>
                                                    <?php } ?>
				                                </select>
                                            @if($errors->any())
                                            	<label class="error" for="cname">{{$errors->first('last_name')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Mde Term Language</label>
                                        <div class="col-lg-4">
                                             <select class="form-control" name="mde_language">
				                                	<option value="">--Select--</option>
                                                    <?php foreach($languages as $language){?>
				                                	<option value="{{$language->id}}"><?=$language->title ?></option>
                                                    <?php } ?>
				                                </select>
                                            @if($errors->any())
                                            	<label class="error" for="cname">{{$errors->first('last_name')}}</label>
                                            @endif
                                        </div>
                                    </div>
                                     <div class="form-group ">
                                        <label for="curl" class="control-label col-lg-3">Status</label>
                                        <div class="col-lg-4">
                                            <label class="radio-inline">
                                                <input name="status" value="active" checked="" type="radio">Active
                                            </label>
                                            <label class="radio-inline">
                                                <input name="status" value="inactive" checked="" type="radio">Inactive
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            <a href="{{URL::to(PREFIX.'/config/pages/mda')}}" class="btn btn-default">Cancel</a>
                                        </div>
                                    </div>
                                {!! Form::close()!!}
                            </div>

                    </div>
                </section>
            </div>
        </div>
        
<!-- page end-->
{!! Html::script('public/cms/sm-function/jsFunction.js')!!}
@stop
