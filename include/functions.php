<?php

require_once ("define.php");

function get_header() : string{    
    if (file_exists((PARTS . 'header.php'))) {
        $include = include_once(PARTS . 'header.php');
    } else {
        $include = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="Free Web tutorials">
            <title>Projet initiation HTML/CSS</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/animations.css">
        </head>
        <body>';
    }
    return $include;
}

function get_footer() : string {
    if (file_exists((PARTS . 'footer.php'))) {
        $include = include_once(PARTS . 'footer.php');
    } else {
        $include = '
        </body>
        </html>';
    }
    return $include;
}


function upload_photo(string $name): array
{
    $error = false;
    
    // Gestion des erreurs
    $error_upload = $_FILES[$name]['error'];

    switch ($error_upload) {
        case 1:
            $error = true;
            $msg_error = "Taille max du fichier 2M ( upload_max_filesize directive in php.ini";
            break;
        // ne pas se servir de MAX_FILE_SIZE: facilement detounable
        case 2:
            $error = true;
            $msg_error = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
            break;
        case 3:
            $error = true;
            $msg_error = "The uploaded file was only partially uploaded. ";
            break;
        case 4:
            $error = true;
            $msg_error = "No file was uploaded.";
            break;
        case 6:
            $error = true;
            $msg_error = "Missing a temporary folder. ";
            break;
        case 7:
            $error = true;
            $msg_error = " Failed to write file to disk";
            break;
        case 8:
            $error = true;
            $msg_error = " A PHP extension stopped the file upload";
            break;

        // Pas d'erreur
        case 0:
            // controle de la taille du fichier
            $size = $_FILES[$name]['size'];
            if ($size > MAX_SIZE_UPLOAD) {
                $error = true;
                $msg_error = "La taille de votre fichier ne doit pas dépasser " . round(MAX_SIZE_UPLOAD / 1024, 0) . "Ko";
            }

            // controle du type de fichier
            $type = $_FILES[$name]['type'];
            if (stristr($type, 'jpg') === false && stristr($type, 'jpeg') === false) {
                $error = true;
                $msg_error = "Le fichier doit être au format jpg ou jpeg";
            }

            // controle de la dimension
            $photo_tmp = $_FILES[$name]['tmp_name'];
            // destructuration
            list($width, $height) = getimagesize($photo_tmp);

            if ($width > MAX_WIDTH) {
                $error = true;
                $msg_error = "La photo est trop grande(" . $width . "px) <br> Largeur max autorisée:" . MAX_WIDTH . "px";
            }

    } // fin switch 

    // Enregistrement de la photo
    if (empty($error)) {
        // creation d'un dossier s'il n'existe pas
        if (!file_exists('upload')) {
            //var_dump('upload don\'t exist');
            $upload = mkdir('upload/', 0777); // renvoie true si ok
            if (!$upload) {
                $error = true;
                die("Dossier d'upload non créé"); // die stop l'execution du script;
            }

        } else {
            $upload_dir = "upload/";
            // on recupere le nom du fichier
            $photo_name = basename($_FILES[$name]['name']);
            // tout en minuscule
            $photo_name = strtolower($photo_name);
            // on supprime les espaces
            $photo_name = str_replace(' ', '', $photo_name);
            // URL de la photo
            $upload_file = $upload_dir . $photo_name;

            // deplacement de la photo du dossier temporaire vers le dossier créé
            $move = move_uploaded_file($_FILES[$name]['tmp_name'], $upload_file);
            // controle du deplacement
            if ($move) {
                $image = $upload_file; // Mettre à jour la valeur de l'image
                $tab_response = [true, $image];
            } else {
                die("Problème de téléchargement");
            }
        }
        // si erreurs
    } else {
        $tab_response = [false, $msg_error];
    }

    return $tab_response;
}

