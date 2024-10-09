#!/usr/bin/perl
use strict;
use warnings;

# Delete a file
unlink 'file.txt' or die "Cannot delete file: $!";
