<?php
class DiaporamaCard {
    private $title;
    private $image;
    private $description;

    public function __construct($title, $description, $image = "") {
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
    }

    public function render() {
        echo "
        <div class='relative w-full h-screen bg-cover bg-center overflow-hidden'
             style='background-image: url(\"$this->image\");'>
             <div class='absolute inset-0 bg-black/30'></div>
             <div class='relative z-10 flex flex-col justify-end items-start h-full p-8'>
                 " . (new Title($this->title, 'font-[var(--font-primary)] font-semibold text-4xl text-[var(--white)]', 'h3'))->render() . "
                 <p class='text-[var(--white)] font-[var(--font-secondary)] text-lg mt-4'>$this->description</p>
             </div>
        </div>
        ";
    }
}
?>
