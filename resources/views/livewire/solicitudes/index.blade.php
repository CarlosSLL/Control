<div>
    @can('viewAny', \App\Models\Solicitud::class)
        <livewire:solicitudes.solicitudes />
    @else
        <livewire:solicitudes.mis-solicitudes />
    @endcan
</div>
