use MIME::Lite;
 
$to = 'aram.work.98@gmail.com';
$cc = 'ashishrambsp007@gmail.com';
$from = 'ashishrambsp0077@gmail.com';
$subject = 'Test Email';
$message = 'This is test email sent by Perl Script';

$msg = MIME::Lite->new(
                 From     => $from,
                 To       => $to,
                 Cc       => $cc,
                 Subject  => $subject,
                 Data     => $message
                 );
                 
$msg->send;
print "Email Sent Successfully\n";