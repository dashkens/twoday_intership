<?php

require_once 'classes/DonationTracking.php';

$tracker = new DonationTracking();

function displayMenu() {
    $dashSpace = "\e[39m---------------------------------------\n";

    echo $dashSpace;
    echo "\e[96mPlease, enter your option: \n\n";
    echo "\e[39m[1] - View List of Charities\n";
    echo "[2] - Add Charity\n";
    echo "[3] - Delete Charity\n";
    echo "[4] - Edit Charity\n";
    echo "[5] - Add Donation\n";
    echo "[6] - Add Charity from .csv file\n";
    echo "[7] - Exit\n";
    echo $dashSpace;
}

echo "\e[95mWelcome to Donation Tracking Application!\n";
displayMenu();


while (true) {
    $option = trim(fgets(STDIN));
    $answer = 'y';

    switch ($option) {
        case "1":
            echo "\e[96mList of the Charities:\n";
            $tracker->viewCharities();
            echo "\n";
            
            echo "\n\e[93mPress any key to go back to the Main Menu\n";
            strtolower(trim(fgets(STDIN)));
            displayMenu();
            break;

        case "2":
            while($answer === 'y') {
                $charity = new Charity();

                echo "\e[39mEnter Charity's ID:\n";
                $id = trim(fgets(STDIN));
                $charity->setId($id, $tracker->getCharities());

                echo "\e[39mEnter Charity's Name:\n";
                $name = trim(fgets(STDIN));
                $charity->setName($name);

                echo "\e[39mEnter Representative's email:\n";
                $representativeEmail = trim(fgets(STDIN));

                $charity->setRepresentativeEmail($representativeEmail);
            
                $tracker->addCharity($charity);
                echo "\n\e[92mThe charity was successfully added!\n";

                echo "\e[93mWould you like to add another charity? Press [Y] for yes. If no, press any other key\n";
                $answer = strtolower(trim(fgets(STDIN)));
            } 
            displayMenu();
            break;

        case "3": 
            while($answer === "y") {
                echo "\e[39mEnter Charity's ID to delete:\n";
                $charityId = trim(fgets(STDIN));
                $tracker->deleteCharity($charityId);

                echo "\e[93mWould you like to delete another charity? Press [Y] for yes. If no, press any other key\n";
                    $answer = strtolower(trim(fgets(STDIN)));
            }
            displayMenu();
            break;
        
        case "4": 
            while($answer === "y") {
                echo "\e[39mEnter Charity's ID to edit:\n";
                $charityId = trim(fgets(STDIN));
                $tracker->editCharity($charityId);

                echo "\e[93mWould you like to edit another charity? Press [Y] for yes. If no, press any other key\n";
                    $answer = strtolower(trim(fgets(STDIN)));
            }
            displayMenu();
            break; 

        case "5": {
            while($answer === "y") {
                $donation = new Donation();

                echo "\e[39mEnter Charity's ID:\n";
                $charityId = trim(fgets(STDIN));
                $donation->setCharityId($charityId, $tracker->getCharities());

                echo "\e[39mEnter Donation's ID:\n";
                $id = trim(fgets(STDIN));
                $donation->setDonationId($id, $tracker->getDonations()); 
            
                echo "\e[39mEnter Your Name:\n";
                $name = trim(fgets(STDIN));
                $donation->setDonorName($name);

                echo "\e[39mEnter the amount you wish to donate:\n";
                $amount = trim(fgets(STDIN));
                $donation->setAmount($amount);

                $tracker->addDonation($donation);
                echo "\n\e[92mThe charity was successfully added!\n";

                echo "\e[93mWould you like to make another donation? Press [Y] for yes. If no, press any other key\n";
                $answer = strtolower(trim(fgets(STDIN)));
            }
            displayMenu();
            break; 
        }  
        case "6": {  
            while($answer === "y") {
            echo "\e[39mEnter the name of file(with .csv included):\n";
            $fileName = trim(fgets(STDIN));

            if (!file_exists($fileName)) {
                echo "\e[91mThe file '$fileName' does not exist.\n";
                continue; 
            }

            $row = 1;         
            $uploadedCharities = [];
            //if file opening is successfull before opening, "r" - read only
            if (($handle = fopen("$fileName", "r")) !== FALSE) {
                //reads a line, up to 1000 characters per line and uses a comma (,) as the field separator.
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                    //skip the 1 row
                    if ($row === 1) {
                        $row++;
                        continue;
                    }

                    $charity = new Charity();

                    // assign values to a list
                    list($id, $name, $representativeEmail) = $data;

                    $charity->setId($id, $tracker->getCharities());
                    $charity->setName($name);
                    $charity->setRepresentativeEmail($representativeEmail);

                    $uploadedCharities[] = $charity;
                    $row++;
                }
                fclose($handle);
                foreach ($uploadedCharities as $charity) {
                    $tracker->addCharity($charity);
                }                
            }
            echo "\n\e[92mThe '$fileName' file was successfully uploaded!\n";
            echo "\e[93mWould you like to upload another file? Press [Y] for yes. If no, press any other key\n";
            $answer = strtolower(trim(fgets(STDIN)));
        }
        displayMenu();
        break; 
        } 
        
        case "7": {
            echo "\e[92mThank you for using our tracker and goodbye!\n\e[39mExiting...\n";
            exit();
        }

        default: 
            echo "Invalid choice. Please, enter a number between 1 and 7\n";    
    }
}
