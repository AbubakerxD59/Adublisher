<?php
/**
 * Class helper
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: helper.class.php, v1.00 2020-02-20 18:20:24 gewa Exp $
 */
if (!defined("_WOJO"))
    die('Direct access to this location is not allowed.');


class Helper
{

    private static $db;
    public function __construct()
    {
        self::$db = Db::run();

    }

    /**
     * Helper
     * 
     * @return
     */
    public static function upload_image($path, $name)
    {
        $file_name = strtotime(date('Y-m-d H:i:s')) . '_' . $path['name'];
        $destinationPath = $_SERVER['DOCUMENT_ROOT'] . "/assets/blogs/" . $file_name;
        if (file_exists($destinationPath)) {
            return $file_name;
        }
        $fileHandle = fopen($destinationPath, 'wb');
        // Write the video content to local storage using fput
        fwrite($fileHandle, file_get_contents($_FILES[$name]['tmp_name']));
        // Close the file stream
        fclose($fileHandle);
        return $file_name;
    }

    public static function upload_gallery($path, $offset)
    {
        $file_name = strtotime(date('Y-m-d H:i:s')) . '_' . $path['name'];
        $destinationPath = $_SERVER['DOCUMENT_ROOT'] . "/assets/blogs/" . $file_name;
        if (file_exists($destinationPath)) {
            return $file_name;
        }
        $fileHandle = fopen($destinationPath, 'wb');
        // Write the video content to local storage using fput
        fwrite($fileHandle, file_get_contents($_FILES['gallery']['tmp_name'][$offset]));
        // Close the file stream
        fclose($fileHandle);
        return $file_name;
    }

    public static function slugify($text)
    {
        // Convert to lowercase
        $text = strtolower($text);

        // Remove non-alphanumeric characters and spaces
        $text = preg_replace('~[^\p{L}\p{N}\s-]+~', '', $text);

        // Replace spaces and hyphens with a single hyphen
        $text = preg_replace('~[\s-]+~', '-', $text);

        // Trim leading and trailing hyphens
        $text = trim($text, '-');

        // If the slug is empty, return a default value
        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}