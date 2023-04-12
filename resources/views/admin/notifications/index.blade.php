<x-dashboard-layout title="Notifications">

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
            <h3 style="display: inline-block;" class="m-0 font-weight-bold">Notifications</h3>
        </div>
      {{--  <div class="card-body">
            <div class="table-responsive">

                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <!-- Counter - Alerts -->
                        <span class="badge badge-danger badge-counter">{{ $NewCountNotification }}</span>
                    </a>
                    <!-- Dropdown - Alerts -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header">
                            {{ $NewCountNotification }} Notifications
                        </h6>
                        @foreach($notifications as $notification)
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="{{ $notification->data['icon'] }}"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $notification->created_at->longAbsoluteDiffForHumans() }}</div>
                                <span class="font-weight-bold">{{ $notification->data['body'] }}</span>
                            </div>
                        </a>
                        @endforeach

                        <a class="dropdown-item text-center small text-gray-500" href="#">Show All Notifications</a>
                    </div>
                </li>

            </div>
        </div> --}}

        <div>
            @foreach ($notifications as $notification)
            <div class="card my-2">
                <a href="{{ $notification->data['action'] }}?notify_id={{ $notification->id }}">
                    <div class="card-body {{ $notification->unread()? 'bg-light fw-bold' : '' }}">
                        <h4>{{ $notification->data['title'] }}</h4>
                    </a>
                        <p>{{ $notification->data['body'] }}</p>
                        <p class="text-muted">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>

            </div>
            @endforeach
        </div>
    </div>




    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- @endsection --}}

    </x-dashboard-layout>


