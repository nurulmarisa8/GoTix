@props(['title', 'value', 'icon', 'color' => 'blue'])

<div class="stats-card">
    <div class="stats-card__header">
        <div class="stats-card__icon bg-{{ $color }}-100 text-{{ $color }}-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
            </svg>
        </div>
        <div class="stats-card__info">
            <h3>{{ $value }}</h3>
            <p>{{ $title }}</p>
        </div>
    </div>
</div>