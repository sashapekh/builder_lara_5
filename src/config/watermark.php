<?php

return [

    'active' => true,
    //top-left, top, top-right, left, center, right, bottom-left, bottom, bottom-right
    'position'       => 'top',
    'path_watermark' => public_path('images').'/watermark.png',
    'x'              => 10, //Optional relative offset of the new image on x-axis of the current image
    'y'              => 10,  //Optional relative offset of the new image on y-axis of the current image
    'width'          => 800,
];
