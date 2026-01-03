<?php
require_once "components/card.php";
require_once "components/title.php";
require_once "components/button.php";
require_once "components/form.php";

class ProfileView{
    public function show_page($user){
        echo '<div class="min-h-screen px-12 py-24 w-[80%]">';
        echo '<div class="mb-8">';
            $title = (new Title("Mon Profil", "text-3xl lg:text-4xl font-bold text-[var(--gray-dark)] mb-2", "h1"))->render();
            echo $title;
            echo '<p class="text-[var(--gray)]">Gérez vos informations personnelles et vos paramètres</p>';
        echo '</div>';
        $this->render_profile($user);
        echo '</div>'; 
       
    }
    
    private function render_profile($user){
        
        $joinDate = !empty($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : 'N/A';
        
        $header = [
    "<div class='flex items-center justify-between mb-6 pb-6 border-b border-gray-200'>
        <div>
            <h3 class='text-xl font-bold text-[var(--gray-dark)]'>Informations du profil</h3>
            <p class='text-[var(--gray)] text-sm mt-1'>Détails de votre compte</p>
        </div>
        <a href='index.php?page=edit_user&id=" . $user['id'] . "' class='px-4 py-2 text-sm font-medium text-[var(--white)] bg-[var(--primary)] hover:bg-[var(--primary-light)] hover:text-[var(--white)] rounded-lg transition-colors'>
            Modifier le profil
        </a>
    </div>"
];


$statusColor = $user['status_user'] === 'active' ? 'green-500' : "gray-500";
        
        $body = [
            "<div class='space-y-8 w-full'>
                <div class='grid md:grid-cols-3 gap-8'>
                    <div class='md:col-span-1'>
                        <div class='text-center'>
                            <div class='relative inline-block'>
                                <img src='{$user['profile_picture']}' 
                                     class='w-32 h-32 rounded-full border-4 border-white shadow-lg mx-auto mb-4'>
                                     
                               <div class='absolute bottom-3 right-3 w-8 h-8 rounded-full bg-".$statusColor." border-3 border-white'></div>
                            </div>
                            <h4 class='text-xl font-bold text-[var(--gray-dark)] mb-1'>{$user['first_name']} {$user['last_name']}</h4>
                            <p class='text-[var(--gray)] mb-2'>{$user['email']}</p>
                            <span class='inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800'>
                                <svg class='w-3 h-3 mr-1' fill='currentColor' viewBox='0 0 20 20'>
                                    <path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'/>
                                </svg>
                                {$user['role']}
                            </span>
                        </div>
                        <div class='space-y-1  my-4'>
                                <div class='text-md text-[var(--gray)] text-center'>Bio</div>
                                <div class='text-center text-[var(--gray-dark)] border p-2 rounded-md'>{$user['bio']}</div>
                        </div>
                    </div>
                    
                    <div class='md:col-span-2'>
                        <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                            <div class='space-y-1'>
                                <div class='text-sm text-[var(--gray)]'>Nom complet</div>
                                <div class='font-medium text-[var(--gray-dark)]'>{$user['first_name']} {$user['last_name']}</div>
                            </div>
                            
                            <div class='space-y-1'>
                                <div class='text-sm text-[var(--gray)]'>Adresse email</div>
                                <div class='font-medium text-[var(--gray-dark)]'>{$user['email']}</div>
                            </div>
                            
                            <div class='space-y-1'>
                                <div class='text-sm text-[var(--gray)]'>Rôle</div>
                                <div class='font-medium text-[var(--gray-dark)]'>{$user['role']}</div>
                            </div>
                            
                            <div class='space-y-1'>
                                <div class='text-sm text-[var(--gray)]'>Date d'inscription</div>
                                <div class='font-medium text-[var(--gray-dark)]'>{$joinDate}</div>
                            </div>
                            
                            <div class='space-y-1'>
                                <div class='text-sm text-[var(--gray)]'>Statut du compte</div>
                                <div class='flex items-center gap-2'>
                                    <span class='font-medium text-" . $statusColor . "'>{$user['status_user']}</span>
                                </div>
                            </div>
                            
                            <div class='space-y-1'>
                                <div class='text-sm text-[var(--gray)]'>Poste</div>
                                <div class=' font-medium text-[var(--gray-dark)]'>{$user['post']}</div>
                            </div>
                            <div class='space-y-1'>
                                <div class='text-sm text-[var(--gray)]'>Specialite</div>
                                <div class='font-medium text-[var(--gray-dark)]'>{$user['speciality']}</div>
                            </div>
                            <div class='space-y-1'>
                                <div class='text-sm text-[var(--gray)]'>Grade</div>
                                <div class='font-medium text-[var(--gray-dark)]'>{$user['grade']}</div>
                            </div>
                        </div>
                        <div class='space-y-1  my-4'>
                                <div class='text-sm text-[var(--gray)]'>CV</div>
                                <div class=' text-[var(--gray-dark)] p-2 rounded-md'> 
                                    <a href='{$user['cv']}' target='_blank' class='text-[var(--primary)] hover:underline'>
                                        Voir 
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>"
        ];
        
        $footer = [
            "<div class='pt-6 border-t border-gray-200 flex justify-between items-center'>
                <div class='text-sm text-[var(--gray)]'>
                    Dernière connexion : " . date('d/m/Y H:i') . "
                </div>
                <a href='index.php?page=logout' class='flex items-center px-3 py-2 bg-red-500 gap-2 text-[var(--white)] hover:bg-red-700 rounded-lg transition-colors'>
                    <svg class='w-5 h-5 text-[var(--white)]' fill='currentColor' viewBox='0 0 20 20'>
                        <path fill-rule='evenodd' d='M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z' clip-rule='evenodd'/>
                    </svg>
                    Déconnexion
                </a>
            </div>"
        ];
        
        $card = new Card(
            $header, 
            $body, 
            $footer, 
            'bg-[var(--white)] rounded-2xl shadow-lg border w-full border-gray-200 p-8'
        );
        
        echo $card->render();
    }

    

}
?>