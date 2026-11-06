<div>
    <div class="ca-dash-wrapper">
        <!-- Tarjetas Principales -->
        <section class="ca-dash-cards-grid">
            <div class="ca-dash-card-stat">
                <div class="ca-dash-card-icon ca-dash-icon-materiales">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l8 4.5v9l-8 4.5l-8 -4.5v-9z"/><path d="M12 12l8 -4.5"/><path d="M12 12v9"/><path d="M12 12l-8 -4.5"/></svg>
                </div>
                <div class="ca-dash-card-content">
                    <span class="ca-dash-card-title">Materiales</span>
                    <span class="ca-dash-card-number">{{ $totalMateriales }}</span>
                </div>
            </div>

            <div class="ca-dash-card-stat">
                <div class="ca-dash-card-icon ca-dash-icon-herramientas">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 10h3v-3l-3.5 -3.5a6 6 0 0 1 8 8l6 6a2 2 0 0 1 -2.5 2.5l-6 -6a6 6 0 0 1 -8 -8l3.5 3.5z"/></svg>
                </div>
                <div class="ca-dash-card-content">
                    <span class="ca-dash-card-title">Herramientas</span>
                    <span class="ca-dash-card-number">{{ $totalHerramientas }}</span>
                </div>
            </div>

            <div class="ca-dash-card-stat">
                <div class="ca-dash-card-icon ca-dash-icon-solicitudes">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/><path d="M9 14l2 2l4 -4"/></svg>
                </div>
                <div class="ca-dash-card-content">
                    <span class="ca-dash-card-title">Solicitudes Pendientes</span>
                    <span class="ca-dash-card-number">{{ $solicitudesPendientes }}</span>
                </div>
            </div>

            <div class="ca-dash-card-stat">
                <div class="ca-dash-card-icon ca-dash-icon-proyectos">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21l18 0"/><path d="M4 21v-11l12 -4v15"/><path d="M9 9l0 .01"/><path d="M9 12l0 .01"/><path d="M9 15l0 .01"/><path d="M9 18l0 .01"/></svg>
                </div>
                <div class="ca-dash-card-content">
                    <span class="ca-dash-card-title">Proyectos en Progreso</span>
                    <span class="ca-dash-card-number">{{ $proyectosEnProgreso }}</span>
                </div>
            </div>
        </section>

        <!-- Contenido Principal Grid -->
        <div class="ca-dash-content-grid">
            <!-- Tabla Solicitudes Recientes -->
            <section class="ca-dash-panel">
                <div class="ca-dash-panel-header">
                    <h2>Solicitudes recientes</h2>
                </div>
                <div class="ca-dash-table-responsive">
                    <table class="ca-dash-table">
                        <thead>
                            <tr>
                                <th># ID</th>
                                <th>Solicitante</th>
                                <th>Tipo</th>
                                <th>Proyecto / Obra</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($solicitudesRecientes as $solicitud)
                                <tr>
                                    <td class="ca-dash-font-bold">#{{ str_pad($solicitud->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $solicitud->usuario_nombre }}</td>
                                    <td>
                                        <span class="ca-dash-badge ca-dash-badge-type">{{ $solicitud->tipo }}</span>
                                    </td>
                                    <td>{{ $solicitud->obra_nombre }}</td>
                                    <td>
                                        @php
                                            $statusClass = match(strtolower($solicitud->estado)) {
                                                'pendiente' => 'ca-dash-badge-warning',
                                                'entregado', 'aprobado' => 'ca-dash-badge-success',
                                                'parcial' => 'ca-dash-badge-info',
                                                'cancelado', 'rechazado' => 'ca-dash-badge-danger',
                                                default => 'ca-dash-badge-neutral',
                                            };
                                        @endphp
                                        <span class="ca-dash-badge {{ $statusClass }}">{{ $solicitud->estado }}</span>
                                    </td>
                                    <td class="ca-dash-text-secondary">
                                        {{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="ca-dash-text-center ca-dash-text-secondary">No hay solicitudes recientes registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Proyectos y Progreso -->
            <section class="ca-dash-panel">
                <div class="ca-dash-panel-header">
                    <h2>Proyectos</h2>
                </div>
                <div class="ca-dash-projects-list">
                    @forelse ($proyectos as $proyecto)
                        <div class="ca-dash-project-item">
                            <div class="ca-dash-project-info">
                                <span class="ca-dash-project-title">{{ $proyecto->nombre }}</span>
                                <span class="ca-dash-badge ca-dash-badge-info">{{ $proyecto->estado }}</span>
                            </div>
                            <div class="ca-dash-progress-container">
                                <div class="ca-dash-barra-progreso">
                                    <div class="ca-dash-barra-progreso-relleno" style="width: {{ $proyecto->progreso }}%;"></div>
                                </div>
                                <span class="ca-dash-progress-text">{{ $proyecto->progreso }}%</span>
                            </div>
                        </div>
                    @empty
                        <p class="ca-dash-text-center ca-dash-text-secondary">No hay proyectos activos en este momento.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</div>
