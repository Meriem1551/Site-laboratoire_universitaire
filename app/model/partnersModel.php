<?php
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

}

?>