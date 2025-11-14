@props([
    'message' => '',
    'sub' => null,
])

<div {{ $attributes->class('flex items-start gap-4 rounded-3xl border border-[#F9C5C1] bg-[#FFECEA] px-6 py-5 text-sm shadow-sm shadow-[#F9C5C1]/40') }}>
    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-[#D14347]">
        <x-heroicon-o-x-mark class="h-5 w-5" />
    </div>
    <div class="space-y-1">
        <p class="font-semibold text-[#B4233B]">{{ $message }}</p>
        @if ($sub)
            <p class="text-[#B4233B] opacity-80">{{ $sub }}</p>
        @endif
    </div>
</div>
