<?php

class Charity {
    private $id;
    private $name;
    private $representativeEmail;

    public function __construct($id = null, $name = null, $representativeEmail = null) {
        if ($id !== null) {
            $this->id = $id;
        }
        if ($name !== null) {
            $this->name = $name;
        }
        if ($representativeEmail !== null) {
            $this->representativeEmail = $representativeEmail;
        }
    }

    //getters
    public function getId() {return $this->id;}
    public function getName() {return $this->name;}
    public function getRepresentativeEmail() {return $this->representativeEmail;}

    //setters
    public function setId($id, $existingCharities) {
        while(true) {
            if (!is_numeric($id) || $id <= 0) {
                echo "\e[91mInvalid ID. Please enter a positive numeric value for the ID:\e[39m\n";
                $id = trim(fgets(STDIN));
                continue;
            }
            
            $idExists = false;
            foreach ($existingCharities as $charity) {
                if ($charity->getId() === $id) {
                    $idExists = true;
                    break;
                }
            }
            if($idExists) {
                echo "\e[91mThe Charity with such ID already exist. Enter another ID:\e[39m\n";
                $id = trim(fgets(STDIN));
            }  else {
                $this->id = $id;
                break;
            }
        }
    }

    public function setName($name) {
        while (empty($name)) {
            echo "\e[91mName can't be empty. Please enter a valid name:\e[39m\n";
            $name = trim(fgets(STDIN));
        }
        $this->name = $name;
    }

    public function setRepresentativeEmail($representativeEmail) {
        while (!filter_var($representativeEmail, FILTER_VALIDATE_EMAIL)) {
            echo "\e[91mInvalid email format. Please enter a valid email:\e[39m\n";
            $representativeEmail = trim(fgets(STDIN));
        }
        $this->representativeEmail = $representativeEmail;
    }
}