<div class="col-lg-12">

  {!! Form::label('facebook_embed','Facebook Embed:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::textarea('facebook_embed',$generalSettings['facebook_embed'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('facebook_url','Facebook URL:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('facebook_url',$generalSettings['facebook_url'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('twitter_embed','Twitter Embed:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::textarea('twitter_embed',$generalSettings['twitter_embed'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>


<div class="col-lg-12">

  {!! Form::label('twitter_url','Twitter URL:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('twitter_url',$generalSettings['twitter_url'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

<div class="col-lg-12">

  {!! Form::label('youtube_url','Youtube URL:',['class'=>'control-label col-lg-4']) !!}
   <div class="col-lg-8">
     <div class="form-group">
        
          {!! Form::text('youtube_url',$generalSettings['youtube_url'],['class'=>'form-control']) !!}
     </div>
   </div>
</div>

