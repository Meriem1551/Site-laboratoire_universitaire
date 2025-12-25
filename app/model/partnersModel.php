<?php
require_once "baseModel.php";
class PartnersModel extends BaseModel{
   
    public function getPartners(){
        $con = $this->connection();
        $partners = $this->requet($con, 'partners.getAll');
        $this->deconnexion($con);
        return $partners;
    }
    public function getPartnersByProject($id_project){
        $con = $this->connection();
        $partners = $this->requet($con, 'partners.getByProject', ['project_id' => $id_project]);
        $this->deconnexion($con);
        return $partners;
    }
    public function deletePartnerFromProject($id_project, $id_partner){
        $con = $this->connection();
        $this->requet($con, 'partners.deleteFromProject', [
            'project_id' => $id_project,
            'partner_id' => $id_partner
        ]);
        $this->deconnexion($con);
    }
    public function addPartnerToProject($id_project, $id_partner){
        $con = $this->connection();
        $this->insert($con, 'project_partners', [
            'id_project' => $id_project,
            'id_part' => $id_partner
        ]);
        $this->deconnexion($con);
    }
    public function getPartnerById($id){
        $con = $this->connection();
        $partner = $this->getByCol($con, 'partners', 'id', $id);
        $this->deconnexion($con);
        return $partner[0];
    }

        public function createPartner($name, $type, $description, $logo_path){
            $con = $this->connection();
            $this->insert($con, 'partners', [
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'logo_path' => $logo_path
            ]);
            $this->deconnexion($con);
        }
    public function updatePartner($id, $name, $type, $description, $logo_path){
        $con = $this->connection();
        echo$id;
        $this->update($con, 'partners', [
            'name' => $name,
            'description' => $description,
            'type' => $type,
            'logo_path' => $logo_path
        ], 'id', $id);
        $this->deconnexion($con);
    }

    public function deletePartner($id){
        $con = $this->connection();
        $this->delete($con, 'partners', 'id', $id);
        $this->deconnexion($con);
    }

}

?>