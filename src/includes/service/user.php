<?php

class User extends Dbh
{

  public $name;
  public $school_name;
  public $gender;
  public $age;

  function __construct(
    $name = null,
    $school_name = null,
    $gender = null,
    $age = null
  ) {
    $this->name = $name;
    $this->school_name = $school_name;
    $this->gender = $gender;
    $this->age = $age;
  }

  public function getAllUsers()
  {
    $stmt = $this->connect()->query("SELECT * FROM users");
    $users_arr = array();
    $users_arr['data'] = array();
    while ($row = $stmt->fetch()) {
      extract($row);
      $user = array(
        'id' => $id,
        'name' => $name,
        'school_name' => $school_name,
        'gender' => $gender,
        'age' => $age
      );
      array_push($users_arr['data'], $user);
    }
    return json_encode($users_arr);
  }

  public function createUser($name, $school_name, $gender, $age)
  {
    $query = "INSERT INTO users(name, school_name, gender, age) VALUES(:name, :school_name, :gender, :age)";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([
      "name" => $name,
      "school_name" => $school_name,
      "gender" => $gender,
      "age" => $age
    ]);
    return "ok";
  }

  public function getOneUser($id)
  {
    try {
      $query = "SELECT * FROM users WHERE id=:id";
      $stmt = $this->connect()->prepare($query);
      $stmt->execute(["id" => $id]);
      $row = $stmt->fetch();
      if ($row) {
        extract($row);
        $user["user"] = array(
          "id" => $id,
          "name" => $name,
          "school_name" => $school_name,
          "gender" => $gender,
          "age" => $age
        );
        return json_encode($user);
      } else {
        http_response_code(404);
        return json_encode(array("error" => "user not found"));
      }
    } catch (PDOException $th) {
      return $th->getMessage();
    }
  }

  public function updateOne($id)
  {
    $query = "UPDATE users
      SET
        name=:name,
        school_name=:school_name,
        gender=:gender,
        age=:age
      WHERE
        id=:id";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([
      "id" => (int) $id,
      "name" => $this->name,
      "school_name" => $this->school_name,
      "gender" => $this->gender,
      "age" => $this->age
    ]);
    return $this->getOneUser($id);
  }

  public function delete($id)
  {
    $query = "DELETE FROM users WHERE id=:id";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute(["id" => $id]);
    return "ok";
  }
}
