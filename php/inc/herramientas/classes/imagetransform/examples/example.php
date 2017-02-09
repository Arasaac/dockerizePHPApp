<?php

    // include the class
    require '../Zebra_Image.php';
    
    // create a new instance of the class
    $image = new Zebra_Image();
    
    // indicate a source image
    // note that, in this example, zebra.png image is a 61x61 image
    $image->source_path = 'zebra.png';
    
    // indicate a target image
    // note that there's no extra property to set in order to specify the target image's type -
    // simply by writing '.jpg' as extension will instruct the script to create a 'jpg' file
    $image->target_path = 'result.jpg';

    // since in this example we're going to have a jpeg file, let's set the output image's quality
    $image->jpeg_quality = 100;
    
    // some additional properties that can be set
    // read about them in the documentation
    $image->preserve_aspect_ratio = true;
    $image->enlarge_smaller_images = true;
    $image->preserve_time = true;

    // resize to 50x50
    //  and if there is an error, check what the error is about
    if (!$image->resize(50, 50)) {

        // if there was an error, let's see what the error is about
        switch ($image->error) {

            case 1:
                echo 'Source file could not be found!';
                break;
            case 2:
                echo 'Source file is not readable!';
                break;
            case 3:
                echo 'Could not write target file!';
                break;
            case 4:
                echo 'Unsupported source file format!';
                break;
            case 5:
                echo 'Unsupported target file format!';
                break;
            case 6:
                echo 'GD library version does not support target file format!';
                break;
            case 7:
                echo 'GD library is not installed!';
                break;

        }

    // if there were no errors
    } else {

        print_r('done, here\'s the result:<br><br>');
        print_r('<img src="' . $image->target_path . '" alt="">');

    }

?>