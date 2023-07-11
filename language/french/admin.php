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

// ---------------- Admin Index ----------------
\define('_AM_WGGALLERY_STATISTICS', 'Statistiques');
// There are
\define('_AM_WGGALLERY_THEREARE_ALBUMS', "Il y a <span class='bold'>%s</span> albums dans la base de données");
\define('_AM_WGGALLERY_THEREARE_IMAGES', "Il y a <span class='bold'>%s</span> images dans la base de données");
\define('_AM_WGGALLERY_THEREARE_GALLERYTYPES', "Il y a <span class='bold'>%s</span> types de galeries dans la base de données");
\define('_AM_WGGALLERY_THEREARE_ALBUMTYPES', "Il y a <span class='bold'>%s</span> types d'albums dans la base de données");
\define('_AM_WGGALLERY_THEREARE_WATERMARKS', "Il y a <span class='bold'>%s</span> filigranes dans la base de données");
\define('_AM_WGGALLERY_THEREARE_CATEGORIES', "Il y a <span class='bold'>%s</span> catégories dans la base de données");
// There aren't
\define('_AM_WGGALLERY_THEREARENT_GALLERYTYPES', "Il n'y a pas de types de galeries ! Pour l'initialisation / réinitialisation, allez à « Maintenance » => « Maintenir les types de galerie » et cliquez sur le bouton « Définir les paramètres par défaut »");
\define('_AM_WGGALLERY_THEREARENT_ALBUMTYPES', "Il n'y a pas de types d'album ! Pour l'initialisation / réinitialisation, allez à « Maintenance » => « Maintenir les types d'album » et cliquez sur le bouton « Définir les paramètres par défaut »");
\define('_AM_WGGALLERY_THEREARENT_WATERMARKS', 'Actuellement, aucun tatouage numérique n\'est défini !');
\define('_AM_WGGALLERY_THEREARENT_CATEGORIES', "Il n'y a pas de catégories !");
// ---------------- Admin Files ----------------
// Buttons
\define('_AM_WGGALLERY_ADD_ALBUM', 'Ajouter un nouvel album');
\define('_AM_WGGALLERY_ADD_IMAGE', 'Ajouter une nouvelle image');
\define('_AM_WGGALLERY_ADD_IMAGES', 'Envoi multiple des images');
\define('_AM_WGGALLERY_ADD_BATCH', 'Envoyer des images par lot');
\define('_AM_WGGALLERY_ADD_GALLERYTYPE', 'Ajouter un nouveau type de galeries');
\define('_AM_WGGALLERY_ADD_ALBUMTYPE', 'Ajouter un nouveau type d\'album');
\define('_AM_WGGALLERY_ADD_CATEGORY', 'Ajouter une nouvelle catégorie');
// Lists
\define('_AM_WGGALLERY_ALBUMS_LIST', 'Liste d\'albums');
\define('_AM_WGGALLERY_ALBUMS_APPROVE', 'Albums en attente d\'approbation');
\define('_AM_WGGALLERY_IMAGES_LIST', 'Liste d\'images');
\define('_AM_WGGALLERY_IMAGES_APPROVE', 'Images en attente d\'approbation');
\define('_AM_WGGALLERY_GALLERYTYPES_LIST', 'Liste de types de galeries');
\define('_AM_WGGALLERY_ALBUMTYPES_LIST', 'Liste de types d\'albums');
\define('_AM_WGGALLERY_WATERMARKS_LIST', 'Liste de tatouages numériques');
\define('_AM_WGGALLERY_CATEGORIES_LIST', 'Liste de catégories');
// Album
\define('_AM_WGGALLERY_ALBUM_IMGNAME', "Nom de l'image de l'album (si « Utiliser une image envoyée comme image de l'album »)");
\define('_AM_WGGALLERY_ALBUM_IMGID', "ID de l'image de l'album (si « Images existantes dans cet album »)");
//Categories
\define('_AM_WGGALLERY_EDIT_CATEGORY', 'Modifier la catégorie');
\define('_AM_WGGALLERY_CAT_ID', 'ID');
\define('_AM_WGGALLERY_CAT_TEXT', 'Texte de la catégorie');
\define('_AM_WGGALLERY_CAT_EXIF', 'Nom exif pour la catégorie');
\define('_AM_WGGALLERY_CAT_ALBUM', 'Utiliser la catégorie pour les albums');
\define('_AM_WGGALLERY_CAT_IMAGE', 'Utiliser la catégorie pour les images');
\define('_AM_WGGALLERY_CAT_SEARCH', 'Utiliser la catégorie pour la recherche');
\define('_AM_WGGALLERY_CAT_ERROR_CHANGE', 'Erreur lors du changement d\'option');
// Elements of Gallerytype
\define('_AM_WGGALLERY_GT_AT_ID', 'ID');
\define('_AM_WGGALLERY_GT_AT_PRIMARY', 'Primaire');
\define('_AM_WGGALLERY_GT_AT_PRIMARY_1', 'Actuellement primaire');
\define('_AM_WGGALLERY_GT_AT_PRIMARY_0', 'Actuellement non primaire');
\define('_AM_WGGALLERY_GT_AT_PRIMARY_SET', 'Défini sur primaire');
\define('_AM_WGGALLERY_GT_AT_NAME', 'Nom');
\define('_AM_WGGALLERY_GT_AT_CREDITS', 'Remerciements');
\define('_AM_WGGALLERY_GT_AT_TEMPLATE', 'Thème');
\define('_AM_WGGALLERY_GT_AT_OPTIONS', 'Option');
\define('_AM_WGGALLERY_GT_AT_DATE', 'Date');
// Gallerytype add/edit
\define('_AM_WGGALLERY_GALLERYTYPE_ADD', 'Ajouter un type de galerie');
\define('_AM_WGGALLERY_GALLERYTYPE_EDIT', 'Modifier le type de galerie');
// Elements of Gallery options
\define('_AM_WGGALLERY_OPTION_GT_SET', 'Définir les options pour le type de galerie sélectionné');
\define('_AM_WGGALLERY_OPTION_GT_SOURCE', 'Source du diaporama');
\define('_AM_WGGALLERY_OPTION_GT_SOURCE_DESC',
       "Faites attention : si l'utilisateur n'a pas à envoyer de grandes images, la source sera automatiquement réduite à moyenne pour cet utilisateur afin d'éviter un envoi non autorisé par un clic droit de la souris.<br>L'utilisateur ayant le droit d'envoyer de grandes images verra également de grandes images, si vous avez sélectionné « grandes images ».");
