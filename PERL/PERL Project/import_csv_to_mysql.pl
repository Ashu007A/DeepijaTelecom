#!/usr/bin/perl
use strict;
use warnings;
use DBI;
use POSIX qw(strftime);

my $dsn = "DBI:mysql:database=office_csv;host=localhost";
my $username = "root";
my $password = "";

my $dbh = DBI->connect($dsn, $username, $password, { RaiseError => 1, AutoCommit => 1 })
    or die "Could not connect to database: $DBI::errstr";

# Current date
my $date = strftime "%Y%m%d", localtime;

foreach my $file ('employees1.csv', 'employees2.csv', 'employees3.csv', 'employees4.csv', 'employees5.csv') {

    # Create table name
    my ($table_name) = $file =~ /^(.+)\.csv$/;
    $table_name .= "_$date";

    open my $fh, '<', $file or die "Could not open '$file' $!\n";
    
    # Read the header line to get column names
    my $header_line = <$fh>;
    chomp $header_line;
    my @header = split /,/, $header_line;

    # Create table
    my $create_table_sql = "CREATE TABLE IF NOT EXISTS $table_name (";
    foreach my $column (@header) {
        $create_table_sql .= "$column VARCHAR(255), ";
    }
    $create_table_sql =~ s/, $//;
    $create_table_sql .= ")";
    $dbh->do($create_table_sql);

    my $insert_sql = "INSERT INTO $table_name (" . join(", ", @header) . ") VALUES (" . join(", ", map { "?" } @header) . ")";
    my $sth = $dbh->prepare($insert_sql);

    while (my $line = <$fh>) {
        chomp $line;
        my @fields = split /,/, $line;
        $sth->execute(@fields);
    }

    close $fh;
    print "Data from '$file' has been imported into table '$table_name'.\n";
}

$dbh->disconnect;