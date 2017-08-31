
<div class="col-lg-12">

  {!! Form::label('og_title','OG Title:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('og_title',$generalSettings['og_title'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('og_site_name','OG Site name:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('og_site_name',$generalSettings['og_site_name'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('og_url','OG URL:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('og_url',$generalSettings['og_url'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('og_type','OG Type:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('og_type',$generalSettings['og_type'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('fb_app_id','FB App ID:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('fb_app_id',$generalSettings['fb_app_id'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('og_description','OG description:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::textarea('og_description',$generalSettings['og_description'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">
  {!! Form::label('og_image','OG Image:',['class'=>'control-label col-lg-4']) !!}
  <div class="col-lg-8">
     <div class="form-group">
          {!! Form::file('og_image',['class'=>'form-control']) !!}
     </div>
   </div>
</div>

@if($generalSettings['og_image'] == "")
<div class="col-lg-12">
  <div class="col-lg-4"></div>
  <div class="col-lg-8"></div>
</div>
@else
<div class="col-lg-12">
  <div class="col-lg-4"></div>
  <div class="col-lg-4">
      <img src="{{asset('uploads')}}/settings/og_image/{{$generalSettings['og_image']}}">
  </div>
  </div>
@endif






