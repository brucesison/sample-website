<?php
// PDO DB
include_once "Pdo.php";

class Functions {

private $con;
private string $response;

  public function __construct($db) {
    $this->con = $db; 
  }
    
  public function getUpcomingAppointment(){
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getAppointmentRequest(){
    $stmt = $this->con->prepare('SELECT * FROM appointment_req_tbl');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getDoneAppointment(){
    $stmt = $this->con->prepare('SELECT * FROM done_appointment_tbl');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }

  public function checkParentDetails($email, $contact_no) {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE email = ? OR contact_no = ?');
    $stmt->execute([$email, $contact_no]);

    return $stmt->fetchAll();
  }

  public function checkChildDetails($child_name, $father_name, $mother_name) {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl WHERE child_name = ? AND father_name = ? AND mother_name = ?');
    $stmt->execute([$child_name, $father_name, $mother_name]);

    return $stmt->fetchAll();
  }

  public function checkDoctorDetails($email, $contact_no) {
    $stmt = $this->con->prepare('SELECT * FROM doctor_tbl WHERE email = ? OR contact_no = ?');
    $stmt->execute([$email, $contact_no]);

    return $stmt->fetchAll();
  }

  public function getAllParents(){
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_type = "user"');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getParents($offset = 0, $limit = 6){
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_type = "user" LIMIT :offset, :limit');
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDoctor($offset = 0, $limit = 6){
    $stmt = $this->con->prepare('SELECT * FROM doctor_tbl LIMIT :offset, :limit');
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getChild($offset = 0, $limit = 6){
    $stmt = $this->con->prepare('SELECT * FROM child_tbl LIMIT :offset, :limit');
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function searchParents($search_query) {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_type = "user" AND (name LIKE :name_query OR email LIKE :email_query)');
    $search_value = '%' . $search_query . '%';
    $stmt->bindValue(':name_query', $search_value);
    $stmt->bindValue(':email_query', $search_value);
    $stmt->execute();

    if (!$stmt->rowCount()) {
        return [];
    }
    return $stmt->fetchAll();
  }

  public function searchParents2($searchTerm){
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_type = "user" AND name LIKE :search');
    $stmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }


  public function searchChild($search_query) {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl WHERE (child_name LIKE :name_query)');
    $search_value = '%' . $search_query . '%';
    $stmt->bindValue(':name_query', $search_value);
    $stmt->execute();

    if (!$stmt->rowCount()) {
        return [];
    }
    return $stmt->fetchAll();
  }

  public function searchDoctor($search_query) {
    $stmt = $this->con->prepare('SELECT * FROM doctor_tbl WHERE (name LIKE :name_query OR email LIKE :email_query)');
    $search_value = '%' . $search_query . '%';
    $stmt->bindValue(':name_query', $search_value);
    $stmt->bindValue(':email_query', $search_value);
    $stmt->execute();

    if (!$stmt->rowCount()) {
        return [];
    }
    return $stmt->fetchAll();
  }

  public function getRequestCount(){
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM appointment_req_tbl');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getUpcomingCount(){
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM appointment_tbl');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getTodayUpcomingCount() {
    // Prepare the SQL statement to count appointments for the current day
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM appointment_tbl WHERE DATE(appointment_date) = CURDATE()');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getChildCount(){
    $stmt = $this->con->prepare('SELECT COUNT(*) AS total FROM child_tbl');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($result['total']) ? (int) $result['total'] : 0;
  }

  public function getParentCount(){
    $stmt = $this->con->prepare('SELECT COUNT(*) AS total FROM user_tbl WHERE user_type = "user"');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($result['total']) ? (int) $result['total'] : 0;
  }

  public function getDoctorCount(){
    $stmt = $this->con->prepare('SELECT COUNT(*) AS total FROM doctor_tbl');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($result['total']) ? (int) $result['total'] : 0;
  }

  public function getCountParent(){
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM user_tbl WHERE user_type = "user"');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getCountDoctor(){
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM doctor_tbl');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getCountChild(){
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM child_tbl');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getPendingParentCount(){
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM user_tbl WHERE user_type = "user" AND status = "not_verified"');
    $stmt->execute();

    if(!$stmt->rowCount()){
      return [];
    }
    return $stmt->fetchAll();
  }
    
  public function responseSQL($stmt){
    if($stmt->rowCount()){
      $this->response = 'success';
    }
    $this->response = 'failed';
  }

  public function getEmployee($id){
    if(!$id) return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM employees where id = ?');
    $stmt->execute([$id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return research
  }

  public function getThisUpcomingAppointment($upcoming_appointment_id){
    if(!$upcoming_appointment_id) return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE appointment_id = ?');
    $stmt->execute([$upcoming_appointment_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getThisRequestAppointment($appointment_req_id){
    if(!$appointment_req_id) return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM appointment_req_tbl WHERE appointment_req_id = ?');
    $stmt->execute([$appointment_req_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getThisDoneAppointment($done_appointment_id){
    if(!$done_appointment_id) return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM done_appointment_tbl WHERE done_appointment_id = ?');
    $stmt->execute([$done_appointment_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getThisParent($parent_id){
    if(!$parent_id) return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_id = ?');
    $stmt->execute([$parent_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getThisDoctor($doctor_id){
    if(!$doctor_id) return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM doctor_tbl WHERE doctor_id = ?');
    $stmt->execute([$doctor_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getResponse(){ 
    return $this->response;
  }
            
}
            
$functions = new Functions($db);
            
?>
            