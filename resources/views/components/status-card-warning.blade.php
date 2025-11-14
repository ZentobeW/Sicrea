@props([
    'message' => '',
    'sub' => null,
])

<div {{ $attributes->class('flex items-start gap-4 rounded-3xl border border-[#FAD6C7] bg-[#FFF5EF] px-6 py-5 text-sm shadow-sm shadow-[#FAD6C7]/40') }}>
    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-[#FF8A64]">
        <x-heroicon-o-megaphone class="h-5 w-5" />
    </div>
    <div class="space-y-1">
        <p class="font-semibold text-[#C65B74]">{{ $message }}</p>
        @if ($sub)
            <p class="text-[#C65B74] opacity-80">{{ $sub }}</p>
        @endif
    </div>
</div>
