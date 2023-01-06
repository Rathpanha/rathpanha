<?php

class Image 
{
    public static function loadImageFromUrl($url)
    {
        $image = file_get_contents('http:'.$url);
        return imagecreatefromstring($image);
    }
    
    public static function loadImageFromFile($file)
    {
        self::correctOrientation($file['tmp_name']);
        $photo_ext = strtolower(end(explode(".", $file['name'])));
        if($photo_ext == "png") {
            return imagecreatefrompng($file['tmp_name']);
        } else {
            return imagecreatefromjpeg($file['tmp_name']);
        }
    }
    
    public static function crop($image, $src_x, $src_y, $width, $height, $src_width, $src_height)
    {
        $crop = imagecreatetruecolor($width, $height);
        $color = imagecolorallocate($crop, 255, 255, 255);
        imagefill($crop, 0, 0, $color);
        
        if($src_height < $src_width) {
            $new_width = $src_width * $height / $src_height;
            $new_height = $height;
        } else {
            $new_height = $src_height * $width / $src_width;
            $new_width = $width;
        }

        imagecopyresized($crop, $image, 0, 0, $src_x, $src_y, $new_width, $new_height, $src_width, $src_height);

        return $crop;
    }
    
    public static function correctOrientation($filename) {
        $exif = exif_read_data($filename);
        
        if (!empty($exif['Orientation'])) {
            $image = imagecreatefromjpeg($filename);
            switch ($exif['Orientation']) {
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;
                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
            }
            
            imagejpeg($image, $filename, 90);
        }
    }
}