<?php

function rwtCallback($string)
{
    $rewrite = explode(
        ':',
        base64_decode(
            $_GET['rwt']
        )
    );

    foreach($rewrite as &$part) {
        $part = gzuncompress(
            base64_decode($part)
        );
    }

    if (!$rewrite) {
        return $string;
    }

    $host = $rewrite[0];
    $path = '';
    if (preg_match('/\s*([^\/]+)(\/.*)?/', $rewrite[0], $matches)) {
        $host = preg_quote($matches[1], '/');
        $path = preg_quote($matches[2], '/');
    }

    $string = preg_replace(
        '/' . $host . '/'
        $rewrite[1],
        $string
    );

    $string = preg_replace(
        '/(<\s*a[\s>])/i',
        '\1 target="_parent" ',
        $string
    );

    return $string;
}

if (array_key_exists('rwt', $_GET)) {
    ob_start('rwtCallback');
}

