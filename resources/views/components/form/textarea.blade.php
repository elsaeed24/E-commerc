@props([

    'name' ,
    'value' =>  '',
    'label' => "false"
])

@if ($label)

<label for="">{{ $label }}</label>

@endif

<textarea
        name="{{ $name }}"

        {{ $attributes->class([    // $attribute print all attr except props
            'form-control',
            'is-invalid' => $errors->has($name)
        ]) }}
>{{ old($name,$value) }}</textarea>

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
