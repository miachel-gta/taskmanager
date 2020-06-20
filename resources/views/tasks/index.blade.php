@extends('layouts.app')

@section('content')
    <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="todo" aria-selected="true">待办事项</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="done" aria-selected="false">已完成</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    @if(count($todos))
        <table class="table table-striped">
            @foreach($todos as $task)
                <tr>
                    <td class="col-9 pl-5">{{ $task->name }}</td>
                    <td>@include('tasks._checkForm')</td>
                    <td>@include('tasks._editModal')</td>
                    <td>@include('tasks._deleteForm')</td>
                </tr>
            @endforeach
        </table>
        <div class="pull-right">
            {{ $todos->links() }}
        </div>
    @endif

  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
     @if(count($dones))
        @foreach($dones as $task)
        <table class="table table-striped">
            <tr>
                <td>{{ $task->name }}</td>
            </tr>
        </table>
        @endforeach
        <div class="pull-right">
                {{ $todos->links() }}
        </div>
    @endif
  </div>
</div>

@endsection
