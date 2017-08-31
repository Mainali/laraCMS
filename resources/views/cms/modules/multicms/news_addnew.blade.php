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
                            <a href="{{URL::to(PREFIX.'/multicms/pages/news')}}">News</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">Add News</a>
                        </li>
                    </ul>
                </header>
          {!!Form::open(['files'=>true,'method'=>'POST','url'=>PREFIX.'/multicms/pages/news/newsLgCreate','class'=>'form-horizontal'])!!}
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

                        <!--start news form-->
                                
                                    <div class="col-lg-12 col-centered">
                                        
                                          
                                             {!! Form::label('form[news][slug]','Slug *:',['class'=>'control-label col-lg-4']) !!}
                                          
                                        
                                          <div class="col-lg-8">
                                            <div class="form-group">
                                                {!! Form::text('form[news][slug]','',['class'=>'form-control','id' => 'slug_input']) !!}
                                            </div>
                                        </div>

                                    </div>



                                    <div class="col-lg-12 col-centered">
                                          
                                            
                                            {!! Form::label('form[news][categories]','News Category *:',['class'=>'control-label col-lg-4']) !!}
                                          
                                          

                                          
                                            <div class="col-lg-8">
                                              {{--*/$i=0;/*--}} 
                                              @foreach( $newsCategoryList as $key => $value )
                                                <div class="checkbox">
                                                  <label>
                                                    {!! Form::checkbox('form[news][categories]['.$i.']', $key,Input::old('form[news][categories]')); !!}&nbsp;{{$value}}
                                                  </label>
                                                </div>
                                                {{--*/$i++;/*--}} 
                                              @endforeach
                                          </div>
                                          
                                    </div>

                                    <div class="col-lg-12 col-centered">
                                          
                                            
                                            {!! Form::label('form[news][gallery_id]','Gallery:',['class'=>'control-label col-lg-4']) !!}
                                          
                                          

                                          
                                            <div class="col-lg-8">
                                              <div class="form-group">
                                              {!! Form::select('form[news][gallery_id]',$galleryList,null,['class'=>'form-control']) !!}
                                            </div>
                                          </div>
                                          
                                    </div>


                                    <div class="col-lg-12 col-centered">
                                        
                                          
                                             {!! Form::label('form[news][image]','Image:',['class'=>'control-label col-lg-4']) !!}
                                             
                                                                                    
                                        
                                          <div class="col-lg-8">
                                            <p>The width of image shouldn't be below 870 pixels</p>
                                            <div class="form-group">

                                                {!! Form::file('form[news][image]',['class'=>'form-control']) !!}
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-lg-12 col-centered">
                                        
                                          
                                             {!! Form::label('form[news][thumbnail]','Thumbnail:',['class'=>'control-label col-lg-4']) !!}
                                             
                                          
                                        
                                          <div class="col-lg-8">
                                            <p>Image Size:370x150 pixels</p>
                                            <div class="form-group">

                                                {!! Form::file('form[news][thumbnail]',['class'=>'form-control']) !!}
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-lg-12 col-centered">
                                        
                                          
                                             {!! Form::label('form[news][published_at]','Published at:',['class'=>'control-label col-lg-4']) !!}
                                          
                                        
                                          <div class="col-lg-8">
                                            <div class="form-group">

                                                {!! Form::text('form[news][published_at]',date('Y-m-d'),['class'=>'form-control datepicker']) !!}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-12 col-centered">
                                          
                                        {!! Form::label('form[news][pinned]','Pinned:',['class'=>'control-label col-lg-4']) !!}
                                          
                                          <div class="col-lg-8">
                                            <div class="form-group">
                                            
                                              {!! Form::radio('form[news][pinned]', 'yes') !!}&nbsp;Yes&nbsp;&nbsp;&nbsp;{!! Form::radio('form[news][pinned]', 'no', true) !!}&nbsp;No
                                            
                                            </div>
                                          </div>
                                    </div>

                                    <div class="col-lg-12 col-centered">
                                        
                                          
                                             {!! Form::label('form[news][pinned_position]','Position :',['class'=>'control-label col-lg-4']) !!}
                                          
                                        
                                          <div class="col-lg-8">
                                            <div class="form-group">
                                                {!! Form::text('form[news][pinned_position]','',['class'=>'form-control']) !!}
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-lg-12 col-centered">
                                          
                                        {!! Form::label('form[news][status]','Status:',['class'=>'control-label col-lg-4']) !!}
                                          
                                          <div class="col-lg-8">
                                            <div class="form-group">
                                            
                                              {!! Form::radio('form[news][status]', 'active', true) !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('form[news][status]', 'inactive') !!}&nbsp;Inactive
                                            
                                            </div>
                                          </div>
                                    </div>














                        <!--close news form-->
                        

                    </div>
                </div>
              
                <ul class="nav nav-tabs">
                    
                {{--*/$a=0;/*--}} 
                @foreach($flags as $flag)
                {{--*/$a++;/*--}} 
                    @if( ($a==1 && !Session::has('flag')) || ( Session::has('flag') && Session::get('flag') == $flag->id ) )<li class="active">@else<li>@endif<a data-toggle="tab" href="#{{ucfirst($flag->slug)}}" id="langtab"><img src="{{URL::asset('/uploads')}}/flags/{{$flag->flag}}" height="20" width="20" style="float:left; margin-right:5px;">{{ucfirst($flag->slug)}}</a></li>
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
                              
                                        
                                        
                                        

                                            
                                            <!--start news_lg form-->
                                                    @if(!empty($news))
                                                    <input type="hidden" name="form[{{$flag->id}}][news_id]" value="{{$news->id}}">
                                                    @endif


                                                    <input type="hidden" name="form[{{$flag->id}}][language_id]" value="{{$flag->id}}">

                                                        



                                                    <div class="col-lg-12 col-centered">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][title]','Title:',['class'=>'control-label col-lg-4']) !!}

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


                                                    <div class="col-lg-12 col-centered">
                                                          
                                                        {!! Form::label('form['.$flag->id.'][status]','Status:',['class'=>'control-label col-lg-4']) !!}
                                                          
                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                            
                                                              {!! Form::radio('form['.$flag->id.'][status]', 'active', true) !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('form['.$flag->id.'][status]', 'inactive') !!}&nbsp;Inactive
                                                            
                                                            </div>
                                                          </div>
                                                    </div>


                                                    <div class="col-lg-12 col-centered">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][intro]','Introduction:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][intro]','',['class'=>'form-control','id' => 'intro'.$flag->id]) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <?php if($flag->slug=='np')$editor = 'editor';else $editor = 'editorNp';?>

                                                    <div class="col-lg-12 col-centered">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][description]','Description:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][description]','',['class'=>'form-control','id' => 'editor'.$flag->id]) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12 col-centered">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][meta_title]','Meta Title:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][meta_title]','',['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12 col-centered">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][meta_description]','Meta Description:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][meta_description]','',['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12 col-centered">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][keyword]','Keyword:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][keyword]','',['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                      CKEDITOR.replace('editor<?php echo $flag->id?>', {
                                                                filebrowserImageBrowseUrl: '{{asset('')}}laravel-filemanager?type=Images',
                                                                filebrowserBrowseUrl: '{{asset('')}}laravel-filemanager?type=Files'
                                                            });
                                                    </script>

                                                    <script type="text/javascript">
                                                      CKEDITOR.replace('intro<?php echo $flag->id?>', {
                                                                filebrowserImageBrowseUrl: '{{asset('')}}laravel-filemanager?type=Images',
                                                                filebrowserBrowseUrl: '{{asset('')}}laravel-filemanager?type=Files'
                                                            });
                                                    </script>





                                            <!--close news_lg form-->
                                            
                                                
                                   
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