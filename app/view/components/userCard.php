<?php
require_once "card.php";
class UserCard {
    private $firstName;
    private $lastName;
    private $role;
    private $speciality;
    private $status;
    private $email;
    private $post;
    private $grade;
    private $picture;
    private $bio;
    private $id;
    
    public function __construct($firstName, $lastName, $role, $status, $picture, $email, $speciality, $post, $grade, $bio, $id = null) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
        $this->status = $status;
        $this->picture = $picture;
        $this->email = $email;
        $this->speciality = $speciality;
        $this->post = $post;
        $this->grade = $grade;
        $this->bio = $bio;
        $this->id = $id;
    }
    
    public function render() {
        $statusColors = [
            'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'dot' => 'bg-green-500'],
            'inactive' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dot' => 'bg-gray-500'],
            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dot' => 'bg-yellow-500'],
            'suspended' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'dot' => 'bg-red-500']
        ];
        
        $statusConfig = $statusColors[strtolower($this->status)] ?? $statusColors['inactive'];
        
        $roleColors = [
            'admin' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
            'enseignant' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
            'doctorant' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
            'etudiant' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
            'invite' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'],
        ];
        
        $roleConfig = $roleColors[strtolower($this->role)] ?? ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'];
        
        $header = [
            "<div class='flex items-start gap-4 mb-4'>
                <div class='relative flex-shrink-0'>
                    <div class='relative w-16 h-16'>
                        <img src='{$this->picture}' 
                             class='w-full h-full rounded-xl object-cover border-2 border-white shadow-sm'
                             alt='{$this->firstName} {$this->lastName}'>
                        
                        <div class='absolute -bottom-1 -right-1 w-4 h-4 rounded-full {$statusConfig['dot']} border-2 border-white'
                             title='{$this->status}'>
                        </div>
                    </div>
                </div>
                
                <div class='flex-1 min-w-0'>
                    <div class='flex items-start justify-between mb-1'>
                        <h3 class='font-bold text-[var(--gray-dark)] truncate'>
                            {$this->firstName} {$this->lastName}
                        </h3>
                        <span class='px-2 py-1 rounded-full text-xs font-medium {$roleConfig['bg']} {$roleConfig['text']} ml-2 flex-shrink-0'>
                            {$this->role}
                        </span>
                    </div>
                    
                    <p class='text-sm text-[var(--gray-dark)] mb-2 truncate'>
                        {$this->post}
                    </p>
                    
                    <div class='flex items-center text-xs text-[var(--gray-dark)]'>
                        <svg class='w-3 h-3 mr-1 flex-shrink-0' fill='currentColor' viewBox='0 0 20 20'>
                            <path d='M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z'/>
                            <path d='M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z'/>
                        </svg>
                        <span class='truncate'>{$this->email}</span>
                    </div>
                </div>
            </div>"
        ];
        
        $body = [
            "<div class='space-y-4'>
                <div class='grid grid-cols-2 gap-2'>
                    <div class='bg-[var(--gray-light)] rounded-lg p-3 text-center'>
                        <div class='text-xs text-[var(--gray-dark)] mb-1'>Spécialité</div>
                        <div class='text-sm font-semibold text-[var(--gray)] truncate' title='{$this->speciality}'>{$this->speciality}</div>
                    </div>
                    
                    <div class='bg-[var(--gray-light)] rounded-lg p-3 text-center'>
                        <div class='text-xs text-[var(--gray-dark)] mb-1'>Grade</div>
                        <div class='text-sm font-semibold text-[var(--gray)] truncate' title='{$this->grade}'>{$this->grade}</div>
                    </div>
                </div>
                
                <div class='flex items-center justify-between bg-[var(--gray-light)] rounded-lg p-3'>
                    <div class='flex items-center'>
                        <div class='w-2 h-2 rounded-full {$statusConfig['dot']} mr-2'></div>
                        <span class='text-sm font-medium {$statusConfig['text']} capitalize'>{$this->status}</span>
                    </div>
                    <span class='text-xs text-[var(--gray-dark)]'>Statut</span>
                </div>
                
                <div class='bg-[var(--gray-light)] rounded-lg p-3'>
                    <div class='text-xs text-[var(--gray)] mb-2'>Bio</div>
                    <p class='text-sm text-[var(--gray)] line-clamp-2 leading-relaxed'>{$this->bio}</p>
                </div>
            </div>"
        ];
        
        $footer = [
            
        ];
        
        $card = new Card(
            $header, 
            $body, 
            $footer, 
            'bg-[var(--white)] rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all duration-200 h-full flex flex-col'
        );
        
        return $card->render();
    }
}
?>