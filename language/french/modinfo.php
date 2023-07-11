<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgGallery module for xoops
 *
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package        wggallery
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */
 
require_once __DIR__ . '/common.php';

// ---------------- Admin Main ----------------
\define('_MI_WGGALLERY_NAME', "wgGallery");
\define('_MI_WGGALLERY_DESC', "Ce module est une galerie d'images pour XOOPS");
// ---------------- Admin Menu ----------------
\define('_MI_WGGALLERY_ADMENU1', "Tableau de bord");
\define('_MI_WGGALLERY_ADMENU2', "Albums");
\define('_MI_WGGALLERY_ADMENU3', "Images");
\define('_MI_WGGALLERY_ADMENU4', "Types de galeries");
\define('_MI_WGGALLERY_ADMENU5', "Types d'album");
\define('_MI_WGGALLERY_ADMENU7', "Permissions");
\define('_MI_WGGALLERY_ADMENU8', "Maintenance");
\define('_MI_WGGALLERY_ADMENU9', "Filigranes");
\define('_MI_WGGALLERY_ADMENU10', "Importer");
\define('_MI_WGGALLERY_ADMENU11', "Catégories");
\define('_MI_WGGALLERY_ADMENU12', "Envoi groupé");
\define('_MI_WGGALLERY_ADMENU13', "Cloner le module");
\define('_MI_WGGALLERY_FEEDBACK', "Retour d'informations");
\define('_MI_WGGALLERY_ABOUT', "À propos");
// ---------------- Admin Nav ----------------
\define('_MI_WGGALLERY_ADMIN_PAGER', "Pages d'administration des éléments de la liste");
\define('_MI_WGGALLERY_ADMIN_PAGER_DESC', "Définissez le nombre d'éléments de la liste dans la zone d'administration");
// User
\define('_MI_WGGALLERY_USER_PAGER', "Page utilisateur des éléments de la liste");
\define('_MI_WGGALLERY_USER_PAGER_DESC', "Définir le nombre d'éléments de la liste dans la zone utilisateur");
// Submenu
\define('_MI_WGGALLERY_SMNAME1', "Sommaire");
\define('_MI_WGGALLERY_SMNAME2', "Gestion des albums");
\define('_MI_WGGALLERY_SMNAME3', "Créer un nouvel album");
\define('_MI_WGGALLERY_SMNAME4', "Envoyer des images");
\define('_MI_WGGALLERY_SMNAME5', "Gestion d'images");
\define('_MI_WGGALLERY_SMNAME6', "Rechercher des images");
\define('_MI_WGGALLERY_SMNAME7', "Charger une seule image");
// Blocks
\define('_MI_WGGALLERY_ALBUMS_BLOCK', "Bloc Albums");
\define('_MI_WGGALLERY_ALBUMS_BLOCK_DESC', "Afficher un bloc avec des albums (le tri peut être sélectionné)");
\define('_MI_WGGALLERY_IMAGES_BLOCK', "Bloc Images");
\define('_MI_WGGALLERY_IMAGES_BLOCK_DESC', "Afficher un bloc avec des images (le tri peut être sélectionné)");
// Config
\define('_MI_WGGALLERY_EDITOR', "Éditeur");
\define('_MI_WGGALLERY_EDITOR_DESC', "Sélectionnez l'éditeur à utiliser");
\define('_MI_WGGALLERY_KEYWORDS', "Mots-clés");
\define('_MI_WGGALLERY_KEYWORDS_DESC', "Insérez ici les mots-clés (séparés par des virgules)");
\define('_MI_WGGALLERY_SIZE_MB', "Mo");
\define('_MI_WGGALLERY_MAXSIZE', "Taille max");
\define('_MI_WGGALLERY_MAXSIZE_DESC', "Définir la taille de fichier maximale pour les fichiers envoyés");
\define('_MI_WGGALLERY_FILEEXT', "Extension de fichier autorisée");
\define('_MI_WGGALLERY_FILEEXT_DESC', "Définissez l'extension de fichiers autorisée pour l'envoi");
\define('_MI_WGGALLERY_MAXWIDTH', "Largeur maximum de l'envoi");
\define('_MI_WGGALLERY_MAXWIDTH_DESC', "Définissez la largeur maximale autorisée pour l'envoi d'images (en pixels)");
\define('_MI_WGGALLERY_MAXHEIGHT', "Hauteur maximale de l'envoi");
\define('_MI_WGGALLERY_MAXHEIGHT_DESC', "Définissez la hauteur maximale autorisée pour l'envoi d'images (en pixels)");
\define('_MI_WGGALLERY_MAXWIDTH_LARGE', "Largeur maximum des images larges");
\define('_MI_WGGALLERY_MAXWIDTH_LARGE_DESC', "Définissez la largeur maximale à laquelle les images envoyées doivent être mises à l'échelle (en pixels)<br>0 signifie que les grandes images conservent la taille d'origine. <br>Si une image est plus petite que la valeur maximale, l'image ne sera pas agrandie, elle sera enregistrée dans sa taille d'origine.");
\define('_MI_WGGALLERY_MAXHEIGHT_LARGE', "Hauteur maximale des images larges");
\define('_MI_WGGALLERY_MAXHEIGHT_LARGE_DESC', "Définissez la hauteur maximale à laquelle les images envoyées doivent être mises à l'échelle (en pixels)<br>0 signifie que les grandes images conservent leur taille d'origine. <br>Si une image est inférieure à la valeur maximale, l'image ne sera pas agrandie, elle sera enregistrée dans sa taille d'origine.");
\define('_MI_WGGALLERY_MAXWIDTH_MEDIUM', "Largeur maximum des images moyennes");
\define('_MI_WGGALLERY_MAXWIDTH_MEDIUM_DESC', "Définissez la largeur maximale à laquelle les images envoyées seront mises à l'échelle pour une image moyenne (en pixels)<br>Si l'image grande / originale est plus petite, l'image ne sera pas agrandie (la grande image sera copiée comme support)");
\define('_MI_WGGALLERY_MAXHEIGHT_MEDIUM', "Hauteur maximale des images moyennes");
\define('_MI_WGGALLERY_MAXHEIGHT_MEDIUM_DESC', "Définissez la hauteur maximale à laquelle les images envoyées doivent être mises à l'échelle pour une image moyenne (en pixels)<br>Si l'image grande / originale est plus petite, l'image ne sera pas agrandie (la grande image sera copiée comme support)");
\define('_MI_WGGALLERY_MAXWIDTH_THUMBS', "Largeur maximale pour les vignettes");
\define('_MI_WGGALLERY_MAXWIDTH_THUMBS_DESC', "Définissez la largeur maximale à laquelle les images envoyées seront mises à l'échelle pour les vignettes (en pixels)");
\define('_MI_WGGALLERY_MAXHEIGHT_THUMBS', "Hauteur maximale des vignettes");
\define('_MI_WGGALLERY_MAXHEIGHT_THUMBS_DESC', "Définissez la hauteur maximale à laquelle les images envoyées doivent être mises à l'échelle pour les vignettes (en pixels)");
\define('_MI_WGGALLERY_MAXWIDTH_ALBIMAGE', "Largeur maximale pour les images des albums");
\define('_MI_WGGALLERY_MAXWIDTH_ALBIMAGE_DESC', "Définissez la largeur maximale à laquelle les images envoyées seront mises à l'échelle pour les images d'album (en pixels)<br>Si vous utilisez une image de l'album lui-même, cette option n'a aucun effet");
\define('_MI_WGGALLERY_MAXHEIGHT_ALBIMAGE', "Hauteur maximale des images des albums");
\define('_MI_WGGALLERY_MAXHEIGHT_ALBIMAGE_DESC', "Définissez la hauteur maximale à laquelle les images envoyées doivent être mises à l'échelle pour les images d'album (en pixels)<br>Si vous utilisez une image de l'album lui-même, cette option n'a aucun effet");
\define('_MI_WGGALLERY_GALLERY_TARGET', "Objectif pour les galeries");
\define('_MI_WGGALLERY_GALLERY_TARGET_DESC', "Veuillez sélectionner où une galerie doit être ouverte");
\define('_MI_WGGALLERY_LINK_TARGET_SELF', "Même fenêtre / onglet");
\define('_MI_WGGALLERY_LINK_TARGET_BLANK', "Nouvelle fenêtre / onglet");
\define('_MI_WGGALLERY_IMAGE_TARGET', "Objectif pour une seule image");
\define('_MI_WGGALLERY_IMAGE_TARGET_DESC', "Veuillez sélectionner où une image seule doit être affichée");
\define('_MI_WGGALLERY_LINK_TARGET_MODAL', "Afficher l'image comme modale sans informations");
\define('_MI_WGGALLERY_LINK_TARGET_MODALINFO', "Afficher l'image en modal avec des informations détaillées sur l'image");
\define('_MI_WGGALLERY_ADDJQUERY', "Ajouter la bibliothèque jquery");
\define('_MI_WGGALLERY_ADDJQUERY_DESC', "Si vous utilisez déjà jquery (par exemple dans votre thème), définissez-le sur NON");
\define('_MI_WGGALLERY_PANEL_TYPE', "Type de panneau");
\define('_MI_WGGALLERY_PANEL_TYPE_DESC', "Le type de panneau est le div html bootstrap.");
\define('_MI_WGGALLERY_SHOWBCRUMBS', "Afficher la navigation dans le fil d'Ariane");
\define('_MI_WGGALLERY_SHOWBCRUMBS_DESC', "La navigation en fil d'Ariane affiche le contexte de la page actuelle dans la structure du site.");
\define('_MI_WGGALLERY_SHOWBCRUMBS_MNAME', "Afficher le nom du module");
\define('_MI_WGGALLERY_SHOWBCRUMBS_MNAME_DESC', "Afficher le nom du module dans le fil d'Ariane");
\define('_MI_WGGALLERY_SHOWCOPYRIGHT', "Afficher les droits d'auteur");
\define('_MI_WGGALLERY_SHOWCOPYRIGHT_DESC', "Vous pouvez supprimer les droits d'auteur de la galerie, mais un retour de lien vers www.wedega.com est attendu, n'importe où sur votre site");
\define('_MI_WGGALLERY_USE_CATS', "Utiliser des catégories");
\define('_MI_WGGALLERY_USE_CATS_DESC', "Définissez si vous souhaitez utiliser des catégories pour les images et les albums");
\define('_MI_WGGALLERY_USE_TAGS', "Utiliser des mots-clés");
\define('_MI_WGGALLERY_USE_TAGS_DESC', "Définissez si vous souhaitez utiliser des mots-clés pour les images et les albums");
\define('_MI_WGGALLERY_STOREEXIF', "Enregistrer les métadonnées (exif)");
\define('_MI_WGGALLERY_STOREEXIF_DESC', "Définissez si vous souhaitez enregistrer les métadonnées (exif) des images");
\define('_MI_WGGALLERY_EXIFTYPES', "Données exif à afficher");
\define('_MI_WGGALLERY_EXIFTYPES_DESC', "Définir quelles données exif doivent être affichées<br>L'option « Enregistrer les métadonnées (exif) » doit être activée");
\define('_MI_WGGALLERY_EXIF_TAGS', "Extraire les mots-clés d'exif");
\define('_MI_WGGALLERY_EXIF_TAGS_DESC', "Définir quelles données exif doivent être automatiquement extraites de exif et ajoutées à une image en tant que balise<br>L'option « Utiliser les balises » doit être activée");
\define('_MI_WGGALLERY_SHOWBUTTONTEXT', "Afficher le texte du bouton");
\define('_MI_WGGALLERY_SHOWBUTTONTEXT_DESC', "Afficher le texte du bouton. Si NON, seules les images seront affichées");
\define('_MI_WGGALLERY_GROUP_UPLOAD', "Options de téléchargement d'images");
\define('_MI_WGGALLERY_GROUP_IMAGE', "Options de traitement d'image");
\define('_MI_WGGALLERY_GROUP_DISPLAY', "Options d'affichage");
\define('_MI_WGGALLERY_GROUP_MISC', "Options diverses");
\define('_MI_WGGALLERY_IDX_ALBLIST', "Afficher la liste des albums dans l'index");
\define('_MI_WGGALLERY_IDX_ALBLIST_DESC', "Précisez si vous souhaitez afficher une liste d'albums sur la page d'index et quel type d'album");
\define('_MI_WGGALLERY_IDX_ALBLIST_NONE', "Aucune liste");
\define('_MI_WGGALLERY_IDX_ALBLIST_LIST', "Liste uniquement");
\define('_MI_WGGALLERY_IDX_ALBLIST_LISTTHUMB', "Liste avec vignettes");
\define('_MI_WGGALLERY_UPLOADER', "Possibilités de transfert");
\define('_MI_WGGALLERY_UPLOADER_DESC', "Définissez les possibilités de transfert que vous souhaitez utiliser.");
\define('_MI_WGGALLERY_UPLOADER_NONE', "Pas de fonction d'envoi du côté de l'utilisateur");
\define('_MI_WGGALLERY_UPLOADER_MULTI', "Utiliser uniquement le transfert multiple");
\define('_MI_WGGALLERY_UPLOADER_SINGLE', "Utiliser le transfert unique exclusivement.");
\define('_MI_WGGALLERY_UPLOADER_BOTHMULTI', "Utilisez les deux (chargement multiple primaire)");
\define('_MI_WGGALLERY_UPLOADER_BOTHSINGLE', "Utiliser les deux (chargement multiple primaire)");
\define('_MI_WGGALLERY_STORE_ORIGINAL', "Stocker l'image d'origine");
\define('_MI_WGGALLERY_STORE_ORIGINAL_DESC', "Définissez si vous souhaitez stocker l'image d'origine.
                <br>Avantage : toutes les images peuvent être reproduites plus tard, y compris de nouveaux tatouages numériques
                <br>Inconvénient : l'espace serveur utilisé augmentera en fonction de la taille du fichier d'envoi autorisée");
define('_MI_WGGALLERY_TAGMODULE', "Utiliser le module TAG pour générer des balises");
define('_MI_WGGALLERY_TAGMODULE_DESC', "Définissez si vos balises d'image doivent également être affichées dans le module TAG<br>- Le module 'TAG' doit être installé<br>- L'option 'Utiliser les balises' doit être activée");
// Notifications
\define('_MI_WGGALLERY_GLOBAL_NOTIFY', "Notifications Globales");
\define('_MI_WGGALLERY_GLOBAL_ALB_NEW_ALL_NOTIFY', "Envoyer une notification lorsqu'un nouvel album a été créé");
\define('_MI_WGGALLERY_GLOBAL_ALB_NEW_ALL_NOTIFY_CAPTION', "M'avertir d'un nouvel album");
\define('_MI_WGGALLERY_GLOBAL_ALB_NEW_ALL_NOTIFY_SUBJECT', "Notification concernant un nouvel album");
\define('_MI_WGGALLERY_GLOBAL_ALB_MODIFY_ALL_NOTIFY', "Envoyer une notification lorsqu'un album a été modifié");
\define('_MI_WGGALLERY_GLOBAL_ALB_MODIFY_ALL_NOTIFY_CAPTION', "M'avertir de toute modification d'album");
\define('_MI_WGGALLERY_GLOBAL_ALB_MODIFY_ALL_NOTIFY_SUBJECT', "Notification concernant l'album modifié");
\define('_MI_WGGALLERY_GLOBAL_ALB_APPROVE_ALL_NOTIFY', "Envoyer une notification lorsqu'un album est en attente d'approbation");
\define('_MI_WGGALLERY_GLOBAL_ALB_APPROVE_ALL_NOTIFY_CAPTION', "M'avertir quand un album est en attente d'approbation");
\define('_MI_WGGALLERY_GLOBAL_ALB_APPROVE_ALL_NOTIFY_SUBJECT', "Notification d'un album en attente d'approbation");
\define('_MI_WGGALLERY_GLOBAL_ALB_DELETE_ALL_NOTIFY', "Envoyer une notification lorsqu'un album a été supprimé");
\define('_MI_WGGALLERY_GLOBAL_ALB_DELETE_ALL_NOTIFY_CAPTION', "M'avertir pour tout album supprimé");
\define('_MI_WGGALLERY_GLOBAL_ALB_DELETE_ALL_NOTIFY_SUBJECT', "Notification concernant la suppression d'un album");
\define('_MI_WGGALLERY_GLOBAL_IMG_NEW_ALL_NOTIFY', "Envoyer une notification lorsqu'une nouvelle image a été envoyée");
\define('_MI_WGGALLERY_GLOBAL_IMG_NEW_ALL_NOTIFY_CAPTION', "M'avertir pour toute nouvelle image");
\define('_MI_WGGALLERY_GLOBAL_IMG_NEW_ALL_NOTIFY_SUBJECT', "Notification pour une nouvelle image");
\define('_MI_WGGALLERY_GLOBAL_IMG_DELETE_ALL_NOTIFY', "Envoyer une notification lorsqu'une image a été supprimée");
\define('_MI_WGGALLERY_GLOBAL_IMG_DELETE_ALL_NOTIFY_CAPTION', "M'avertir de la suppression d'une image");
\define('_MI_WGGALLERY_GLOBAL_IMG_DELETE_ALL_NOTIFY_SUBJECT', "Notification pour l'image supprimée");
\define('_MI_WGGALLERY_ALBUMS_NOTIFY', "Notifications pour les albums");
\define('_MI_WGGALLERY_ALBUMS_ALB_MODIFY_NOTIFY', "Envoyer une notification lorsque cet album a été modifié");
\define('_MI_WGGALLERY_ALBUMS_ALB_MODIFY_NOTIFY_CAPTION', "Me prévenir de la modification de cet album");
\define('_MI_WGGALLERY_ALBUMS_ALB_MODIFY_NOTIFY_SUBJECT', "Notification concernant un album modifié");
\define('_MI_WGGALLERY_ALBUMS_ALB_DELETE_NOTIFY', "Envoyer une notification lorsque cet album a été supprimé");
\define('_MI_WGGALLERY_ALBUMS_ALB_DELETE_NOTIFY_CAPTION', "M'informer de la suppression de cet album");
\define('_MI_WGGALLERY_ALBUMS_ALB_DELETE_NOTIFY_SUBJECT', "Notification concernant l'album supprimé");
\define('_MI_WGGALLERY_ALBUMS_IMG_NEW_NOTIFY', "Envoyer une notification lorsqu'une nouvelle image a été envoyée dans cet album");
\define('_MI_WGGALLERY_ALBUMS_IMG_NEW_NOTIFY_CAPTION', "Me prévenir d'une nouvelle image de cet album");
\define('_MI_WGGALLERY_ALBUMS_IMG_NEW_NOTIFY_SUBJECT', "Notification pour une nouvelle image");
\define('_MI_WGGALLERY_ALBUMS_IMG_APPROVE_NOTIFY', "Envoyer une notification lorsqu'une image est en attente d'approbation");
\define('_MI_WGGALLERY_ALBUMS_IMG_APPROVE_NOTIFY_CAPTION', "M'avertir d'une image en attente d'approbation");
\define('_MI_WGGALLERY_ALBUMS_IMG_APPROVE_NOTIFY_SUBJECT', "Notification d'une image en attente d'approbation");
\define('_MI_WGGALLERY_ALBUMS_IMG_DELETE_NOTIFY', "Envoyer une notification lorsqu'une nouvelle image a été supprimée de cet album");
\define('_MI_WGGALLERY_ALBUMS_IMG_DELETE_NOTIFY_CAPTION', "Me prévenir de la suppression d'une image de cet album");
\define('_MI_WGGALLERY_ALBUMS_IMG_DELETE_NOTIFY_SUBJECT', "Notification pour une image supprimée");
\define('_MI_WGGALLERY_GLOBAL_IMG_COMMENT_NOTIFY', "M'avertir des nouveaux commentaires sur les images");
\define('_MI_WGGALLERY_GLOBAL_IMG_COMMENT_NOTIFY_CAPTION', "Me prévenir des commentaires pour les images");
\define('_MI_WGGALLERY_GLOBAL_IMG_COMMENT_NOTIFY_SUBJECT', "Notification des commentaires pour une image");
\define('_MI_WGGALLERY_ALBUMS_IMG_COMMENT_NOTIFY', "Me notifier des nouveaux commentaires pour les images de cet album");
\define('_MI_WGGALLERY_ALBUMS_IMG_COMMENT_NOTIFY_CAPTION', "M'avertir des commentaires sur les images de cet album");
\define('_MI_WGGALLERY_ALBUMS_IMG_COMMENT_NOTIFY_SUBJECT', "Notification d'un nouveau commentaire pour une image");
\define('_MI_WGGALLERY_IMAGES_NOTIFY', "Notifications sur les images");
\define('_MI_WGGALLERY_IMAGES_IMG_COMMENT_NOTIFY', "Me prévenir des nouveaux commentaires pour cette image");
\define('_MI_WGGALLERY_IMAGES_IMG_COMMENT_NOTIFY_CAPTION', "M'avertir des commentaires sur cette image");
\define('_MI_WGGALLERY_IMAGES_IMG_COMMENT_NOTIFY_SUBJECT', "Notification d'un nouveau commentaire pour une image");
//ratings
\define('_MI_WGGALLERY_RATINGBARS', "Autoriser l'évaluation");
\define('_MI_WGGALLERY_RATINGBARS_DESC', "Définir si la notation doit être possible et quel type de notation doit être utilisée");
\define('_MI_WGGALLERY_RATINGBAR_GROUPS', "Groupes avec droits de notation");
\define('_MI_WGGALLERY_RATINGBAR_GROUPS_DESC', "Définir quels groupes devraient avoir le droit de noter");
\define('_MI_WGGALLERY_RATING_NONE', "Ne pas utiliser l'évaluation");
\define('_MI_WGGALLERY_RATING_5STARS', "Note avec 5 étoiles");
\define('_MI_WGGALLERY_RATING_10STARS', "Note avec 10 étoiles");
\define('_MI_WGGALLERY_RATING_LIKES', "Note avec des j'aime");
\define('_MI_WGGALLERY_RATING_10NUM', "Note avec 10 points");
