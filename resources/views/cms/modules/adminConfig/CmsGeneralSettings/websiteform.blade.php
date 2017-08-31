
<div class="col-lg-12">

  {!! Form::label('website_name','Website Name:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('website_name',$generalSettings['website_name'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">
  <div class="col-lg-4">
    {!! Form::label('website_title','Website Title:',['class'=>'control-label']) !!}
    <p>Max character allowed is 80 for website title.</p>
  </div>
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('website_title',$generalSettings['website_title'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">
  <div class="col-lg-4">
    {!! Form::label('website_keywords','Website Keywords:',['class'=>'control-label']) !!}
    <p>Only characters from A-Z,0-9,comma and full-stop are allowed,character limit is upto 155.</p>
  </div>

   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('website_keywords',$generalSettings['website_keywords'],['class'=>'form-control','id'=>'website_keywords']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">
  <div class="col-lg-4">
    {!! Form::label('website_meta_desc','Website Meta description:',['class'=>'control-label']) !!}
    <p>Only characters from A-Z,0-9,comma and full-stop are allowed,character limit is upto 155.</p>
  </div>
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::textarea('website_meta_desc',$generalSettings['website_meta_desc'],['class'=>'form-control','id'=>'website_meta_desc']) !!}
     </div>
   </div>
</div>






