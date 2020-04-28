<?php
return [
    'summary'=>[
        'action'=>'Ver Resumen'
    ],
    'options' => [
        'combobox' => [
            'default'=>'Selecciona una opción'
        ],
        'button'=>[
            'return' =>'Regresar',
            'retry' =>'Reintentar',
            'pay' =>'Pagar',
        ]
    ],
    'delete' => [
        'action' => 'Eliminar',
        'success' => [
            'male' => ' eliminado correctamente',
            'female' => ' eliminada correctamente'
        ],
        'error' => [
            'male' => 'Ha ocurrio un error',
            'female' => 'Ha ocurrio un error'
        ]
    ],
    'edit' => [
        'action' => 'Editar',
        'success' => [
            'male' => ' editado satisfactoriamente',
            'female' => ' editada satisfactoriamente',
        ],
        'error' => [
            'male' => 'Ha ocurrio un error',
            'female' => 'Ha ocurrio un error'
        ]
    ],
    'create' => [
        'action' => 'Crear',
        'success' => [
            'male' => ' creado satisfactoriamente',
            'female' => ' creada satisfactoriamente'
        ],
        'error' => [
            'male' => 'Ha ocurrio un error',
            'female' => 'Ha ocurrio un error'
        ]
    ],
];
