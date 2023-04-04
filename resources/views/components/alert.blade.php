<div x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => showMessage = false, 3000)">
    @if (session()->has($h))
        <div class="alert alert-{{ $h }}">
            {{ session()->get($h) }}
        </div>
    @endif
</div>
