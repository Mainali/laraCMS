<div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Edit Mobile Apk</h4>
                        </div>
                        <div class="modal-body">
                            <div class="panel-body">
                            <div class="row">
                              @if($errors->any())
                              <ul class="list-group col-lg-12">
                                  @foreach($errors->all() as $error)
                                    <li class="list-group-item alert alert-danger col-lg-6">
                                      <span class="glyphicon glyphicon-hand-righ"></span>&nbsp;{{$error}}
                                    </li>
                                  @endforeach
                              </ul>
                              @endif


                                <div class="col-sm-12">
                            {!! Form::open(array('url' =>PREFIX.'/mobileBuilt/editPost', 'method'=>'POST', 'name'=>'myForm', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                <input type="hidden" name="id" value="{{$builtData->id}}">
                                <div class="col-lg-12">

                                          {!! Form::label('title','Title:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('title',$builtData->title,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>
                                          <div class="col-lg-12">

                                          {!! Form::label('apk_version','APK Version:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('apk_version',$builtData->apk_version,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('description','Description:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::textarea('description',$builtData->description,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>
                                        <div class="col-lg-12">
                                        {!! Form::label('apk','Mobile Built:',['class'=>'control-label col-lg-4']) !!}
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                {!! Form::file('apk','',array('class'=>'btn btn-success form-control') )!!}
                                            </div>
                                        </div>
                                               <div class="col-lg-8">
                                                @if(!empty($builtData->apk) && file_exists("public/apk/" . $builtData->apk))
                                                    <img src="{{asset('/public/apk/apk.png')}}" height="100" width="100" style="float:left; margin-right:5px;">
                                                @else
                                                <img src="{{asset('/public/no-image.png')}}" height="100" width="100" style="float:left; margin-right:5px;">
                                                @endif
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