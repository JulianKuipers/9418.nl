<?php
if(!isset($_POST['submit']))
{
	echo "Error; vul het formulier in!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

if(empty($name)||empty($visitor_email)) 
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
$email_subject = "Nieuw bericht via formulier";
$email_body = "Hallo, \n \n$name heeft contact met ons opgenomen via het formulier 'Contact' op de website.\n \n$name heeft het volgende bericht achter gelaten:\n \n'$message'\n \n".
    "Antwoord op: $visitor_email \n \n--------------------------------\n".
    
$to = "info@9418.nl";
$headers = "From: $email_from \r\n";
$headers .= "Reply-to: $visitor_email \r\n";

mail($to,$email_subject,$email_body,$headers);

//Ontvangstbevestiging
$email_from = 'no-reply@9418.nl';
$email_subject = "Ontvangstbevestiging";
$email_body = "Beste $name,\n\nJe hebt contact met ons opgenomen via het contactformulier op onze website.\nDeze hebben wij in goede orde ontvangen en streven ernaar om binnen 24 uur antwoord te geven op het volgende bericht:\n\n'$message'\n\nDit is een automatisch gegenereerd bericht, hier kunnen geen rechten aan worden ontleend.\n\nWe hebben jouw bericht ontvangen van dit e-mailadres: ". 
    
$to = "$visitor_email";
$headers = "From: $email_from \r\n";

mail($to,$email_subject,$email_body,$headers);

header('Location: bedankt.html');



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