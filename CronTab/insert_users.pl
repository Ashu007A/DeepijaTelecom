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

# Get the last table number from a file
my $file = '/opt/lampp/htdocs/AKR/CronTab/last_table_number.txt';
my $last_table_number = 0;

if (-e $file) {
    open my $fh, '<', $file or die "Could not open file '$file': $!";
    $last_table_number = <$fh>;
    close $fh;
}
$last_table_number++;

open my $fh, '>', $file or die "Could not open file '$file': $!";
print $fh $last_table_number;
close $fh;

# Create a new table name with incremented number
my $table_name = "user_table" . $last_table_number;

my $create_table_sql = qq{
    CREATE TABLE IF NOT EXISTS $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        age INT,
        city VARCHAR(100)
    )
};
$dbh->do($create_table_sql);

my $faker = Data::Faker->new;

my $sth = $dbh->prepare("INSERT INTO $table_name (name, email, age, city) VALUES (?, ?, ?, ?)");

# Insert
for (1..100) {
    my $name = $faker->name;
    my $email = $faker->email;
    my $age = int(rand(60)) + 18;
    my $city = $faker->city;
    $sth->execute($name, $email, $age, $city);
}

print "100 random users inserted into table $table_name successfully.\n";

$dbh->disconnect;
