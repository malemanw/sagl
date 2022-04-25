<?php
$usuario  = 'marco';
$password = '123456';
                                                                                                                                                                                                                       if($usuario === 'marco' && $password === '123456')
{
    echo Auth::SignIn([
        'id' => 1,
        'name' => 'marco'
    ]);
}
