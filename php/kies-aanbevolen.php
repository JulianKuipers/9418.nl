<?php
if(!isset($_POST['submit']))
{
    echo "Error; vul het formulier in!";
}

//Gegevensset

$voornaam = $_POST['firstname'];
$achternaam = $_POST['lastname'];
$bedrijfsnaam = $_POST['company'];
$visitor_email = $_POST['email'];
$telefoonnummer = $_POST['phone'];
$voorkeur = $_POST['list1'];
$product = $_POST['prod'];
$huisstijl = $_POST['cstyle'];
$info = $_POST['minfo'];

if(empty($voornaam)||empty($visitor_email)) 
{
    echo " Het invullen van je naam en email is nodig om contact met ons op te nemen!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Dit emailadres bestaat niet!";
    exit;
}

//Mail naar ons

$email_from = 'no-reply@9418.nl';
$email_subject = "Interesse in het product: $product";
$email_body =   "Hallo, \n \n$voornaam $achternaam heeft interesse in het product '$product'.\n \n$voornaam beschrijft de huisstijl als volgt:\n\n'$huisstijl' \n \nDaarnaast heeft $voornaam de volgende informatie gegeven: \n\n'$info' \n \n".
                "Contactgegevens:\nNaam: $voornaam $achternaam\nBedrijf: $bedrijfsnaam\nE-mail: $visitor_email\nTelefoon: $telefoonnummer\nWil graag benaderd worden via: $voorkeur \n \n---------------------\n ".

$to = "info@9418.nl";
$headers = "From: $email_from \r\n";
$headers .= "Reply-to: $visitor_email \r\n";

mail($to,$email_subject,$email_body,$headers);

//Ontvangstbevestiging

$email_from = 'no-reply@9418.nl';
$email_subject = "Ontvangstbevestiging van 9418.nl";
$email_body =   "Beste $voornaam $achternaam,\n \nHartelijk bedankt voor je aanvraag. Bij deze sturen wij je een ontvangstbevestiging van je aanvraag.\n \n".
                "Hieronder staat een overzicht van de aanvraag:\n \nAanvrager: $voornaam $achternaam\nBedrijf: $bedrijfsnaam \nE-mail: $visitor_email \nTelefoonnummer: $telefoonnummer \nContactvoorkeur: $voorkeur \nProduct: $product \n\nBeschrijving huisstijl:\n '$huisstijl' \n\nExtra info:\n '$info'\n\n\n".
                "Met vriendelijke groeten,\nMartijn & Julian van 9418.nl\n \n".
                "Dit is een automatisch gegenereerd bericht, hier kunnen geen rechten aan worden ontleend. Wij streven ernaar om binnen 24 uur in contact met je te komen.\n\nWe hebben jouw bericht ontvangen van dit e-mailadres: ".

$to = "$visitor_email";
$headers = "From: $email_from \r\n";
$headers .= "Reply-to: info@9418.nl \r\n";

mail($to,$email_subject,$email_body,$headers);

header('Location: bedankt2.html');



function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

?>
