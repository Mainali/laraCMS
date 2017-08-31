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
                            {!! Form::open(array('url' => PREFIX.'/api/pages/types/editPost', 'method'=>'POST', 'name'=>'myForm', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                
                                <div class="col-lg-12">

                                          {!! Form::label('API_Name','API Name:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('api_name',$apiTypeFormData->api_name,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>
                                        <div class="col-lg-12">

                                          {!! Form::label('API_cat','API Category:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                 {!! Form::select('category_id', $apiCategories ,$apiTypeFormData->category_id,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>


                                          {!! Form::hidden('id',$apiTypeFormData->id) !!}
                                        <div class="col-lg-12">

                                          {!! Form::label('API_ID','API ID:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('api_id',$apiTypeFormData->api_id,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('api_type','TYPE:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('type',$apiTypeFormData->type,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('API_method','API Method:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                 {!! Form::select('api_method', ['POST'=>'POST','GET'=>'GET','PUT'=>'PUT','DELETE'=>'DELETE'] ,$apiTypeFormData->api_method,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('api_url','API URL:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('api_url',$apiTypeFormData->api_url,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('version','API Version:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('version',$apiTypeFormData->version,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('api_desc','API Description:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::textarea('api_description',$apiTypeFormData->api_description,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('manual_response','Manual Response:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                  {!! Form::textarea('manual_response',$apiTypeFormData->manual_response,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                        </div>

                                        <div class="col-lg-12">

                                          {!! Form::label('status','Status:',['class'=>'control-label col-lg-4']) !!}
                                           <div class="col-lg-8">
                                             <div class="form-group">
                                                
                                                 {!! Form::select('status', ['active'=>'Active','inactive' => 'Inactive'] ,$apiTypeFormData->status,['class'=>'form-control']) !!}
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