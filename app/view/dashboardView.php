<?php
require_once "components/card.php";
require_once "components/title.php";
require_once "components/table.php";

class DashboardView {
    public function show_page($cards) {
        echo '<div class="min-h-screen py-24 px-12">';
        echo '<div class="mx-auto">';
        
        echo '<div class="mb-8 md:mb-12">';
        echo (new Title('Tableau de bord', 'text-3xl lg:text-4xl font-bold text-gray-900 mb-2', 'h1'))->render();
        echo '<p class="text-gray-600 text-lg">Gérez l\'ensemble de votre système</p>';
        echo '</div>';
        
        echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">';
        
        foreach ($cards as $cardKey => $cardData) {
            if(!$cardData['title']) {
                continue;
            }
            
            $header = [
                "<div class='p-6 grid justify-center'>
                    <div class='rounded-lg flex items-center justify-center mb-4'>
                        <div class='text-" . $cardData['color'] . "-600'>
                            " . $cardData['icon'] . "
                        </div>
                    </div>
                    
                    <h3 class='text-lg text-center font-bold text-gray-900 mb-2'>" . $cardData['title'] . "</h3>
                    
                    <div class='absolute top-0 left-0 right-0 h-1 bg-" . $cardData['color'] . "-500 rounded-t-lg'></div>
                </div>"
            ];
            
            $body = [
                "<div class='px-6 pb-6'>
                    <div class='flex items-center justify-center'>
                        <a href='" . $cardData['url'] . "' 
                           class='px-6 py-3 text-sm font-medium text-white bg-" . $cardData['color'] . "-500 hover:bg-" . $cardData['color'] . "-600 rounded-lg transition-colors hover:shadow-md w-full text-center'>
                            Accéder au module
                        </a>
                    </div>
                </div>"
            ];
            
            $footer = [];
            
            $card = new Card(
                $header, 
                $body, 
                $footer, 
                "bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-200 overflow-hidden relative"
            );
            
            echo $card->render();
        }
        
        echo '</div>'; 
        echo '</div>';
        echo '</div>';
    }
   public function show_entity_table($title, $data, $rowActions, $globalActions, $stats = []) {
    // Sécurité
    $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $entityKey = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $title));
    
    ?>
    <section class="min-h-screen py-8 md:py-12 px-4 md:px-8">
        
        <!-- En-tête et Statistiques -->
        <div class="mb-10">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2"><?= $safeTitle ?></h1>
            <p class="text-gray-600 text-base md:text-lg">Consultez et gérez tous les éléments</p>

            <?php if (!empty($stats)): ?>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <?php foreach($stats as $stat): 
                    $statTitle = htmlspecialchars($stat['title'] ?? '', ENT_QUOTES, 'UTF-8');
                    $statValue = htmlspecialchars($stat['value'] ?? '', ENT_QUOTES, 'UTF-8');
                ?>
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                    <div class="text-sm text-gray-500 mb-1"><?= $statTitle ?></div>
                    <div class="text-2xl font-bold text-gray-900"><?= $statValue ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Tableau -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            
            <!-- En-tête du tableau -->
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-900">Liste des éléments</h2>
                
                <?php if (!empty($globalActions)): ?>
                <div class="flex gap-3 ml-auto">
                    <?php foreach ($globalActions as $action): 
                        $safeAction = htmlspecialchars($action, ENT_QUOTES, 'UTF-8');
                        $actionLabel = ucfirst($safeAction);
                    ?>
                        <?php if ($action === 'add' || $action === 'create'): ?>
                            <a href="index.php?page=dashboard&entity=<?= $entityKey ?>&action=<?= $safeAction ?>" 
                               class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <?= $actionLabel === 'Add' ? 'Nouvel élément' : $actionLabel ?>
                            </a>
                        <?php else: ?>
                            <a href="index.php?page=dashboard&entity=<?= $entityKey ?>&action=<?= $safeAction ?>" 
                               class="px-4 py-2 text-indigo-600 hover:text-indigo-700 font-medium transition-colors">
                                <?= $actionLabel ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Contenu du tableau -->
            <div class="p-6">
                <?php if (!empty($data)): 
                    // Préparation des données pour le tableau
                    $tableData = [];
                    
                    foreach ($data as $row) {
                        $tableRow = [];
                        foreach ($row as $key => $value) {
                            $safeValue = htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
                            $tableRow[$key] = $safeValue;
                        }

                        // Ajout des actions par ligne
                        if (!empty($rowActions)) {
                            $id = $row['id'] ?? 0;
                            $safeId = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
                            
                            $actionsHtml = '<div class="flex items-center gap-2 justify-center">';
                            foreach ($rowActions as $action) {
                                $safeAction = htmlspecialchars($action, ENT_QUOTES, 'UTF-8');
                                
                                // Icônes selon l'action
                                if ($safeAction === 'edit' || $safeAction === 'update') {
                                    $actionsHtml .= '
                                    <a href="index.php?page=dashboard&entity=' . $entityKey . '&action=' . $safeAction . '&id=' . $safeId . '" 
                                       class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>';
                                } elseif ($safeAction === 'delete') {
                                    $actionsHtml .= '
                                    <a href="index.php?page=dashboard&entity=' . $entityKey . '&action=' . $safeAction . '&id=' . $safeId . '" 
                                       class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </a>';
                                } elseif ($safeAction === 'view') {
                                    $actionsHtml .= '
                                    <a href="index.php?page=dashboard&entity=' . $entityKey . '&action=' . $safeAction . '&id=' . $safeId . '" 
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Voir">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>';
                                } else {
                                    $actionsHtml .= '
                                    <a href="index.php?page=dashboard&entity=' . $entityKey . '&action=' . $safeAction . '&id=' . $safeId . '" 
                                       class="px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg transition-colors text-sm">
                                        ' . ucfirst($safeAction) . '
                                    </a>';
                                }
                            }
                            $actionsHtml .= '</div>';
                            $tableRow['Actions'] = $actionsHtml;
                        }
                        $tableData[] = $tableRow;
                    }
                    
                    // Détermination des colonnes
                    $columns = !empty($data) ? array_keys($data[0]) : [];
                    if (!empty($rowActions) && !in_array('Actions', $columns)) {
                        $columns[] = 'Actions';
                    }
                    
                    // Création du tableau
                    $table = new Table($columns, $tableData, 'w-full');
                    $table->render();
                    
                else: ?>
                    <!-- État vide -->
                    <div class="text-center py-16 px-4">
                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune donnée disponible</h3>
                        <p class="text-gray-600 max-w-md mx-auto mb-6">
                            Les données n'ont pas encore été ajoutées.
                        </p>
                        <?php if (!empty($globalActions) && (in_array('add', $globalActions) || in_array('create', $globalActions))): ?>
                            <a href="index.php?page=dashboard&entity=<?= $entityKey ?>&action=add" 
                               class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Ajouter le premier élément
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

}
?>