<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Preload using
    |---------------------------------------------------------------------------
    |
    | This value determine what to use to generate paths.It can either be
    | path or name. e.g given the following manifest entry
    | "/js/app.js": "/js/app.js?id=68f7c9d7cf483f0bca922becd796f7f8"
    | name is '/js/app.js' and path is
    | "/js/app.js?id=68f7c9d7cf483f0bca922becd796f7f8"
     */
    'using' => 'path',

    /*
    |---------------------------------------------------------------------------
    | Preload paths
    |---------------------------------------------------------------------------
    |
    | These values determine the paths from the mix-manifest file that will be
    | added to preload. If the path includes one of the substrings in the
    | `include` array AND doesn't contain the substring in exclude
     */
    'preload' => [
        'include' => [
            '/js/',
            '/css/'
        ],
        'exclude' => 'chunk'
    ],

    /*
    |---------------------------------------------------------------------------
    | Preload paths
    |---------------------------------------------------------------------------
    |
    | These values determine the paths from the mix-manifest file that will be
    | added to prefetch. If the path includes one of the substrings in the
    | `include` array AND doesn't contain the substring in exclude it
    | will be prefetched
     */
    'prefetch' => [
        'include' => [
            'chunk',
        ],
        'exclude' => null,
    ]
];
