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
    public function getAll(){
        $con = $this->connection();
        $events = $this->get_all($con, 'events');
        $this->deconnexion($con);
        return $events;
    }
    public function getEventById($id){
        $con = $this->connection();
        $event = $this->getByCol($con, 'events', 'id', $id);
        $this->deconnexion($con);
        return $event[0];
    }
    public function createEvent( $title,$description,$type,$date,$image,$by,$open,$extern){
        $con = $this->connection();
        $this->insert($con, 'events', ['title' =>$title, 'description'=> $description, 'type'=> $type, 'event_date' => $date, 'image_path' => $image, 'created_by'=>$by, 'registerOpen' => $open, 'isExtern' => $extern]);
        $this->deconnexion($con);
    }
    public function updateEvent($id,$title,$description,$type,$date,$image,$open,$extern){
        $con = $this->connection();
        $this->update($con, 'events', ['title' =>$title, 'description'=> $description, 'type'=> $type, 'event_date' => $date, 'image_path' => $image,'registerOpen' => $open, 'isExtern' => $extern], 'id', $id);
        $this->deconnexion($con);
    }
    public function deleteEvent($id){
        $con = $this->connection();
        $this->delete($con, 'events', 'id', $id);
        $this->deconnexion($con);
    }
}
?>