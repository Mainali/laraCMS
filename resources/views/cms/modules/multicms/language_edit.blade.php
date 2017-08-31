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
                            <a href="{{URL::to(PREFIX.'/multicms/pages/languages')}}">Language</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">Edit Language</a>
                        </li>
                    </ul>
                </header>
                        <div class="panel-body">
                            <div class=" form">

								{!!Form::open(['files'=>true,'method'=>'POST','url'=>PREFIX.'/multicms/pages/languages/update','class'=>'form-horizontal'])!!}

								<!--start language update form-->
                                    <input type="hidden" name="id" value="{{$lang->id}}"/>
                                    <input type="hidden" name="slug" value="{{$lang->slug}}"/>


                                    <div class="form-group">
                                      {!! Form::label('slug','Language *:',['class'=>'control-label col-lg-3']) !!}
                                      <div class="col-lg-8">
                                        
                                             {{$lang->title}}
                                          <img src="{{asset('/uploads')}}/flags/{{$lang->flag}}" alt="No image" height="30" width="30">
                                        
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      {!! Form::label('flag','Change Flag image *:',['class'=>'control-label col-lg-3']) !!}
                                      <div class="col-lg-8">
                                          
                                            {!! Form::file('flag','',array('class'=>'btn btn-success form-control') )!!}
                                        
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      {!! Form::label('status','Status:',['class'=>'control-label col-lg-3']) !!}
                                      <div class="col-lg-3">
                                          
                                              {!! Form::select('status',['active'=>'Active','inactive'=>'Inactive'],$lang->status,['class'=>'form-control','id'=>'field']) !!}
                                          
                                        </div>
                                    </div>

                                    <div class="form-group">
                                      {!! Form::label('default_lang','Set Default:',['class'=>'control-label col-lg-3']) !!}
                                      <div class="col-lg-8">
                                        <div class="checkbox">
                                          @if($lang->id == $def_lang)
                                        <label>
                                          {!! Form::checkbox('default_lang', '1',true); !!}&nbsp;Set as Default Language
                                        </label>
                                        @else
                                        <label>
                                          {!! Form::checkbox('default_lang', '1'); !!}&nbsp;Set as Default Language
                                        </label>
                                        @endif

                                        </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            
                                            {!!Form::submit('Save',['class'=>'btn btn-primary']) !!}
                                            
                                        </div>
                                    </div>

                                <!--close language update form-->

								{!!Form::close() !!}
							</div>

                        </div>
                  </section>
            </div>
</div>       
<!-- page end-->



															@stop