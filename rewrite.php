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

    $string = preg_replace(
        '/' . preg_quote($rewrite[0], '/') . '/',
        $rewrite[1],
        $string
    );

    $string = preg_replace(
        '/(<\s*a[\s>])/i',
        '\1 target="_parent"',
        $string
    );

    return $string;
}

if (array_key_exists('rwt', $_GET)) {
    ob_start('rwtCallback');
}

