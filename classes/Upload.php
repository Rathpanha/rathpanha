<?php

class Upload 
{
  public static function uploadWithWatermark($watermark, $photo, $opacity = 1, $position = "m") 
  {
    //Load photo
    $photo_ext = strtolower(end(explode(".", $photo['name'])));
    $photo = ($photo_ext == "png" ? imagecreatefrompng($photo['tmp_name']) : imagecreatefromjpeg($photo['tmp_name']));
    $photo_width = imagesx($photo); //Get width
    $photo_height = imagesy($photo); //Get Height
    //Load watermark 
    $watermark_ext = strtolower(end(explode(".", $watermark)));
    $watermark = ($watermark_ext == "png" ? imagecreatefrompng($watermark) : imagecreatefromjpeg($watermark));
    $watermark_width = imagesx($watermark); //Get width
    $watermark_height = imagesy($watermark); //Get Height
    //Scale watermark
    $new_watermark_width = $photo_width * 0.3;
    $new_watermark_height = $watermark_height * ($new_watermark_width / $watermark_width);

    $watermark = imagescale($watermark, $new_watermark_width, $new_watermark_height);

    //Opacity of watermark
    imagealphablending($watermark, false); // imagesavealpha can only be used by doing this for some reason
    imagesavealpha($watermark, true); // this one helps you keep the alpha. 
    $transparency = 1 - $opacity;
    imagefilter($watermark, IMG_FILTER_COLORIZE, 0, 0, 0, 127 * $transparency);

    //Fill watermark to photo by position
    switch ($position) {
      case "tl" :
        $watermark_position_x = $photo_width - ( $photo_width - 30);
        $watermark_position_y = $photo_height - ( $photo_height - 30 );
        break;
      case "tr" :
        $watermark_position_x = $photo_width - ( $new_watermark_width + 30 );
        $watermark_position_y = $photo_height - ( $photo_height - 30 );
        break;
      case "m" :
        $watermark_position_x = $photo_width / 2 - $new_watermark_width / 2;
        $watermark_position_y = $photo_height / 2 - $new_watermark_height / 2;
        break;
      case "bl" :
        $watermark_position_x = $photo_width - ( $photo_width - 30);
        $watermark_position_y = $photo_height - ($new_watermark_height + 30);
        break;
      case "br" :
        $watermark_position_x = $photo_width - ( $new_watermark_width + 30 );
        $watermark_position_y = $photo_height - ($new_watermark_height + 30);
        break;
    }

    imagecopy($photo, $watermark, $watermark_position_x, $watermark_position_y, 0, 0, $new_watermark_width, $new_watermark_height);

    $photo_temp = tmpfile();
    $photo_ext == "png" ? imagepng($photo, stream_get_meta_data($photo_temp)['uri'], 0) : imagejpeg($photo, stream_get_meta_data($photo_temp)['uri'], 100);

    $_FILES['photo']['name'] = "photo." . $photo_ext;
    $_FILES['photo']['tmp_name'] = stream_get_meta_data($photo_temp)['uri'];

    return self::uploadFileFromFile("photo");
  }

  public static function uploadFileFromImage($image)
  {

    $temp_file = tmpfile();
    imagejpeg($image, stream_get_meta_data($temp_file)['uri'], 100);

    $_FILES['image']['name'] = "image.jpg";
    $_FILES['image']['tmp_name'] = stream_get_meta_data($temp_file)['uri'];

    return self::uploadFileFromFile("image", false);
  }

  public static function uploadFileFromFile($post_file, $reduce = true) 
  {
    if (isset($_FILES[$post_file]) && $_FILES[$post_file]['error'] > 0) {
      return "";
    }
    
    $ext = pathinfo($_FILES[$post_file]['name'], PATHINFO_EXTENSION);
    //Reduce size if image width or height bigger than 1000px
    if(self::isSupportedImageExtension($ext) && $reduce) {
      $original_orientation = exif_read_data($_FILES[$post_file]['tmp_name'])['Orientation'];
      $image = $ext == "png" ? imagecreatefrompng($_FILES[$post_file]['tmp_name']) : imagecreatefromjpeg($_FILES[$post_file]['tmp_name']);
      $image = self::reduceImage($image);
      $image_temp = tmpfile();
      $ext == "png" ? imagepng($image, stream_get_meta_data($image_temp)['uri'], 0) : imagejpeg($image, stream_get_meta_data($image_temp)['uri'], 100);
      
      $_FILES['_image']['name'] = "image." . $ext;
      $_FILES['_image']['tmp_name'] = stream_get_meta_data($image_temp)['uri'];
      $post_file = "_image";
      self::correctOrientation($_FILES[$post_file]['tmp_name'], $original_orientation);//Correct orientation 
    }

    $result = self::uploadFile($_FILES[$post_file]['tmp_name'], $_FILES[$post_file]['name'], $ext);

    if ($result === false) {
      return "";
    } else {
      return $result;
    }
  }
  
