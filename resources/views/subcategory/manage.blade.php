@extends('layout.app')

@section('title', 'sub_category-create')
@section('css')
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="fs-2">Create</h1>
        </div>
    </div>
    <form action="{{ isset($sub_category) ? route('sub_category.update', $sub_category->id) : route('sub_category.store') }}"
        method="POST">
        @csrf
        @method(isset($sub_category) ? 'PATCH' : 'POST')
        <div class="card mt-3">
            <div class="card-body">
                <div class="row my-5">
                    <div class="col-md-3">
                        <label for="type" class="form-label">Category Name</label>
                    </div>
                    <div class="col-md-3">
                       <select class="form-control @error('catName') is-invalid @enderror"  name="catName" id="catName">
                            <option value="" disabled {{ old('catName', $sub_category->cat_id ?? '') == '' ? 'selected' : '' }}>Select category</option>
                            @foreach ($category as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('catName', $sub_category->cat_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->cat_name }}
                                </option>
                            @endforeach
                        </select>

                        <span class="text-danger">
                            @error('catName')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-3">
                        <label for="catName" class="form-label">Sub Category Name</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control @error('subCatName') is-invalid @enderror" id="subCatName"
                            name="subCatName" value="{{ old('subCatName', $sub_category->sub_cat_name ?? '') }}">
                        <span class="text-danger">
                            @error('subCatName')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row md-5">
                    <div class="col-md-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="subCatStatus" id="inlineRadio1"
                                value="1" checked>
                            <label class="form-check-label" for="inlineRadio1">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="subCatStatus" id="inlineRadio2"
                                value="0">
                            <label class="form-check-label" for="inlineRadio2">Deactive</label>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-md-12 vstack gap-2 p-2">
                    <button type="submit" class="btn btn-primary mx-auto">Submit</button>
                </div>
            </div>
        </div>
    </form>


@endsection

@section('js')
@endsection
