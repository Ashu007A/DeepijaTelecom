#!/usr/bin/perl
use strict;
use warnings;

# Open a file for writing
open my $fh, '>', 'file.txt' or die "Cannot open file: $!";

# Write to the file
print $fh "Hello, world!\n";

# Close the file
close $fh;
