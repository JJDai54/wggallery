<?php
/*
Vous ne pouvez pas changer ou altérer une partie de ce commentaire ou des crédits
des développeurs de support à partir de ce code source ou de tout code source de support
considéré comme protégé par le droit d'auteur (c) du matériel du commentaire original ou des auteurs de crédit.

Ce programme est distribué dans l'espoir qu'il sera utile,
mais SANS AUCUNE GARANTIE ; sans même la garantie implicite de
COMMERCIALISATION ou D'ADAPTATION À UN USAGE PARTICULIER.
*/

/**
 * Module wgGallery pour xoops
 *
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package        wggallery
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */

// defines for state
\define('_CO_WGGALLERY_STATE_OFFLINE', "Hors ligne");
\define('_CO_WGGALLERY_STATE_ONLINE', "En ligne");
\define('_CO_WGGALLERY_STATE_APPROVAL', "En attente d'approbation");
// General
\define('_CO_WGGALLERY_NONE', "Aucun");
\define('_CO_WGGALLERY_BACK', "Revenir");
\define('_CO_WGGALLERY_ALL', "Tout");
\define('_CO_WGGALLERY_UPDATE', "Mettre à jour");
\define('_CO_WGGALLERY_EXEC', "Exécuter");
\define('_CO_WGGALLERY_DOWNLOAD', "Télécharger");
\define('_CO_WGGALLERY_DOWNLOAD_ALB', "Télécharger l'album");
\define('_CO_WGGALLERY_DATE', "Date");
\define('_CO_WGGALLERY_SUBMITTER', "Auteur");
\define('_CO_WGGALLERY_WEIGHT', "Poids");
\define('_CO_WGGALLERY_COMMENT', "commenter");
\define('_CO_WGGALLERY_COMMENTS', "commentaires");
\define('_CO_WGGALLERY_VIEWS', "Vues");
\define('_CO_WGGALLERY_RATING', "Classement");
\define('_CO_WGGALLERY_MB', "MB");
// Forms
\define('_CO_WGGALLERY_FORM_UPLOAD', "Envoyer un fichier");
\define('_CO_WGGALLERY_FORM_IMAGE_PATH', "Fichiers dans %s ");
\define('_CO_WGGALLERY_FORM_ACTION', "Action");
\define('_CO_WGGALLERY_FORM_EDIT', "Modification");
\define('_CO_WGGALLERY_FORM_TOGGLE_SELECT', "sélectionner / désélectionner tout");
\define('_CO_WGGALLERY_FORM_IMAGEPICKER', "Sélectionnez une image");
\define('_CO_WGGALLERY_FORM_SUBMIT_SUBMITUPLOAD', "Soumettre et envoyer les images");
\define('_CO_WGGALLERY_FORM_SUBMIT_WMTEST', "Soumettre et afficher l'image de test");
\define('_CO_WGGALLERY_FORM_ERROR_INVALIDID', "ID invalide");
\define('_CO_WGGALLERY_FORM_OK', "Enregistré avec succès");
\define('_CO_WGGALLERY_FORM_DELETE_OK', "Supprimé avec succès");
\define('_CO_WGGALLERY_FORM_SURE_DELETE', "Êtes-vous sûr de vouloir supprimer : <b><span style='color : Red;'>%s </span></b>"); //default xoops confirm
\define('_CO_WGGALLERY_FORM_SURE_RENEW', "Êtes-vous sûr de vouloir mettre à jour : <b><span style='color : Red;'>%s </span></b>");
\define('_CO_WGGALLERY_FORM_DELETE', "Supprimer"); //wggallery xoops confirm
\define('_CO_WGGALLERY_FORM_DELETE_SURE', "Voulez-vous vraiment le supprimer ?"); //wggallery xoops confirm
\define('_CO_WGGALLERY_FORM_ERROR_RESETUSAGE1', "Erreur lors de la réinitialisation de l'utilisation d'un tatouage numérique");
\define('_CO_WGGALLERY_FORM_ERROR_RESETUSAGE2', "Erreur lors de la réinitialisation de l'utilisation du tatouage numérique dans les albums");
\define('_CO_WGGALLERY_FORM_ERROR_ALBPID', "Erreur : albums parents introuvables");
\define('_CO_WGGALLERY_FORM_OK_APPROVE', "L'album a bien été enregistré. Vous serez redirigé pour approuver les images");
// There aren't
\define('_CO_WGGALLERY_THEREARENT_ALBUMS', "Il n'y a actuellement aucun album disponible");
\define('_CO_WGGALLERY_THEREARENT_IMAGES', "Il n'y a actuellement aucune image disponible");
// fine uploader
\define('_CO_WGGALLERY_FU_SUBMIT', "Soumission de l\'image : ");
\define('_CO_WGGALLERY_FU_SUBMITTED', "Image vérifiée avec succès, veuillez l\'envoyer");
\define('_CO_WGGALLERY_FU_UPLOAD', "Envoyer l\'image : ");
\define('_CO_WGGALLERY_FU_FAILED', "Des erreurs se sont produites lors de l\'envoi des images");
\define('_CO_WGGALLERY_FU_SUCCEEDED', "Envoi réussi de toutes les images");
// Album buttons
\define('_CO_WGGALLERY_ALBUM_ADD', "Ajouter un album");
\define('_CO_WGGALLERY_ALBUM_EDIT', "Modifier l'album");
// Elements of collections
\define('_CO_WGGALLERY_COLL_TITLE', "Collections disponibles");
\define('_CO_WGGALLERY_COLL_ALBUMS', "Afficher les sous-albums");
// Elements of Album
\define('_CO_WGGALLERY_ALBUMS_TITLE', "Galerie d'albums");
\define('_CO_WGGALLERY_ALBUMS_COUNT', "Nombre d'albums");
\define('_CO_WGGALLERY_ALBUM', "Album");
\define('_CO_WGGALLERY_ALBUMS', "Albums");
\define('_CO_WGGALLERY_ALBUMS_DESC', "wgGallery est un module XOOPS pour présenter des images dans des albums et des catégories");
\define('_CO_WGGALLERY_ALBUM_COLL', "Collection");
\define('_CO_WGGALLERY_ALBUM_NB_COLL', "album(s) dans cette collection");
\define('_CO_WGGALLERY_ALBUM_NB_IMAGES', "image(s) dans cet album");
\define('_CO_WGGALLERY_ALBUM_NO_IMAGES', "L'album ne contient aucune image");
\define('_CO_WGGALLERY_ALBUM_ID', "Id");
\define('_CO_WGGALLERY_ALBUM_PID', "Collection parente");
\define('_CO_WGGALLERY_ALBUM_ISCOLL', "L'album est une collection");
\define('_CO_WGGALLERY_ALBUM_NAME', "Nom");
\define('_CO_WGGALLERY_ALBUM_DESC', "Description");
\define('_CO_WGGALLERY_ALBUM_IMAGE', "Image de l'album");
\define('_CO_WGGALLERY_ALBUM_IMGTYPE', "Source de l'image de l'album");
\define('_CO_WGGALLERY_ALBUM_USE_EXIST', "Utiliser une image de l'album comme image de l'album");
\define('_CO_WGGALLERY_ALBUM_IMGID', "Images existantes dans cet album");
\define('_CO_WGGALLERY_ALBUM_USE_UPLOADED', "Utiliser une image envoyée comme image d'album");
\define('_CO_WGGALLERY_ALBUM_CREATE_GRID', "Créer une grille");
\define('_CO_WGGALLERY_ALBUM_CROP_IMAGE', "Recadrer l'image");
\define('_CO_WGGALLERY_ALBUM_FORM_UPLOAD_IMAGE', "Envoyer une nouvelle image");
\define('_CO_WGGALLERY_ALBUM_STATE', "État");
\define('_CO_WGGALLERY_ALBUM_DELETE_DESC', "Attention : toutes les images liées à cet album seront également supprimées");
\define('_CO_WGGALLERY_ALBUM_SELECT', "Sélectionnez l'album");
\define('_CO_WGGALLERY_ALBUM_SELECT_DESC', "Veuillez sélectionner l'album pour envoyer des images");
\define('_CO_WGGALLERY_ALBUMS_SHOW', "Afficher tous les albums");
\define('_CO_WGGALLERY_ALBUMS_SORT', "Tri des albums");
\define('_CO_WGGALLERY_ALBUM_SORT_SHOWHIDE', "Cliquez pour afficher / masquer les sous-éléments");
\define('_CO_WGGALLERY_ALBUM_IMAGE_ERRORNOTFOUND', "Erreur : image de l'album introuvable");
\define('_CO_WGGALLERY_ALBUMS_ERRNOTFOUND', "Erreur : image introuvable (Image-Id %s)");
// album image handler
\define('_CO_WGGALLERY_ALBUM_IH_APPLY', "Appliquer");
\define('_CO_WGGALLERY_ALBUM_IH_IMAGE_EDIT', "Modifier l'image de l'album");
\define('_CO_WGGALLERY_ALBUM_IH_CURRENT', "Actuel");
\define('_CO_WGGALLERY_ALBUM_IH_GRID4', "Utiliser 4 images");
\define('_CO_WGGALLERY_ALBUM_IH_GRID6', "Utiliser 6 images");
\define('_CO_WGGALLERY_ALBUM_IH_GRID_SRC1', "Sélectionner l'image 1");
\define('_CO_WGGALLERY_ALBUM_IH_GRID_SRC2', "Sélectionner l'image 2");
\define('_CO_WGGALLERY_ALBUM_IH_GRID_SRC3', "Sélectionner l'image 3");
\define('_CO_WGGALLERY_ALBUM_IH_GRID_SRC4', "Sélectionner l'image 4");
\define('_CO_WGGALLERY_ALBUM_IH_GRID_SRC5', "Sélectionner l'image 5");
\define('_CO_WGGALLERY_ALBUM_IH_GRID_SRC6', "Sélectionner l'image 6");
\define('_CO_WGGALLERY_ALBUM_IH_GRID_CREATE', "Créer une grille");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_CREATE', "Créer une image");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_MOVE', "Déplacer");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_ZOOMIN', "Agrandir");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_ZOOMOUT', "Réduire");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_MOVE_LEFT', "Déplacer à gauche");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_MOVE_RIGHT', "Déplacer à droite");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_MOVE_UP', "Monter");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_MOVE_DOWN', "Descendre");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_FLIP_HORIZONTAL', "Retourner horizontalement");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_FLIP_VERTICAL', "Retourner verticalement");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_ASPECTRATIO', "Ratio d'aspect");
\define('_CO_WGGALLERY_ALBUM_IH_CROP_ASPECTRATIO_FREE', "Libre");
// Image add/edit/show
\define('_CO_WGGALLERY_IMAGE_ADD', "Ajouter une image");
\define('_CO_WGGALLERY_IMAGE_EDIT', "Modifier l'image");
\define('_CO_WGGALLERY_IMAGE_SHOW', "Afficher l'image");
// Elements of Image
\define('_CO_WGGALLERY_IMAGE', "Image");
\define('_CO_WGGALLERY_IMAGES', "Images");
\define('_CO_WGGALLERY_IMAGES_TITLE', "Galerie d'images de ");
\define('_CO_WGGALLERY_IMAGES_COUNT', "Nombre d'images");
\define('_CO_WGGALLERY_IMAGES_ALBUMSHOW', "Afficher l'album");
\define('_CO_WGGALLERY_IMAGES_INDEX', "Afficher l'index des images");
\define('_CO_WGGALLERY_IMAGES_UPLOAD', "Envoyer des images");
\define('_CO_WGGALLERY_IMAGE_MANAGE', "Gestion des images");
\define('_CO_WGGALLERY_IMAGE_MANAGE_DESC', "Retrier vos images par glisser-déposer");
\define('_CO_WGGALLERY_IMAGE_ID', "Id");
\define('_CO_WGGALLERY_IMAGE_TITLE', "Titre");
\define('_CO_WGGALLERY_IMAGE_DESC', "Description");
\define('_CO_WGGALLERY_IMAGE_NAME', "Nom");
\define('_CO_WGGALLERY_IMAGE_NAMEORIG', "Nom d'origine");
\define('_CO_WGGALLERY_IMAGE_NAMELARGE', "Nom de la grande image");
\define('_CO_WGGALLERY_IMAGE_MIMETYPE', "Type Mime");
\define('_CO_WGGALLERY_IMAGE_SIZE', "Taille");
\define('_CO_WGGALLERY_IMAGE_RES', "Résolution");
\define('_CO_WGGALLERY_IMAGE_RESX', "Résx");
\define('_CO_WGGALLERY_IMAGE_RESY', "Résy");
\define('_CO_WGGALLERY_IMAGE_DOWNLOADS', "Téléchargements");
\define('_CO_WGGALLERY_IMAGE_RATINGLIKES', "Notes J'aime");
\define('_CO_WGGALLERY_IMAGE_VOTES', "Votes");
\define('_CO_WGGALLERY_IMAGE_ALBID', "Albums");
\define('_CO_WGGALLERY_IMAGE_STATE', "État");
\define('_CO_WGGALLERY_IMAGE_IP', "Ip");
\define('_CO_WGGALLERY_IMAGE_RESIZE', "Redimensionner l'image à la taille suivante :");
\define('_CO_WGGALLERY_IMAGE_THUMB', "Image miniature");
\define('_CO_WGGALLERY_IMAGE_MEDIUM', "Image moyenne");
\define('_CO_WGGALLERY_IMAGE_LARGE', "Grande image");
\define('_CO_WGGALLERY_IMAGE_ALL', "Toutes les images");
\define('_CO_WGGALLERY_IMAGE_EXIF', "Données Exif");
\define('_CO_WGGALLERY_IMAGE_ROTATE_LEFT', "Tourner vers la gauche");
\define('_CO_WGGALLERY_IMAGE_ROTATE_RIGHT', "Tourner vers la droite");
\define('_CO_WGGALLERY_IMAGE_ROTATED', "Image tournée avec succès");
\define('_CO_WGGALLERY_IMAGE_ROTATE_ERROR', "Erreur de rotation de l'image");
\define('_CO_WGGALLERY_IMAGE_ERRORUNLINK', "Erreur lors de la suppression de l'image : l'image a été supprimée dans la base de données, mais une erreur s'est produite lors de la suppression de l'image elle-même");
// Watermark add/edit
\define('_CO_WGGALLERY_WATERMARK_ADD', "Ajouter un filigrane");
\define('_CO_WGGALLERY_WATERMARK_EDIT', "Modifier le filigrane");
// Elements of Watermark
\define('_CO_WGGALLERY_WATERMARK', "Filigrane");
\define('_CO_WGGALLERY_WATERMARKS', "Filigranes");
\define('_CO_WGGALLERY_WATERMARK_ID', "Id");
\define('_CO_WGGALLERY_WATERMARK_PREVIEW', "Aperçu");
\define('_CO_WGGALLERY_WATERMARK_NAME', "Nom");
\define('_CO_WGGALLERY_WATERMARK_TYPE', "Type");
\define('_CO_WGGALLERY_WATERMARK_TYPETEXT', "Utiliser du texte");
\define('_CO_WGGALLERY_WATERMARK_TYPEIMAGE', "Utiliser une image");
\define('_CO_WGGALLERY_WATERMARK_POSITION', "Position");
\define('_CO_WGGALLERY_WATERMARK_POSTOPLEFT', "En haut à gauche");
\define('_CO_WGGALLERY_WATERMARK_POSTOPRIGHT', "En haut à droite");
\define('_CO_WGGALLERY_WATERMARK_POSTOPCENTER', "En haut au centre");
\define('_CO_WGGALLERY_WATERMARK_POSMIDDLELEFT', "Au milieu à gauche");
\define('_CO_WGGALLERY_WATERMARK_POSMIDDLERIGHT', "Au milieu à droite");
\define('_CO_WGGALLERY_WATERMARK_POSMIDDLECENTER', "Au milieu au centre");
\define('_CO_WGGALLERY_WATERMARK_POSBOTTOMLEFT', "En bas à gauche");
\define('_CO_WGGALLERY_WATERMARK_POSBOTTOMRIGHT', "En bas à droite");
\define('_CO_WGGALLERY_WATERMARK_POSBOTTOMCENTER', "En bas au centre");
\define('_CO_WGGALLERY_WATERMARK_USAGENONE', "Non utilisé actuellement");
\define('_CO_WGGALLERY_WATERMARK_USAGEALL', "Utilisation dans tous les albums");
\define('_CO_WGGALLERY_WATERMARK_USAGESINGLE', "Défini dans chaque album séparément");
\define('_CO_WGGALLERY_WATERMARK_MARGIN', "Marge");
\define('_CO_WGGALLERY_WATERMARK_MARGINLR', "Gauche / droite");
\define('_CO_WGGALLERY_WATERMARK_MARGINTB', "Haut / Bas");
\define('_CO_WGGALLERY_WATERMARK_IMAGE', "Image");
\define('_CO_WGGALLERY_FORM_UPLOAD_IMAGE_WATERMARKS', "Image dans le transfert d'images");
\define('_CO_WGGALLERY_WATERMARK_TEXT', "Texte");
\define('_CO_WGGALLERY_WATERMARK_FONT', "Police");
\define('_CO_WGGALLERY_WATERMARK_FONTFAMILY', "Famille de polices");
\define('_CO_WGGALLERY_WATERMARK_FONTSIZE', "Taille de la police");
\define('_CO_WGGALLERY_WATERMARK_COLOR', "Couleur");
\define('_CO_WGGALLERY_WATERMARK_USAGE', "Utilisation");
\define('_CO_WGGALLERY_WATERMARK_TARGET', "Type d'images pour l'ajout d'un filigrane");
\define('_CO_WGGALLERY_WATERMARK_TARGET_A', "Ajouter à tous");
\define('_CO_WGGALLERY_WATERMARK_TARGET_M', "Ajouter à moyen");
\define('_CO_WGGALLERY_WATERMARK_TARGET_L', "Ajouter à large");
// Elements of categories
\define('_CO_WGGALLERY_CAT', "Catégorie");
\define('_CO_WGGALLERY_CATS', "Catégories");
\define('_CO_WGGALLERY_CATS_SELECT', "Sélectionnez des catégories");
// Elements of Tags
\define('_CO_WGGALLERY_TAG', "Étiquette");
\define('_CO_WGGALLERY_TAGS', "Étiquettes");
\define('_CO_WGGALLERY_TAGS_ENTER', "Entrez les étiquettes (veuillez utiliser #)");
// Permissions
\define('_CO_WGGALLERY_PERMS_GLOBAL', "Autorisations globales");
\define('_CO_WGGALLERY_PERMS_GLOBAL_USECOLL', "Permissions globales pour utiliser les collections d'albums");
\define('_CO_WGGALLERY_PERMS_GLOBAL_USECOLL_DESC', "<ul><li>L'utilisateur peut combiner plusieurs albums dans une collection d'albums</li></ul>");
\define('_CO_WGGALLERY_PERMS_GLOBAL_SUBMITALL', "Permissions globales pour soumettre / modifier tous les albums");
\define('_CO_WGGALLERY_PERMS_GLOBAL_SUBMITALL_DESC', "Groupes qui devraient avoir les droits de <ul><li>créer des albums</li><li>modifier tous les albums</li><li>approuver tous les albums</li><li>envoyer des images vers tous les albums</li><li>approuver toutes les images</li></ul>");
\define('_CO_WGGALLERY_PERMS_GLOBAL_SUBMITOWN', "Autorisations globales de soumettre / modifier ses propres albums sans approbation");
\define('_CO_WGGALLERY_PERMS_GLOBAL_SUBMITOWN_DESC', "Groupes qui devraient avoir les permissions de <ul><li>créer des albums</li><li>modifier leurs propres albums</li><li>transférer des images dans leurs propres albums</li></ul>");
\define('_CO_WGGALLERY_PERMS_GLOBAL_SUBMITAPPR', "Permissions globales pour soumettre / modifier ses propres albums uniquement avec approbation");
\define('_CO_WGGALLERY_PERMS_GLOBAL_SUBMITAPPR_DESC', "Groupes qui devraient avoir les autorisations suivantes <ul><li>créer des albums</li><li>modifier ses propres albums</li><li>transférer des images vers ses propres albums</li></ul>");
\define('_CO_WGGALLERY_PERMS_GLOBAL_DESC', "<ul>
                                                <li>' . \_CO_WGGALLERY_PERMS_GLOBAL_USECOLL . ': ' . \_CO_WGGALLERY_PERMS_GLOBAL_USECOLL_DESC . '<br></li>
                                                <li>' . \_CO_WGGALLERY_PERMS_GLOBAL_SUBMITALL . ': ' . \_CO_WGGALLERY_PERMS_GLOBAL_SUBMITALL_DESC . '<br></li>
                                                <li>' . \_CO_WGGALLERY_PERMS_GLOBAL_SUBMITOWN . ': ' . \_CO_WGGALLERY_PERMS_GLOBAL_SUBMITOWN_DESC . '<br></li>
                                                <li>' . \_CO_WGGALLERY_PERMS_GLOBAL_SUBMITAPPR . ': ' . \_CO_WGGALLERY_PERMS_GLOBAL_SUBMITAPPR_DESC . '<br></li>
                                           </ul>");
\define('_CO_WGGALLERY_PERMS_ALB_VIEW', "Autorisations de voir");
\define('_CO_WGGALLERY_PERMS_ALB_VIEW_DESC', "Groupes qui ont le droit de visualiser un album");
\define('_CO_WGGALLERY_PERMS_ALB_DLFULLALB', "Permissions de télécharger l'album complet");
\define('_CO_WGGALLERY_PERMS_ALB_DLFULLALB_DESC', "Groupes qui sont autorisés à télécharger l'album complet en une seule fois");
\define('_CO_WGGALLERY_PERMS_ALB_DLIMAGE_LARGE', "Permissions de visualiser / télécharger des images de grande taille");
\define('_CO_WGGALLERY_PERMS_ALB_DLIMAGE_LARGE_DESC', "Groupes qui ont le droit de visualiser et de télécharger des images de grande taille");
\define('_CO_WGGALLERY_PERMS_ALB_DLIMAGE_MEDIUM', "Permissions de visualiser / télécharger les images moyennes");
\define('_CO_WGGALLERY_PERMS_ALB_DLIMAGE_MEDIUM_DESC', "Groupes qui ont le droit de visualiser et de télécharger les images moyennes");
\define('_CO_WGGALLERY_PERMS_NOTSET', "Aucune permission n'a été définie");
\define('_CO_WGGALLERY_PERMS_NODOWNLOAD', "Vous n'avez pas la permission de télécharger");
// exif
\define('_CO_WGGALLERY_EXIF', "Données Exif du fichier original");
\define('_CO_WGGALLERY_EXIF_ALL', "Tout afficher");
\define('_CO_WGGALLERY_EXIF_FILENAME', "Nom du fichier");
\define('_CO_WGGALLERY_EXIF_FILEDATETIME', "Date du fichier");
\define('_CO_WGGALLERY_EXIF_FILESIZE', "Taille du fichier");
\define('_CO_WGGALLERY_EXIF_MIMETYPE', "Type MIME");
\define('_CO_WGGALLERY_EXIF_CAMERA', "Marque de l'appareil photo");
\define('_CO_WGGALLERY_EXIF_MODEL', "Modèle");
\define('_CO_WGGALLERY_EXIF_EXPTIME', "Temps d'exposition");
\define('_CO_WGGALLERY_EXIF_FOCALLENGTH', "Distance focale");
\define('_CO_WGGALLERY_EXIF_DATETIMEORIG', "Date et heure d'origine");
\define('_CO_WGGALLERY_EXIF_ISO', "ISO Speed");
\define('_CO_WGGALLERY_EXIF_LENSMAKE', "Marque d'objectif");
\define('_CO_WGGALLERY_EXIF_LENSMODEL', "Modèle d'objectif");
// ---------------- Misc ----------------
\define('_CO_WGGALLERY_MAINTAINEDBY', "Entretenu par");
\define('_CO_WGGALLERY_MAINTAINEDBY_DESC', "Autoriser l'URL du site d'assistance ou de la communauté");

$moduleDirName      = \basename(\dirname(\dirname(__DIR__)));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

//Sample Data
\define('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA', "Importer des exemples de données (supprimera TOUTES les données actuelles)");
\define('CO_' . $moduleDirNameUpper . '_' . 'SAMPLEDATA_SUCCESS', "Exemple de données envoyé avec succès");
\define('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA', "Exporter les tables vers YAML");
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON', "Afficher le bouton exemple ?");
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC', "Si oui, le bouton « Ajouter des exemples de données » sera visible par l'administrateur. C'est Oui par défaut pour la première installation.");
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA', "Exporter le schéma de base de données vers YAML");
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_SUCCESS', "L'exportation du schéma de base de données vers YAML a été un succès");
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_ERROR', "ERREUR : l'exportation du schéma de base de données vers YAML a échoué");

//Menu
\define('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE', "Migrer");
\define('CO_' . $moduleDirNameUpper . '_' . 'FOLDER_YES', "Le dossier « %s » existe");
\define('CO_' . $moduleDirNameUpper . '_' . 'FOLDER_NO', "Le dossier « %s » n'existe pas. Créez le dossier spécifié avec CHMOD 777.");
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS', "Afficher le bouton des outils de développement ?");
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC', "Si oui, l'onglet « Migrer » et les autres outils de développement seront visibles par l'administrateur.");
\define('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_FEEDBACK', "Retour d'informations");

//Latest Version Check
\define('CO_' . $moduleDirNameUpper . '_' . 'NEW_VERSION', "Nouvelle version : ");
\define('CO_' . $moduleDirNameUpper . '_' . 'ERROR_BAD_XOOPS', "Vous avez besoin au minimum de la version %s (votre version actuelle est %s)"); 
\define('CO_' . $moduleDirNameUpper . '_' . 'ERROR_BAD_PHP', "Vous avez besoin au minimum de la version %s (votre version actuelle est %s)");

\define('_CO_WGGALLERY_FORM_CLEAR_ALBUM', "Suppression des images de l&apos;album");
\define('_CO_WGGALLERY_FORM_CLEAR_ALBUM_OK', "Suppression des images avec succès");
\define('_CO_WGGALLERY_FORM_SURE_CLEAR_ALBUM', "Êtes-vous de vouloir supprimer toutes les <b><span style='color : Red;'>%s </span></b> images de l'album : <b><span style='color : Red;'>%s </span></b>"); //default xoops confirm
\define('_CO_WGGALLERY_COLLECTION', "Collection");
\define('_CO_WGGALLERY_COLLECTIONS', "Collections");
\define('_CO_WGGALLERY_MANAGE_ALBUMS', "Gestion des albums");
\define('_CO_WGGALLERY_ALL_ALBUMS', "Tous les albums");
\define('_AM_WGGALLERY_SET_COLL_PERMISSIONS', "Appliquer les permissions de la collection aux albums");
\define('_CO_WGGALLERY_SURE_SET_COLL_PERM', "Êtes-vous de vouloir appliquer les permissions aux <b><span style='color : Red;'>%s </span></b> albums de la collection : <b><span style='color : Red;'>%s </span></b>");  
\define('_CO_WGGALLERY_SET_COLL_PERM_OK', "Application avec succès des permissions aux albums de la collection ");
\define('_CO_WGGALLERY_VIEW_ALBUM', "Voir l&apos;album");
\define('_CO_WGGALLERY_COLLECTIONS_ROOT', "Collections à la racine");

