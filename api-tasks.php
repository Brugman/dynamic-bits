<?php

function dynbit_task_unavailable()
{
    return [
        'success' => false,
        'data'    => 'Task unavailable.',
    ];
}

function dynbit_time()
{
    return [
        'success' => true,
        'data'    => date('H:i:s'),
    ];
}

function dynbit_day()
{
    return [
        'success' => true,
        'data'    => date('l'),
    ];
}

function dynbit_random_number()
{
    return [
        'success' => true,
        'data'    => rand( 1, 10 ),
    ];
}

