<?php

namespace App;

class Functions
{
    /**
     * Cette fonction permet de retourner une série aléatoire de 65 caractères
     * @return string
     */
    public static function createToken() : string{
        return uniqid(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_@'));
    }

    /**
     * Cette function retourne une suite de 10 Caractères numérique ;
     * @return string
     */
    public static function createCode() : string{
        return substr(str_shuffle("0123456789012345678901234567890123456789"), 1, 10);
    }

    public static function uploadFiles($file, $uploadDir, $type = 'picture'): array
    {
        if ($type === 'picture' ) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $name = 'img';
        } else {
            $allowedExtensions = ['pdf', 'docx'];
            $name = 'doc';
        }
        $maxFileSize = 200000000;
        $error = false;
        $success = false;
        // Vérifier s'il y a une erreur lors du téléchargement
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error = "Erreur lors du téléchargement du fichier.";
        }

        // Vérifier la taille du fichier
        if ($file['size'] > $maxFileSize) {
            $error =  "Le fichier est trop volumineux.";
        }

        // Vérifier l'extension du fichier
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            $error = "Extension de fichier non autorisée.";
        }
        $name .= self::createCode() . date('YmdHis') . basename($file['name']);
        // Enregistrer le fichier
        $uploadPath = "$uploadDir{$name}";
        if ($error === false) {
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) $success = true;else {
                $error .= "Erreur lors de l'enregistrement du fichier.";
            }
        }
        return compact('success', 'error', 'name');

    }


}