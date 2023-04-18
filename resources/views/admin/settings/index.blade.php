<x-dashboard-layout title="Settings">

    <form action="{{ route('settings.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            {{-- <div class="card-header py-3">
                <h3 style="display: inline-block;" class="m-0 font-weight-bold">Add Product</h3>

            </div> --}}
            <div class="card-body">
                {{-- @foreach ($settings as $name => $setting ) --}}
                <div class="from-group">
                    {{-- @if ($setting['type'] == 'select') --}}
              {{-- <x-form.select :label="$setting['label']" :name="$name" :selected="config($name)" :options="$setting['options']" /> --}}
                    {{-- @endif --}}

                    {{-- <x-form.input :label="$setting['label']"  :name="$name" :value="config($name)"/> --}}


                        <label for="">{{ $settings['label']  }}</label>
                        <input type="text" name="{{ $settings['label'] }}" value="{{ $settings['label']}}">


                </div>


                {{-- @endforeach --}}







            </div>
        </div>

    </form>


    </x-dashboard-layout>
