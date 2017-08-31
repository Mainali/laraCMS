@extends('cms.master')

@section('content')

<!-- page start-->
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <ul class="breadcrumbs-alt">
                          <li>
                            <a  href="{{URL::to(PREFIX.'/activation')}}"> list</a>
                        </li>
                        <li>
                            <a class="current" href="javascript:void(0)">Sim Users list @if(!empty($activationData->fullname))of {{$activationData->fullname}}@endif</a>
                        </li>
                        </ul>
                        
                    </header>

                    <div class="panel-body">
                        <section id="unseen">
                            <table class="table table-bordered table-striped table-condensed my_table">
                                <thead>

                       <tr>
    <td class="numeric">Full Name</td>
    <td class="numeric">{{ $activationData->fullname }}</td>  
     <td class="numeric">Action</td>  
  </tr>
      <tr>
    <td class="numeric">Visa Image</td>
     <?php $visaImagePath='../../uploads/visa_image/'.$activationData->visa_image; ?>
                                   @if(!empty($activationData->visa_image))
                                    <td class="numeric"><a href="{{$visaImagePath}}" onclick="return hs.expand(this)"  class="highslide"><img src="{{$visaImagePath}}" id="img-rotate1" class="img-responsive north" style="max-width:200px; max-height:200px;" /></a><input type="button" class="btn btn-success rotate" value="Rotate"></td>
                                    @else
                                    <td class="numeric"><a href="{{URL::asset('public/cms/images/images.jpg')}}" onclick="return hs.expand(this)" class="highslide"><img src="{{URL::asset('public/cms/images/images.jpg')}}" id="img-rotate1" class="img-responsive north"/></a><input type="button" class="btn btn-success rotate" value="Rotate"></td>
                                    @endif 
                                    <td class="numeric"><a href="#myModal" data-toggle="modal" class="btn btn-danger">Edit</a></td>
                                                          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Edit Visa Image</h4>
                                    </div>
                                    <div class="modal-body">

                                        {!! Form::open(array('url' => PREFIX.'/activation/edit', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                            <input type="hidden" name="editid" value="<?php echo $activationData->id?>">  
                                            <div class="form-group">
                                                <label for="visaimage">Visa Image</label>
                                                <input type="file"  class="form-control" id="exampleInputEmail3" name="visa_image">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                       {!! Form::close()!!}
                                    </div>
                                </div>
                            </div>
                        </div>
  </tr>
  <tr>
    <td class="numeric">Passport Image 1</td>
<?php $passportImagePath='../../uploads/passport_image/image1/'.$activationData->passport_image_1; ?>
          @if(!empty($activationData->passport_image_1))
          <td class="numeric"> <a href="{{$passportImagePath}}" onclick="return hs.expand(this)" class="highslide"><img src="{{$passportImagePath}}" id="img-rotate2" class="img-responsive north" style="max-width:200px;"/></a><input type="button" class="btn btn-success rotate1" value="Rotate"></td>
           @else
              <td class="numeric"><a href="{{URL::asset('public/cms/images/images.jpg')}}" onclick="return hs.expand(this)" class="highslide"><img src="{{URL::asset('public/cms/images/images.jpg')}}" id="img-rotate2" class="img-responsive north"/></a><input type="button" class="btn btn-success rotate1" value="Rotate"></td> 
          @endif
           <td class="numeric"><a href="#myModal1" data-toggle="modal" class="btn btn-danger
           ">Edit</a></td>
                                                      <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal1" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Edit Passport Image 1</h4>
                                    </div>
                                    <div class="modal-body">

                                        {!! Form::open(array('url' => PREFIX.'/activation/editpassportimage', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                           <input type="hidden" name="editid" value="<?php echo $activationData->id?>">  
                                            <div class="form-group">
                                                <label for="passportimage1">Passport Image 1</label>
                                                <input type="file"  class="form-control" id="exampleInputEmail3" name="passport_image_1">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                       {!! Form::close()!!}
                                    </div>
                                </div>
                            </div>
                        </div>
  </tr>
  <tr>
    <td class="numeric">Passport Image 2</td>
<?php $passportImage2Path='../../uploads/passport_image/image2/'.$activationData->passport_image_2; ?>
          @if(!empty($activationData->passport_image_2))
          <td class="numeric"><a href="{{$passportImage2Path}}" onclick="return hs.expand(this)" class="highslide"> <img src="{{$passportImage2Path}}"id="img-rotate3" class="img-responsive north" style="max-width:200px;"/></a><input type="button" class="btn btn-success rotate2" value="Rotate"></td>
           @else
              <td class="numeric"><a href="{{URL::asset('public/cms/images/images.jpg')}}" onclick="return hs.expand(this)" class="highslide"><img src="{{URL::asset('public/cms/images/images.jpg')}}"id="img-rotate3" class="img-responsive north"/></a><input type="button" class="btn btn-success rotate2" value="Rotate"></td> 
          @endif
           <td class="numeric"><a href="#myModal2" data-toggle="modal" class="btn btn-danger">Edit</a></td>
                            <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal2" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Edit Passport Image 2</h4>
                                    </div>
                                    <div class="modal-body">

                                        {!! Form::open(array('url' => PREFIX.'/activation/editpassportimage2', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                           <input type="hidden" name="editid" value="<?php echo $activationData->id?>">  
                                            <div class="form-group">
                                                <label for="visaimage">Passport Image 2</label>
                                                <input type="file"  class="form-control" id="exampleInputEmail3" name="passport_image_2">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                       {!! Form::close()!!}
                                    </div>
                                </div>
                            </div>
                        </div>
  </tr>
<tr>
    <td class="numeric">Country Id Image 1</td>
<?php $countryImagePath='../../uploads/country_image/image1/'.$activationData->country_id_image_1; ?>
          @if(!empty($activationData->country_id_image_1))
          <td class="numeric"><a href="{{$countryImagePath}}" onclick="return hs.expand(this)" class="highslide"> <img src="{{$countryImagePath}}"id="img-rotate4" class="img-responsive north" style="max-width:200px;"/></a><input type="button" class="btn btn-success rotate3" value="Rotate"></td>
           @else
              <td class="numeric"><a href="{{URL::asset('public/cms/images/images.jpg')}}" onclick="return hs.expand(this)" class="highslide"><img src="{{URL::asset('public/cms/images/images.jpg')}}"id="img-rotate4" class="img-responsive north"/></a><input type="button" class="btn btn-success rotate3" value="Rotate"></td> 
          @endif
          <td class="numeric"><a href="#myModal3" data-toggle="modal" class="btn btn-danger">Edit</a></td>
 <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal3" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Edit Country Id Image 1</h4>
                                    </div>
                                    <div class="modal-body">

                                        {!! Form::open(array('url' => PREFIX.'/activation/editcountryimage1', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                            <input type="hidden" name="editid" value="<?php echo $activationData->id?>"> 
                                            <div class="form-group">
                                                <label for="visaimage">Country Id Image 1</label>
                                                <input type="file"  class="form-control" id="exampleInputEmail3" name="country_id_image_1">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                       {!! Form::close()!!}
                                    </div>
                                </div>
                            </div>
                        </div>
 </tr>
       <tr>
    <td class="numeric">Country Id Image 2</td>
<?php $countryImage2Path='../../uploads/country_image/image2/'.$activationData->country_id_image_2; ?>
          @if(!empty($activationData->country_id_image_2))
          <td class="numeric"> <a href="{{$countryImage2Path}}" onclick="return hs.expand(this)" class="highslide"><img src="{{$countryImage2Path}}"id="img-rotate5" class="img-responsive north" style="max-width:200px;"/></a><input type="button" class="btn btn-success rotate4" value="Rotate"></td>
           @else
              <td class="numeric"><a href="{{URL::asset('public/cms/images/images.jpg')}}" onclick="return hs.expand(this)" class="highslide"><img src="{{URL::asset('public/cms/images/images.jpg')}}"id="img-rotate5" class="img-responsive north"/></a><input type="button" class="btn btn-success rotate4" value="Rotate"></td> 
          @endif
           <td class="numeric"><a href="#myModal4" data-toggle="modal" class="btn btn-danger">Edit</a></td>
  <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal4" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Edit Country Id Image 2</h4>
                                    </div>
                                    <div class="modal-body">

                                        {!! Form::open(array('url' => PREFIX.'/activation/editcountryimage2', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                            <input type="hidden" name="editid" value="<?php echo $activationData->id?>"> 
                                            <div class="form-group">
                                                <label for="visaimage">Country Id Image 2</label>
                                                <input type="file"  class="form-control" id="exampleInputEmail3" name="country_id_image_2">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                       {!! Form::close()!!}
                                    </div>
                                </div>
                            </div>
                        </div>
 </tr>
  </tr>
       <tr>
    <td class="numeric">Form Image</td>
<?php $formImage='../../uploads/form/'.$activationData->form_image; ?>
          @if(!empty($activationData->form_image))
          <td class="numeric"> <a href="{{$formImage}}" onclick="return hs.expand(this)" class="highslide"><img src="{{$formImage}}"id="img-rotate6" class="img-responsive north" style="max-width:200px;"/></a><input type="button" class="btn btn-success rotate5" value="Rotate"></td>
           @else
              <td class="numeric"><a href="{{URL::asset('public/cms/images/images.jpg')}}" onclick="return hs.expand(this)" class="highslide"><img src="{{URL::asset('public/cms/images/images.jpg')}}"id="img-rotate6" class="img-responsive north"/></a><input type="button" class="btn btn-success rotate5" value="Rotate"></td> 
          @endif
           <td class="numeric"><a href="#myModal5" data-toggle="modal" class="btn btn-danger">Edit</a></td>
  <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal5" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Edit Form Image</h4>
                                    </div>
                                    <div class="modal-body">

                                        {!! Form::open(array('url' => PREFIX.'/activation/editformimage', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                           <input type="hidden" name="editid" value="<?php echo $activationData->id?>"> 
                                            <div class="form-group">
                                                <label for="visaimage">Form Image</label>
                                                <input type="file"  class="form-control"  name="form_image">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                       {!! Form::close()!!}
                                    </div>
                                </div>
                            </div>
                        </div>
 </tr>
  </tr>
       <tr>
    <td class="numeric">Sim Image</td>
<?php $simImage='../../uploads/sim_image/'.$activationData->sim_image; ?>
          @if(!empty($activationData->sim_image))
          <td class="numeric"><a href="{{$simImage}}" onclick="return hs.expand(this)" class="highslide"> <img src="{{$simImage}}"id="img-rotate7" class="img-responsive north" style="max-width:200px;"/></a><input type="button" class="btn btn-success rotate6" value="Rotate"></td>
           @else
              <td class="numeric"><a href="{{URL::asset('public/cms/images/images.jpg')}}" onclick="return hs.expand(this)" class="highslide"><img src="{{URL::asset('public/cms/images/images.jpg')}}"id="img-rotate7" class="img-responsive north"/></a><input type="button" class="btn btn-success rotate6" value="Rotate"></td> 
          @endif
           <td class="numeric"><a href="#myModal6" data-toggle="modal" class="btn btn-danger">Edit</a></td>
  <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal6" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Edit Sim Image</h4>
                                    </div>
                                    <div class="modal-body">

                                        {!! Form::open(array('url' => PREFIX.'/activation/editsimimage', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                           <input type="hidden" name="editid" value="<?php echo $activationData->id?>"> 
                                            <div class="form-group">
                                                <label for="visaimage">Sim Image</label>
                                                <input type="file"  class="form-control" id="exampleInputEmail3" name="sim_image">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                       {!! Form::close()!!}
                                    </div>
                                </div>
                            </div>
                        </div>
 </tr>
  </tr>
       <tr>
    <td class="numeric">User Image</td>
<?php $userImage='../../uploads/user_image/'.$activationData->user_image; ?>
          @if(!empty($activationData->user_image))
          <td class="numeric"> <a href="{{$userImage}}" onclick="return hs.expand(this)" class="highslide"><img src="{{$userImage}}"id="img-rotate8" class="img-responsive north" /></a><input type="button" class="btn btn-success rotate7" value="Rotate"></td>
           @else
              <td class="numeric"><a href="{{URL::asset('public/cms/images/images.jpg')}}" onclick="return hs.expand(this)" class="highslide"><img src="{{URL::asset('public/cms/images/images.jpg')}}"id="img-rotate8" class="img-responsive north"/></a><input type="button" class="btn btn-success rotate7" value="Rotate"></td> 
          @endif
           <td class="numeric"><a href="#myModal7" data-toggle="modal" class="btn btn-danger ">Edit</a></td>
  <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal7" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Edit User Image</h4>
                                    </div>
                                    <div class="modal-body">

                                        {!! Form::open(array('url' => PREFIX.'/activation/edituserimage', 'method'=>'POST', 'class'=>'cmxform form-horizontal', 'id'=>'commentForm','files'=>true)) !!}
                                            <input type="hidden" name="editid" value="<?php echo $activationData->id?>"> 
                                            <div class="form-group">
                                                <label for="visaimage">User Image</label>
                                                <input type="file"  class="form-control" id="exampleInputEmail3" name="user_image">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                       {!! Form::close()!!}
                                    </div>
                                </div>
                            </div>
                        </div>
 </tr>
  </tr>
                                </tbody>
                            </table>
                        </section>
                         <!-- Modal -->
  
                        <ul class="pagination">
                            {!! str_replace('/?', '?', $adminData->render()) !!}
                        </ul>
                    </div>
                </section>
            </div>
        </div>
        
<!-- page end-->
{!! Html::script('public/cms/sm-function/jsFunction.js')!!}

@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
$('.rotate').click(function(){
    var img = $('#img-rotate1');
    if(img.hasClass('north')){
        img.attr('class','west');
    }else if(img.hasClass('west')){
        img.attr('class','south');
    }else if(img.hasClass('south')){
        img.attr('class','east');
    }else if(img.hasClass('east')){
        img.attr('class','north');
    }
});
$('.rotate1').click(function(){
    var img = $('#img-rotate2');
    if(img.hasClass('north')){
        img.attr('class','west');
    }else if(img.hasClass('west')){
        img.attr('class','south');
    }else if(img.hasClass('south')){
        img.attr('class','east');
    }else if(img.hasClass('east')){
        img.attr('class','north');
    }
});
$('.rotate2').click(function(){
    var img = $('#img-rotate3');
    if(img.hasClass('north')){
        img.attr('class','west');
    }else if(img.hasClass('west')){
        img.attr('class','south');
    }else if(img.hasClass('south')){
        img.attr('class','east');
    }else if(img.hasClass('east')){
        img.attr('class','north');
    }
});
$('.rotate3').click(function(){
    var img = $('#img-rotate4');
    if(img.hasClass('north')){
        img.attr('class','west');
    }else if(img.hasClass('west')){
        img.attr('class','south');
    }else if(img.hasClass('south')){
        img.attr('class','east');
    }else if(img.hasClass('east')){
        img.attr('class','north');
    }
});
$('.rotate4').click(function(){
    var img = $('#img-rotate5');
    if(img.hasClass('north')){
        img.attr('class','west');
    }else if(img.hasClass('west')){
        img.attr('class','south');
    }else if(img.hasClass('south')){
        img.attr('class','east');
    }else if(img.hasClass('east')){
        img.attr('class','north');
    }
});
$('.rotate5').click(function(){
    var img = $('#img-rotate6');
    if(img.hasClass('north')){
        img.attr('class','west');
    }else if(img.hasClass('west')){
        img.attr('class','south');
    }else if(img.hasClass('south')){
        img.attr('class','east');
    }else if(img.hasClass('east')){
        img.attr('class','north');
    }
});
$('.rotate6').click(function(){
    var img = $('#img-rotate7');
    if(img.hasClass('north')){
        img.attr('class','west');
    }else if(img.hasClass('west')){
        img.attr('class','south');
    }else if(img.hasClass('south')){
        img.attr('class','east');
    }else if(img.hasClass('east')){
        img.attr('class','north');
    }
});
$('.rotate7').click(function(){
    var img = $('#img-rotate8');
    if(img.hasClass('north')){
        img.attr('class','west');
    }else if(img.hasClass('west')){
        img.attr('class','south');
    }else if(img.hasClass('south')){
        img.attr('class','east');
    }else if(img.hasClass('east')){
        img.attr('class','north');
    }
});
});
</script>

