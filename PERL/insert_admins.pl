#!/usr/bin/perl
use strict;
use warnings;
use DBI;

# Database connection
my $dsn = "DBI:mysql:database=registration;host=localhost;port=3307;mysql_socket=/opt/lampp/var/mysql/mysql.sock";
my $username = "root";
my $password = "";

# Connect to the database
my $dbh = DBI->connect($dsn, $username, $password, { RaiseError => 1, AutoCommit => 1 });

# Query
my $sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
my $sth = $dbh->prepare($sql);

# Data
my @admins = (
    ["DBI3307", "DBI"],
    ["DBD3307", "DBD"]
);

# Execute the statement for each admin
foreach my $admin (@admins) {
    $sth->execute(@$admin);
}

# Disconnect from the database
$dbh->disconnect;

print "Admin records inserted successfully.\n";
