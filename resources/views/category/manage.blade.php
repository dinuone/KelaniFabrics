@extends('layout.app')

@section('title', 'category-create')

@section('css')
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="fs-2">Create</h1>
        </div>
    </div>
    <form action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }}" method="POST">
        @csrf
        @method(isset($category) ? 'PATCH' : 'POST')
        <div class="card mt-3">
            <div class="card-body">
                <div class="row my-5">
                    <div class="col-md-2">
                        <label for="catName" class="form-label">Category Name</label>

                    </div>
                    <div class="col-md-4">

                        <input type="text" class="form-control @error('catName') is-invalid @enderror" id="catName"
                            name="catName" value="{{ old('catName', $category->cat_name ?? '') }}">
                        <span class="test-danger">
                            @error('catName')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="catStatus" id="inlineRadio1"
                                value="1" checked>
                            <label class="form-check-label" for="inlineRadio1">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="catStatus" id="inlineRadio2"
                                value="0">
                            <label class="form-check-label" for="inlineRadio2">Deactive</label>
                        </div>
                    </div>
                    <div class="col-md-12 vstack gap-2 p-2">
                        <button type="submit" class="btn btn-primary mx-auto">Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
    </div>
@endsection

@section('js')
@endsection
