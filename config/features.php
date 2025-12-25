<?php
return [
    'projets' => [
        'title' => 'Gestion des projets',
        'icon' =>'<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
        'url' => 'index.php?page=gestion_projet',
        'color' => 'blue',
        'permissions' => [
            'read'   => 'read_project',
            'create' => 'create_project',
            'update' => 'update_project',
            'delete' => 'delete_project',
        ],
    ],
    'users' => [
        'title' => 'Gestion des utilisateurs et role',
        'icon' => '<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 0A11.955 11.955 0 0112 10.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 17c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
        'url' => 'index.php?page=gestion_users',
        'color' => 'purple',
        'permissions' => [
            'read'   => 'read_user',
            'create' => 'create_user',
            'update' => 'update_user',
            'delete' => 'delete_user',
        ],
    ],
    'publications' => [
        'title' => 'gestion des publications',
        'icon' =>  '<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
        'url' => 'index.php?page=gestion_publications',
        'color' => 'amber',
        'permissions' => [
            'read'   => 'read_publication',
            'create' => 'create_publication',
            'update' => 'update_publication',
            'delete' => 'delete_publication',
        ],
    ],
    'equipes' => [
        'title' => 'gestion des equipes',
        'icon' => '<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
        'url' => 'index.php?page=gestion_equipes',
        'color' => 'green',
        'permissions' => [
            'read'   => 'read_team',
            'create' => 'create_team',
            'update' => 'update_team',
            'delete' => 'delete_team',
        ],
    ],
    'equipments' => [
        'title' => 'gestion des equipements',
        'icon' => '<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>',
        'url' => 'index.php?page=gestion_equipements',
        'color' => 'cyan',
        'permissions' => [
            'read'   => 'read_equipment',
            'create' => 'create_equipment',
            'update' => 'update_equipment',
            'delete' => 'delete_equipment',
        ],
    ],
    'evenements' => [
        'title' => 'Gestion des evénements',
        'icon' => '<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
        'url' => 'index.php?page=gestion_evenements',
        'color' => 'pink',
        'permissions' => [
            'read'   => 'read_event',
            'create' => 'create_event',
            'update' => 'update_event',
            'delete' => 'delete_event',
        ],
    ],
    'settings' => [
        'title' => 'Gestion des paramètres',
        'icon' =>  '<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        'url' => 'index.php?page=gestion_settings',
        'color' => 'gray',
        'permissions' => [
            'read'   => 'read_settings',
            'update' => 'update_settings',
        ],
    ],
    'actualites' => [
        'title' => 'Gestion des actualités',
        'icon' => '<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>',
        'url' => 'index.php?page=gestion_actualites',
        'color' => 'orange',
        'permissions' => [
            'read'   => 'read_news',
            'create' => 'create_news',
            'update' => 'update_news',
            'delete' => 'delete_news',
        ],
    ],
    'diaporama' => [
        'title' => 'Gestion de diaporama',
        'icon' =>'<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
        'url' => 'index.php?page=gestion_diaporama',
        'color' => 'indigo',
        'permissions' => [
            'read'   => 'read_slideshow',
            'create' => 'create_slideshow',
            'update' => 'update_slideshow',
            'delete' => 'delete_slideshow',
        ],
    ],
    'reservations' => [
        'title' => 'Gestion des réservations',
        'icon' => '<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>',
        'url' => 'index.php?page=gestion_reservations',
        'color' => 'teal',
        'permissions' => [
            'read'   => 'read_reservation',
            'create' => 'create_reservation',
            'update' => 'update_reservation',
            'delete' => 'delete_reservation',
        ],
    ],
    'roles' => [
        'permissions' => [
            'read'   => 'read_role',
            'create' => 'create_role',
            'delete' => 'delete_role',
        ],
    ],
    'partners' => [
    'title' => 'Gestion des partenaires',
    'icon' => '<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
    'url' => 'index.php?page=gestion_partners',
    'color' => 'yellow',
    'permissions' => [
        'read'   => 'read_partner',
        'create' => 'create_partner',
        'update' => 'update_partner',
        'delete' => 'delete_partner',
    ],
]
];


?>