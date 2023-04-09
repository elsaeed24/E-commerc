<x-dashboard-layout title="Categories">

{{-- @extends('layouts.dashboard')

@section('title', 'Categories')

@section('content') --}}

<!-- Page Heading -->
{{-- <h1 class="h3 mb-2 text-gray-800">Categories</h1> --}}
{{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p> --}}

        {{-- <x-alert type='success'/>
        <x-alert type='info'/> --}}


        <div x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => showMessage = false, 3000)">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h3 style="display: inline-block;" class="m-0 font-weight-bold">Categories</h3>
        @can('create', App\Models\Category::class)
        <a  href="{{ route('categories.create') }}" class="btn btn-lg btn-outline-primary ml-2">Create</a>
        @endcan
        @can('create', App\Models\Category::class)
        <a  href="{{ route('categories.trash') }}" class="btn btn-lg btn-outline-warning ml-2">Trash</a>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">

            {{-- <form action="{{ URL::current() }}" method="get" class="d-flex mb-4">
                <input type="text" name="name" class="form-control me-2" placeholder="Search by name">
                <select name="parent_id" class="form-control me-2">
                    <option value="">All Categories</option>
                    @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form> --}}

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Parent Name</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td><a href="{{ route('categories.edit', $category->id)}}">{{$category->name}}</a></td>
                        <td>{{ $category->parent->name }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>{{ $category->status }}</td>
                        <td>
                            @can('delete', $category)
                            <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                @csrf
                                {{-- from method spoofing --}}
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>

                            </form>
                            @endcan
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="6">No Categories Defined.</td>
                    </tr>

                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>



<script src="//unpkg.com/alpinejs" defer></script>

{{-- @endsection --}}

</x-dashboard-layout>


