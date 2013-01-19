<?php
class Core_Controller_Helper_ImageUtils
{
	public static function getWidthHeight($path,$type) {
		if ($type == 'jpeg')
            $type = 'jpg';
        switch ($type) {
            case 'bmp':
                $image = imagecreatefromwbmp($path);
                break;
            case 'gif':
                $image = imagecreatefromgif($path);
                break;
            case 'jpg':
                $image = imagecreatefromjpeg($path);
                break;
            case 'png':
                $image = imagecreatefrompng($path);
                break;
            default:
                return "Unsupported picture type!";
        }
		if($image==null)
			return null;
		return array(
			'width' => imagesx($image),
			'height' => imagesy($image)
		);
	} 
	public static function image_resize ($src,$type,$dst, $width, $height, $crop = 0)
    {
        if (! list ($origWidth, $origHeight) = getimagesize($src)) throw new zendcms_Exceptions_Exception('ERROR');
        if ($type == 'jpeg')
            $type = 'jpg';
        switch ($type) {
            case 'bmp':
                $img = imagecreatefromwbmp($src);
                break;
            case 'gif':
                $img = imagecreatefromgif($src);
                break;
            case 'jpg':
                $img = imagecreatefromjpeg($src);
                break;
            case 'png':
                $img = imagecreatefrompng($src);
                break;
            default:
               throw new zendcms_Exceptions_Exception('ERROR');
        }
        // resize
        if ($crop) {
        	if($width==null) { //fix height
        		$ratio = $height / $origHeight;
        		$x = ($origHeight - $height / $ratio) / 2;
        		$newHeight = $height;
        		$newWidth = $origWidth / $ratio;
        		
        	} elseif ($height==null) { //fix width
        		$ratio = $width / $origWidth;
        		$x = ($origWidth - $width / $ratio) / 2;
        		$newWidth = $width;
        		$newHeight = $origHeight / $ratio;
        	} else {
        		if ($origWidth < $width || $origHeight < $height)
                	return array(
                		'rs' => 'TO_SMALL',
                		'new_width' => $origWidth,
                		'new_height' => $origHeight
                	);
	            $newHeight = $height;
	            $x = ($origWidth - $width / $ratio) / 2;
	            $newWidth = $width;
        	}
        } else {
        	if($width==null) { //fix height
        		if($origHeight < $height) {
        			return array(
	                	'rs' => 'TO_SMALL',
                		'new_width' => $origWidth,
                		'new_height' => $origHeight
                	);
        		}
        		$ratio = round($origHeight / $height,2);
        		$newHeight = $height;
        		$newWidth = ceil($origWidth / $ratio); 
	            $x = 0;
        		
        	} elseif ($height==null) { //fix width
        		if($origWidth < $width) {
        			return array(
	                	'rs' => 'TO_SMALL',
                		'new_width' => $origWidth,
                		'new_height' => $origHeight
                	);
        		}
        		$ratio = round($origWidth / $width,2);
        		$newWidth = $width;
        		$newHeight = ceil($origHeight / $ratio);
        		$x = 0;
        	} else {
        		if ($origWidth < $width && $origHeight < $height)
	                return array(
	                	'rs' => 'TO_SMALL',
                		'new_width' => $origWidth,
                		'new_height' => $origHeight
                	);
	           	$newWidth = $width;
		        $newHeight = $height;
	            $x = 0;
        	}
        }
        $new = imagecreatetruecolor($newWidth, $newHeight);
        // preserve transparency
        if ($type == "gif" or $type == "png") {
            imagecolortransparent($new, 
            imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }
        imagecopyresampled($new, $img, 0, 0, $x, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        switch ($type) {
            case 'bmp':
                imagewbmp($new, $dst,DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case 'gif':
                imagegif($new, $dst,DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case 'jpg':
                imagejpeg($new, $dst,DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case 'png':
                imagepng($new, $dst,9);
                break;
        }
        return array(
        	'rs' => 'OK',
        	'new_width' => $newWidth,
            'new_height' => $newHeight
      	);
    }
	public static function image_resize_ratio ($src,$type,$dst, $size)
    {
        if (! list ($origWidth, $origHeight) = getimagesize($src)) throw new zendcms_Exceptions_Exception('ERROR');
        if ($type == 'jpeg')
            $type = 'jpg';
        switch ($type) {
            case 'bmp':
                $img = imagecreatefromwbmp($src);
                break;
            case 'gif':
                $img = imagecreatefromgif($src);
                break;
            case 'jpg':
                $img = imagecreatefromjpeg($src);
                break;
            case 'png':
                $img = imagecreatefrompng($src);
                break;
            default:
                throw new zendcms_Exceptions_Exception('ERROR');
        }
        // resize
        if ($origWidth < $size and $origHeight < $size)
	    	return array(
	        	'rs' => 'TO_SMALL',
	        	'new_width' => $origWidth,
	            'new_height' => $origHeight
	      	);
	    if($origWidth > $origHeight) {
	    	$ratio = round($origWidth / $size,2);
	    	$newWidth = $size;
	    	$newHeight = ceil($origHeight / $ratio);	    	
	    } elseif ($origHeight > $origWidth) {
	    	$ratio = round($origHeight / $size,2);
	    	$newHeight = $size;
	    	$newWidth = ceil($origWidth / $ratio);
	    } else {
	    	$newWidth = $size;
			$newHeight = $size;
	    }
	    $x = 0;
        $new = imagecreatetruecolor($newWidth, $newHeight);
        // preserve transparency
        if ($type == "gif" or $type == "png") {
            imagecolortransparent($new, 
            imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }
        imagecopyresampled($new, $img, 0, 0, $x, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        switch ($type) {
            case 'bmp':
                imagewbmp($new, $dst,DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case 'gif':
                imagegif($new, $dst,DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case 'jpg':
                imagejpeg($new, $dst,DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case 'png':
                imagepng($new, $dst,9);
                break;
        }
        return array(
        	'rs' => 'OK',
        	'new_width' => $newWidth,
            'new_height' => $newHeight
      	);
    }
}
?>