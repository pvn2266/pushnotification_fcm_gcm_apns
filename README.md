# pushnotification_fcm_gcm_apns

A generic rest api that allows to send push notification to any iOS and Android device. This is PHP based services that can be consumed from any rest client/code to test/use push notification service for mobility apps

Type: POST


# 1.Parameter for iOS notification:
 {
 "ostype":"IOS",
"tokens":["358f72d585e3144571dcfa518b595ac1c79095441b0b0bb3d4fdc659b8ed2ec3"],
"certificatefile":"pushcert.pem",
"isproduction":0,
"passphrase":"ZAQ!2wsxCDE#",
"badge":1,
"message":"Notification message",
"payload":"Extra text",
"sound":"default"
}

# Explanation: 
1. Token -> Array(string) of device tokens
2. Certificatefile -> name of certificate that is placed in same heirarchy(folder) as that of the api/script
3.isproduction -> 0=development(only our mobility team devices) ,1=production (public devices)
4. Passphrase -> SSL authentication password of certificate
5. message -> Actual message to be delivered
6. Payload -> Additional parameter(kept for future enhancement)
7. Sound -> Sound to ring on notification reception






# 2.Parameters for Android notification:
{
"ostype":"ANDROID",
"regids":["APA91bEGiZBwu9Ci1WMug22YDCw7rO2zfrNpksIrWmJgZfczzYS2SW5Cnl5R9vkAIf90t9Gdbwmc9aoN4yOnayKTvVzgXAKdiR6xL_p9IVe-cB0vnJr-dWc7AN-97WnXnmp7qt6vdjwT","APA91bG6cUWmkNyNz4V4e4K1FWKOzNH1TK8LWQ1jYPMC7tM4wzy1hH5UhmynvhhsQjJhT_xosY2mzYZ6XMytaUMTzDpo-KjqR23iSJasEQddENcj9DyjSKO0xPYFJKv96AbiKRDR-njG"],
"apikey":"AIzaSyAlJQxxxxxxxxxx",
"message":"Notification message"
}

# Explanation: 
1. regids -> Array(string) of device registration ids
2. apikey -> GCM/FCM server api key 
 



