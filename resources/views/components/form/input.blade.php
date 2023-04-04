@props([
    'type' => 'text' ,     // default for type is text
    'name' ,
    'value' =>  '',
    'label' => ""
])

@if ($label)

<label for="">{{ $label }}</label>

@endif

<input type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name,$value) }}"
        {{ $attributes->class([    // $attribute print all attr except props
            'form-control',
            'is-invalid' => $errors->has($name)
        ]) }}
>

            {{-- @if($errors->has('name'))
            <div class="text-danger">
                {{ $errors->first('name') }}
            </div>
            @endif --}}

            {{-- @class([   derictive
                'form-control',
                'is-invalid' => $errors->has($name)
            ]) --}}

 @error($name)
     <div class="invalid-feedback">
                {{ $message  }}
     </div>
 @enderror


