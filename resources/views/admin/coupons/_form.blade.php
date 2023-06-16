

<div class="form-group mb-3">
    <label for="">Name:</label>
    <input type="text" name="name" value="{{ old('name', $coupon->name) }}" class="form-control @error('name') is-invalid @enderror">
    @error('name')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="">Code:</label>
    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="form-control @error('code') is-invalid @enderror">
    @error('code')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="">Description:</label>
    <textarea name="discription" class="form-control @error('discription') is-invalid @enderror">{{ old('discription', $coupon->discription) }}</textarea>
    @error('discription')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>


<div class="form-group mb-3">
    <label for="">Discount:</label>
    <input type="number" name="discount" value="{{ old('discount', $coupon->discount) }}" class="form-control @error('discount') is-invalid @enderror">
    @error('discount')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>


<div class="form-group mb-3">
    <label for="">Type</label>
   <div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="type" value="fixed" @if (old('type', $coupon->type) == 'fixed') checked @endif  >
        <label class="form-check-label" >
         Fixed
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="type"  value="percent" @if (old('type', $coupon->type) == 'percent') checked @endif >
        <label class="form-check-label" >
            Percent
        </label>
      </div>



      <div class="form-group">
        <label for="">Start At</label>
        <input type="date" name="start_at" value="{{ old('start_at', $coupon->start_at) }}" class="form-control @error('start_at') is-invalid @enderror">
        @error('start_at')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Expired At</label>
        <input type="date" name="expir_at" value="{{ old('expir_at', $coupon->expir_at) }}" class="form-control @error('expir_at') is-invalid @enderror">
        @error('expir_at')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

   </div>
   @error('type')
   <p class="invalid-feedback d-block">{{ $message }}</p>
@enderror
 </div>



<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>


@push('css')
<link rel="stylesheet" href="{{ asset('dashboard/assets/js/tagify/tagify.css') }}">
@endpush

@push('js')
{{-- <form action="" method="post" id="deleteGallery" class="d-none">
@csrf
<input type="hidden" name="id" id="imageId">
</form> --}}
<script src="{{ asset('dashboard/assets/js/tagify/tagify.min.js') }}"></script>
<script>
var inputElm = document.querySelector('.tags'),
    tagify = new Tagify (inputElm);
// function deleteImage(id) {
//     document.querySelector('#imageId').value = id;
//     document.querySelector('#deleteGallery').submit();
// }
</script>
@endpush




