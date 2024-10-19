#!/usr/bin/perl
use strict;
use warnings;

print "Enter the first number: ";
my $num1 = <STDIN>;
chomp($num1);

print "Choose an operation (+, -, *, /): ";
my $operation = <STDIN>;
chomp($operation);

print "Enter the second number: ";
my $num2 = <STDIN>;
chomp($num2);

my $result;
if ($operation eq '+') {
    $result = $num1 + $num2;
} elsif ($operation eq '-') {
    $result = $num1 - $num2;
} elsif ($operation eq '*') {
    $result = $num1 * $num2;
} elsif ($operation eq '/') {
    if ($num2 != 0) {
        $result = $num1 / $num2;
    } else {
        die "Cannot divide by zero";
    }
} else {
    die "Invalid operation";
}

print "$num1 $operation $num2 = $result\n";
