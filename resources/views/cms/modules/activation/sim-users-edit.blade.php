<div class="modal-dialog modal-lg modal-ex-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                          <button onClick="javascript:updateStatus('{{$editUrl}}',{{$editFormData->id}})" aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
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
                            {!! Form::open(array('url' => PREFIX.'/activation/saveEdit', 'method'=>'POST', 'name'=>'myForm', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                

                                {!! Form::hidden('id',$editFormData->id) !!}
                                <div class="row">
                                  <div class="col-sm-5">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        {!! Form::label('Name','Full Name:',['class'=>'control-label col-lg-5']) !!}
                                       <div class="col-lg-7">
                                         <div class="form-group">
                                            
                                             {!! Form::text('fullname',$editFormData->fullname,['class'=>'form-control datepicker']) !!}
                                         </div>
                                       </div>
                                     </div>
                                    <div class="col-sm-12">
                                          {!! Form::label('Country','Country:',['class'=>'control-label col-lg-5']) !!}
                                           <div class="col-lg-7">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('country',$editFormData->country,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                       </div>
                                       <div class="col-sm-12">
                                        {!! Form::label('Text','Passport no:',['class'=>'control-label col-lg-5']) !!}
                                         <div class="col-lg-7">
                                           <div class="form-group">
                                              
                                                {!! Form::text('passport_num',$editFormData->passport_num,['class'=>'form-control']) !!}
                                         </div>
                                       </div>
                                     </div>
                                       <div class="col-sm-12">
                                        {!! Form::label('Ctzn','Citizenship no:',['class'=>'control-label col-lg-5']) !!}
                                         <div class="col-lg-7">
                                           <div class="form-group">
                                              
                                                {!! Form::text('citizenship_num',$editFormData->citizenship_num,['class'=>'form-control']) !!}
                                           </div>
                                         </div>
                                       </div>
                                       <div class="col-sm-12">
                                        {!! Form::label('Visa','Visa no:',['class'=>'control-label col-lg-5']) !!}
                                           <div class="col-lg-7">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('visa_num',$editFormData->visa_num,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                       </div>
                                       <div class="col-sm-12">
                                        {!! Form::label('CntryNo','Country no:',['class'=>'control-label col-lg-5']) !!}
                                           <div class="col-lg-7">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('country_num',$editFormData->country_num,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                       </div>
                                       <div class="col-sm-12">
                                         {!! Form::label('SimNo','Sim no:',['class'=>'control-label col-lg-5']) !!}
                                           <div class="col-lg-7">
                                             <div class="form-group">
                                                
                                                  {!! Form::text('sim_num',$editFormData->sim_num,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                       </div>
                                       <div class="col-sm-12">
                                         {!! Form::label('status','Status:',['class'=>'control-label col-lg-5']) !!}
                                           <div class="col-lg-7">
                                             <div class="form-group">
                                                
                                                 {!! Form::select('status', ['Pending'=>'Pending' ,'Activated'=>'Activated','Cancelled' => 'Cancelled'] ,$editFormData->status,['class'=>'form-control']) !!}
                                             </div>
                                           </div>
                                       </div>
                                      </div>
                                    </div>

                                    <div class="col-sm-7">
                                    <div id="photos" class="clearfix">
                                          <div class="photos-blocks">
                                          <ul class="row">
                                            <li class="col-lg-2 col-md-6"><a href="javascript:void()">@if(!empty($editFormData->country_id_image_1)) <img src="{{asset('/uploads/country_image/image1').'/'.$editFormData->country_id_image_1}}" height="75px" > @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif<span>Country Id 1</span></a></li>
                                            <li class="col-lg-2 col-md-6"><a href="javascript:void()">@if(!empty($editFormData->country_id_image_2)) <img src="{{asset('/uploads/country_image/image2').'/'.$editFormData->country_id_image_2}}"  height="75px"> @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif<span>Country Id 2</span></a></li>
                                            <li class="col-lg-2 col-md-6"><a href="javascript:void()">@if(!empty($editFormData->passport_image_1)) <img src="{{asset('/uploads/passport_image/image1').'/'.$editFormData->passport_image_1}}"  height="75px"> @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif<span>Passport 1</span></a></li>
                                            <li class="col-lg-2 col-md-6"><a href="javascript:void()">@if(!empty($editFormData->passport_image_2)) <img src="{{asset('/uploads/passport_image/image2').'/'.$editFormData->passport_image_2}}"  height="75px"> @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif<span>Passport 2</span></a></li>
                                            <li class="col-lg-2 col-md-6"><a href="javascript:void()">@if(!empty($editFormData->visa_image)) <img src="{{asset('/uploads/visa_image').'/'.$editFormData->visa_image}}"  height="75px"> @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif<span>Visa image </span></a></li>
                                            <li class="col-lg-2 col-md-6"><a href="javascript:void()">@if(!empty($editFormData->sim_image)) <img src="{{asset('/uploads/sim_image').'/'.$editFormData->sim_image}}"  height="75px"> @else <img src="{{asset('public/cms/images/images.jpg')}}" height="75px">@endif<span>Sim image</span></a></li>
                                          </ul>

                                          </div>
                                    </div>

                                    <div style="display:none; margin:0 auto" id="buttons">
                                      <a class="btn btn-primary" onClick="Javascript: rotateMyImageLeft();" title="Rotate Left"><i class="fa fa-undo"></i></a>
                                      <a  class="btn btn-primary" onClick="Javascript: rotateMyImageRight();" title="Rotate Right"><i class="fa fa-repeat"></i></a>
                                    </div>
                                    
                                    <div id="img-container" class="photo-display"></div>

                                    <div class="row">
                                            <div class="col-lg-12">
                                              <button type="submit" class="btn btn-primary pull-right">Update</button></div>
                                        </div>
                                  </div>

                                  </div>
                                  {!! Form::close()!!}
                                </div>

                             </div>
                                       
                                      
                                     </div>
                                 </div>
                            </div>
                         </div>
                    </div>
                </div>

                <script type="text/javascript">







                 $('#photos img').click(function(){
                    var c = $(this).attr("src");
                    var img = $('#img-rotate1');
                    var deg_temp=45;
                    $("#img-container").html('<img id="img-rotate1" class="img-responsive north" src="'+ c +'" />');
                   document.getElementById('buttons').style.display='block';
                  }); 



                 function rotateMyImageLeft()
                 {
                  //alert(document.getElementById('img-rotate1').className);
                  if(document.getElementById('img-rotate1').className=='img-responsive north')
                  {
                    
                    document.getElementById('img-rotate1').className='img-responsive west';
                    //alert(document.getElementById('img-rotate1').className);
                  }

                  else if(document.getElementById('img-rotate1').className=='img-responsive west')
                  {
                    document.getElementById('img-rotate1').className='img-responsive south';
                  }

                  else if(document.getElementById('img-rotate1').className=='img-responsive south')
                  {
                    document.getElementById('img-rotate1').className='img-responsive east';
                  }

                  else if(document.getElementById('img-rotate1').className=='img-responsive east')
                  {
                    document.getElementById('img-rotate1').className='img-responsive north';
                  }
              }


              function rotateMyImageRight()
                 {
                  //alert(document.getElementById('img-rotate1').className);
                  if(document.getElementById('img-rotate1').className=='img-responsive north')
                  {
                    
                    document.getElementById('img-rotate1').className='img-responsive east';
                    //alert(document.getElementById('img-rotate1').className);
                  }

                  else if(document.getElementById('img-rotate1').className=='img-responsive east')
                  {
                    document.getElementById('img-rotate1').className='img-responsive south';
                  }

                  else if(document.getElementById('img-rotate1').className=='img-responsive south')
                  {
                    document.getElementById('img-rotate1').className='img-responsive west';
                  }

                  else if(document.getElementById('img-rotate1').className=='img-responsive west')
                  {
                    document.getElementById('img-rotate1').className='img-responsive north';
                  }
              }
              //     $('.rotate-right').click(function(){
              //     var img = $('#img-rotate1');
              //     if(img.hasClass('east')){
              //       img.removeClass("east").addClass("north");
              //         //img.attr('class','img-responsive north');
              //     }else if(img.hasClass('south')){
              //       img.removeClass("south").addClass("east");
              //         //img.attr('class','img-responsive east');
              //     }else if(img.hasClass('west')){
              //       img.removeClass("west").addClass("south");
              //         //img.attr('class','img-responsive south');
              //     }else if(img.hasClass('north')){
              //         img.removeClass("north").addClass("west");
              //         //img.attr('class','img-responsive west');
              //     }
              // });

              function updateStatus(editurl,id)
{
    $.ajax({
         url: editurl+"?id="+id,
            type: 'get',
            success: function(result)
            {
              

              if(result==1)
              {
               console.log('updated'); 
              }
              else
              {
                $('#editModal').html(result);
                $('#editModal').modal('show');
              }
                
                //$('#editModal').html(result);
                //$('#editModal').modal('show');
             
            },
            error: function()
            {
               $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2>Could not complete the request.</h2></div></div>');
                $('#modalinfo').modal('show'); 
            }
    })
}


                </script>