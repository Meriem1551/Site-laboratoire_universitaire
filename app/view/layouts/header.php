<?php
class Header{
    private function create_header() { 
        $currentPage = $_GET['page'] ?? 'accueil';

        function navClass($currentPage, $pageName="") {
            $base = "text-[var(--white)] hover:text-[var(--primary-light)]";
            if ($currentPage === $pageName) {
                $base .= " border-b-2 border-[var(--primary-light)] text-[var(--primary-light)]";
            }
            return $base;
        }       
        function subNavClass() {
            $base = "px-4 py-2 hover:bg-[var(--primary-light)] hover:text-[var(--white)]";
            return $base;
        }
        
        function userNavClass($currentPage, $pageName="") {
            $base = "px-4 py-2 hover:bg-[var(--primary-light)] hover:text-[var(--white)] flex items-center gap-2";
            if ($currentPage === $pageName) {
                $base = "px-4 py-2 bg-[var(--primary-light)] text-[var(--white)] flex items-center gap-2";
            }
            return $base;
        }
        ?>
        
        <nav class="p-4 flex justify-between items-center bg-[var(--primary-dark)] shadow-md fixed w-full z-10">
            <div class="w-full flex justify-center items-center font-medium">
                 <?php
                    $settings = $GLOBALS['appSettings'] ?? [];
                ?>
                <img src="<?= $settings['labo_logo'] ?? '' ?>" class="w-12 h-12 mr-auto rounded-lg">     
                <ul class="flex items-center gap-6 lg:gap-12 mr-auto">
                    <li><a href="index.php?page=accueil" class='<?= navClass($currentPage, "accueil") ?>'>Accueil</a></li>
                    <li><a href="index.php?page=projets" class='<?= navClass($currentPage, "projets") ?>'>Projets</a></li>
                    <li><a href="index.php?page=publications" class='<?= navClass($currentPage, "publications") ?>'>Publications</a></li>
                    <li><a href="index.php?page=equipements" class='<?= navClass($currentPage, "equipements") ?>'>Equipements</a></li>
                    <li><a href="index.php?page=membres" class='<?= navClass($currentPage, "membres") ?>'>Membres</a></li>
                    
                    <li class="relative group">
                        <a class="<?= navClass($currentPage, "")?>">Decouvrir</a>
                        <ul class="absolute left-0 w-40 bg-[var(--gray-light)] text-[var(--gray-dark)] rounded shadow-lg p-2 hidden group-hover:block">
                            <li class="<?= userNavClass($currentPage, "actualites")?>"><a href="index.php?page=actualites">Actualites</a></li>
                            <li class="<?= userNavClass($currentPage, "evenments")?>"><a href="index.php?page=evenments">Evenments</a></li>
                            <li class="<?= userNavClass($currentPage, "offres")?>"><a href="index.php?page=offres">Offres et opportunities</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="index.php?page=contact" class='<?= navClass($currentPage, "contact") ?>'>Contact</a></li>
                </ul>
                
                <ul class="flex items-center gap-6 lg:gap-12">
                    <li class="relative group ml-0">
                        <a class="<?= navClass($currentPage, "")?>">Nos Réseaux</a>
                        <ul class="absolute left-0 w-40 bg-[var(--gray-light)] text-[var(--gray-dark)] rounded shadow-lg p-2 hidden group-hover:block">
                            <li class="<?= subNavClass()?>"><a href="#">Facebook</a></li>
                            <li class="<?= subNavClass()?>"><a href="#">Twitter</a></li>
                            <li class="<?= subNavClass()?>"><a href="#">Linkedin</a></li>
                            <li class="<?= subNavClass()?>"><a href="#">Site officiel</a></li>
                        </ul>
                    </li>
                    
                    <?php if(isset($_SESSION['user'])): ?>
                    <li class="relative group ml-0">
                        <div class="flex items-center gap-2 cursor-pointer">
                            <img src="<?= $_SESSION['user'][0]['profile_picture'] ?>" 
                                 class="rounded-full w-9 h-9">
                            <p class='text-[var(--white)]'><?= $_SESSION['user'][0]['role']?></p>
                            <svg class="w-4 h-4 text-[var(--white)]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        
                        <ul class="absolute right-0 mt-1 w-48 bg-[var(--gray-light)] text-[var(--gray-dark)] rounded shadow-lg p-2 hidden group-hover:block">
                            <li>
                                <a href="index.php?page=dashboard&role=<?=$_SESSION['user'][0]['role']?>" class="<?= userNavClass($currentPage, "dashboard") ?>">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/>
                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/>
                                    </svg>
                                    Tableau de bord
                                </a>
                            </li>
                            
                            <li>
                                <a href="index.php?page=profile" class="<?= userNavClass($currentPage, "profile") ?>">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    Mon profil
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <?php else: ?>
                    <li>
                        <a href="index.php?page=login">
                            <?php
                            $button = (new Button("Connexion", "button", "text-[var(--white)] bg-[var(--primary)] px-4 py-2 rounded hover:bg-[var(--primary-light)]"))->render();
                            echo $button;
                            ?>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    <?php
    }
    public function display_header(){
        $this->create_header();
    }
}
?>

