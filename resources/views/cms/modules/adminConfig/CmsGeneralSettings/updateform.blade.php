


<div class="col-lg-12">
  {!! Form::label('status','Status:',['class'=>'control-label col-lg-4']) !!}
  <div class="col-lg-3">
      <div class="form-group">
          {!! Form::select('status',['active'=>'Active','inactive'=>'Inactive'],'',['class'=>'form-control','id'=>'field']) !!}
      </div>
    </div>
</div>



<div class="col-lg-12">
     <div class="form-group">
      <div class="col-lg-4">
          &nbsp;
      </div>
     </div>

     <div class="form-group">
      <div class="col-lg-2">
          {!!Form::submit($submitText,['class'=>'btn btn-primary form-control']) !!}
      </div>
     </div>

     <div class="form-group">
      <div class="col-lg-4">
          &nbsp;
      </div>
     </div>
</div>