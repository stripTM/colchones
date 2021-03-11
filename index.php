<?php
    function order($a, $b) {
        return $a->name > $b->name;
    }
    function getMedia($dir) {
        $enabledExtensions = ['.jpg', '.mp4'];
        $files = [];
        if ($gestor = opendir($dir)) {
            while (false !== ($entry = readdir($gestor))) {
                $extension = strtolower( substr($entry, -4) );
                if (in_array($extension, $enabledExtensions)) {
                    $file = new stdclass();
                    $file->name = $entry;
                    $file->extension = $extension;
                    $files[] = $file;
                }
            }
        }
        usort($files, order);
        return $files;
    }
?><!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad Colchonera</title>
    <style type="text/css">
        body{ margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; font-size: 60%; }
        #lienzo { column-count: 6; column-gap: 1px; }
        figure { margin: 0 0 1px 0; width: 100%; text-align: center; position: relative; }
        img, video{ display: block; width: 100%; height: auto; z-index: 0; }
        figcaption{ position: absolute; z-index: 10; bottom: 0; left: 0; right: 0; text-align: center; padding: .2em; background-color: rgba(0,0,0,.5); color: white; }
        .footer{ background-color: black; color: white; text-align: center; margin: 0; }
        @media screen and (max-width: 800px) {
              #lienzo { column-count: 4; }
        }
        @media screen and (max-width: 500px) {
              #lienzo { column-count: 2; }
        }
    </style>
</head>
<body>
    <div id="lienzo">
<?php
        $medias = getMedia(__DIR__);
        foreach($medias as $media) {
            switch($media->extension) {
                case '.jpg':
?>
                    <figure><a href="./<?=$media->name?>"><img src="./<?=$media->name?>"><figcaption><?=$media->name?></figcaption></a></figure>
<?php
                    break;
                case '.mp4':
?>
                    <figure><a href="./<?=$media->name?>"><video src="./<?=$media->name?>" controls></video><figcaption><?=$media->name?></figcaption></a></figure>
<?php
                    break;
            }
        }
?>
    </div>
    <p class="footer"><?php echo count($medias); ?></p>
</body>
</html>
