<?php
require_once "baseModel.php";
class EventModel extends BaseModel{
  
    public function getEvents($limit, $offset){
        $con = $this->connection();
        $events = $this->requet($con, 'events.getAll',['limit' => (int)$limit, 'offset' => (int)$offset]);
        $this->deconnexion($con);
        return $events;
    }
    public function getEvent_public($limit, $offset){
        $con = $this->connection();
        $events = $this->requet($con, 'events.getAllPublic',['limit' => (int)$limit, 'offset' => (int)$offset]);
        $this->deconnexion($con);
        return $events;
    }
    public function getTotal_public(){
        $con = $this->connection();
        $total = $this->requet($con, 'events.getTotalPublic');
        $this->deconnexion($con);
        return $total;
    }
    public function getTotal(){
        $con = $this->connection();
        $total = $this->requet($con, 'events.getTotal');
        $this->deconnexion($con);
        return $total;
    }
}
?>