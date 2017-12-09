<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'login',
        'signUp',
        'getUserInfo',
        'uploadHead',
        'modifyProfile',
        'modifyPassword',
        'tag/createTag',
        'tag/search',
        'notebook/createNotebook',
        'note/createNote',
        'note/getAllNote',
        'note/searchNote',
        'note/modifyNote'
    ];
}
