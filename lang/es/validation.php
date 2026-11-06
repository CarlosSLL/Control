<?php

return [
    'accepted'   => 'El campo :attribute debe ser aceptado.',
    'active_url' => 'El campo :attribute no es una URL válida.',
    'after'      => 'El campo :attribute debe ser una fecha posterior a :date.',
    'before'     => 'El campo :attribute debe ser una fecha anterior a :date.',
    'boolean'    => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'  => 'La confirmación de :attribute no coincide.',
    'date'       => 'El campo :attribute no es una fecha válida.',
    'email'      => 'El campo :attribute debe ser un correo electrónico válido.',
    'image'      => 'El campo :attribute debe ser una imagen.',
    'integer'    => 'El campo :attribute debe ser un número entero.',
    'nullable'   => 'El campo :attribute puede ser nulo.',
    'numeric'    => 'El campo :attribute debe ser un número.',
    'regex'      => 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.',
    'required'   => 'El campo :attribute es obligatorio.',
    'string'     => 'El campo :attribute debe ser una cadena de texto.',
    'unique'     => 'Este correo electrónico ya se encuentra registrado.',

    'max' => [
        'string'  => 'El campo :attribute no puede tener más de :max caracteres.',
        'numeric' => 'El campo :attribute no puede ser mayor que :max.',
        'file'    => 'El archivo :attribute no puede ser mayor de :max KB.',
    ],
    'min' => [
        'string'  => 'El campo :attribute debe tener al menos :min caracteres.',
        'numeric' => 'El campo :attribute debe ser al menos :min.',
    ],

    'attributes' => [
        'nombre'         => 'nombre',
        'categoria_id'   => 'categoría',
        'composicion_id' => 'composición',
        'descripcion'    => 'descripción',
        'rol_id'         => 'rol',
        'id_usuario'     => 'Lider',
        'cantidad'       => 'cantidad',
        'foto'           => 'foto',
        'email'          => 'correo electrónico',
        'password'       => 'contraseña',
    ],
];
