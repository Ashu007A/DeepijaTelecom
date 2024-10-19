#!/usr/bin/perl
use strict;
use warnings;

# Check if the filename is provided
if (@ARGV != 1) {
    die "Usage: $0 <filename>\n";
}

my $filename = $ARGV[0];

open my $fh, '<', $filename or die "Cannot open file '$filename': $!";

my $char_count = 0;
my $word_count = 0;
my $line_count = 0;

while (my $line = <$fh>) {
    $char_count += length($line);
    my @words = split(/\s+/, $line);
    $word_count += scalar @words;
    $line_count++;
}

close $fh;

print "Number of characters: $char_count\n";
print "Number of words: $word_count\n";
print "Number of lines: $line_count\n";
