<?php
require_once "card.php";
class UserCard{
private $firstName;
private $lastName;
private $role;
private $speciality;
private $status;
private $email;
private $post;
private $grade;
private $picture;
public function __construct($firstName, $lastName, $role, $status, $picture, $email, $speciality, $post, $grade){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
        $this->status = $status;
        $this->picture = $picture;
        $this->email = $email;
        $this->speciality =$speciality;
        $this->post = $post;
        $this->grade = $grade;
}
    public function render(){
        $status = (new Badge($this->status, "#4ade80", "#bbf7d0"))->render();
                $role = (new Badge($this->role, "var(--primary-light)", "var(--blue-blur)"))->render();
                $header = [
                    "<div class='grid border-b border-[var(--gray-light)] pb-4'>",
                        "<div class='flex justify-start mb-2'>",
                        $status,
                        "</div>",
                        "<div class='grid justify-center gap-4 items-center'>",
                            "<img src='{$this->picture}' class='w-24 h-24 object-cover rounded-full'/>",
                            $role,
                        "</div>",
                    "</div>",
                    ];
                $body = [
                            "<div class='flex justify-center gap-4 font-bold items-center mb-2'>",
                                    "<p class='text-[var(--gray-dark)]'>{$this->firstName}</p>",
                                    "<p class='text-[var(--gray-dark)]'> {$this->lastName}</p>",
                            "</div>",
                            "<div class='flex justify-between items-center mb-2'>",
                                    "<p class='text-[var(--gray)]'>Email:</p>",
                                    "<p class='text-[var(--gray-dark)]'>{$this->email}</p>",
                            "</div>",
                            "<div class='flex justify-between items-center mb-2'>",
                                    "<p class='text-[var(--gray)]'>Specialite:</p>",
                                    "<p class='text-[var(--gray-dark)]'>{$this->speciality}</p>",
                            "</div>",
                            "<div class='flex justify-between items-center mb-2'>",
                                    "<p class='text-[var(--gray)]'>Poste:</p>",
                                    "<p class='text-[var(--gray-dark)]'>{$this->post}</p>",
                            "</div>",
                            "<div class='flex justify-between items-center'>",
                                    "<p class='text-[var(--gray)]'>Grade:</p>",
                                    "<p class='text-[var(--gray-dark)]'>{$this->grade}</p>",
                            "</div>",
                ];
                    $footer = [];
                    $card = new Card($header,$body,$footer, 'p-6 shadow-md rounded-xl w-full grid gap-2');
                    $card->render();
    }
}
?>