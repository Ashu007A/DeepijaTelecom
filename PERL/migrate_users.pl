#!/usr/bin/perl
use strict;
use warnings;
use DBI;

my $dsn = "DBI:mysql:database=perl;host=localhost";
my $username = "root";
my $password = "";

my $dbh = DBI->connect($dsn, $username, $password, { RaiseError => 1, AutoCommit => 1 })
    or die "Could not connect to database: $DBI::errstr";

# If not created
my $create_table_sql = qq{
    CREATE TABLE IF NOT EXISTS user_details1 (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        age INT,
        city VARCHAR(100)
    )
};
$dbh->do($create_table_sql);

# Insert
my $insert_sql = qq{
    INSERT INTO user_details1 (name, email, age, city)
    SELECT name, email, age, city FROM user_table
};
$dbh->do($insert_sql);

print "Table 'user_details' created and data inserted successfully.\n";

$dbh->disconnect;
