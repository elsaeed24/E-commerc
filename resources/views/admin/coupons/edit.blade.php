<x-dashboard-layout title="Coupons">





    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 style="display: inline-block;" class="m-0 font-weight-bold">Edit Discount Coupon</h3>

        </div>
        <div class="card-body">

            <form action="{{ route('coupons.update', $coupon->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                @include('admin.coupons._form',[
                    'button_label' => 'Update'
                ])


            </form>
        </div>
    </div>

{{-- @endsection --}}

</x-dashboard-layout>



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
{{--
                <div class="form-group mb-3">
                    <label for="">Name:</label>
                    <input type="text" name="name" value="{{ $category->name }}"
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
                            <option value="{{ $parent->id }}" @selected($parent->id == $category->parent_id)  >{{ $parent->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Description:</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ $category->description }}</textarea>
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
                        <input class="form-check-input" type="radio" name="status" value="active" @checked($category->status == "active") >
                        <label class="form-check-label" >
                          Active
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="status"  value="inactive" @checked($category->status == "inactive")>
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
                </div> --}}
