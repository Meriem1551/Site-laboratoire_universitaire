<?php
require_once "button.php";
require_once "title.php";
    class Form{
    private array $fields = [];
    private string $method;
    private string $action;
    private string $submitText;
    private string $formTitle;
    private string $text = '';

    private bool $twoColumn = false;

    public function __construct(string $action = "", string $method, string $submitText, string $formTitle, string $text = '', bool $twoColumn = false) {
        $this->action = $action;
        $this->method = $method;
        $this->submitText = $submitText;
        $this->formTitle = $formTitle;
        $this->text = $text;
        $this->twoColumn = $twoColumn;
    }

    public function addField(string $name, string $label, string $type, string $value='', string $placeholder= '') {
        $field = '';
    if ($type === 'textarea') {
        $field = "<label for='$name'>$label</label>
                  <textarea name='$name' id='$name' placeholder='$placeholder' class='w-full px-4 py-2 border border-[var(--gray)] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition duration-200'>$value</textarea>";
    } else {
        $field = "<label for='$name'>$label</label>
                  <input type='$type' name='$name' id='$name' value='$value' placeholder='$placeholder' class='w-full px-4 py-2 border border-[var(--gray)] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition duration-200'>";
    }
        $this->fields[] = $field;
    }

    public function render() {
    echo "<div class='w-full bg-white rounded-xl p-8'>";
    $title = (new Title($this->formTitle, 'text-3xl font-bold text-center text-[var(--primary)] mb-6', 'h2'))->render();
    echo $title;
    echo $this->text;
    echo "<form action='{$this->action}' method='{$this->method}' class='space-y-5' enctype='multipart/form-data'>";
    $gridClass = $this->twoColumn ? "grid grid-cols-2 gap-4" : "space-y-5";
    echo "<div class='{$gridClass}'>";
    foreach ($this->fields as $f) {
        $value = htmlspecialchars($f['value'] ?? '');
        echo "
            <div>
                $f
            </div>
        ";
    }
echo "</div>";

    echo"<div>";
            $button = (new Button($this->submitText, 'submit', 'w-full bg-[var(--primary)] text-white py-2 rounded-lg font-semibold hover:border-[var(--primary-light)] hover:border-2 hover:text-[var(--primary-light)] hover:bg-white transition duration-200'))->render();
            echo $button;
    echo"</div>";

    echo "</form></div>";
}

    }
?>