<?php
	// Set the values
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $org = $_POST['org'];
    $title = $_POST['title'];
    $address = $_POST['address'];
    $type = $_POST['type'];
    if(!empty($name) && !empty($phone) && !empty($email) && !empty($org) && !empty($org) && !empty($title) && !empty($address) && !empty($type)){

        // reCAPTCHA validation
        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

            // Google secret API
            $secretAPIkey = '6LcO4MYiAAAAAAzBmHda-xAHtesaxDgUV5l6dxYf';

            // reCAPTCHA response verification
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretAPIkey.'&response='.$_POST['g-recaptcha-response']);

            // Decode JSON data
            $response = json_decode($verifyResponse);
            if($response->success){
                // Database connection
                $conn = new mysqli('localhost','egyptcsrforum_admin','allow2csr@2022','egyptcsrforum_main');
                if($conn->connect_error){
                    echo "$conn->connect_error";
                    die("Connection Failed : ". $conn->connect_error);
                } else {
                    mysqli_set_charset($conn,"utf8");
                    $stmt = $conn->prepare("insert into sponsor(name, phone, email, org, title, address, type) values(?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssss", $name, $phone, $email, $org, $title, $address, $type);
                    $execval = $stmt->execute();
                    $stmt->close();
                    $conn->close();
                    $response = array(
                        "status" => "alert-success",
                        "message" => "Your message has been sent."
                    );
                }
            }
            else {
                $response = array(
                    "status" => "alert-danger",
                    "message" => "Robot verification failed, please try again."
                );
            }       
        } 
        else{ 
            $response = array(
                "status" => "alert-danger",
                "message" => "Plese check on the reCAPTCHA box."
            );
        } 
    }  
    else{ 
        $response = array(
            "status" => "alert-danger",
            "message" => "All the fields are required."
        );
    }
?>