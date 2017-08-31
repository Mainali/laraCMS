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
                            <a href="{{URL::to(PREFIX.'/multicms/pages/pages')}}">Pages</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">Manage:&nbsp;{{$page->title}}</a>
                        </li>
                    </ul>
                </header>
          {!!Form::open(['files'=>true,'method'=>'POST','url'=>PREFIX.'/multicms/pages/pages/allUpdate','class'=>'form-horizontal'])!!}
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

                        <!--start pages update form-->
                                <input type="hidden" name="form[page][id]" value="{{$page->id}}">
                                <div class="col-lg-12">
                                      
                                        
                                        {!! Form::label('form[page][parent_id]','Parent:',['class'=>'control-label col-lg-4']) !!}
                                      
                                      

                                      
                                        <div class="col-lg-8">
                                          <div class="form-group">
                                          {!! Form::select('form[page][parent_id]',$pageList,$page->parent_id,['class'=>'form-control']) !!}
                                        </div>
                                      </div>
                                      
                                </div>

                                <div class="col-lg-12">
                                    
                                      
                                        {!! Form::label('form[page][slug]','Slug *:',['class'=>'control-label col-lg-4']) !!}
                                      
                                    
                                      <div class="col-lg-8">
                                        <div class="form-group">
                                        {!! Form::text('form[page][slug]',$page->slug,['class'=>'form-control','id' => 'slug_input']) !!}
                                      </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    
                                      
                                        {!! Form::label('form[page][page_template]','Page Template:',['class'=>'control-label col-lg-4']) !!}
                                      
                                    
                                      <div class="col-lg-8">
                                        <div class="form-group">
                                        {!! Form::select('form[page][page_template]',$page_template,$page->page_template,['class'=>'form-control']) !!}
                                      </div>
                                    </div>

                                </div>

                                <div class="col-lg-12">
                                    
                                      
                                          {!! Form::label('form[page][show_in_mainmenu]','Show in Main Menu:',['class'=>'control-label col-lg-4']) !!}
                                      
                                    
                                      <div class="col-lg-8">
                                        <div class="form-group">
                                        @if($page->show_in_mainmenu == 'yes')  
                                          {!! Form::radio('form[page][show_in_mainmenu]', 'yes',true) !!}&nbsp;Yes&nbsp;&nbsp;&nbsp;{!! Form::radio('form[page][show_in_mainmenu]', 'no') !!}&nbsp;No
                                        @else
                                          {!! Form::radio('form[page][show_in_mainmenu]', 'yes') !!}&nbsp;Yes&nbsp;&nbsp;&nbsp;{!! Form::radio('form[page][show_in_mainmenu]', 'no', true) !!}&nbsp;No
                                        @endif
                                        </div>
                                      </div>

                                </div>

                                <div class="col-lg-12">
                                    
                                      
                                        {!! Form::label('form[page][position]','Position:',['class'=>'control-label col-lg-4']) !!}
                                      
                                    
                                      <div class="col-lg-8">
                                        <div class="form-group">
                                        {!! Form::text('form[page][position]',$page->position,['class'=>'form-control']) !!}
                                      </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                      
                                        
                                          {!! Form::label('form[page][menu_icon]','Menu Icon:',['class'=>'control-label col-lg-4']) !!}
                                        
                                      
                                      <div class="col-lg-8">
                                        <div class="form-group">
                                          {!! Form::file('form[page][menu_icon]',['class'=>'form-control']) !!}
                                        </div>  
                                          <div class="form-group">
                                              @if($page->menu_icon!="")
                                              <img src="{{asset('/uploads/pages')}}/menu_icon/{{$page->menu_icon}}" height="100" width="100" style="float:left; margin-right:5px;">
                                              <a class="btn btn-danger btn-xs" href="{{ URL::to(PREFIX.'/multicms/pages/pages/menuIconDelete')}}?id=<?= $page->id;?>"><i class="fa fa-trash"></i>Delete Menu Icon</a>
                                              @endif
                                          </div>                            
                                        
                                      </div>
                                     
                                </div>



                                <div class="col-lg-12">
                                      
                                    {!! Form::label('form[page][status]','Status:',['class'=>'control-label col-lg-4']) !!}
                                      
                                      <div class="col-lg-8">
                                        <div class="form-group">
                                        @if($page->status == 'active')  
                                          {!! Form::radio('form[page][status]', 'active',true) !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('form[page][status]', 'inactive') !!}&nbsp;Inactive
                                        @else
                                          {!! Form::radio('form[page][status]', 'active') !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('form[page][status]', 'inactive', true) !!}&nbsp;Inactive
                                        @endif
                                        </div>
                                      </div>
                                </div>




                        <!--close pages update form-->
                        

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
                              
                                        
                                        @if(count($page->pagesLg)>0)

                                            @foreach($page->pagesLg as $Lg)
                                                @if($Lg->language_id == $flag->id)
                                                    
                                                    {{--*/$langMatch=1;/*--}}
                                                    {{--*/$pLg=$Lg;/*--}}

                                                @endif
                                            @endforeach
                                        @endif

                                        

                                    @if($langMatch == 1)

                                            <!--start pagesLg udateform-->
                                                    

                                                    <input type="hidden" name="form[{{$flag->id}}][id]" value="{{$pLg->id}}">

                                                    <input type="hidden" name="form[{{$flag->id}}][page_id]" value="{{$page->id}}">

                                                    <input type="hidden" name="form[{{$flag->id}}][language_id]" value="{{$flag->id}}">

                                                       
                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][title]','Title *:',['class'=>'control-label col-lg-4']) !!}

                                                           <div class="col-lg-8">
                                                            <div class="form-group">
                                                              @if($flag->slug == "en")
                                                              {!! Form::text('form['.$flag->id.'][title]',$pLg->title,['class'=>'form-control','id' => 'title']) !!}
                                                              @else
                                                               {!! Form::text('form['.$flag->id.'][title]',$pLg->title,['class'=>'form-control']) !!}
                                                              @endif
                                                            </div>
                                                         </div>

                                                    </div>


                                                    <div class="col-lg-12">
                                                          
                                                        {!! Form::label('form['.$flag->id.'][status]','Status:',['class'=>'control-label col-lg-4']) !!}
                                                          
                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                            @if($pLg->status == 'active')  
                                                              {!! Form::radio('form['.$flag->id.'][status]', 'active',true) !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('form['.$flag->id.'][status]', 'inactive') !!}&nbsp;Inactive
                                                            @else
                                                              {!! Form::radio('form['.$flag->id.'][status]', 'active') !!}&nbsp;Active&nbsp;&nbsp;&nbsp;{!! Form::radio('form['.$flag->id.'][status]', 'inactive', true) !!}&nbsp;Inactive
                                                            @endif
                                                            </div>
                                                          </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                         
                                                              {!! Form::label('form['.$flag->id.'][thumbnails]','Thumbnail:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::file('form['.$flag->id.'][thumbnails]',['class'=>'form-control']) !!}
                                                             </div>
                                                              
                                                              <div class="form-group">
                                                                @if($pLg->thumbnails!="")
                                                                <img src="{{asset('/uploads/pages')}}/thumbnails/{{$pLg->thumbnails}}" height="50" width="50" style="float:left; margin-right:5px;">
                                                                <a class="btn btn-danger btn-xs" href="{{ URL::to(PREFIX.'/multicms/pages/pages/thumbDelete')}}?pages_lg_id=<?= $pLg->id;?>&id=<?= $page->id;?>"><i class="fa fa-trash"></i>Delete Thumbnail</a>
                                                                @endif
                                                              </div>
                                                            
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                         

                                                              {!! Form::label('form['.$flag->id.'][banner]','Banner:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                          <div class="form-group">
                                                            
                                                                {!! Form::file('form['.$flag->id.'][banner]',['class'=>'form-control']) !!}
                                                              
                                                            </div>
                                                          
                                                                <div class="form-group">
                                                                  @if($pLg->banner!="")
                                                                  <img src="{{asset('/uploads/pages')}}/banner/{{$pLg->banner}}" height="100" width="100" style="float:left; margin-right:5px;">
                                                                  <a class="btn btn-danger btn-xs" href="{{ URL::to(PREFIX.'/multicms/pages/pages/bannerDelete')}}?pages_lg_id=<?= $pLg->id;?>&id=<?= $page->id;?>"><i class="fa fa-trash"></i>Delete Banner</a>
                                                                  @endif
                                                                </div>
                                                            
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][description]','Description:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][description]',$pLg->description,['class'=>'form-control','id' => 'editor'.$flag->id]) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][meta_title]','Meta Title:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][meta_title]',$pLg->meta_title,['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][meta_description]','Meta Description:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][meta_description]',$pLg->meta_description,['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][keyword]','Keyword:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][keyword]',$pLg->keyword,['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>


                                                    <script type="text/javascript">
                                                      CKEDITOR.replace('editor<?php echo $flag->id?>', {
                                                                filebrowserImageBrowseUrl: '{{asset('')}}laravel-filemanager?type=Images',
                                                                filebrowserBrowseUrl: '{{asset('')}}laravel-filemanager?type=Files'
                                                            });
                                                    </script>



                                            <!--close pagesLg updateform-->

                                        
                                    @else
                                            <!--start pagesLg form-->
                                                    @if( $page !=="")
                                                      <input type="hidden" name="form[{{$flag->id}}][page_id]" value="{{$page->id}}">
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
                                                         
                                                              {!! Form::label('form['.$flag->id.'][thumbnails]','Thumbnail:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">

                                                              {!! Form::file('form['.$flag->id.'][thumbnails]',['class'=>'form-control']) !!}

                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                         

                                                              {!! Form::label('form['.$flag->id.'][banner]','Banner:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::file('form['.$flag->id.'][banner]',['class'=>'form-control']) !!}

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



                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][meta_title]','Meta Title:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][meta_title]','',['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][meta_description]','Meta Description:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][meta_description]','',['class'=>'form-control texteditor','id' => 'editor']) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                         
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



                                            <!--close pagesLg form-->
                                    @endif
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