<?php
     return [
    'accueil' => [
        'controller' => 'HomeController',
        'action' => 'show_home_page'
    ],

    'projets' => [
        'controller' => 'ProjectController',
        'action' => 'list_projects'
    ],
     'projet' => [
        'controller' => 'ProjectController',
        'action' => 'view_project'
    ],
    'publications' => [
        'controller' => 'PublicationController',
        'action' => 'list_publications'
    ],
    'publication' => [
        'controller' => 'PublicationController',
        'action' => 'view_publication'
    ],

    'equipements' => [
        'controller' => 'EquipmentController',
        'action' => 'list_equip'
    ],
    'equipment' => [
        'controller' => 'EquipmentController',
        'action' => 'show_form_reservation',
    ],
    'reservation' => [
        'controller' => 'ReservationController',
        'action' => 'submit_reservation'
    ],

    'membres' => [
        'controller' => 'PresController',
        'action' => 'show_page'
    ],

    'actualites' => [
        'controller' => 'ActualiteController',
        'action' => 'show_actualite_page'
    ],
    'offres' => [
        'controller' => 'NewsController',
        'action' => 'offres'
    ],
    'login' => [
        'controller' => 'AuthController',
        'action' => 'handle_login'
    ],
    'register' => [
        'controller' => 'AuthController',
        'action' => 'handle_register'
    ],
    'logout' => [
        'controller' => 'AuthController',
        'action' => 'logout'
    ],
    'evenments' => [
        'controller' => 'EventController',
        'action' => 'list_events'
    ],
    'contact' => [
        'controller' => 'ContactController',
        'action' => 'handle_contact'
    ],
    'team' => [
        'controller' => 'TeamController',
        'action' => 'show_team'
    ],

    'profile' => [
        'controller' => 'ProfileController',
        'action' => 'show_profile'
    ],
    'edit_user' => [
        'controller' => 'UserController',
        'action' => 'show_form'
    ],
    'edit_profile'=> [
        'controller' => 'UserController',
        'action' => 'update_user'
    ],
    'dashboard' => [
        'controller' => 'DashboardController',
        'action' => 'show_dashboard'
    ]
 ];
?>