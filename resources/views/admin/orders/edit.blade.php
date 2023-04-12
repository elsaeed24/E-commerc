<x-dashboard-layout title="Orders">



        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 style="display: inline-block;" class="m-0 font-weight-bold">Edit Status Order</h3>

            </div>
            <div class="card-body">

                <form action="{{ route('orders.update', $order->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')


                <div class="form-group mb-3">
                    <label for="">User Name</label>
                    <input type="text" name="user_id" value="{{ $order->user->name }}"
                        class="form-control @error('user_id') is-invalid @enderror" readonly>
                    @error('user_id')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="">Phone</label>
                    <input type="text" name="phone" value="{{ $order->phone }}"
                        class="form-control @error('phone') is-invalid @enderror" readonly>
                    @error('phone')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Status</label>
                   <div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="active" @checked($order->status == "active") >
                        <label class="form-check-label" >
                          Active
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="status"  value="inactive" @checked($order->status == "inactive")>
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>





                </form>
            </div>
        </div>

    {{-- @endsection --}}

    </x-dashboard-layout>
