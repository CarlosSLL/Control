<div>
    @can('viewAny', \App\Models\Solicitud::class)
        @include('solicitudes.atender-solicitud')
    @else
        @include('solicitudes.ver-solicitud')
    @endcan
    
</div>
