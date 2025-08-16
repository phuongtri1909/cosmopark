@props(['badge'])

<div class="badge-custom badge rounded-pill mb-3 p-2 p-md-3 animate-on-scroll">
    {{ $badge }}
</div>

@push('styles')
    <style>
        .badge-custom {
            border: 1px solid var(--color-border);
            background-color: transparent;
            color: var(--color-green);
            font-size: var(--font-size-sm);
            font-weight: var(--font-weight-normal);
            opacity: 0;
            transform: scale(0.8);
            transition: opacity 0.3s, transform 0.3s;
        }
        .badge-custom.animated {
            animation: scaleInBadge 0.7s cubic-bezier(.39, .575, .565, 1) both;
        }
        @keyframes scaleInBadge {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
@endpush
