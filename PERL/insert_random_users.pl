#!/usr/bin/perl
use strict;
use warnings;
use DBI;
use List::Util qw(shuffle);
use Data::Faker;

$ENV{PATH} = "/usr/bin:/bin";
$ENV{HOME} = "/home/dtel";

my $dsn = "DBI:mysql:database=perl;host=localhost";
my $username = "root";
my $password = "";

my $dbh = DBI->connect($dsn, $username, $password, { RaiseError => 1, AutoCommit => 1 })
    or die "Could not connect to database: $DBI::errstr";

my $create_table_sql = qq{
    CREATE TABLE IF NOT EXISTS user_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        age INT,
        city VARCHAR(100)
    )
};
$dbh->do($create_table_sql);

# Faker
my $faker = Data::Faker->new;

my $sth = $dbh->prepare("INSERT INTO user_table (name, email, age, city) VALUES (?, ?, ?, ?)");

for (1..100) {
    my $name = $faker->name;
    my $email = $faker->email;
    my $age = int(rand(60)) + 18;
    my $city = $faker->city;
    $sth->execute($name, $email, $age, $city);
}

print "100 random users inserted successfully.\n";

$dbh->disconnect;
