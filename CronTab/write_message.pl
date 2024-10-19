#!/usr/bin/perl
use strict;
use warnings;

$ENV{PATH} = "/usr/bin:/bin";
$ENV{HOME} = "/home/dtel";

my $file = '/opt/lampp/htdocs/AKR/CronTab/message.txt';
open(my $fh, '>>', $file) or die "Could not open file '$file': $!";
print $fh "This is a cron message written at " . localtime() . "\n";
close $fh;
