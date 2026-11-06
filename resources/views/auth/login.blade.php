@extends('layouts.guest')

@section('content')


 <div class="formulario-login">
        <h1>Iniciar Sesion</h1>
        <p>Ingresa tus credenciales para acceder al sistema</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Correo Electrónico</label>
            <div class="campo-formulario">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                <input type="email" id="email" name="email" placeholder="usuario@empresa.com">
                 @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
             <label for="password">Contraseña</label>
            <div class="campo-formulario">
                <svg for="password" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                <input type="password" id="password" name="password" placeholder="********">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                {{-- <svg class="ojo-password" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg> --}}
            </div>

            <div class="enlace-login"><a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a></div>

            <input class="boton-azul" type="submit" value="Iniciar Sesion">
        </form>
    </div>


    <div class="modal" id="modal-privacidad">

    <div class="modal-contenido">
        <div class="titulo-modal">
            <h1>Aviso de privacidad</h1>
        </div>
        <p>
        <strong>Responsable del tratamiento de datos.</strong>
        Este sistema es una herramienta interna de administración de
        almacén, proyectos, materiales y herramientas. El responsable
        del tratamiento de la información aquí registrada es la
        organización que opera esta plataforma.
    </p>

    <p>
        <strong>Datos personales que recopilamos.</strong>
        Para el funcionamiento del sistema, almacenamos: nombre y
        apellidos, correo electrónico, contraseña (cifrada), rol
        asignado dentro de la organización, fotografía de perfil
        (opcional), y el historial de actividad relacionado con
        proyectos, solicitudes de materiales y herramientas que el
        usuario realice dentro del sistema.
    </p>

    <p>
        <strong>Finalidad del tratamiento.</strong>
        Estos datos se utilizan exclusivamente para: identificar a
        cada usuario dentro del sistema, controlar el acceso según su
        rol y permisos, registrar y dar seguimiento a solicitudes de
        materiales y herramientas, y mantener trazabilidad de
        entregas e inventario para fines administrativos internos.
    </p>

    <p>
        <strong>Seguridad de la información.</strong>
        Implementamos medidas técnicas razonables para proteger tus
        datos, incluyendo: contraseñas almacenadas con cifrado
        unidireccional (nunca en texto plano), control de acceso
        basado en roles para limitar quién puede ver o modificar
        cada tipo de información, y conexiones protegidas para el
        acceso al sistema. Ningún sistema es completamente inmune a
        riesgos de seguridad, pero trabajamos para minimizarlos.
    </p>

    <p>
        <strong>Con quién compartimos tu información.</strong>
        Los datos registrados en este sistema no se comparten con
        terceros ajenos a la organización, salvo que exista una
        obligación legal que lo requiera.
    </p>

    <p>
        <strong>Tus derechos (Acceso, Rectificación, Cancelación y
        Oposición).</strong>
        Puedes solicitar el acceso, corrección o eliminación de tus
        datos personales registrados en este sistema, así como
        oponerte a un uso específico de los mismos, contactando al
        administrador de la organización.
    </p>

    <p>
        <strong>Cambios a este aviso.</strong>
        Este aviso de privacidad puede actualizarse periódicamente.
        Cualquier cambio relevante será comunicado a través de este
        mismo sistema.
    </p>
    <button class="boton-azul" id="btn-aceptar-privacidad">
        Aceptar aviso de privacidad
    </button>
    </div>


</div>
    @endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal-privacidad');
    const btnAceptar = document.getElementById('btn-aceptar-privacidad');
    const yaAcepto = localStorage.getItem('aviso_privacidad_aceptado');

    // Si NO lo ha aceptado, lo mostramos
    if (!yaAcepto) {
        modal.style.display = 'flex';
    }

    btnAceptar.addEventListener('click', () => {
        localStorage.setItem('aviso_privacidad_aceptado', 'true');
        modal.style.display = 'none';
    });
});
</script>

