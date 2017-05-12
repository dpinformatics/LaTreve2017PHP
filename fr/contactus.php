<?php

define("EMAIL", "info@latreve.eu");
//define("EMAIL", "diego.polak@gmail.com");

// Initialise result-Array
$result = array("result" => true);

// validate Name
$name = trim($_REQUEST["name"]);
if ( ! strlen($name) > 0)
{
    $result["errors"][] = array("field" => "name", "error" => "Vous n'avez pas donnez votre nom.");
    $result["result"] = false;
}

// validate email-adres
$email = trim($_REQUEST["email"]);
if ( ! strlen($email) > 0)
{
    $result["errors"][] = array("field" => "email", "error" => "Vous n'avez pas donnez votre addresse email.");
    $result["result"] = false;
}
else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email))
{
    $result["errors"][] = array("field" => "email", "error" => "Vous avez donnez une addresse email fautive.");
    $result["result"] = false;
}

// get the other fields
$phone = trim($_REQUEST["phone"]);
$message = trim($_REQUEST["message"]);


if($result["result"]) {
    // mail request to LaTrêve
    //mail("diego.polak@soprabanking.com", "mail from site", "<pre>" . print_r($_REQUEST, true) . "</pre>");
    $header = "From: $email\n" . "Reply-To: $email\n";
    $subject = "Demande d'information sur La Trêve";
    $email_to = EMAIL;

    $emailMessage = "Nom: " . $name . "\n";
    $emailMessage .= "Email: " . $email . "\n";
    $emailMessage .= "Téléphone: " . $phone . "\n\n";
    $emailMessage .= $message;

    //echo $emailMessage . "\n";
    mail($email_to, $subject ,$emailMessage ,$header );

    // mail confirmation to user_error
    $header = "From: " . EMAIL . "\n" . "Reply-To: " . EMAIL . "\n";
    $subject = "Votre demande d'informatie sur La Trêve";
    $email_to = $email;

    $emailMessage = "Chèr, " . $name . ",\n\n";
    $emailMessage .= "Nous vous remercions pour votre demande d'information sur notre site LaTrêve.eu.\n";
    $emailMessage .= "On traitera votre question avec le plus grand soin et que vous sachiez quelque chose dès que possible par " . $email;
    if (strlen($phone) > 0)
    {
        $emailMessage .= " of par " . $phone . ".";
    }
    $emailMessage .= "\n\nCordialement,\nDiégo en Ella";

    //echo $emailMessage . "\n";
    mail($email_to, $subject ,$emailMessage ,$header );

}

//return the complete result-array
header('Content-type: application/json');
echo json_encode($result);


?>