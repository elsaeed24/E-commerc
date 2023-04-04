@extends('layouts.dashboard')

@section('title', 'Categories')

@section('content')

    <!-- Page Heading -->
    {{-- <h1 class="h3 mb-2 text-gray-800">Categories</h1> --}}
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p> --}}



    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 style="display: inline-block;" class="m-0 font-weight-bold">Add Category</h3>

        </div>
        <div class="card-body">

            <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <h3>Error Occured!</h3>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                <div class="form-group mb-3">
                    <label for="">Name:</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Parent:</label>
                    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="">No Parent</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}" >{{ $parent->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Description:</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Image:</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                   <div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="active" >
                        <label class="form-check-label" >
                          Active
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="status"  value="inactive">
                        <label class="form-check-label" >
                          Inactive
                        </label>
                      </div>
                   </div>
                   @error('status')
                   <p class="invalid-feedback">{{ $message }}</p>
               @enderror

                 </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>


            </form>



        </div>
    </div>

@endsection
