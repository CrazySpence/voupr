<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
	$mail->Host = 'smtp.mail.me.com';
	$mail->IsSMTP();
        		                $mail->SMTPAuth = true;
        		                	                $mail->Username = 'commodorespence@icloud.com';
        		                	                	                $mail->Password = 'xoav-gxnz-imhw-bvzf';
        		                	                	                	                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        		                	                	                	                	                $mail->Port = 587;

        		                	                	                	                	                    //Recipients
        		                	                	                	                	                        $mail->setFrom('wiki-auto@vo-wiki.com', 'VOUPR Registration');
        		                	                	                	                	                            $mail->addAddress('phil@philtopia.com');     //Add a recipient
        		                	                	                	                	                                
        		                	                	                	                	                                    //Content
        		                	                	                	                	                                        $mail->isHTML(true);                                  //Set email format to HTML
        		                	                	                	                	                                            $mail->Subject = 'Here is the subject';
        		                	                	                	                	                                                $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        		                	                	                	                	                                                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        		                	                	                	                	                                                        $mail->send();
        		                	                	                	                	                                                            echo 'Message has been sent';
        		                	                	                	                	                                                            } catch (Exception $e) {
        		                	                	                	                	                                                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        		                	                	                	                	                                                      }