\define('_AM_WGGALLERY_OPTION_GT_SOURCE_PREVIEW', 'Aperçu de la source');
\define('_AM_WGGALLERY_OPTION_GT_SOURCE_LARGE', 'grandes images');
\define('_AM_WGGALLERY_OPTION_GT_SOURCE_MEDIUM', 'images moyennes');
\define('_AM_WGGALLERY_OPTION_GT_SOURCE_THUMB', 'vignettes');
// jssor
\define('_AM_WGGALLERY_OPTION_GT_ARROWS', 'Type de flèches');
\define('_AM_WGGALLERY_OPTION_GT_BULLETS', 'Type de puces');
\define('_AM_WGGALLERY_OPTION_GT_BULLETS_DESC', 'N\'utilisez pas de puces avec des vignettes');
\define('_AM_WGGALLERY_OPTION_GT_THUMBNAILS', 'Type de listes de vignettes');
\define('_AM_WGGALLERY_OPTION_GT_LOADINGS', 'Type de symboles de chargement');
\define('_AM_WGGALLERY_OPTION_GT_AUTOPLAY', 'Lecture automatique');
\define('_AM_WGGALLERY_OPTION_GT_PLAYOPTIONS', 'Options de lecture');
\define('_AM_WGGALLERY_OPTION_GT_PLAYOPTION_1', 'jouer en continu');
\define('_AM_WGGALLERY_OPTION_GT_PLAYOPTION_2', 'arrêter à la dernière diapositive');
\define('_AM_WGGALLERY_OPTION_GT_PLAYOPTION_4', 'arrêter au clic');
\define('_AM_WGGALLERY_OPTION_GT_PLAYOPTION_8', 'arrêter la navigation de l\'utilisateur (cliquer sur la flèche / puce / vignette, faire défiler la diapositive, appuyer sur le clavier vers la gauche, la flèche de droite)');
\define('_AM_WGGALLERY_OPTION_GT_PLAYOPTION_12', 'arrêter au clic ou à la navigation de l\'utilisateur');
\define('_AM_WGGALLERY_OPTION_GT_FILLMODE', 'Options pour le mode de remplissage');
\define('_AM_WGGALLERY_OPTION_GT_FILLMODE_0', 'Étendu');
\define('_AM_WGGALLERY_OPTION_GT_FILLMODE_1', 'Contenu (conserver les proportions et mettre tout à l\'intérieur de la diapositive)');
\define('_AM_WGGALLERY_OPTION_GT_FILLMODE_2', 'Couvert (conserver les proportions et couvrir toute la diapositive)');
\define('_AM_WGGALLERY_OPTION_GT_FILLMODE_4', 'taille actuelle');
\define('_AM_WGGALLERY_OPTION_GT_FILLMODE_5', 'contenu pour grande image et taille actuelle pour petite image');
\define('_AM_WGGALLERY_OPTION_GT_SLIDERTYPE', 'Type de diaporama');
\define('_AM_WGGALLERY_OPTION_GT_SLIDERTYPE_1', 'Taille définie');
\define('_AM_WGGALLERY_OPTION_GT_SLIDERTYPE_2', 'Largeur totale du modèle');
// \define('_AM_WGGALLERY_OPTION_GT_SLIDERTYPE_3', 'Pleine fenêtre');
\define('_AM_WGGALLERY_OPTION_GT_MAXWIDTH', 'Largeur maximale de l\'image');
\define('_AM_WGGALLERY_OPTION_GT_MAXWIDTH_DESC', "Définissez la largeur maximale de l'image pour le conteneur d'image en pixels. Non valide pour « Largeur totale du modèle »");
\define('_AM_WGGALLERY_OPTION_GT_MAXHEIGHT', 'Hauteur maximale de l\'image');
\define('_AM_WGGALLERY_OPTION_GT_MAXHEIGHT_DESC', "Définissez la hauteur d'image maximale pour le conteneur d'image en pixels Non valide pour « Largeur totale du modèle »");
\define('_AM_WGGALLERY_OPTION_GT_ORIENTATION', 'Orientation');
\define('_AM_WGGALLERY_OPTION_GT_ORIENTATION_H', 'Horizontal');
\define('_AM_WGGALLERY_OPTION_GT_ORIENTATION_V', 'Vertical');
\define('_AM_WGGALLERY_OPTION_GT_TRANSORDER', 'Ordre de transition');
\define('_AM_WGGALLERY_OPTION_GT_TRANSORDER_RANDOM', 'Aléatoire');
\define('_AM_WGGALLERY_OPTION_GT_TRANSORDER_INORDER', 'Par ordre de liste');
\define('_AM_WGGALLERY_OPTION_GT_SHOWTHUMBSDOTS', 'Afficher les vignettes ou les points');
\define('_AM_WGGALLERY_OPTION_GT_SHOWTHUMBS', 'Afficher les vignettes');
\define('_AM_WGGALLERY_OPTION_GT_SHOWDOTS', 'Afficher les points');
\define('_AM_WGGALLERY_OPTION_GT_SLIDESHOWSPEED', 'Vitesse du diaporama');
\define('_AM_WGGALLERY_OPTION_GT_SLIDESHOWSPEED_DESC', 'Intervalle en millisecondes avant d\'afficher l\'image suivante');
\define('_AM_WGGALLERY_OPTION_GT_PLAYOPTION_DESC', 'Lancer automatiquement le diaporama à l\'ouverture');
\define('_AM_WGGALLERY_OPTION_GT_ROWHEIGHT', 'Hauteur de ligne');
\define('_AM_WGGALLERY_OPTION_GT_LASTROW', 'Dernière ligne');
\define('_AM_WGGALLERY_OPTION_GT_LASTROW_DESC', 'Si la dernière ligne doit être justifiée sur toute la largeur de la ligne');
\define('_AM_WGGALLERY_OPTION_GT_MARGINS', 'Marge entre les images');
\define('_AM_WGGALLERY_OPTION_GT_OUTERBORDER', 'Marge extérieure du conteneur d\'image');
\define('_AM_WGGALLERY_OPTION_GT_RANDOMIZE', 'Afficher l\'image dans un ordre aléatoire');
\define('_AM_WGGALLERY_OPTION_GT_SLIDESHOW', 'Afficher le diaporama');
\define('_AM_WGGALLERY_OPTION_GT_SLIDESHOW_OPTIONS', 'Options du diaporama (toutes les options ne s\'appliquent pas à chaque style de palette de couleurs) :');
\define('_AM_WGGALLERY_OPTION_GT_COLORBOXSTYLE', 'Style de boîte de palette de couleurs');
\define('_AM_WGGALLERY_OPTION_GT_TRANSEFFECT', 'Effet de transition');
\define('_AM_WGGALLERY_OPTION_GT_SPEEDOPEN', 'Vitesse d\'ouverture du diaporama');
\define('_AM_WGGALLERY_OPTION_GT_AUTOOPEN', 'Ouvrir automatiquement le diaporama modal');
\define('_AM_WGGALLERY_OPTION_GT_SLIDESHOWTYPE', 'Type de diaporama');
\define('_AM_WGGALLERY_OPTION_GT_BUTTTONCLOSE', 'Afficher le bouton de fermeture');
\define('_AM_WGGALLERY_OPTION_GT_NAVBAR', 'Afficher la barre de navigation avec des vignettes');
\define('_AM_WGGALLERY_OPTION_GT_SHOW_1', 'Toujours afficher');
\define('_AM_WGGALLERY_OPTION_GT_SHOW_2', 'Afficher la barre de navigation uniquement lorsque la largeur de l\'écran est supérieure à 768 pixels');
\define('_AM_WGGALLERY_OPTION_GT_SHOW_3', 'Afficher la barre de navigation uniquement lorsque la largeur de l\'écran est supérieure à 992 pixels');
\define('_AM_WGGALLERY_OPTION_GT_SHOW_4', 'Afficher la barre de navigation uniquement lorsque la largeur de l\'écran est supérieure à 1200 pixels');
\define('_AM_WGGALLERY_OPTION_GT_TOOLBAR', 'Afficher la barre d\'outils');
\define('_AM_WGGALLERY_OPTION_GT_TOOLBARZOOM', 'Afficher les boutons de zoom dans la barre d\'outils');
\define('_AM_WGGALLERY_OPTION_GT_TOOLBARDOWNLOAD', 'Afficher les boutons de téléchargement dans la barre d\'outils');
\define('_AM_WGGALLERY_OPTION_GT_TOOLBARDOWNLOAD_DESC', 'Si vous activez cette option, le fichier source sera toujours téléchargé. Faites attention : cela ignore les autorisations définies dans les paramètres de l\'album.');
\define('_AM_WGGALLERY_OPTION_GT_FULLSCREEN', 'Passer en plein écran lors du démarrage du diaporama');
\define('_AM_WGGALLERY_OPTION_GT_TRANSDURATION', 'Vitesse de transition');
\define('_AM_WGGALLERY_OPTION_GT_TRANSDURATION_DESC', 'Période d\'animation en millisecondes entre 2 images');
\define('_AM_WGGALLERY_OPTION_GT_INDEXIMG', 'Type d\'image sur la page index');
\define('_AM_WGGALLERY_OPTION_GT_INDEXIMGHEIGHT', 'Hauteur de l\'image');
\define('_AM_WGGALLERY_OPTION_GT_SHOWLABEL', 'Afficher l\'index de l\'image (Image {current} de {total}%)');
\define('_AM_WGGALLERY_OPTION_GT_LCLSKIN', 'Commandes de style');
\define('_AM_WGGALLERY_OPTION_GT_ANIMTIME', 'Vitesse d\'animation');
\define('_AM_WGGALLERY_OPTION_GT_ANIMTIME_DESC', 'Temps pour l\'animation (par exemple redimensionner l\'image) entre deux images en millisecondes');
\define('_AM_WGGALLERY_OPTION_GT_LCLCOUNTER', 'Afficher le compteur');
\define('_AM_WGGALLERY_OPTION_GT_LCLPROGRESSBAR', 'Afficher la barre de progression');
\define('_AM_WGGALLERY_OPTION_GT_LCLMAXWIDTH', 'Largeur max de la galerie (en % de la fenêtre)');
\define('_AM_WGGALLERY_OPTION_GT_LCLMAXHEIGTH', 'Hauteur max de la galerie (en % de la fenêtre)');
\define('_AM_WGGALLERY_OPTION_GT_BACKGROUND', 'Fond');
\define('_AM_WGGALLERY_OPTION_GT_BACKHEIGHT', 'Hauteur du fond');
\define('_AM_WGGALLERY_OPTION_GT_BORDER', 'Bordure');
\define('_AM_WGGALLERY_OPTION_GT_BORDERWIDTH', 'Largeur');
\define('_AM_WGGALLERY_OPTION_GT_BORDERCOLOR', 'Couleur');
\define('_AM_WGGALLERY_OPTION_GT_BORDERPADDING', 'Remplissage');
\define('_AM_WGGALLERY_OPTION_GT_BORDERRADIUS', 'Rayon');
\define('_AM_WGGALLERY_OPTION_GT_SHADOW', 'Afficher l\'ombre');
\define('_AM_WGGALLERY_OPTION_GT_LCLDATAPOSITION', 'Position des données');
\define('_AM_WGGALLERY_OPTION_GT_LCLDATAPOSITION_UNDER', 'En dessous');
\define('_AM_WGGALLERY_OPTION_GT_LCLDATAPOSITION_OVER', 'Au-dessus');
\define('_AM_WGGALLERY_OPTION_GT_LCLDATAPOSITION_RSIDE', 'Côté droit');
\define('_AM_WGGALLERY_OPTION_GT_LCLDATAPOSITION_LSIDE', 'Côté gauche');
\define('_AM_WGGALLERY_OPTION_GT_LCLDATAPOSITION_DESC', "Veuillez noter que Lightbox utilise un système intelligent basculant automatiquement sur « Fin » dès que l'élément devient trop petit à cause de longs textes ou d'une petite fenêtre.");
\define('_AM_WGGALLERY_OPTION_GT_LCLCMDPOSITION', 'Position des commandes');
\define('_AM_WGGALLERY_OPTION_GT_LCLCMDPOSITION_INNER', 'À l\'intérieur');
\define('_AM_WGGALLERY_OPTION_GT_LCLCMDPOSITION_OUTER', 'À l\'extérieur');
\define('_AM_WGGALLERY_OPTION_GT_LCLCMDPOSITION_DESC', "Veuillez noter que Lightbox passera automatiquement sur « Fin » si les commandes internes sont trop larges pour l'élément représenté");
\define('_AM_WGGALLERY_OPTION_GT_LCLTHUMBSWIDTH', 'Largeur des vignettes (en pixels)');
\define('_AM_WGGALLERY_OPTION_GT_LCLTHUMBSHEIGTH', 'Hauteur des vignettes (en pixels)');
\define('_AM_WGGALLERY_OPTION_GT_LCLFULLSCREEN', "Afficher les boutons de commande « plein écran »");
\define('_AM_WGGALLERY_OPTION_GT_LCLFSIMGBEHAVIOUR', 'Comportement de l\'image en plein écran');
\define('_AM_WGGALLERY_OPTION_GT_LCLFSIMGBEHAVIOUR_FIT', 'ajustement - l\'image sera complètement visible (laissant éventuellement des espaces sur les bords)');
\define('_AM_WGGALLERY_OPTION_GT_LCLFSIMGBEHAVIOUR_FILL', 'remplissage - l\'image remplira toujours l\'écran (une partie pourrait éventuellement être masquée)');
\define('_AM_WGGALLERY_OPTION_GT_LCLFSIMGBEHAVIOUR_SMART', "intelligent - LC Lightbox utilise le mode « ajustement » et passe en mode « remplissage » uniquement si le rapport hauteur / largeur des images est similaire à l'espace disponible");
\define('_AM_WGGALLERY_OPTION_GT_LCLSOCIALS', "Afficher le bouton « Réseaux sociaux »");
\define('_AM_WGGALLERY_OPTION_GT_LCLSOCIALS_FB', 'ID de l\'application Facebook');
\define('_AM_WGGALLERY_OPTION_GT_LCLSOCIALS_FB_DESC', 'N\'oubliez pas d\'ajouter le SDK de Facebook dans votre site internet');
\define('_AM_WGGALLERY_OPTION_GT_LCLDOWNLOAD', "Afficher le bouton « Télécharger »");
\define('_AM_WGGALLERY_OPTION_GT_LCLRCLICK', 'Désactiver le clic droit de la souris');
\define('_AM_WGGALLERY_OPTION_GT_LCLTOGGLETXT', "Afficher le bouton « Texte »");
\define('_AM_WGGALLERY_OPTION_GT_LCLNAVBTNPOS', 'Position des boutons de navigation');
\define('_AM_WGGALLERY_OPTION_GT_LCLNAVBTNPOS_N', 'Normal');
\define('_AM_WGGALLERY_OPTION_GT_LCLNAVBTNPOS_M', 'Centre');
\define('_AM_WGGALLERY_OPTION_GT_LCLSLIDESHOW', "Afficher le bouton « Lecture »");

