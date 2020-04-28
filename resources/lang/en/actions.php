<?php
return [
    
    'summary'=>[
        'action'=>'Summary'
    ],
    'options' => [
        'combobox' => [
            'default'=>'Select an option'
        ],
        'button'=>[
            'return' =>'Return',
            'retry' =>'Retry',
            'pay' =>'Pay',
        ]
    ],
    'delete' => [
        'action' => 'Delete',
        'success' => [
            'male' => ' successfully removed',
            'female' => ' successfully removed'
        ],
        'error' => [
            'male' => 'An error has occurred',
            'female' => 'An error has occurred'
        ]
    ],
    'edit' => [
        'action' => 'Edit',
        'success' => [
            'male' => ' successfully edited',
            'female' => ' successfully edited'
        ],
        'error' => [
            'male' => 'An error has occurred',
            'female' => 'An error has occurred'
        ]
    ],
    'create' => [
        'action' => 'Create',
        'success' => [
            'male' => ' successfully created',
            'female' => ' successfully created'
        ],
        'error' => [
            'male' => 'An error has occurred',
            'female' => 'An error has occurred'
        ]
    ],
];
