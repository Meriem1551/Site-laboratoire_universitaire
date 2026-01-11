<?php
require_once "components/table.php";

class SettingView {
    public function show_settings($settings, $allowed) {
        echo '<section class="min-h-screen py-12 md:py-24 px-4 md:px-8 lg:px-12">';
        echo '<div class="max-w-7xl mx-auto">';
        echo '<div class="mb-8">';
        echo '<div class="flex items-center gap-3 mb-3">';
        echo '<h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-[var(--gray-dark)]">Paramètres du système</h1>';
        echo '</div>';
        echo '<p class="text-[var(--gray)] text-base md:text-lg">Configurez les préférences et les options de votre plateforme</p>';
        echo '</div>';

        

        echo '<form action="index.php?page=update_setting" method="POST" enctype="multipart/form-data" class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 overflow-hidden">';
        
        echo '<div class="px-6 py-5 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">';
        echo '<div>';
        echo '<h2 class="text-xl font-bold text-[var(--gray-dark)]">Configuration</h2>';
        echo '<p class="text-sm text-[var(--gray)]">Modifiez les valeurs ci-dessous pour personnaliser votre plateforme</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="divide-y divide-gray-200">';
        
        foreach ($settings as $index => $setting) {
            echo '<div class="px-6 py-5">';
            echo '<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">';
            
            echo '<div class="lg:col-span-1">';
            echo '<div class="flex items-start gap-3">';
            
            $icon = $this->getSettingIcon($setting['type']);
            echo '<div class="p-2 bg-gray-100 rounded-lg mt-1">';
            echo '<svg class="w-4 h-4 text-[var(--gray)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' . $icon . '"/>';
            echo '</svg>';
            echo '</div>';
            
            echo '<div>';
            echo '<label class="block text-sm font-semibold text-[var(--gray-dark)] mb-1">';
            echo htmlspecialchars($setting['key_name']);
            echo '</label>';
            if (!empty($setting['description'])) {
                echo '<p class="text-xs text-[var(--gray)]">' . htmlspecialchars($setting['description']) . '</p>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="lg:col-span-2">';
            
            if ($setting['type'] === 'file') {
                echo '<div class="space-y-3">';
                if (!empty($setting['value']) && file_exists($setting['value'])) {
                    echo '<div class="flex items-center gap-3">';
                    echo '<div class="text-sm text-[var(--gray)]">Fichier actuel :</div>';
                    if (strpos($setting['value'], '.png') !== false || strpos($setting['value'], '.jpg') !== false || strpos($setting['value'], '.jpeg') !== false) {
                        echo '<img src="' . htmlspecialchars($setting['value']) . '" class="w-12 h-12 rounded-lg border border-gray-200">';
                    } else {
                        echo '<div class="p-3 bg-gray-100 rounded-lg border border-gray-200">';
                        echo '<svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>';
                        echo '</svg>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
                
                echo '<div class="relative">';
                echo '<input type="file" name="' . htmlspecialchars($setting['key_name']) . '" id="file_' . $index . '" class="hidden">';
                echo '<label for="file_' . $index . '" class="cursor-pointer">';
                echo '<div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 hover:bg-blue-50 transition-colors">';
                echo '<svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>';
                echo '</svg>';
                echo '<div class="text-sm text-[var(--gray)]">Cliquez pour téléverser un fichier</div>';
                echo '<div class="text-xs text-[var(--gray)] mt-1">PNG, JPG, PDF ou autres formats</div>';
                echo '</div>';
                echo '</label>';
                echo '</div>';
                
                echo '</div>';
            } else {
                $inputClass = "w-full px-4 py-2.5 bg-[var(--white)] border border-gray-300 rounded-lg text-[var(--gray-dark)] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm";
                
                if ($setting['type'] === 'color') {
                    echo '<div class="flex items-center gap-3">';
                    echo '<input type="color" name="' . htmlspecialchars($setting['key_name']) . '" value="' . htmlspecialchars($setting['value']) . '" class="w-12 h-12 cursor-pointer">';
                    echo '<input type="text" name="' . htmlspecialchars($setting['key_name']) . '_text" value="' . htmlspecialchars($setting['value']) . '" class="' . $inputClass . '">';
                    echo '</div>';
                } else {
                    echo '<input type="' . htmlspecialchars($setting['type']) . '" name="' . htmlspecialchars($setting['key_name']) . '" value="' . htmlspecialchars($setting['value']) . '" class="' . $inputClass . '">';
                }
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
        
        echo '<div class="px-6 py-4 border-t border-gray-200 bg-gray-50">';
        echo '<div class="flex justify-between items-center">';
        if ($allowed['update']) {
            echo '<button type="submit" class="px-6 py-2.5 bg-[var(--primary)] text-[var(--white)] font-medium rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2 shadow-sm hover:shadow">';
            echo '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>';
            echo '</svg>';
            echo 'Enregistrer toutes les modifications';
            echo '</button>';
        }
        echo '<div class="flex gap-4 my-4">
            <button type="submit" name="backup_db" class="px-4 py-2 bg-[var(--primary)] text-[var(--white)] rounded hover:bg-[var(--primary-light)]">
                Sauvegarder la base
            </button>
            <button type="submit" name="reset_db" class="px-4 py-2 bg-[var(--primary)] text-[var(--white)] rounded hover:bg-[var(--error)]">
                Restaurer la base
            </button>
        </div>';
        echo '</div>';
        echo '</div>';

        echo '</form>';
        echo '</div>';
        echo '</section>';

    }
    
    private function getSettingIcon($type) {
        $icons = [
            'text' => 'M4 6h16M4 12h16M4 18h16',
            'file' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            'color' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
        ];
        
        return $icons[$type] ?? $icons['text'];
    }
}
?>