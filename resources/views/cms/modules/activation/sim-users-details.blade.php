<div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">View Details of {{$activationData->fullname}}</h4>
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

                                	<div class="col-lg-12 well">

                                          
                                           <div class="col-lg-6">
                                             <div class="form-group">
                                                	<label for="cname" class="control-label col-lg-4">Full Name:</label>
                                                 <label for="cname" class="control-label col-lg-8">{{$activationData->fullname}}</label>
                                             </div>
                                           </div>

                                           
                                           <div class="col-lg-6">
                                             <div class="form-group">
                                                <label for="cname" class="control-label col-lg-4">Password No:</label>
                                                 <label for="cname" class="control-label col-lg-8">{{$activationData->passport_num}}</label>
                                             </div>
                                           </div>
                                          
                                           <div class="col-lg-6">
                                             <div class="form-group">
                                                 <label for="cname" class="control-label col-lg-4">Country:</label>
                                                 <label for="cname" class="control-label col-lg-8">{{$activationData->country}}</label>
                                             </div>
                                           </div>
                                           
                                           <div class="col-lg-6">
                                             <div class="form-group">
                                                <label for="cname" class="control-label col-lg-4">Citiznship No:</label>
                                                 <label for="cname" class="control-label col-lg-8">{{$activationData->citizenship_num}}</label>
                                             </div>
                                           </div>

                                           

                                    
                                        </div> <!--well -->

                                        <div class="col-lg-12">
                                             <div class="form-group">
                                                <label for="cname" class="control-label col-lg-12">User Image:</label>
                                                @if(!empty($activationData->user_image)) <img src="{{asset('/uploads/user_image').'/'.$activationData->user_image}}" > @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif
                                                 
                                             </div>
                                           </div> 

                                           <div class="col-lg-12">
                                             <div class="form-group">
                                                <label for="cname" class="control-label col-lg-12">Visa Image:</label>
                                                @if(!empty($activationData->visa_image)) <img src="{{asset('/uploads/visa_image').'/'.$activationData->visa_image}}" > @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif
                                                 
                                             </div>
                                           </div>

                                           <div class="col-lg-12">
                                             <div class="form-group">
                                                <label for="cname" class="control-label col-lg-12">Password Image1:</label>
                                                @if(!empty($activationData->passport_image_1)) <img src="{{asset('/uploads/passport_image/image1').'/'.$activationData->passport_image_1}}" > @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif
                                                 
                                             </div>
                                           </div>

                                           <div class="col-lg-12">
                                             <div class="form-group">
                                                <label for="cname" class="control-label col-lg-12">Password Image2:</label>
                                                @if(!empty($activationData->passport_image_2)) <img src="{{asset('/uploads/passport_image/image2').'/'.$activationData->passport_image_2}}" > @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif
                                                 
                                             </div>
                                           </div> 

                                           <div class="col-lg-12">
                                             <div class="form-group">
                                                <label for="cname" class="control-label col-lg-12">Country ID Image1:</label>
                                                @if(!empty($activationData->country_id_image_1)) <img src="{{asset('/uploads/country_image/image1').'/'.$activationData->country_id_image_1}}" > @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif
                                                 
                                             </div>
                                           </div>

                                           <div class="col-lg-12">
                                             <div class="form-group">
                                                <label for="cname" class="control-label col-lg-12">Country ID Image2:</label>
                                                @if(!empty($activationData->country_id_image_2)) <img src="{{asset('/uploads/country_image/image2').'/'.$activationData->country_id_image_2}}" > @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif
                                                 
                                             </div>
                                           </div>       

                                           <div class="col-lg-12">
                                             <div class="form-group">
                                                <label for="cname" class="control-label col-lg-12">Sim Image:</label>
                                                @if(!empty($activationData->sim_image)) <img src="{{asset('/uploads/sim_image').'/'.$activationData->sim_image}}" > @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif
                                                 
                                             </div>
                                           </div> 

                           							
                                             </div>
                                         </div>
                                    </div>
                         </div>
                         <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                   
                </div>
                    </div>
                </div>