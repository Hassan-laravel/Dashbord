<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dashboard Translations - Dutch (Nederlands)
    |--------------------------------------------------------------------------
    */

    // 1. General Texts (Algemene Teksten)
    'general' => [
        'dashboard' => 'Dashboard',
        'home' => 'Home',
        'actions' => 'Acties',
        'status' => 'Status',
        'created_at' => 'Aangemaakt op',
        'save' => 'Opslaan',
        'update' => 'Bijwerken',
        'delete' => 'Verwijderen',
        'edit' => 'Bewerken',
        'cancel' => 'Annuleren',
        'close' => 'Sluiten',
        'search' => 'Zoeken',
        'reset' => 'Resetten',
        'yes' => 'Ja',
        'no' => 'Nee',
        'active' => 'Actief',
        'inactive' => 'Inactief',
        'image' => 'Afbeelding',
        'confirm_delete_msg' => 'Weet u zeker dat u dit wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.',
        'entry_language' => 'U voert gegevens in voor de taal:',
        'auto_generated' => 'Automatisch gegenereerd',
        'no_data' => 'Geen gegevens beschikbaar',

        'search_placeholder' => 'Zoeken op artikeltitel...',
        'loading' => 'Laden...',
        'unknown' => 'Onbekend',
        'no_image' => 'Geen afbeelding',
        'no_results' => 'Geen resultaten gevonden voor uw zoekopdracht',
        'all_statuses' => 'Alle statussen',
    ],

    // 2. Navigation (Navigatie)
    'nav' => [
        'users' => 'Gebruikersbeheer',
        'categories' => 'Categorieën',
        'posts' => 'Artikelen',
        'settings' => 'Instellingen',
        'pages' => 'Pagina\'s',
        'logout' => 'Uitloggen',
    ],

    // 3. Users Section (Gebruikers)
    'users' => [
        'title' => 'Gebruikersbeheer',
        'list' => 'Gebruikerslijst',
        'add_user' => 'Nieuwe gebruiker toevoegen',
        'edit_user' => 'Gebruikersgegevens bewerken',
        'name' => 'Naam',
        'email' => 'E-mailadres',
        'password' => 'Wachtwoord',
        'password_confirm' => 'Wachtwoord bevestigen',
        'password_placeholder' => 'Laat leeg om het huidige wachtwoord te behouden',
        'role' => 'Rol',
        'select_role' => 'Selecteer rol',
        'modal_title' => 'Gebruikersdetails',
    ],

    // 4. Categories Section (Categorieën)
    'categories' => [
        'title' => 'Categoriebeheer',
        'list' => 'Categorielijst',
        'add_new' => 'Nieuwe categorie toevoegen',
        'edit_category' => 'Categorie bewerken',
        'name' => 'Categorienaam',
        'slug' => 'Slug',
        'meta_title' => 'SEO Titel',
        'meta_description' => 'SEO Beschrijving / Trefwoorden',
        'active' => 'Actief',
        'inactive' => 'Inactief',
        'all' => 'Alle categorieën',
    ],

    // 5. Posts Section (Artikelen / Berichten)
    'posts' => [
        'title' => 'Artikelbeheer',
        'list' => 'Artikelenlijst',
        'add_new' => 'Nieuw artikel toevoegen',
        'edit_post' => 'Artikel bewerken',

        // Fields
        'article_title' => 'Artikeltitel',
        'article_title_placeholder' => 'Voer hier de titel van het artikel in...',
        'content' => 'Inhoud',
        'content_placeholder' => 'Schrijf hier de inhoud van het artikel...',
        'youtube_link' => 'YouTube Link (Optioneel)',

        // Side Sections
        'seo_section' => 'Zoekmachineoptimalisatie (SEO)',
        'publish_section' => 'Publiceren',
        'categories_section' => 'Categorieën',
        'featured_image' => 'Uitgelichte afbeelding',
        'gallery' => 'Galerij',

        // Options
        'status' => 'Status',
        'status_published' => 'Gepubliceerd',
        'status_draft' => 'Concept',
        'no_categories' => 'Geen categorieën gevonden.',
        'add_category_link' => 'Categorie toevoegen',
        'gallery_help' => 'U kunt meerdere afbeeldingen selecteren',
        'select_multiple' => 'Selecteer meerdere afbeeldingen',

        // Buttons
        'save_btn' => 'Artikel opslaan',
        'update_btn' => 'Artikel bijwerken',
        'author' => 'Auteur',
    ],

    // 6. System Messages (Systeemberichten)
    'messages' => [
        'success' => 'Succes',
        'error' => 'Fout',
        // Users
        'user_created' => 'Gebruiker aangemaakt en rol succesvol toegewezen',
        'user_updated' => 'Gebruikersgegevens succesvol bijgewerkt',
        'user_deleted' => 'Gebruiker succesvol verwijderd',
        'cannot_delete_self' => 'Sorry, u kunt uw eigen account niet verwijderen!',
        // Categories
        'category_created' => 'Categorie succesvol aangemaakt',
        'category_updated' => 'Categorie succesvol bijgewerkt',
        'category_deleted' => 'Categorie succesvol verwijderd',
        // Posts
        'post_created' => 'Artikel succesvol aangemaakt',
        'post_updated' => 'Artikel succesvol bijgewerkt',
        'post_deleted' => 'Artikel succesvol verwijderd',
    ],

    // 7. Settings (Instellingen)
    'settings' => [
        'title' => 'Website Instellingen',
        'site_email' => 'Website E-mail',
        'site_logo' => 'Website Logo',
        'maintenance_mode' => 'Onderhoudsmodus',
        'site_name' => 'Websitenaam',
        'site_description' => 'Website omschrijving',
        'copyright' => 'Copyright',
        'save_settings' => 'Instellingen opslaan',
        'on' => 'Aan',
        'off' => 'Uit',
    ],

    // 8. Pages (Pagina's)
    'pages' => [
        'title' => 'Paginabeheer',
        'list' => 'Paginalijst',
        'add_new' => 'Nieuwe pagina toevoegen',
        'edit_page' => 'Pagina bewerken',
        'page_title' => 'Paginatitel',
        'content' => 'Pagina inhoud',
        'featured_image' => 'Uitgelichte afbeelding',
    ],
];
