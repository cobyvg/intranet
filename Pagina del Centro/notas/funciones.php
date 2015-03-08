
<? 

function CheckMail($Email,$Debug=false) 
{ 
    global $HTTP_HOST; 
    $Return =array();  

    if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $Email)) { 
        $Return[0]=false; 
        $Return[1]="${Email} is E-Mail form that is not right."; 
        if ($Debug) echo "Error : {$Email} is E-Mail form that is not right.<br>";         
        return $Return; 
    } 
    else if ($Debug) echo "Confirmation : {$Email} is E-Mail form that is not right.<br>"; 

    list ( $Username, $Domain ) = split ("@",$Email); 
    if ( checkdnsrr ( $Domain, "MX" ) )  { 
        if($Debug) echo "Confirmation : MX record about {$Domain} exists.<br>"; 

        if ( getmxrr ($Domain, $MXHost))  { 
      if($Debug) { 
                echo "Confirmation : Is confirming address by MX LOOKUP.<br>"; 
              for ( $i = 0,$j = 1; $i < count ( $MXHost ); $i++,$j++ ) { 
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Result($j) - $MXHost[$i]<BR>";  
        } 
            } 
        } 

        $ConnectAddress = $MXHost[0]; 
    } 
    else { 
        $ConnectAddress = $Domain;         
        if ($Debug) echo "Confirmation : MX record about {$Domain} does not exist.<br>"; 
    } 

    $Connect = fsockopen ( $ConnectAddress, 25 ); 
    if ($Connect)   
    { 
        if ($Debug) echo "Connection succeeded to {$ConnectAddress} SMTP.<br>"; 
        if ( ereg ( "^220", $Out = fgets ( $Connect, 1024 ) ) ) { 
             
            fputs ( $Connect, "HELO $HTTP_HOST\r\n" ); 
                if ($Debug) echo "Run : HELO $HTTP_HOST<br>"; 
            $Out = fgets ( $Connect, 1024 ); // Receive server's answering cord. 

            fputs ( $Connect, "MAIL FROM: <{$Email}>\r\n" ); 
                if ($Debug) echo "Run : MAIL FROM: &lt;{$Email}&gt;<br>"; 
            $From = fgets ( $Connect, 1024 ); // Receive server's answering cord. 

            fputs ( $Connect, "RCPT TO: <{$Email}>\r\n" ); 
                if ($Debug) echo "Run : RCPT TO: &lt;{$Email}&gt;<br>"; 
            $To = fgets ( $Connect, 1024 ); // Receive server's answering cord. 

            fputs ( $Connect, "QUIT\r\n"); 
                if ($Debug) echo "Run : QUIT<br>"; 

            fclose($Connect); 

                if ( !ereg ( "^250", $From ) || !ereg ( "^250", $To )) { 
                    $Return[0]=false; 
                    $Return[1]="${Email} is address done not admit in E-Mail server."; 
                    if ($Debug) echo "{$Email} is address done not admit in E-Mail server.<br>"; 
                    return $Return; 
                } 
        } 
    } 
    else { 
        $Return[0]=false; 
        $Return[1]="Can not connect E-Mail server ({$ConnectAddress})."; 
        if ($Debug) echo "Can not connect E-Mail server ({$ConnectAddress}).<br>"; 
        return $Return; 
    } 
    $Return[0]=true; 
    $Return[1]="{$Email} is E-Mail address that there is no any problem."; 
    return $Return; 
}
CheckMail($correo,$Debug); 
?> 
	

