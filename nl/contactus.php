<?php

define("EMAIL", "info@latreve.eu");
//define("EMAIL", "diego.polak@gmail.com");

// Initialise result-Array
$result = array("result" => true);

// validate Name
$name = trim($_REQUEST["name"]);
if ( ! strlen($name) > 0)
{
    $result["errors"][] = array("field" => "name", "error" => "U hebt uw naam niet opgegeven");
    $result["result"] = false;
}

// validate email-adres
$email = trim($_REQUEST["email"]);
if ( ! strlen($email) > 0)
{
    $result["errors"][] = array("field" => "email", "error" => "U hebt uw emailadres niet opgegeven");
    $result["result"] = false;
}
else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email))
{
    $result["errors"][] = array("field" => "email", "error" => "U hebt een ongeldig emailadres opgegeven");
    $result["result"] = false;
}

// get the other fields
$phone = trim($_REQUEST["phone"]);
$message = trim($_REQUEST["message"]);


if($result["result"]) {
    // mail request to LaTrêve
    //mail("diego.polak@soprabanking.com", "mail from site", "<pre>" . print_r($_REQUEST, true) . "</pre>");
    $header = "From: $email\n" . "Reply-To: $email\n";
    $subject = "Aanvraag informatie op La Trêve";
    $email_to = EMAIL;

    $emailMessage = "Naam: " . $name . "\n";
    $emailMessage .= "Email: " . $email . "\n";
    $emailMessage .= "Telefoon: " . $phone . "\n\n";
    $emailMessage .= $message;

    //echo $emailMessage . "\n";
    mail($email_to, $subject ,$emailMessage ,$header );

    // mail confirmation to user_error
    $header = "From: " . EMAIL . "\n" . "Reply-To: " . EMAIL . "\n";
    $subject = "Uw aanvraag voor informatie op La Trêve";
    $email_to = $email;

    $emailMessage = "Beste " . $name . ",\n\n";
    $emailMessage .= "Wij danken u voor uw aanvraag voor informatie via onze website LaTrêve.eu.\n";
    $emailMessage .= "Wij zullen uw vraag met de grootste zorg behandelen en laten u zo snel mogelijk iets weten via " . $email;
    if (strlen($phone) > 0)
    {
        $emailMessage .= " of via " . $phone . ".";
    }
    $emailMessage .= "\n\nMet vriendelijke groeten,\nDiégo en Ella";

    //echo $emailMessage . "\n";
    mail($email_to, $subject ,$emailMessage ,$header );

}

//return the complete result-array
header('Content-type: application/json');
echo json_encode($result);


?>