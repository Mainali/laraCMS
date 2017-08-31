<div class="col-lg-12">
  {!! Form::label('maintenance_mode','Maintenance Mode:',['class'=>'control-label col-lg-4']) !!}
  <div class="col-lg-3">
      <div class="form-group">
          {!! Form::select('maintenance_mode',['no'=>'Inactive','yes'=>'Active'],$generalSettings['maintenance_mode'],['class'=>'form-control','id'=>'field']) !!}
      </div>
    </div>
</div>


<div class="col-lg-12">

  {!! Form::label('maintenance_content','Maintenance Content:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::textarea('maintenance_content',$generalSettings['maintenance_content'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('google_analytics_code','Google Analytics Code:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('google_analytics_code',$generalSettings['google_analytics_code'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>
