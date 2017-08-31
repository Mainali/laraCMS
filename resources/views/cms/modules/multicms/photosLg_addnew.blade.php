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
                            <a href="{{URL::to(PREFIX.'/multicms/pages/gallery/lists')}}?gallery_id=<?= $photo->gallery_id;?>">Photos</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">Manage:&nbsp;</a>
                        </li>
                    </ul>
                </header>
          {!!Form::open(['files'=>true,'method'=>'POST','url'=>PREFIX.'/multicms/pages/gallery/photosLgManage','class'=>'form-horizontal'])!!}
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
                        <ul class="ul-manage">
                            <li style=" font-size:22px;">Album Title : {{$photo->gallery->title}}</li>
                            <li>Updated date : {{$photo->updated_at}}</li>
                            @if($photo->status == "inactive")<li style="color:red;">@else<li>@endif Status : {{$photo->status}}</li>
                        </ul>

                        

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

                <div class="form-group pull-right" style="margin-top:-48px;">
                          
                              {!!Form::submit('Apply',['class'=>'btn btn-primary','style'=>'float:right; width:125px; margin-top:5px;']) !!}
                          
                         </div>
                
                {{--*/$b=0;/*--}} 
                <div class="tab-content" style="border:solid 1px #dddddd; border-top:none;">

                    @foreach($flags as $flag)
                      {{--*/$b++;/*--}}

                      {{--*/$langMatch=0;/*--}} 

                      @if( ($b==1 && !Session::has('flag')) || ( Session::has('flag') && Session::get('flag') == $flag->id ) )
                        <div id="{{ucfirst($flag->slug)}}" class="tab-pane fade in active">{{Session::forget('flag')}}@else

                          <div id="{{ucfirst($flag->slug)}}" class="tab-pane fade">@endif
                            <div class="panel-body">
                              
                                        
                                        @if(count($photo->picturesLg)>0)

                                            @foreach($photo->picturesLg as $Lg)
                                                @if($Lg->language_id == $flag->id)
                                                    
                                                    {{--*/$langMatch=1;/*--}}
                                                    {{--*/$pLg=$Lg;/*--}}

                                                @endif
                                            @endforeach
                                        @endif

                                        

                                    @if($langMatch == 1)

                                            
                                            <!--start photosLg updateform-->
                                                    
                                                    <input type="hidden" name="form[{{$flag->id}}][id]" value="{{$pLg->id}}">

                                                    <input type="hidden" name="form[{{$flag->id}}][picture_id]" value="{{$photo->id}}">

                                                    <input type="hidden" name="form[{{$flag->id}}][language_id]" value="{{$flag->id}}">



                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][caption]','Caption:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][caption]',$pLg->caption,['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                          
                                                              {!! Form::label('form['.$flag->id.'][status]','Status:',['class'=>'control-label col-lg-4']) !!}

                                                            <div class="col-lg-8">
                                                              <div class="form-group">
                                                              {!! Form::select('form['.$flag->id.'][status]',['active'=>'Active','inactive'=>'Inactive'],$pLg->status,['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>
                                            <!--close photosLg updateform-->
                                           
                                    @else
                                        

                                            
                                            <!--start photosLg form-->
                                                    



                                                    <input type="hidden" name="form[{{$flag->id}}][language_id]" value="{{$flag->id}}">



                                                    <div class="col-lg-12">
                                                         
                                                             {!! Form::label('form['.$flag->id.'][caption]','Caption:',['class'=>'control-label col-lg-4']) !!}

                                                          <div class="col-lg-8">
                                                            <div class="form-group">
                                                              {!! Form::textarea('form['.$flag->id.'][caption]','',['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                          
                                                              {!! Form::label('form['.$flag->id.'][status]','Status:',['class'=>'control-label col-lg-4']) !!}

                                                            <div class="col-lg-8">
                                                              <div class="form-group">
                                                              {!! Form::select('form['.$flag->id.'][status]',['active'=>'Active','inactive'=>'Inactive'],null,['class'=>'form-control']) !!}
                                                            </div>
                                                          </div>
                                                    </div>




                                            <!--close photosLg updateform-->
                                            
                                                
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