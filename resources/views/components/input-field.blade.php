@props(['id', 'name', 'title', 'description', 'type', 'options', 'placeholder', 'value', 'cols'])

@php
    $name = $name ?? 'field';
    $id = $id ?? $name;
    $title = Str::of($title ?? Str::of($name)->replace(['-','_'], ' '))->title();
    $type = $type ?? 'text';

    $options = $options ?? [];
    $option_key = $options['key'] ?? 'id';
    $option_text = $options['text'] ?? 'name';
    $select_options = $options['items'] ?? [];

    $attributes = $attributes->class([
        match($type){
            'checkbox', 'radio' => 'form-check-input',
            default => 'form-control',
        }
    ]);
    $attributes['id'] = $id;
    $attributes['name'] = $name;
    $attributes['aria-describedby'] = 'field_info_' . $name;
@endphp

<div class="row align-items-center mb-3 {{ $type == 'hidden' ? 'd-none' : '' }}">
    <div class="col-md-3 text-md-end">
        <label for="{{ $id }}">{{ $title }}</label>
    </div>

    <div class="col-md-{{ $cols ?? 6}}">
        @if ($type == 'select')
            <select {{ $attributes }}>
                <option value="">{{ $placeholder ?? $title }}</option>
                
                @foreach ($select_options as $select_options)
                    @php($select_options = is_object($select_options) ? $select_options : (object)$select_options)

                    <option
                        value="{{ $option_value = $select_options->{$option_key} }}"
                        @selected($option_value == old($name, $value ?? null))
                    >
                        {{ $select_options->{$option_text} }}
                    </option>
                @endforeach
            </select>
        @elseif($type == 'textarea')
            <textarea {{ $attributes }}>{{ old($name, $value ?? null) }}</textarea>
        @else
            <input type="{{ $type }}" value="{{ old($name, $value ?? null) }}" {{ $attributes }}>
        @endif
        
        @isset($description)
            <div id="field_info_{{ $name }}" class="form-text">{{ $description }}</div>
        @endisset
        
        @error($name)
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>