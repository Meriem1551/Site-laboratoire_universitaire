<?php
require_once __DIR__ . "/../components/button.php";
class Footer {
    private function create_footer() {
    ?>
        <div class=" bg-[var(--primary-dark)] text-[var(--white)] p-6 mb-auto font-[var(--font-primary)]">
            <div class="flex justify-between  font-medium">
                 <?php
                    $settings = $GLOBALS['appSettings'] ?? [];
                ?>
                <img 
                src="<?= $settings['univ_logo'] ?>"
                class="h-16 w-16"
                alt="Université"
                >
                    <div class="grid gap-4">
                        <a href="index.php?page=accueil" class="hover:text-[var(--primary-light)]">Accueil</a>
                        <a href="index.php?page=projets" class="hover:text-[var(--primary-light)]">Projets</a>
                        <a href="index.php?page=publications" class="hover:text-[var(--primary-light)]">Publications</a>
                    </div>
                    <div class="grid gap-4">
                        <a href="index.php?page=equipements" class="hover:text-[var(--primary-light)]">Equipements</a>
                        <a href="index.php?page=membres" class="hover:text-[var(--primary-light)]">Membres</a>
                        <a href="" class="hover:text-[var(--primary-light)]">Contact</a>
                    </div>
                    <div class="grid gap-4">
                        <a href="index.php?page=evenements" class="hover:text-[var(--primary-light)]">Evenements</a>
                        <a href="index.php?page=offres" class="hover:text-[var(--primary-light)]">Offres et Opportunites</a>
                        <a href="index.php?page=actualites" class="hover:text-[var(--primary-light)]">Actualites</a>
                    </div>
            </div>
            <div class="mt-6 border-t border-white/20 border-t-2 pt-4 lg:flex grid justify-between items-center gap-6">
                <?php $button = (new Button("Site officiel", "button", "text-[var(--primary-dark)] bg-[var(--white)] px-4 py-2 rounded hover:text-[var(--white)] hover:bg-[var(--primary-light)] font-medium"))->render(); 
                echo $button; ?>
                <div class="flex justify-between lg:gap-6 gap-10 lg:items-center items-start">
                    <a href="">Facebook</a> 
                    <a href="">Instagram</a>
                    <a href="">Linkedin</a>
                </div>
                <p>Copyright &copy; 2026. All rights reserved.</p>
                
            </div>
        </div>
    <?php
    }
    public function display_footer() {
        $this->create_footer();
    }
}
?>