// Albumtype add/edit
\define('_AM_WGGALLERY_ALBUMTYPE_ADD', 'Ajouter un type d\'album');
\define('_AM_WGGALLERY_ALBUMTYPE_EDIT', 'Modifier le type d\'album');
// options  of Album types
\define('_AM_WGGALLERY_OPTION_AT_SET', 'Définir les options pour le type d\'album sélectionné');
\define('_AM_WGGALLERY_OPTION_AT_SETINFO', 'Les paramètres des types d\'album seront utilisés pour la page d\'accueil et les blocs d\'album');
\define('_AM_WGGALLERY_OPTION_AT_HOVER', 'Effet de survol');
\define('_AM_WGGALLERY_OPTION_AT_NB_COLS_ALB', 'Nombre de colonnes pour la liste d\'albums');
\define('_AM_WGGALLERY_OPTION_AT_NB_COLS_CAT', 'Nombre de colonnes pour la liste des catégories');
// common options
\define('_AM_WGGALLERY_OPTION_OPACITIY', 'Opacité');
\define('_AM_WGGALLERY_OPTION_SHOWTITLE', 'Montrer le titre');
\define('_AM_WGGALLERY_OPTION_SHOWDESCR', 'Afficher la description');
\define('_AM_WGGALLERY_OPTION_CSS', 'Sélectionner le css pour le style');
\define('_AM_WGGALLERY_OPTION_SHOWSUBMITTER', 'Afficher le déposant');
// Maintenance
\define('_AM_WGGALLERY_MAINTENANCE_ALBUM_SELECT', 'Sélectionner l\'album');
\define('_AM_WGGALLERY_MAINTENANCE_EXECUTE_DR', 'Supprimer et réinitialiser');
\define('_AM_WGGALLERY_MAINTENANCE_EXECUTE_R', 'Définir les paramètres par défaut');
\define('_AM_WGGALLERY_MAINTENANCE_EXECUTE_RIL', 'Redimensionner toutes les grandes images');
\define('_AM_WGGALLERY_MAINTENANCE_EXECUTE_RIM', 'Redimensionner toutes les images moyennes');
\define('_AM_WGGALLERY_MAINTENANCE_EXECUTE_RIT', 'Redimensionner toutes les vignettes');
\define('_AM_WGGALLERY_MAINTENANCE_EXECUTE_DUI', 'Supprimer les images inutilisées');
\define('_AM_WGGALLERY_MAINTENANCE_EXECUTE_DUI_SHOW', 'Afficher la liste des images inutilisées');
\define('_AM_WGGALLERY_MAINTENANCE_SUCCESS_RESET', 'Réinitialisation réussie :');
\define('_AM_WGGALLERY_MAINTENANCE_SUCCESS_CREATE', 'Créé avec succès :');
\define('_AM_WGGALLERY_MAINTENANCE_SUCCESS_RESIZE', 'Redimensionnement réussi : %s fois redimensionné pour %t images');
\define('_AM_WGGALLERY_MAINTENANCE_SUCCESS_DELETE', 'Suppression réussie :');
\define('_AM_WGGALLERY_MAINTENANCE_ERROR_RESET', 'Erreur lors de la réinitialisation :');
\define('_AM_WGGALLERY_MAINTENANCE_ERROR_CREATE', 'Erreur lors de la création :');
\define('_AM_WGGALLERY_MAINTENANCE_ERROR_DELETE', 'Erreur lors de la suppression :');
\define('_AM_WGGALLERY_MAINTENANCE_ERROR_RESIZE', 'Erreur lors du redimensionnement :');
\define('_AM_WGGALLERY_MAINTENANCE_ERROR_READDIR', 'Erreur lors de la lecture du répertoire :');
\define('_AM_WGGALLERY_MAINTENANCE_TYP', 'Type de maintenance');
\define('_AM_WGGALLERY_MAINTENANCE_DESC', 'Description');
\define('_AM_WGGALLERY_MAINTENANCE_RESULTS', 'Résultats');
\define('_AM_WGGALLERY_MAINTENANCE_GT', 'Gérer les types de galeries');
\define('_AM_WGGALLERY_MAINTENANCE_GT_DESC', 'Supprimer les types de galeries non pris en charge et / ou réinitialiser tous les types de galeries aux valeurs par défaut');
\define('_AM_WGGALLERY_MAINTENANCE_GT_SURERESET', 'Tous les paramètres de la galerie existants seront mis à jour avec les paramètres par défaut. Souhaitez-vous continuer ?');
\define('_AM_WGGALLERY_MAINTENANCE_GT_SUREDELETE', 'Tous les types de galerie existants (paramètres inclus) seront supprimés et remplacés par les types de galerie actuels. Voulez-vous continuer?');
\define('_AM_WGGALLERY_MAINTENANCE_AT', 'Conserver les types d\'album');
\define('_AM_WGGALLERY_MAINTENANCE_AT_DESC', 'Supprimer les types d\'albums qui ne sont plus pris en charge et / ou réinitialiser tous les types d\'albums aux valeurs par défaut');
\define('_AM_WGGALLERY_MAINTENANCE_AT_SURERESET', 'Tous les paramètres d\'album existants seront mis à jour avec les types d\'albums par défaut. Voulez-vous continuer?');
\define('_AM_WGGALLERY_MAINTENANCE_AT_SUREDELETE', 'Tous les types d\'album existants (paramètres inclus) seront supprimés et remplacés par les types d\'album actuels. Voulez-vous continuer?');
\define('_AM_WGGALLERY_MAINTENANCE_RESIZE', 'Redimensionner les images');
\define('_AM_WGGALLERY_MAINTENANCE_RESIZE_DESC', 'Redimensionnez les images ou les vignettes à la hauteur maximale des préférences du module correspondantes.<br>Paramètres actuels :<ul>
<li>large : largeur maximum %lw px / hauteur maximum %lh px</li>
<li>moyen : largeur maximum %mw px / hauteur maximum %mh px</li>
<li>vignette : largeur maximum %tw px / hauteur maximum %th px</li>
</ul>');
\define('_AM_WGGALLERY_MAINTENANCE_RESIZE_INFO', 'Le redimensionnement des « grandes images » n\'est possible que si l\'image originale est disponible !');
\define('_AM_WGGALLERY_MAINTENANCE_RESIZE_SELECT', 'Sélectionnez le type d\'images à redimensionner');
\define('_AM_WGGALLERY_MAINTENANCE_DELETE_UNUSED', 'Nettoyer le répertoire d\'images');
\define('_AM_WGGALLERY_MAINTENANCE_DELETE_UNUSED_DESC', 'Toutes les images actuellement inutilisées des répertoires suivants seront supprimées :<ul>
<li>%p/albums/</li>
<li>%p/large/</li>
<li>%p/medium/</li>
<li>%p/thumbs/</li>
<li>%p/temp/</li>
</ul>');
\define('_AM_WGGALLERY_MAINTENANCE_DELETE_INVALID', "Supprimer les éléments non valides dans le tableau « images »");
\define('_AM_WGGALLERY_MAINTENANCE_DELETE_INVALID_DESC', "Supprimer les éléments non valides dans le tableau « images », par exemple l'élément a été créé, mais une erreur s'est produite lors de l'envoi");
\define('_AM_WGGALLERY_MAINTENANCE_DELETE_INVALID_IMG', 'Élément invalide : img_id ');
\define('_AM_WGGALLERY_MAINTENANCE_DELETE_UNUSED_NONE', 'Aucune image inutilisée trouvée');
\define('_AM_WGGALLERY_MAINTENANCE_DUI_SUREDELETE', 'Toutes les images d\'album actuellement inutilisées seront supprimées ! Souhaitez-vous continuer ?');
\define('_AM_WGGALLERY_MAINTENANCE_WATERMARK', 'Ajouter des tatouages numériques à un album plus tard');
\define('_AM_WGGALLERY_MAINTENANCE_WATERMARK_DESC', 'Ajoutez des tatouages numériques à un album sélectionné.<br>Attention : les tatouages numériques existants ne seront pas supprimés.<br>S\'il y a déjà des tatouages numériques, un tatouage numérique supplémentaire sera ajouté aux images.');
\define('_AM_WGGALLERY_MAINTENANCE_IMGDIR', 'Entrées d\'images incorrectes dans le répertoire');
\define('_AM_WGGALLERY_MAINTENANCE_IMGDIR_DESC', 'Les entrées sont recherchées dans la table Images qui ne se trouvent pas dans le répertoire de téléchargement.');
\define('_AM_WGGALLERY_MAINTENANCE_IMGALB', 'Entrées d\'images incorrectes pour les albums');
\define('_AM_WGGALLERY_MAINTENANCE_IMGALB_DESC', 'Les entrées sont recherchées dans la table Images, dont l\'album n\'existe plus.');
\define('_AM_WGGALLERY_MAINTENANCE_ITEM_SEARCH', 'Rechercher des éléments');
\define('_AM_WGGALLERY_MAINTENANCE_IMG_SEARCHOK', 'Aucune entrée d\'image incorrecte n\'a été trouvée');
\define('_AM_WGGALLERY_MAINTENANCE_IMG_CLEAN', 'Nettoyer les entrées incorrectes');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_SYSTEM', 'Vérification du système');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_SYSTEMDESC', 'Vérifie si les paramètres php sont compatibles avec les paramètres de votre module');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_RESULTS', 'Résultat des contrôles du système');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_TYPE', "Vérification des paramètres PHP '%s'");
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MS_DESC', 'Le réglage du module autorise %s Octets');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_PMS_INFO', 'Définit la taille maximale autorisée des données de publication');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_PMS_DESC', 'Taille maximale du fichier pour le message : %s (%b Octets)');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_FU_INFO', 'Autoriser ou non les téléchargements de fichiers HTTP');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_FU_DESC', 'L\'envoi de fichier permet :');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_UMF_INFO', 'Définit la taille maximale pour l\'envoi des fichiers');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_UMF_DESC', 'Taille de fichier maximale pour l\'envoi des fichiers : %s (%b Octets)');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_ML_INFO1', 'Définit la quantité maximale de mémoire en octets qu\'un script est autorisé à allouer');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_ML_INFO2', 'Si vous rencontrez des problèmes lors de l\'envoi de grandes images, augmentez cette valeur');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_ML_DESC', 'Limite de mémoire maximale : %s (%b Octets)');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MS_ERROR1', 'Veuillez réduire le paramètre du module ou augmenter le paramètre php');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MS_ERROR2', 'Veuillez activer le paramètre php');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MS_ERROR3', 'memory_limit doit être supérieur à upload_max_filesize et supérieur à post_max_size');
\define('_AM_WGGALLERY_MAINTENANCE_READ_EXIF', 'Lire les données exif');
\define('_AM_WGGALLERY_MAINTENANCE_READ_EXIF_DESC', 'Lire et enregistrer à nouveau les données exif pour toutes les images');
\define('_AM_WGGALLERY_MAINTENANCE_READ_EXIF_READ', 'Lire les données exif manquantes');
\define('_AM_WGGALLERY_MAINTENANCE_READ_EXIF_READALL', 'Relire toutes les données exif');
\define('_AM_WGGALLERY_MAINTENANCE_READ_EXIF_SUCCESS', 'Exif lut avec succès');
\define('_AM_WGGALLERY_MAINTENANCE_READ_EXIF_ERROR', 'Erreur lors de la lecture de l\'exif');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_SPACE', 'Vérifier l\'espace utilisé dans le répertoire des envois');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_SPACE_DESC', 'Les répertoires de transfert suivants seront vérifiés afin de gagner de l\'espace :<ul>
<li>%p/albums/</li>
<li>%p/large/</li>
<li>%p/medium/</li>
<li>%p/thumbs/</li>
<li>%p/temp/</li>
</ul>');
\define('_AM_WGGALLERY_MAINTENANCE_ERROR_SOURCE', 'Erreur - fichier source nécessaire introuvable :');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MT', 'Vérifier les types MIME');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MT_DESC', 'Vérifiez le tableau des images pour :<ul>
<li>types de fichiers MIME invalides</li>
<li>types de fichiers MIME non autorisés selon les préférences du module</li>
</ul>');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MT_SEARCH', 'Recherche de types MIME non valides');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MT_CLEAN', 'Nettoyage des types MIME invalides');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MT_SUCCESS', '%s types MIME de %t sont valides');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MT_SUCCESSOK', 'Type MIME valide');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MT_ERROR', 'Type MIME non valide');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MT_SAVESUCCESS', 'Le type MIME a bien été modifié');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_MT_SAVEERROR', 'Erreur lors de l\'enregistrement du type MIME');
\define('_AM_WGGALLERY_MAINTENANCE_INVALIDRATE', 'Nettoyages des Notes / J\'aime');
\define('_AM_WGGALLERY_MAINTENANCE_INVALIDRATE_DESC', 'Supprimer les Notes / J\'aime, là où l\'image n\'existe plus');
\define('_AM_WGGALLERY_MAINTENANCE_INVALIDRATE_NUM', '%e sur %s notes ne sont pas valides');
\define('_AM_WGGALLERY_MAINTENANCE_INVALIDRATE_RESULT', '%s sur %t notes nettoyées');
\define('_AM_WGGALLERY_MAINTENANCE_INVALIDCATS', 'Nettoyage des catégories utilisées');
\define('_AM_WGGALLERY_MAINTENANCE_INVALIDCATS_DESC', 'Supprimer la catégorie dans les albums et les images, si la catégorie n\'existe plus');
\define('_AM_WGGALLERY_MAINTENANCE_INVALIDCATS_RESULT', '%t éléments ont été nettoyés');
\define('_AM_WGGALLERY_MAINTENANCE_DELETE_EXIF', 'Supprimer les données exif');
\define('_AM_WGGALLERY_MAINTENANCE_EXIF_CURRENT', 'Données exif actuellement manquantes : %c sur %t images');
\define('_AM_WGGALLERY_MAINTENANCE_DELETE_EXIF_SUCCESS', 'Les données exif ont été supprimées avec succès');
\define('_AM_WGGALLERY_MAINTENANCE_DELETE_EXIF_ERROR', 'Erreur lors de la suppression des données Exif');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTGD', 'Vérifiez si l\'extension GD obligatoire est chargée ou non.');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTGD_LOADED', 'Extension GD chargée');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTGD_NOTLOADED', 'Extension GD non chargée');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTGD_INFO1', 'L\'extension GD doit être activée, sinon certaines fonctionnalités de ce module ne fonctionneront PAS.');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTGD_INFO2', 'Veuillez activer l\'extension GD, sinon le module ne fonctionnera PAS correctement.');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTEXIF', 'Vérifiez si l\'extension exif est chargée ou non');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTEXIF_LOADED', 'Extension exif chargée');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTEXIF_NOTLOADED', 'Extension exif NON chargée');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTEXIF_INFO1', 'l\'extension exif doit être activée, si vous voulez utiliser les fonctions de lecture exif');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTEXIF_INFO2', 'Veuillez activer l\'extension exif, sinon le module ne fonctionnera PAS correctement.');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTEXIF_INFO3', 'La sauvegarde exif n\'est pas activée actuellement. Si vous voulez utiliser cette fonction, vous devez également charger l\'extension exif.');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTEXIF_OPTENABLED', 'La sauvegarde exif est activée dans les préférences du module');
\define('_AM_WGGALLERY_MAINTENANCE_CHECK_EXTEXIF_OPTDISABLED', 'La sauvegarde exif n\'est PAS activée dans les préférences du module');
// Import
\define('_AM_WGGALLERY_IMPORT', 'Importer des données et des fichiers à partir d\'autres modules de la galerie');
\define('_AM_WGGALLERY_IMPORT_LIST', 'Liste des modules pris en charge');
\define('_AM_WGGALLERY_IMPORT_SUPPORT', 'Modules pris en charge pour l\'importation');
\define('_AM_WGGALLERY_IMPORT_SUP_INSTALLED', 'le module est installé');
\define('_AM_WGGALLERY_IMPORT_SUP_NOTINSTALLED', 'le module n\'est pas installé');
\define('_AM_WGGALLERY_IMPORT_FOUND', 'Résultat de la recherche');
\define('_AM_WGGALLERY_IMPORT_READ', 'Lire les données du module');
\define('_AM_WGGALLERY_IMPORT_EXEC', 'Importer les données et les fichiers');
\define('_AM_WGGALLERY_IMPORT_NUMALB', 'Nombre d\'albums');
\define('_AM_WGGALLERY_IMPORT_NUMIMG', 'Nombre d\'images');
\define('_AM_WGGALLERY_IMPORT_INFO_SIZE', 'Attention : les images ne seront pas redimensionnées en fonction des préférences du module. Si vous souhaitez redimensionner, utilisez la « Maintenance » après l\'importation.');
\define('_AM_WGGALLERY_IMPORT_ERR', 'L\'importation de données n\'est possible que lorsque les tables d\'albums et d\'images sont vides');
\define('_AM_WGGALLERY_IMPORT_ERR_ALBEXIST', 'Il existe déjà des albums');
\define('_AM_WGGALLERY_IMPORT_ERR_IMGEXIST', 'Il existe déjà des images');
\define('_AM_WGGALLERY_IMPORT_SUCCESS', '%a albums et %i images importés avec succès');
\define('_AM_WGGALLERY_IMPORT_ERROR', 'Une erreur s\'est produite lors de l\'importation');
//perms
\define('_AM_WGGALLERY_PERMS_ALBDEFAULT', 'Autorisations par défaut du nouvel album');
\define('_AM_WGGALLERY_PERMS_ALBDEFAULT_DESC', 'Définir les autorisations par défaut pour la création d\'un nouvel album');
//batch upload
\define('_AM_WGGALLERY_BATCH_CHECKSIZE', 'La taille du fichier dépasse la taille maximale autorisée de %s');
\define('_AM_WGGALLERY_BATCH_CHECKFILEEXT', 'L\'extension de fichier %s n\'est pas autorisée');
\define('_AM_WGGALLERY_BATCH_CHECKWIDTH', 'La largeur de l\'image dépasse la largeur maximale autorisée de %s');
\define('_AM_WGGALLERY_BATCH_CHECKHEIGHT', 'La hauteur de l\'image dépasse la hauteur maximale autorisée de %s');
\define('_AM_WGGALLERY_BATCH_FORM', 'Démarrer le transfert groupé');
\define('_AM_WGGALLERY_BATCH_LIST', 'Contenu du répertoire des fichiers groupés');
\define('_AM_WGGALLERY_BATCH_ERROR', 'Erreur lors du traitement par lots de %s');
\define('_AM_WGGALLERY_BATCH_SUCCESS', ' %s fichiers traités avec succès');
\define('_AM_WGGALLERY_BATCH_NODATA', 'Il n\'y a actuellement aucun fichier dans le répertoire batch %s');
//clone
\define('_AM_WGGALLERY_CLONE', 'Cloner');
\define('_AM_WGGALLERY_CLONE_DSC', 'Cloner un module n\'a jamais été aussi facile ! Il suffit de taper le nom que vous souhaitez et cliquez sur le bouton « Soumettre » !');
\define('_AM_WGGALLERY_CLONE_TITLE', 'Clone %s');
\define('_AM_WGGALLERY_CLONE_NAME', 'Choisissez un nom pour le nouveau module');
\define('_AM_WGGALLERY_CLONE_NAME_DSC', 'N\'utilisez pas de caractères spéciaux !  <br />Ne choisissez pas un nom de répertoire de module ou un nom de table de base de données existant !');
\define('_AM_WGGALLERY_CLONE_INVALIDNAME', 'ERREUR : Nom de module invalide, veuillez en essayer un autre !');
\define('_AM_WGGALLERY_CLONE_EXISTS', 'ERREUR : Le nom du module est déjà pris, veuillez en essayer un autre !');
\define('_AM_WGGALLERY_CLONE_CONGRAT', 'Félicitations ! Le module %s  a été créé avec succès ! <br />Vous pouvez apporter des modifications aux fichiers de langue.');
\define('_AM_WGGALLERY_CLONE_IMAGEFAIL', 'Attention, nous n\'avons pas réussi à créer le nouveau logo du module. Veuillez modifier manuellement le fichier assets/images/logo_module.png !');
\define('_AM_WGGALLERY_CLONE_FAIL', "Désolé, nous n'avons pas réussi à créer le nouveau clone. Vous devez peut-être définir temporairement les droits d'écriture (CHMOD 777) dans le dossier « modules » et réessayer.");

\define('_AM_WGGALLERY_FIRST', 'Premier');
\define('_AM_WGGALLERY_UP', 'Monter');
\define('_AM_WGGALLERY_DOWN', 'Descendre');
\define('_AM_WGGALLERY_LAST', 'Dernier');
\define('_AM_WGGALLERY_WEIGHT_UPDATE', 'Poids mis à jour');
\define('_AM_WGGALLERY_VIEW_ALBUM', 'Consulter l&apos;album');
\define('_AM_WGGALLERY_SUBALBUMS', 'sous-Album-s');
\define('_AM_WGGALLERY_ALPHA', 'Tri alphabétique');
\define('_AM_WGGALLERY_ALBUM_PARENT', 'Album parent');


                        

