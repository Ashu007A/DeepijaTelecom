print "Hello, world!\n";
print "This is Ashish.\n";

# ---------------------------------------------------------------------

# This is case of interpolation.
$str = "Welcome to \ntutorialspoint.com!";
print "$str\n";

# This is case of non-interpolation.
$str = 'Welcome to \ntutorialspoint.com!';
print "$str\n";

# Only W will become upper case.
$str = "\uwelcome to tutorialspoint.com!";
print "$str\n";

# Whole line will become capital.
$str = "\UWelcome to tutorialspoint.com!";
print "$str\n";

# A portion of line will become capital.
$str = "Welcome to \Ututorialspoint\E.com!"; 
print "$str\n";

# Backsalash non alpha-numeric including spaces.
$str = "\QWelcome to tutorialspoint's family";
print "$str\n";

# ---------------------------------------------------------------------

# SCALER
$age = 25;             # An integer assignment
$name = "John Paul";   # A string 
$salary = 1445.50;     # A floating point

print "Age = $age\n";
print "Name = $name\n";
print "Salary = $salary\n";

# ---------------------------------------------------------------------

# ARRAY
@ages = (25, 30, 40);             
@names = ("John Paul", "Lisa", "Kumar");

print "\$ages[0] = $ages[0]\n";
print "\$ages[1] = $ages[1]\n";
print "\$ages[2] = $ages[2]\n";
print "\$names[0] = $names[0]\n";
print "\$names[1] = $names[1]\n";
print "\$names[2] = $names[2]\n";

# Also works with negative index

# ---------------------------------------------------------------------

# HASH VARIABLES
%data = ('John Paul', 45, 'Lisa', 30, 'Kumar', 40);

print "\$data{'John Paul'} = $data{'John Paul'}\n";
print "\$data{'Lisa'} = $data{'Lisa'}\n";
print "\$data{'Kumar'} = $data{'Kumar'}\n";

# ---------------------------------------------------------------------

# VARIABLE CONTEXT
@names = ('John Paul', 'Lisa', 'Kumar');

@copy = @names;
$size = @names;

print "Given names are : @copy\n";
print "Number of names are : $size\n";

# ---------------------------------------------------------------------

# SPECIAL LITERALS
print "File name ". __FILE__ . "\n";
print "Line Number " . __LINE__ ."\n";
print "Package " . __PACKAGE__ ."\n";

# they can not be interpolated
print "__FILE__ __LINE__ __PACKAGE__\n";


# ---------------------------------------------------------------------

#HASHES
%data = ('John Paul', 45, 'Lisa', 30, 'Kumar', 40);

print "\$data{'John Paul'} = $data{'John Paul'}\n";
print "\$data{'Lisa'} = $data{'Lisa'}\n";
print "\$data{'Kumar'} = $data{'Kumar'}\n";

# ---------------------------------------------------------------------

# CURRENT DATE AND TIME
@months = qw( Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec );
@days = qw(Sun Mon Tue Wed Thu Fri Sat Sun);

($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime();
print "$mday $months[$mon] $days[$wday]\n";

$datestring = localtime();
print "Local date and time $datestring\n";

# ---------------------------------------------------------------------

# FILE OPEN FUNCTION
open(DATA, "<Redundants.txt") or die "Couldn't open file file.txt, $!";

while(<DATA>) {
   print "$_";
}

# FILE CLOSE FUNCTION
close FILEHANDLE
close

# ---------------------------------------------------------------------

# EMAIL SENDING
$to = 'aram.work.98@gmail.com';
$from = 'webmaster@yourdomain.com';
$subject = 'Test Email';
$message = 'This is test email sent by Perl Script';
 
open(MAIL, "|/usr/sbin/sendmail -t");
 
# Email Header
print MAIL "To: $to\n";
print MAIL "From: $from\n";
print MAIL "Subject: $subject\n\n";
# Email Body
print MAIL $message;

close(MAIL);
print "Email Sent Successfully\n";

# ---------------------------------------------------------------------

# ---------------------------------------------------------------------

# ---------------------------------------------------------------------

# ---------------------------------------------------------------------

# ---------------------------------------------------------------------

# ---------------------------------------------------------------------

# ---------------------------------------------------------------------

# ---------------------------------------------------------------------
