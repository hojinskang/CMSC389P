<?php
class Student {
  private $name;
  private $grade;

  public function __construct($pname, $pgrade) {
    $this->name = $pname;		// Notice this->name (no $ for name)
    $this->grade = $pgrade;  // We need $this-> to refer to data members
  }

  public function getName() {
    return $this->name;
  }

  public function getGrade() {
    return $this->grade;
  }
}
?>
