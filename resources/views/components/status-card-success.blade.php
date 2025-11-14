@props([
    'message' => '',
    'sub' => null,
])

<div {{ $attributes->class('flex items-start gap-4 rounded-3xl border border-[#DDF5EB] bg-[#F6FFFA] px-6 py-5 text-sm shadow-sm shadow-[#BFE3D1]/30') }}>
    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#E9FBF2] text-[#1B9C85]">
        <x-heroicon-o-check class="h-5 w-5" />
    </div>
    <div class="space-y-1">
        <p class="font-semibold text-[#1B9C85]">{{ $message }}</p>
        @if ($sub)
            <p class="text-[#1B9C85] opacity-80">{{ $sub }}</p>
        @endif
    </div>
</div>
