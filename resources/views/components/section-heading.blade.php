@props(['eyebrow', 'title'])

<div class="mb-8 flex flex-wrap items-end justify-between gap-4 border-b border-slate-200 pb-4">
    <div>
        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">{{ $eyebrow }}</p>
        <h2 {{ $attributes->merge(['class' => 'mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl']) }}>{{ $title }}</h2>
    </div>
    @isset($action)
        <div class="shrink-0">{{ $action }}</div>
    @endisset
</div>
