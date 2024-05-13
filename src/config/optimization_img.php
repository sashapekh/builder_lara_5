<?php

return [
    'active'   => true,
    'jpg_path' => 'convert [file] -sampling-factor 4:2:0 -strip -quality 85 -interlace JPEG [file]',
    'png_path' => 'optipng -o4 [file]',
    'webp_optimize' => true,
];
