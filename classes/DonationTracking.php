<?php

require_once 'classes/Charity.php';
require_once 'classes/Donation.php';

class DonationTracking{
    private $donations = [];
    private $charities = [];

    // Charities functions
    public function getCharities() {
        return $this->charities;
    }

    public function addCharity($charity){
        $this->charities[] = $charity;
    }

    public function deleteCharity($charityId) {
        while(true) {
            foreach($this->charities as $key => $charity) {
                if($charity->getId() == $charityId) {
                    unset($this->charities[$key]);
                    echo "\n\e[92mThe charity with {$charityId} ID was successfully deleted!\e[39m\n";
                    return;
                } 
            }
                echo "\e[91mCharity with ID {$charityId} not found. Enter existing charity's ID.\e[39m\n";
                $charityId = trim(fgets(STDIN));
        }
    }

    public function editCharity($charityId) {
        while(true) {
            foreach($this->charities as $charity) {
                if($charity->getId() == $charityId) {
                    echo "Enter new name for charity:\n";
                    $newCharityName = trim(fgets(STDIN));
                    $charity->setName($newCharityName);

                    echo "Enter new representative email:\n";
                    $newRepresentativeEmail = trim(fgets(STDIN));
                    $charity->setRepresentativeEmail($newRepresentativeEmail); 

                    echo "\n\e[92mThe charity was successfully edited!\e[39m\n";
                    return;
                } 
            }
            echo "\e[91mCharity with $charityId ID was not found. Enter existing charity's ID\e[39m\n";
            $charityId = trim(fgets(STDIN));
        }
    }

    public function viewCharities() {
        if (empty($this->charities)) {
            echo "\e[90mNo charities were created yet.\n";
            return;
        }
        foreach ($this->charities as $charity) {
            echo "\e[39m---------------------------------------\nCharity ID: {$charity->getId()}\nName: {$charity->getName()}\nRepresentative Email: {$charity->getRepresentativeEmail()}\n\n";

            $donations = $this->viewDonations($charity->getId());
            if (!empty($donations)) {
                echo "Donations of Charity {$charity->getId()}:\n";

                foreach ($donations as $donation) {
                    echo "\e[39mID: {$donation->getDonationId()}\n";
                    echo "Was made by: {$donation->getDonorName()}\n";
                    echo "Amount: {$donation->getAmount()}\n";
                    echo "Donation made at: {$donation->getDateTime()->format('Y-m-d H:i:s')}\n\n";
                }
            } else {
                echo "\e[90mNo donations were made.\n";
            }
        }
        
    }

    //Donation functions
    public function getDonations() {
        return $this->donations;
    }

    public function addDonation($donation) {
        $this->donations[] = $donation;
    }

    public function viewDonations($charityId) {
        $donations = [];
        foreach ($this->donations as $donation) {
            if($donation->getCharityId() == $charityId){
                $donations[] = $donation;
            }
        }
        return $donations;
    }
}




