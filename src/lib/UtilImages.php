<?php
namespace Cocol\Redsocial\lib;

class UtilImages {
    public static function storeImage(array $photo): string {
        $target_dir = 'public/img/photos/';
        $extarr = explode('.', $photo["name"]);
        $filename = $extarr[sizeof($extarr) - 2];
        $ext = $extarr[sizeof($extarr) - 1];
        $hash = md5(Date('Ymdgi') . $filename) . '.' . $ext;
        $target_file = $target_dir . $hash;
        $check = getimagesize($photo["tmp_name"]);

        if ($check === false) {
            return "";
        } else {
            if (move_uploaded_file($photo["tmp_name"], $target_file)) {
                return $hash;
            } else {
                return "";
            }
        }
    }
}