  public static function uploadFileFromFileArray($post_file, $reduce = true)
  {
    $results = array();
    for($i = 0; $i < count($_FILES[$post_file]['name']); $i++) {
      if (isset($_FILES[$post_file][$i]) && $_FILES[$post_file]['error'][$i] > 0) {
        $results[] = "";
      }
    
      $ext = pathinfo($_FILES[$post_file]['name'][$i], PATHINFO_EXTENSION);
      //Reduce size if image width or height bigger than 1000px
      if(self::isSupportedImageExtension($ext) && $reduce) {
        $original_orientation = exif_read_data($_FILES[$post_file]['tmp_name'][$i])['Orientation'];
        $image = $ext == "png" ? imagecreatefrompng($_FILES[$post_file]['tmp_name'][$i]) : imagecreatefromjpeg($_FILES[$post_file]['tmp_name'][$i]);
        $image = self::reduceImage($image);
        $image_temp = tmpfile();
        $ext == "png" ? imagepng($image, stream_get_meta_data($image_temp)['uri'], 0) : imagejpeg($image, stream_get_meta_data($image_temp)['uri'], 100);

        $_FILES['_image']['name'] = "image." . $ext;
        $_FILES['_image']['tmp_name'] = stream_get_meta_data($image_temp)['uri'];
        self::correctOrientation($_FILES["_image"]['tmp_name'], $original_orientation);//Correct orientation 
      }
      
      $results[] = self::uploadFile($_FILES["_image"]['tmp_name'], $_FILES["_image"]['name'], $ext);
    }

    return $results;
  }

  public static function uploadFile($file, $name, $ext) {
    if (!self::isSupportedExtension($ext)) {
      return false;
    }
    
    $file_contents = file_get_contents($file);
    

    if (self::isSupportedDocExtension($ext)) {
      $public_part = "/files/" . sha1($file_contents) . "." . $ext;
    } else {
      $public_part = "/photos/" . sha1($file_contents) . "." . $ext;
    }

    $des_admin = __DIR__ . "/../src/admin/public" . $public_part;
    $des_desktop = __DIR__ . "/../src/desktop/public" . $public_part;

    //If file already exist, return path
    if (file_exists($des_admin) && file_exists($des_desktop)) {
      return $public_part;
    }

    if (copy($file, $des_admin) && copy($file, $des_desktop)) {
      unlink($file); //Delete file after copy
      return $public_part;
    }

    return false;
  }

  public static function isUploadedFile($post_file) 
  {
    if (empty($_FILES[$post_file])) {
      return false;
    }

    if (!file_exists($_FILES[$post_file]['tmp_name']) || !is_uploaded_file($_FILES[$post_file]['tmp_name'])) {
      return false;
    }

    return true;
  }  

  private static function reduceImage($image)
  {
    $width = imagesx($image);//Get width
    $height = imagesy($image);//Get Height
    $new_width = 0;
    $new_height = 0;

    if ($width > 1920 || $height > 1920) {
      if ($width > $height) {
        $new_width = 1920;
        $new_height = 1920 * $height / $width;
      } else {
        $new_height = 1920;
        $new_width = 1920 * $width / $height;
      }
    } else {
      $new_width = $width;
      $new_height = $height;
    }

    $new_img = imagecreatetruecolor($new_width, $new_height);
    $white_background = imagecolorallocate($new_img, 255, 255, 255); //Create white background
    imagefill($new_img, 0, 0, $white_background); //Fill white background
    imagecopyresampled($new_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height); //Reduce

    return $new_img;
  }
  
  private static function correctOrientation($filename, $orientation) 
  {
    if (!empty($orientation)) {
      $image = imagecreatefromjpeg($filename);
      switch ($orientation) {
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
  
  private static function isSupportedImageExtension($extension)
  {
    return in_array(strtolower($extension), array('jpg', 'bmp', 'png', 'jpeg', 'pneg', 'gif', 'ico'));
  }

  private static function isSupportedExtension($extension) 
  {
    return in_array(strtolower($extension), array('jpg', 'bmp', 'png', 'jpeg', 'pneg', 'gif', 'ico', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'));
  }

  private static function isSupportedDocExtension($extension)
  {
    return in_array(strtolower($extension), array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'));
  }
}
