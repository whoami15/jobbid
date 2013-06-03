<?php

/**
 * @see Zend_Filter_ImageSize_Strategy_Interface 
 */
require_once 'Zend/Filter/ImageSize/Strategy/Interface.php';

/**
 * Strategy for resizing the image by fitting the content into the given 
 * dimensions.
 */
class Zend_Filter_Imagesize_Strategy_Fit 
    implements Zend_Filter_ImageSize_Strategy_Interface
{
    /**
     * Return canvas resized according to the given dimensions.
     * @param resource $image GD image resource
     * @param int $width Output width
     * @param int $height Output height
     * @return resource GD image resource
     */
	public function resize($image, $width, $height)
    {
        $origWidth = imagesx($image);
        $origHeight = imagesy($image);
        if($width == 0) { //fix height
        	$ratio = round($origHeight / $height,2);
        	$newHeight = $height;
        	$newWidth = ceil($origWidth / $ratio); 
        } else if ($height == 0) { //fix width
        	$ratio = round($origWidth / $width,2);
        	$newWidth = $width;
        	$newHeight = ceil($origHeight / $ratio);
        } else {
	        $newWidth = $width;
	        $newHeight = $height;
        }
        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        
        return $resized;
    }
}