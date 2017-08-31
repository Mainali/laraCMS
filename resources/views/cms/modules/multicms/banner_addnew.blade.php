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
                            <a href="{{URL::to(PREFIX.'/multicms/pages/banner')}}">Banners</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">Add New Banner</a>
                        </li>
                    </ul>
                </header>
          {!!Form::open(['files'=>true,'method'=>'POST','url'=>PREFIX.'/multicms/pages/banner/bannerLgCreate','class'=>'form-horizontal'])!!}
            <div class=" form">
                <style type="text/css">.tab-section{padding:15px;}</style>


                <div class="tab-section">

                    <div class="row">
                    <div class="col-lg-12">
                        
                        
                         <style type="text/css">
                            .ul-manage{
                                float: left;
                                margin: 5px 0 20px;
                                padding: 0;
                            }
                            .ul-manage li {
                                list-style: none;
                                margin-bottom: 5px;
                            }
                         </style>
                        
                         <div class="col-sm-12">
                          <div class="col-sm-12">
                            <div class="form-group pull-right ">
                          
                               {!!Form::submit('Save',['class'=>'btn btn-primary','style'=>'float:right; width:125px; margin-top:5px;']) !!}
                          
                            </div>
                          </div>
                        </div>

                        <!--start banner form-->
                                
                                    <div class="col-lg-12">
                                          
                                            
                                              {!! Form::label('form[banner][image]','Image *:',['class'=>'control-label col-lg-4']) !!}
                                              
                                            
                                             
                                          
                                          <div class="col-lg-8">
                                             
                                            <div class="form-group">
                                              <p>Image size:1600x543 pixels</p>
                                                {!! Form::file('form[banner][image]',['class'=>'form-control']) !!}
                                              
                                                
                                                
                                                                          
                                            </div>
                                          </div>
                                         
                                    </div>

                                    <div class="col-lg-12">
                                        
                                          
                                            {!! Form::label('form[banner][link]','Link:',['class'=>'control-label col-lg-4']) !!}
                                          
                                        
                                          <div class="col-lg-8">
                                            <div class="form-group">
                                            {!! Form::text('form[banner][link]','',['class'=>'form-control']) !!}
                                          </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        
                                          
                                            {!! Form::label('form[banner][position]','Position:',['class'=>'control-label col-lg-4']) !!}
                                          
                                        
                                          <div class="col-lg-8">
                                            <div class="form-group">
                                            {!! Form::text('form[banner][position]','',['class'=>'form-control']) !!}
                                          </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                          
                                        {!! Form::label('form[banner][status]','Status:',['class'=>'control-label col-lg-4']) !!}
                                          
                                          <div class="col-lg-8">
                                            <div class="form-group">
                                            
                                              {!! Form::radio('form[banner][status]', 'active', true) !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('form[banner][status]', 'inactive') !!}&nbsp;Inactive
                                            
                                            </div>
                                          </div>
                                    </div>










                        <!--close banner form-->
                        

                    </div>
                </div>
              
                <ul class="nav nav-tabs">
                    
                {{--*/$a=0;/*--}} 
                @foreach($flags as $flag)
                {{--*/$a++;/*--}} 
                    @if( ($a==1 && !Session::has('flag')) || ( Session::has('flag') && Session::get('flag') == $flag->id ) )<li class="active">@else<li>@endif<a data-toggle="tab" href="#{{ucfirst($flag->slug)}}" id="langtab"><img src="{{asset('/uploads')}}/flags/{{$flag->flag}}" height="20" width="20" style="float:left; margin-right:5px;">{{ucfirst($flag->slug)}}</a></li>
                    <!-- <li><a data-toggle="tab" href="#Nepali">Nepali</a></li> -->
                @endforeach


                
                </ul>

                
                          
                              
                          
                         
                
                {{--*/$b=0;/*--}} 
                <div class="tab-content" style="border:solid 1px #dddddd; border-top:none;">

                    @foreach($flags as $flag)
                      {{--*/$b++;/*--}}

                      {{--*/$langMatch=0;/*--}} 

                      @if( ($b==1 && !Session::has('flag')) || ( Session::has('flag') && Session::get('flag') == $flag->id ) )
                        <div id="{{ucfirst($flag->slug)}}" class="tab-pane fade in active">{{Session::forget('flag')}}@else

                          <div id="{{ucfirst($flag->slug)}}" class="tab-pane fade">@endif
                            <div class="panel-body">
                              
                                        
                                        
                                        

                                            
                                            <!--start banner_lg form-->
                                                    @if( $banner !=="")
                                                      <input type="hidden" name="form[{{$flag->id}}][page_id]" value="{{$banner->id}}">
                                                    @endif



                                                    <input type="hidden" name="form[{{$flag->id}}][language_id]" value="{{$flag->id}}">

                                                        



                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][title]','Title *:',['class'=>'control-label col-lg-4']) !!}

                                                           <div class="col-lg-8">
                                                            <div class="form-group">
                                                              @if($flag->slug == "en")
                                                              {!! Form::text('form['.$flag->id.'][title]','',['class'=>'form-control','id' => 'title']) !!}
                                                              @else
                                                               {!! Form::text('form['.$flag->id.'][title]','',['class'=>'form-control']) !!}
                                                              @endif
                                                            </div>
                                                         </div>

                                                    </div>


                                                    <div class="col-lg-12">
                                                          
                                                        {!! Form::label('form['.$flag->id.'][status]','Status:',['class'=>'control-label col-lg-4']) !!}
                                                          
                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                            
                                                              {!! Form::radio('form['.$flag->id.'][status]', 'active', true) !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('form['.$flag->id.'][status]', 'inactive') !!}&nbsp;Inactive
                                                            
                                                            </div>
                                                          </div>
                                                    </div>




                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][description]','Description:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][description]','',['class'=>'form-control','id' => 'editor'.$flag->id]) !!}
                                                            </div>
                                                          </div>
                                                    </div>



                                                    <script type="text/javascript">
                                                      CKEDITOR.replace('editor<?php echo $flag->id?>', {
                                                                filebrowserImageBrowseUrl: '{{asset('')}}laravel-filemanager?type=Images',
                                                                filebrowserBrowseUrl: '{{asset('')}}laravel-filemanager?type=Files'
                                                            });
                                                    </script>



                                            <!--close banner_lg form-->
                                            
                                                
                                    
                                    </div>

                                </div>
                            
                    

                    @endforeach
                   
                    <!-- <div id="Nepali" class="tab-pane fade">
                        <p>Section B content…</p>
                    </div> -->
                    
                </div>
                
               </div> 
                
            </div>
          {!!Form::close() !!}         
                </section>
            </div>
</div>       
<!-- page end-->



@stop