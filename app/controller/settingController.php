
<?php
require_once "baseController.php";
require_once "app/model/settingModel.php";
require_once "app/view/settingView.php";

class SettingController extends BaseController{
    private function getSettings(){
        $model = new SettingModel();
        $settings = $model->getAll();
        return $settings;
    }
    public function show_settings(){
        $settings = $this->getSettings();
        $view = new SettingView();
        $allowed = $this->getAllowedActions('settings');
        $view->show_settings($settings, $allowed);
    }
    private function backupDatabase(){
        $model = new SettingModel();
        $model->backup();
    }
    private function resetDatabase(){
        $model = new SettingModel();
        $model->reset();
    }
   public function update_settings() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        $model = new SettingModel();
        if (isset($_POST['backup_db'])) {
        $backupFile = $model->backup();

            if ($backupFile) {
                echo "<script>alert('Sauvegarde créée avec succès');</script>";
            } else {
                echo "<script>alert('Échec de la sauvegarde');</script>";
            }
        }


        if (isset($_POST['reset_db'])) {
            $backups = glob(__DIR__ . '/../../backups/*.sql');
            rsort($backups);

            if (!empty($backups)) {
                $success = $model->reset($backups[0]);

                if ($success) {
                    echo "<script>alert('Base de données restaurée'); window.location='index.php?page=gestion_settings';</script>";
                } else {
                    echo "<script>alert('Erreur lors de la restauration'); window.location='index.php?page=gestion_settings';</script>";
                }
            } else {
                echo "<script>alert('Aucune sauvegarde trouvée'); window.location='index.php?page=gestion_settings';</script>";
            }
            exit;
        }

        foreach ($_POST as $key => $value) {
        if ($value === '' || in_array($key, ['backup_db', 'reset_db'])) {
            continue;
        }
        $model->update_setting($value, $key);
        }
        foreach ($_FILES as $key => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {

                $uploadDir = 'public/assets/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $filename   = uniqid() . '_' . basename($file['name']);
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $model->update_setting($targetPath, $key);
                }
            }
        }
        header("Location: index.php?page=gestion_settings");
        exit;
    }

}
?>