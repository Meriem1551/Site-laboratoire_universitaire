
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
        if (!empty($_POST['backup_db'])) {
            $this->backupDatabase();  
        }

        if (!empty($_POST['reset_db'])) {
            $this->resetDatabase();
        }
        foreach ($_POST as $key => $value) {
            if ($value === '') continue;
            $model->update_setting($value, $key);
        }
        foreach ($_FILES as $key => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/assets/';
                $filename  = uniqid() . '_' . basename($file['name']);
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