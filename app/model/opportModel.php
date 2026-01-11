<?php
require_once "baseModel.php";
class OpportModel extends BaseModel{
    public function getAll(){
        $con = $this->connection();
        $offers = $this->get_all($con, 'opportunities');
        $this->deconnexion($con);
        return $offers;
    }

    public function getOfferById($id){
        $con = $this->connection();
        $offer = $this->getByCol($con, 'opportunities', 'id', $id);
        $this->deconnexion($con);
        return $offer[0];
    }
    public function deleteOpport($id){
        $con = $this->connection();
        $this->delete($con, 'opportunities', 'id', $id);
        $this->deconnexion($con);
    }
    public function createOffer($title,$description,$type,$requirements,$deadline,$contact_email,$status){
        $con = $this->connection();
        $id = $this->insert($con, 'opportunities', ['title' =>$title, 'description'=> $description, 'type'=> $type, 'deadline' => $deadline, 'requirements' => $requirements, 'contact_email'=>$contact_email, 'status' => $status]);
        $this->deconnexion($con);
        return $id;
    }
    public function updateOffer($id,$title,$description,$type,$requirements,$deadline,$contact_email,$status){
        $con = $this->connection();
        $this->update($con, 'opportunities', ['title' =>$title, 'description'=> $description, 'type'=> $type, 'deadline' => $deadline, 'requirements' => $requirements, 'contact_email'=>$contact_email, 'status' => $status], 'id', $id);
        $this->deconnexion($con);
    }
}

?>