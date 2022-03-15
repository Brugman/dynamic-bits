<?php

function dynbit_random_number()
{
    return [
        'success' => true,
        'data'    => rand( 1, 10 ),
    ];
}

