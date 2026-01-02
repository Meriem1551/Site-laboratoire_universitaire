<?php
require_once "button.php";
require_once "title.php";
class Form {
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

    public function addInput(string $name, string $label, string $value = '', string $placeholder = '', string $type = 'text') {
        $field = "<div class='space-y-2'>
                    <label for='$name' class='block text-sm font-medium text-[var(--gray-dark)]'>$label</label>
                    <input type='$type' name='$name' id='$name' value='$value' placeholder='$placeholder' 
                           class='w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                  focus:outline-none focus:ring-2 focus:ring-[var(--primary-light)] focus:border-[var(--primary-light)]
                                  transition duration-200'>
                  </div>";
        $this->fields[] = $field;
    }

    public function addTextarea(string $name, string $label, string $value = '', string $placeholder = '', int $rows = 4) {
        $field = "<div class='space-y-2'>
                    <label for='$name' class='block text-sm font-medium text-[var(--gray-dark)]'>$label</label>
                    <textarea name='$name' id='$name' placeholder='$placeholder' rows='$rows'
                              class='w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                     focus:outline-none focus:ring-2 focus:ring-[var(--primary-light)] focus:border-[var(--primary-light)]
                                     transition duration-200 resize-none'>$value</textarea>
                  </div>";
        $this->fields[] = $field;
    }

    public function addSelect(string $name, string $label, array $options = [], string $selectedValue = '') {
        $field = "<div class='space-y-2'>
                    <label for='$name' class='block text-sm font-medium text-[var(--gray-dark)]'>$label</label>
                    <select name='$name' id='$name' 
                            class='w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                   focus:outline-none focus:ring-2 focus:ring-[var(--primary-light)] focus:border-[var(--primary-light)]
                                   transition duration-200 bg-white'>
                        <option value=''>Sélectionnez...</option>";
        foreach ($options as $value => $optionLabel) {
            $selected = ($value == $selectedValue) ? 'selected' : '';
            $field .= "<option value='$value' $selected>$optionLabel</option>";
        }
        $field .= "</select></div>";
        $this->fields[] = $field;
    }

    public function addCheckbox(string $name, string $label, $value = '', bool $checked = false) {
    $isChecked = $checked ? 'checked' : '';
    $field = "<div class='flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-gray-200'>
                <input type='checkbox' name='$name' id='$name-$value' value='$value' $isChecked
                       class='w-4 h-4 text-[var(--primary)] border-gray-300 rounded focus:ring-blue-500'>
                <label for='$name-$value' class='text-sm font-medium text-gray-800'>$label</label>
              </div>";
    $this->fields[] = $field;
    }


    public function addHidden(string $name, string $value) {
        $field = "<input type='hidden' name='$name' value='$value'>";
        $this->fields[] = $field;
    }

    public function addFile(string $name, string $label) {
        $field = "<div class='space-y-2'>
                    <label for='$name' class='block text-sm font-medium text-[var(--gray-dark)]'>$label</label>
                    <div class='border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition-colors'>
                        <input type='file' name='$name' id='$name' 
                               class='block w-full text-sm text-[var(--gray-dark)]
                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                      file:text-sm file:font-semibold file:bg-blue-50 file:text-[var(--primary)] 
                                      hover:file:bg-blue-100'>
                        <p class='mt-2 text-xs text-gray-500'>Choisissez un fichier</p>
                    </div>
                  </div>";
        $this->fields[] = $field;
    }

    public function render() {
        echo "<div class='w-full bg-[var(--white)] rounded-xl shadow-lg border border-gray-200 p-6 md:p-8'>";
        if (!empty($this->formTitle)) {
            $title = (new Title($this->formTitle, 'text-2xl md:text-3xl font-bold text-gray-900 mb-4', 'h2'))->render();
            echo $title;
        }
        if (!empty($this->text)) {
            echo "<p class='text-gray-600 mb-8 pb-4 border-b border-gray-200'>$this->text</p>";
        }

        echo "<form action='{$this->action}' method='{$this->method}' class='space-y-8' enctype='multipart/form-data'>";
        $gridClass = $this->twoColumn ? "grid grid-cols-1 md:grid-cols-2 gap-6" : "space-y-6";
        echo "<div class='{$gridClass}'>";
        foreach ($this->fields as $field) {
            echo "<div class='animate-fadeIn'>$field</div>";
        }
        echo "</div>";

        echo "<div class='flex flex-col sm:flex-row items-center gap-4'>";
        $button = (new Button(
            $this->submitText, 
            'submit', 
            'px-6 py-3 bg-[var(--primary)] text-[var(--white)] font-semibold
             rounded-lg hover:bg-[var(--primary-light)] active:scale-[0.98] 
             focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 
             transition-all duration-200 shadow-sm hover:shadow-md'
        ))->render();
        echo $button;
        echo "<div class='text-sm text-[var(--gray)] ml-auto'>Remplissez tous les champs obligatoires</div>";
        echo "</div></form></div>";
    }
}

?>