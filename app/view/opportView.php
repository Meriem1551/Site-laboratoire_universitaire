<?php
require_once "components/title.php";
require_once "components/badge.php";
require_once "components/card.php";

class OpportView {
    public function show_offers($data) {
        echo '<section id="offers" class="px-8 md:px-12 py-16 md:py-24">';
        echo '<div class="container mx-auto px-4 max-w-6xl">';
        
        echo '<div class="text-center mb-16">';
        echo '<span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold bg-gradient-to-r from-blue-50 to-blue-100 text-[var(--primary)] border border-blue-200 mb-6">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                </svg>
                Opportunités Professionnelles
              </span>';
        
        $title = (new Title(
            "Opportunités de Carrière", 
            "text-4xl md:text-5xl font-bold text-[var(--gray-dark)] mb-6", 
            'h2'
        ))->render();
        echo $title;
        
        echo '<p class="text-[var(--gray)] max-w-2xl mx-auto text-lg leading-relaxed">Découvrez nos offres de stage et opportunités professionnelles pour développer votre expertise.</p>';
        echo '</div>';
        
        if(!empty($data)) {
            echo '<div class="grid md:grid-cols-2 gap-8 mb-16">';
            
            foreach($data as $row) {
                $status = $row['status'];
                $rowDate = date('d M Y', strtotime($row['deadline']));

                $statusColor = $status === 'ouvert' ? 
                    'var(--success)' : 
                    'var(--error)';
                $text = $status === 'ouvert' ? 'green-800' : 'red-800';

                $statusBadge = (new Badge(
                    $status === 'ouvert' ? 'Ouverte' : 'Fermée',
                    $statusColor,
                    $text
                ))->render();
                
                $typeBadge = (new Badge(
                    $row['type'],
                    'var(--primary)',
                    'white',
                ))->render();
                
                $header = [
                    '<div class="relative h-56 overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50 border-b border-gray-200">
                        <div class="absolute inset-0 flex items-center justify-center opacity-20">
                            <svg class="w-32 h-32 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                            </svg>
                        </div>
                        <div class="flex justify-between">
                        ' . $statusBadge . $typeBadge. '
                        </div>
                    </div>'
                ];

                $dateInfo = '<div class="flex items-center gap-4 mb-6 p-5 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-200">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[var(--primary-light)] to-[var(--primary)] flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-6 h-6 text-[var(--white)]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-500 mb-1">Date limite de candidature</div>
                        <div class="font-bold text-gray-900 text-lg">' . $rowDate . '</div>
                    </div>
                </div>';
                
                $cardTitle = (new Title(
                    $row['title'],
                    'text-2xl font-bold text-[var(--gray-dark)] mb-4 leading-tight',
                    'h3'
                ))->render();
                
                $requirementsHTML = '';
                if(!empty($row['requirements'])) {
                    $requirements = array_map('trim', explode(',', $row['requirements']));
                    $requirementsHTML = '<div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="text-sm font-medium text-[var(--gray-dark)] mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
                            </svg>
                            Compétences requises
                        </div>
                        <div class="flex flex-wrap gap-2">';
                    foreach($requirements as $req) {
                        $requirementsHTML .= '<span class="px-3 py-1.5 bg-gradient-to-r from-blue-50 to-indigo-50 text-[var(--primary)] rounded-lg text-sm font-medium border border-blue-200">
                            ' . htmlspecialchars($req) . '
                        </span>';
                    }
                    $requirementsHTML .= '</div></div>';
                }
                
                $contactInfo = '';
                if(!empty($row['contact_email'])) {
                    $contactInfo = '<div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-gradient-to-r from-gray-100 to-gray-50 rounded-lg border border-gray-200">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-700 mb-1">Pour postuler</div>
                                <div class="flex items-center gap-2">
                                    <a href="mailto:' . htmlspecialchars($row['contact_email']) . '" 
                                       class="text-[var(--primary)] hover:text-[var(--primary-light)] font-medium transition-colors">
                                        ' . htmlspecialchars($row['contact_email']) . '
                                    </a>
                                    <button onclick="copyToClipboard(\'' . htmlspecialchars($row['contact_email']) . '\')" 
                                            class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                                            title="Copier l\'email">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
                
                $body = [
                    '<div class="p-8">
                        ' . $dateInfo . '
                        ' . $cardTitle . '
                        <p class="text-gray-600 leading-relaxed mb-6">' . htmlspecialchars($row['description']) . '</p>
                        ' . $requirementsHTML . '
                        ' . $contactInfo . '
                    </div>'
                ];
                
                $footer = [
                    '<div class="p-8 pt-0">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">
                                Publié le ' . date('d/m/Y', strtotime($row['created_at'])) . '
                            </span>
                        </div>
                    </div>'
                ];
                
                $card = new Card(
                    $header,
                    $body,
                    $footer,
                    'bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y- p-4'
                );
                
                $card->render();
            }
            
            echo '</div>';
        } else {
            echo '<div class="text-center py-16 bg-gradient-to-br from-white to-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="max-w-md mx-auto">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucune offre disponible</h3>
                        <p class="text-gray-600 mb-8">De nouvelles opportunités seront publiées prochainement.</p>
                    </div>
                  </div>';
        }
        
        echo '</div>';
        echo '</section>';
        
        // JavaScript for copy to clipboard and save functionality
        echo '<script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show success message (you can implement a toast notification here)
                alert("Email copié dans le presse-papier !");
            }).catch(err => {
                console.error("Erreur lors de la copie: ", err);
            });
        }
        
        function saveOpportunity(offerId) {
            const button = event.target.closest("button");
            const originalHTML = button.innerHTML;
            
            button.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Sauvegarde...
            `;
            button.disabled = true;
            
            fetch("/save-opportunity.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ offer_id: offerId })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    button.innerHTML = `
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 011.414 0l-4-4a1 1 0 111.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Sauvegardé
                    `;
                    button.classList.remove("hover:shadow-sm", "hover:bg-gray-100");
                }
            })
            .catch(error => {
                button.innerHTML = originalHTML;
                button.disabled = false;
                alert("Erreur lors de la sauvegarde");
            });
        }
        </script>';
    }
}
?>