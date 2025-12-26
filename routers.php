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
    ],


    'gestion_users' => [
        'controller' => 'UserController',
        'action' => 'show_users', 
    ],
    'create_user' => [
        'controller' => 'UserController',
        'action' => 'user_form'
    ],
    'update_user' => [
        'controller' => 'UserController',
        'action' => 'user_form'
    ],
    'createUser' => [
        'controller' => 'UserController',
        'action' => 'handle_submit_create_update'
    ],
    'updateUser' => [
        'controller' => 'UserController',
        'action' => 'handle_submit_create_update'
    ],
     'delete_user' => [
        'controller' => 'UserController',
        'action' => 'delete_user'
    ],

    'roles' => [
        'controller' => 'RoleController',
        'action' => 'show_roles'
    ],
    'add_role' => [
        'controller' => 'RoleController',
        'action' => 'add_role'
    ],
    'delete_role' => [
        'controller' => 'RoleController',
        'action' => 'delete_role'
    ],

    'gestion_perm' => [
        'controller' => 'PermissionController',
        'action' => 'show_form'
    ],
    'give_permission' => [
         'controller' => 'PermissionController',
        'action' => 'handle_submit'
    ],



    'gestion_projet' => [
        'controller' => 'ProjectController',
        'action' => 'show_projects', 
    ],
    'create_project' => [
        'controller' => 'ProjectController',
        'action' => 'project_form'
    ],
    'update_project' => [
        'controller' => 'ProjectController',
        'action' => 'project_form'
    ],
    'createProject' => [
        'controller' => 'ProjectController',
        'action' => 'handle_submit_create_update'
    ],
    'updateProject' => [
        'controller' => 'ProjectController',
        'action' => 'handle_submit_create_update'
    ],
     'delete_project' => [
        'controller' => 'ProjectController',
        'action' => 'delete_project'
    ],

    'add_partner' => [
        'controller' => 'PartnerController',
        'action' => 'handle_partner'
    ],
    'delete_partner_project' => [
        'controller' => 'PartnerController',
        'action' => 'delete_partner_project'
    ],
    'add_member' => [
        'controller' => 'UserController',
        'action' => 'handle_member'
    ],
    'delete_member' => [
        'controller' => 'UserController',
        'action' => 'delete_member'
    ],



    'gestion_publications' => [
        'controller' => 'PublicationController',
        'action' => 'show_pubs',
    ],

    'gestion_equipes' => [
        'controller' => 'TeamController',
        'action' => 'show_teams',
    ],

    'gestion_equipements' => [
        'controller' => 'EquipmentController',
        'action' => 'show_equip',
    ],

    'gestion_evenements' => [
        'controller' => 'EventController',
        'action' => 'show_events',
    ],

    'gestion_settings' => [
        'controller' => 'SettingsController',
        'action' => 'show_settings',
    ],

    'gestion_actualites' => [
        'controller' => 'ActualiteController',
        'action' => 'show_news',
    ],

    'gestion_diaporama' => [
        'controller' => 'DiapoController',
        'action' => 'show_diapo',
    ],

    'gestion_reservations' => [
        'controller' => 'ReservationController',
        'action' => 'show_reservations',
    ],
    'gestion_partners' => [
        'controller' => 'PartnerController',
        'action' => 'show_partners',
    ],
    'create_partner' => [
        'controller' => 'PartnerController',
        'action' => 'partner_form'
    ],
    'update_partner' => [
        'controller' => 'PartnerController',
        'action' => 'partner_form'
    ],
    'createPartner' => [
        'controller' => 'PartnerController',
        'action' => 'handle_submit_create_update'
    ],
    'updatePartner' => [
        'controller' => 'PartnerController',
        'action' => 'handle_submit_create_update'
    ],
        'delete_partner' => [
            'controller' => 'PartnerController',
            'action' => 'delete_partner'
        ],
        'report_project' => [
            'controller' => 'ReportController',
            'action' => 'generate_report'
        ],
        'report_project' => [
            'controller' => 'ReportController',
            'action' => 'generate_report'
        ],
        'report_project' => [
            'controller' => 'ReportController',
            'action' => 'generate_report'
        ],
    
 ];
?>