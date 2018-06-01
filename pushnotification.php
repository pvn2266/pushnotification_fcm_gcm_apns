<?php


 //extract($_POST);
 //echo(json_encode($_POST));
 	
 	$json = file_get_contents('php://input');
	$obj = json_decode($json);
	// Get data
 
	$message = $obj->{'message'};
	
  	$ostype=$obj->{'ostype'};
    
  
  if($ostype!=null)
  {
				if($ostype == 'IOS')
				 {
				  if($obj->{'tokens'}  && $obj->{'certificatefile'} && $obj->{'passphrase'}  && $obj->{'badge'}  && $obj->{'message'} && $obj->{'payload'} )
					 
					  {
					  
					  
					  
						    $deviceTokens = $obj->{'tokens'};
							$Port = 2195;
							$Certificate = $obj->{'certificatefile'};
							$Passphrase= $obj->{'passphrase'} ;
							$Host = null;

							if($obj->{'isproduction'}== 1)
							{
								$Host = 'gateway.push.apple.com';
							}
							else
							{
								$Host = 'gateway.sandbox.push.apple.com';
							}
						    
							$Alert = $obj->{'message'};
							$Badge = $obj->{'badge'};
							$ContentAvailable = 1;
							$Sound = 'default';
							$Payload =$obj->{'payload'} ;
							$tokenResponse;
							 $Body['aps'] = array (

								'alert' => $Alert,

								'badge' => $Badge,

								'sound' => $Sound,

							);
 						    $Body ['payload'] = $Payload;
   							$Body = json_encode ($Body);
							
							
							
						// 	$apns_settings = array(
//        						 "host" => 'gateway.sandbox.push.apple.com',
//      						   "port" => 2195,
//       						  "certificate" => 'ipad.pem',
//      						   "passphrase" => '',
// 							);
								
						// 	$context_options = array(
//      				  	  	 'ssl' => array(
//             			    'local_cert' => $apns_settings["certificate"],
//               				  'passphrase' => $apns_settings["passphrase"],
//              			   'peer_name' => $apns_settings["host"],
//              			   'SNI_server_name' => $apns_settings["host"],
//        				 ),
// 						);
// 						
// 						$stream_context = stream_context_create($context_options);
							
							//OR use below stream_context format
							
							
							$Context = stream_context_create ();
   							stream_context_set_option ($Context, 'ssl','local_cert',$Certificate);
							stream_context_set_option ($Context, 'ssl', 'passphrase', $Passphrase);
							$Socket = stream_socket_client ('ssl://'.$Host.':'.$Port, $error, $errstr, 30, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $Context);
							if (!$Socket)
							{
							$tokenResponse[]=array("Message"=> "APNS message failed","Token"=>$token,"status"=>PHP_EOL);
							$output=array("Response"=> $tokenResponse,"Responsecode"=>200);
							print json_encode($output);
							// exit ("APNS Connection Failed: $error $errstr" . PHP_EOL);
							}
							
							$Msg='';
							foreach($deviceTokens as $token)
							{
							$Msg.= chr (0) . chr (0) . chr (32) . pack ('H*', $token) . pack ('n', strlen ($Body)) . $Body;
							}
							echo(json_encode($Msg));
							$Result = fwrite ($Socket, $Msg, strlen ($Msg));
							if ($Result)
							{
							//$output=array("Message"=> "APNS message successfully delivered","Responsecode"=>200,"status"=>PHP_EOL);
							$tokenResponse[]=array("Message"=> "APNS message successfully delivered","status"=>PHP_EOL);
							//print json_encode($output);
							}
							else
							{
							$tokenResponse[]=array("Message"=> "APNS message failed","status"=>PHP_EOL);
							//$output=array("Message"=> "APNS message failed","Responsecode"=>200,"status"=>PHP_EOL);
							//print json_encode($output);
							}
							fclose ($Socket);
							
							$output=array("Response"=> $tokenResponse,"Responsecode"=>200);
							print json_encode($output);
					  }
					  else
					  {
							$output=array("Message"=> "Check post parameters for APNS","Responsecode"=>400);
							print json_encode($output);
					  }
				 }
				 else if ($ostype == 'ANDROID')
				 {
				      //   $url = 'https://android.googleapis.com/gcm/send'; GCM URL
					    $url = 'https://fcm.googleapis.com/fcm/send';
						
						 	$regids=$obj->{'regids'};
						 	$apikey = $obj->{'apikey'};
						 
						 if($regids && $apikey && $message)
						 {
							//    $jsonText = $_POST['regids'];
// 							//  echo($jsonText);
// 							  $decodedText = html_entity_decode($jsonText);
// 							  $RegistrationIds = json_decode($decodedText, true);
							  $Message = array('alert' => $message);
							  
							  $post = array(
							'registration_ids'=> $regids,
							'data'=> $Message
							);

						$headers = array(
						'Authorization: key='.$apikey,
						'Content-Type: application/json'
						);
					// Open connection
					$ch = curl_init();


					// Set the url, number of POST vars, POST data
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                                   //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    					curl_setopt($ch, CURLOPT_HEADER, false); 
    					curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
   					//curl_setopt($ch, CURLOPT_PROXYUSERPWD, "your company proxy password");
   					// curl_setopt($ch, CURLOPT_PROXY, "proxy");
   					// curl_setopt($ch, CURLOPT_PROXYPORT, 8080);
   					 //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 //   curl_setopt($url, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);


		
					

						// Disabling SSL Certificate support temporarly
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

						// Execute post
						$result = curl_exec($ch);
						if ($result === FALSE) {
						die('Curl failed: ' . curl_error($ch));
						}

					// Close connection
					curl_close($ch);
					echo $result;
					//print json_encode($result);
						 }
				 }
  }
  else
  {
	  $output=array("Message"=> "OS Type not specified","Responsecode"=>400);
	  print json_encode($output);
  }

?>