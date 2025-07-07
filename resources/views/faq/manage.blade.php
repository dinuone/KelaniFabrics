
@extends('layout.app')

@section('title', 'employee-create')

@section('css')
@endsection


@section('content')
  <h1>Create</h1>
<form action="{{(isset($employee))?route('employee.update',$employee->id):route('employee.store')}}" method="POST">
  @csrf
  @method((isset($employee))?'PATCH':'POST')
  <div class="row nb-5">
    <div class="col-md-6">
        <label for="topic" class="form-label">Topic</label>
        <input type="text" class="form-control @error("topic") is-invalid @enderror" id="topic" name="topic" value="{{old('topic',$employee->topic ?? '')}}">
        <span class="test-danger">@error("topic"){{$message}}@enderror</span>
      </div>
      <div class="col-md-6">
        <label for="comment" class="form-label">Comment</label>
        <input type="text" class="form-control @error("comment") is-invalid @enderror" id="comment" name="comment" value="{{old('comment',$employee->comment ?? '')}}">
        <span class="test-danger">@error("comment"){{$message}}@enderror</span>
      </div>
      <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control @error("email") is-invalid @enderror" id="email" name="email" value="{{old('email',$employee->email ?? '')}}">
        <span class="test-danger">@error("email"){{$message}}@enderror</span>
      </div>
  </div>

  <button type="submit" class="btn btn-primary w-100">Submit</button>
</form>
</div>
@endsection

@section('js')
@endsection





