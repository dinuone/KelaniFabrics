@extends('layout.app')

@section('title', 'delivery-create')

@section('css')
@endsection


@section('content')
  <h1>Create</h1>
<form action="{{(isset($delivery))?route('delivery.update',$delivery->id):route('delivery.store')}}" method="POST">
  @csrf
  @method((isset($delivery))?'PATCH':'POST')
  <div class="row nb-5">
      <div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <input type="text" class="form-control @error("status") is-invalid @enderror" id="status" name="status" value="{{old('status',$delivery->status ?? '')}}">
        <span class="test-danger">@error("status"){{$message}}@enderror</span>
      </div>
  </div>

  <button type="submit" class="btn btn-primary w-100">Submit</button>
</form>
</div>
@endsection

@section('js')
@endsection






