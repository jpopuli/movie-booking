<?php

    use PHPMailer\PHPMailer\PHPMailer;

    session_start();

    require_once "phpmailer/Exception.php";
    require_once "phpmailer/PHPMailer.php";
    require_once "phpmailer/SMTP.php";

    require "./model.php";

    $modelObj = new Model();

    // for CONTACT
    if (isset($_POST["contact_send"])) {
        $customer_email = $_POST["customerEmail"];
        $customer_name = $_POST["customerName"];
        $customer_msg = $_POST["customerMsg"];
        $msg_subj = "Reply to concern";
        $msg_body = "Hi <b>" .$customer_name. "</b><p>Thanks for messaging us. We've received your concern.</p>";

        if (sendEmail($customer_email, $msg_subj, $msg_body)) {
            $_SESSION["modal_title"] = "WE'VE RECEIVED YOUR MESSAGE";
            $_SESSION["admin_reply"] = "Hi <b>$customer_name</b>! Thanks for your message. We appreciate you reaching out.";
            header("location:index.php");
        } else {
            echo "error";
        }
        
    }

    // for TRANSACTION / BOOKING
    if (isset($_SESSION["customer_id"])) {
        $customer_email = $_SESSION["customer_email"];
        // $customer_name = $_SESSION["customer_name"];
        $msg_subj = "Reply to transaction";

        // retrieve transac record to display
        $orders = $modelObj->displayTransaction($_SESSION["customer_id"]);
        // print_r($orders);

        foreach ($orders as $order) {
            // meesage in email
            $msg_body = "<p>Hi! <b>{$order["customer_fname"]} {$order["customer_lname"]}</b></p>
                        <p>Here is the summary of your transaction in <b>SineMax.</b></p>
                        <p><b>Transaction Date:</b> {$order["transaction_date"]}</p>
                        <p><b>Movie Title:</b> {$order["mvTitle"]}</p>
                        <p><b>Show Schedule:</b> {$order["mvStart"]} to {$order["mvEnd"]}</p>
                        <p><b>Ticket Quantity:</b> {$order["no_of_tickets"]}</p>
                        <p><b>Ticket Price:</b> <span>&#8369;</span> {$order["ticketPrice"]}</p>
                        <br>
                        <p><b>Total Cost:</b> <span>&#8369;</span> {$order["total_cost"]}</p>";
        }

        if (sendEmail($customer_email, $msg_subj, $msg_body)) {
            $_SESSION["modal_title"] = "WE'VE RECEIVED YOUR ORDER";
            $_SESSION["admin_reply"] = "Hi <b>{$order["customer_fname"]} {$order["customer_lname"]}</b>! Thanks for booking a ticket in <b>SineMax</b>! You'll find a summary of your transaction in your email.";
            echo "<script>window.location.href='index.php';</script>";
            exit;
        } else {
            echo "error";
        }
    }

    // CALL TO SEND EMAIL
    function sendEmail($customer_email, $msg_subject, $msg_body) {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "codingtesting26@gmail.com";
            $mail->Password = "CodingTest_26";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = "587";

            // send to recepient
            $mail->setFrom($customer_email);
            $mail->addAddress($customer_email);

            // $mail->addReplyTo($customerEmail, "We receive your concern");

            $mail->isHTML(true);
            $mail->Subject = $msg_subject;
            $mail->Body = $msg_body;

            return $mail->send();
        } catch (Exception $e) {

        }
    }
    
?>