<?php

require_once 'classes/Charity.php';
require_once 'classes/DonationTracking.php';



class Donation {
    private $donationId;
    private $donorName;
    private $amount;
    private $charityId;
    private $dateTime;

    public function __construct($donationId = null, $donorName = null, $amount = null, $charityId = null, $dateTime = null) {
        if ($donationId !== null) {
            $this->donationId = $donationId;
        }
        if ($donorName !== null) {
            $this->donorName = $donorName;
        }
        if ($amount !== null) {
            $this->amount = $amount;
        }
        if ($charityId !== null) {
            $this->charityId = $charityId;
        }
        if ($dateTime !== null) {
            $this->dateTime = $dateTime;
        }

        $this->setDateTime(new DateTime());

    }

    public function getDonationId() {return $this->donationId;}
    public function getDonorName() {return $this->donorName;}
    public function getAmount() {return $this->amount;}
    public function getCharityId() {return $this->charityId;}
    public function getDateTime() {return $this->dateTime;}


    public function setDonationId($donationId, $existingDonations) {

        while(true) {
            $idExists = false;
            foreach ($existingDonations as $donation) {
                if ($donation->getDonationId() === $donationId) {
                    $idExists = true;
                    break;
                }
            }
            if($idExists) {
                echo "\e[91mThe Donation with $donationId ID already exist. Enter another ID:\e[39m\n";
                $donationId = trim(fgets(STDIN));
            } else if (!is_numeric($donationId) || $donationId <= 0) {
                echo "\e[91mInvalid ID. Please enter a positive numeric value for the ID:\e[39m\n";
                $donationId = trim(fgets(STDIN));
            }  else {
                $this->donationId = $donationId;
                break;
            }
        }
    }
    public function setDonorName($donorName) {
        while (empty($donorName)) {
            echo "\e[91mName can't be empty. Please enter a valid name:\e[39m\n";
            $donorName = trim(fgets(STDIN));
        }
        $this->donorName = $donorName;
    }
    public function setAmount($amount) {
        while (!is_numeric($amount) || $amount <= 0) {
            echo "\e[91mInvalid amount. Please enter a positive numeric value:\e[39m\n";
            $amount = trim(fgets(STDIN));
        }
        $this->amount = $amount;
    }
    
    public function setCharityId($charityId, $charities) {
        while(true) {
            foreach($charities as $charity) {
                if($charity->getId() == $charityId) {
                    $this->charityId = $charityId;
                    return;
                } 
            }
            echo "\e[91mCharity with ID {$charityId} not found. Enter existing charity's ID.\e[39m\n";
            $charityId = trim(fgets(STDIN));
        }
    }

    public function setDateTime($dateTime) {
        $this->dateTime = $dateTime;
    }

}