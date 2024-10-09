#!/usr/bin/perl
use strict;
use warnings;

# Open a file for reading
open my $fh, '<', 'file.txt' or die "Cannot open file: $!";

# Open a file for writing
open my $fh, '>', 'file.txt' or die "Cannot open file: $!";

# Open a file for appending
open my $fh, '>>', 'file.txt' or die "Cannot open file: $!";
