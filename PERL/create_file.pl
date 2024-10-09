#!/usr/bin/perl
use strict;
use warnings;

# Open (or create) a file for writing
open my $fh, '>', 'file.txt' or die "Cannot open file: $!";

print "File open/created successfully!\n";

# Close the file
close $fh;
