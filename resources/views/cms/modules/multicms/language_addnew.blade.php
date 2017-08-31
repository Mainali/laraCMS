@extends('cms.master')



@section('content')


@include('errors/errors')


<!-- page start-->
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                <header class="panel-heading">
                	<ul class="breadcrumbs-alt">
                        <li>
                            <a href="{{URL::to(PREFIX.'/multicms/pages/languages')}}">Languages</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">Add New language</a>
                        </li>
                    </ul>
                </header>
                        <div class="panel-body">
                            <div class="form">

								{!!Form::open(['files'=>true,'method'=>'POST','url'=>PREFIX.'/multicms/pages/languages/store','file'=>'true','class'=>'form-horizontal'])!!}

								<!--start language form-->
                                    
                                            <div class="form-group">
                                              {!! Form::label('multilang_id','Language *:',['class'=>'control-label col-lg-3']) !!}
                                              <div class="col-lg-3">
                                                 {!! Form::select('multilang_id', $multilangData,null,['class'=>'form-control']) !!}
                                              </div>
                                            </div>

                                            <div class="form-group">
                                              {!! Form::label('flag','Flag Image *:',['class'=>'control-label col-lg-3']) !!}
                                              <div class="col-lg-6">
                                                    {!! Form::file('flag','',array('class'=>'btn btn-success form-control') )!!}
                                              </div>
                                            </div>

                                            <div class="form-group">
                                               {!! Form::label('status','Status:',['class'=>'control-label col-lg-3']) !!}
                                               <div class="col-lg-2">
                                                    {!! Form::select('status',['active'=>'Active','inactive'=>'Inactive'],null,['class'=>'form-control','id'=>'field']) !!}
                                                </div>
                                            </div>


                                            <div class="form-group">
                                              {!! Form::label('default_lang','Set Default:',['class'=>'control-label col-lg-3']) !!}
                                              <div class="col-lg-6">
                                                <div class="checkbox">
                                                <label>
                                                  {!! Form::checkbox('default_lang', '1'); !!}&nbsp;Set as Default Language
                                                </label>
                                                </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-lg-6">
                                                    
                                                    {!!Form::submit('Save',['class'=>'btn btn-primary']) !!}
                                                    
                                                </div>
                                            </div>

                                            



                                <!--close language form-->

								{!!Form::close() !!}
							</div>

                        </div>
                  </section>
            </div>
</div>       
<!-- page end-->



															@stop