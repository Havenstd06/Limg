<?php

return [

    'default' => 'toastr',

    'toastr' => [

        'class' => \Yoeunes\Notify\Notifiers\Toastr::class,

        'notify_js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js',
        ],

        'notify_css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css',
        ],

        'types' => [
            'error',
            'info',
            'success',
            'warning',
        ],

        'options' => [],
    ],

    'pnotify' => [

        'class' => \Yoeunes\Notify\Notifiers\Pnotify::class,

        'notify_js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js',
        ],

        'notify_css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css',
            'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.brighttheme.css',
        ],

        'types' => [
            'alert',
            'error',
            'info',
            'notice',
            'success',
        ],

        'options' => [],
    ],

    'sweetalert2' => [

        'class' => \Yoeunes\Notify\Notifiers\SweetAlert2::class,

        'notify_js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.1/sweetalert2.min.js',
            'https://cdn.jsdelivr.net/npm/promise-polyfill/dist/polyfill.min.js',
        ],

        'notify_css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.1/sweetalert2.min.css',
        ],

        'types' => [
            'error',
            'info',
            'question',
            'success',
            'warning',
        ],

        'options' => [],
    ],
];
