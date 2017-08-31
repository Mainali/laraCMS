<div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Edit Field</h4>
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
                            {!! Form::open(array('url' => PREFIX.'/api/pages/categories/addPost','method'=>'POST', 'name'=>'myForm', 'class'=>'cmxform form-horizontal')) !!}
                                
                                            
                                        <div class="col-lg-12">

                                          {!! Form::label('title','Category Title:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('title','',['class'=>'form-control']) !!}
                                             </div>
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