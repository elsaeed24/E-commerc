<x-dashboard-layout title="Orders">

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
            <h3 style="display: inline-block;" class="m-0 font-weight-bold">Orders</h3>
            {{-- @can('create', App\Models\Product::class) --}}
            {{-- <a  href="{{ route('orders.create') }}" class="btn btn-lg btn-outline-primary ml-2">Create</a>
            @endcan --}}
            {{-- @can('create', App\Models\Product::class) --}}
            <a  href="{{ route('orders.trash') }}" class="btn btn-lg btn-outline-warning ml-2">Trash</a>
            {{-- @endcan --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">


                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Address </th>
                            <th>Phone</th>
                            <th>Total </th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td><a href="{{ route('orders.edit', $order->id)}}">{{$order->user->name}}</a></td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->total }}</td>
                            <td><button class="btn btn-sm btn-primary">{{ $order->status }}</button></td>
                            <td>{{ $order->created_at }}</td>

                            <td>
                                {{-- @if (Auth::guard('store')->user()->can('delete', $order))     --}}
                                {{-- @can('delete', $order) --}}

                                <form action="{{ route('orders.destroy', $order->id) }}" method="post">
                                    @csrf
                                    {{-- from method spoofing --}}
                                    @method('delete')
                                    <button type="submit"  class="btn btn-sm btn-danger">Delete</button>

                                </form>
                                {{-- @endif --}}

                                {{-- @endcan --}}
                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="6">No Orders Defined.</td>
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


