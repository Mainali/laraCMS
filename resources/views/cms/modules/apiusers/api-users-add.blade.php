<div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Add Field</h4>
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
                            {!! Form::open(array('url' => PREFIX.'/apiusers/addPost', 'method'=>'POST', 'name'=>'myForm', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                
                                <div class="col-lg-12">

                                          {!! Form::label('FirstName','First Name:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('firstName','',['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>


                                        <div class="col-lg-12">

                                          {!! Form::label('MiddleName','Middle Name:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('middleName','',['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('LastName','Last Name:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('lastName','',['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('UserName','User Name:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('userName','',['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('Password','Password:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::password('password',['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        

                                        <div class="col-lg-12">

                                          {!! Form::label('Email','Email:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('email','',['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('Mobile','Mobile No.:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('mobileNumber','',['class'=>'form-control']) !!}
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