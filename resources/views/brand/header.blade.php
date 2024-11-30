@push('head')
    <link href="/favicon.ico" id="favicon" rel="icon">
    {{-- AREA CSS --}}
    <link href="{{ asset('css/style.css') }}?v={{ time() }}" rel="stylesheet">

    {{-- AREA DE JS --}}
    <script src="{{ asset('js/jquery.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/utility.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/brio.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/roleo_long.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/descriptionpart.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/packinglist.js') }}?v={{ time() }}"></script>

    <style>
        /* Ocultar la columna de acciones generada automáticamente por Orchid */
        th[data-column="actions"],
        td[data-column="actions"] {
            display: none;
        }
    </style>
@endpush


<div class="h2 d-flex align-items-center">
    @auth
        <x-orchid-icon path="bs.house" class="d-inline d-xl-none" />
    @endauth

    <p class="my-0 {{ auth()->check() ? 'd-none d-xl-block' : '' }}">
        {{ config('app.name') }}
    </p>
</div>
