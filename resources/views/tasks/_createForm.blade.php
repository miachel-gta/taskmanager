{!! Form::open(['route'=>'tasks.store', 'method'=>'POST']) !!}
    <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-plus"></i></div>
        </div>

        {!! Form::hidden('project', $project->id) !!}

        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'你有什么要完成的具体任务吗?']) !!}
      </div>
      {!! $errors->create->first('name', '<div class="alert alert-danger">:message</div>') !!}
      {!! $errors->create->first('project', '<div class="alert alert-danger">:message</div>') !!}
{!! Form::close() !!}
