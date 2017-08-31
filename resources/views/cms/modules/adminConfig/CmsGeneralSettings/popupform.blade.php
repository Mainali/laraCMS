<div class="col-lg-12">
  {!! Form::label('homepage_popup','Homepage Popup:',['class'=>'control-label col-lg-4']) !!}
  <div class="col-lg-3">
      <div class="form-group">
          {!! Form::select('homepage_popup',['no'=>'Inactive','yes'=>'Active'],$generalSettings['homepage_popup'],['class'=>'form-control','id'=>'field']) !!}
      </div>
    </div>
</div>


<div class="col-lg-12">

  {!! Form::label('homepage_popup_title','Popup title:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('homepage_popup_title',$generalSettings['homepage_popup_title'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('homepage_popup_description','Popup Description:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::textarea('homepage_popup_description',$generalSettings['homepage_popup_description'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('homepage_popup_link','Popup link:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('homepage_popup_link',$generalSettings['homepage_popup_link'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">
  {!! Form::label('homepage_popup_image','Popup Image:',['class'=>'control-label col-lg-4']) !!}
  <div class="col-lg-8">
     <div class="form-group">
          {!! Form::file('homepage_popup_image',['class'=>'form-control']) !!}
     </div>
   </div>
</div>

@if($generalSettings['homepage_popup_image'] == "")
<div class="col-lg-12">
  <div class="col-lg-4"></div>
  <div class="col-lg-8"></div>
</div>
@else
<div class="col-lg-12">
  <div class="col-lg-4"></div>
  <div class="col-lg-4">
      <img src="{{asset('uploads')}}/settings/homepage_popup_image/{{$generalSettings['homepage_popup_image']}}">
  </div>
  </div>
@endif