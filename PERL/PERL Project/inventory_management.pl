#!/usr/bin/perl
use strict;
use warnings;
use DBI;

my $dsn = "DBI:mysql:database=inventory;host=localhost";
my $username = "root";
my $password = "";

my $dbh = DBI->connect($dsn, $username, $password, { RaiseError => 1, AutoCommit => 1 })
    or die "Could not connect to database: $DBI::errstr";

my $create_table_sql = qq{
    CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL
    );
};
$dbh->do($create_table_sql);

# Add
sub add_product {
    print "Enter product name: ";
    my $name = <STDIN>; chomp($name);
    print "Enter category: ";
    my $category = <STDIN>; chomp($category);
    print "Enter quantity: ";
    my $quantity = <STDIN>; chomp($quantity);
    if ($quantity !~ /^\d+$/) {
        die "Quantity must be a numeric value.\n";
    }
    print "Enter price: ";
    my $price = <STDIN>; chomp($price);
    if ($price !~ /^\d+(\.\d{1,2})?$/) {
        die "Price must be a numeric value.\n";
    }

    my $insert_sql = qq{
        INSERT INTO products (name, category, quantity, price)
        VALUES (?, ?, ?, ?)
    };
    my $sth = $dbh->prepare($insert_sql);
    $sth->execute($name, $category, $quantity, $price);

    print "Product added successfully!\n";
}

# Update
sub update_product {
    print "Enter the product ID to update: ";
    my $id = <STDIN>; chomp($id);

    my $select_sql = qq{SELECT * FROM products WHERE id = ?};
    my $sth = $dbh->prepare($select_sql);
    $sth->execute($id);
    my $product = $sth->fetchrow_hashref;

    if ($product) {
        print "Current name ($product->{name}): ";
        my $name = <STDIN>; chomp($name);
        $name = $name || $product->{name};

        print "Current category ($product->{category}): ";
        my $category = <STDIN>; chomp($category);
        $category = $category || $product->{category};

        print "Current quantity ($product->{quantity}): ";
        my $quantity = <STDIN>; chomp($quantity);
        $quantity = $quantity || $product->{quantity};
        if ($quantity !~ /^\d+$/) {
            die "Quantity must be a numeric value.\n";
        }

        print "Current price ($product->{price}): ";
        my $price = <STDIN>; chomp($price);
        $price = $price || $product->{price};
        if ($price !~ /^\d+(\.\d{1,2})?$/) {
            die "Price must be a numeric value.\n";
        }

        my $update_sql = qq{
            UPDATE products SET name = ?, category = ?, quantity = ?, price = ?
            WHERE id = ?
        };
        my $sth = $dbh->prepare($update_sql);
        $sth->execute($name, $category, $quantity, $price, $id);

        print "Product updated successfully!\n";
    } else {
        print "Product with ID $id does not exist.\n";
    }
}

# Delete
sub delete_product {
    print "Enter the product ID to delete: ";
    my $id = <STDIN>; chomp($id);

    my $delete_sql = qq{DELETE FROM products WHERE id = ?};
    my $sth = $dbh->prepare($delete_sql);
    my $rows_deleted = $sth->execute($id);

    if ($rows_deleted > 0) {
        print "Product deleted successfully!\n";
    } else {
        print "Product with ID $id does not exist.\n";
    }
}

# View
sub view_products {
    my $select_sql = qq{SELECT * FROM products};
    my $sth = $dbh->prepare($select_sql);
    $sth->execute();

    print "ID | Name                     | Category     | Quantity | Price   \n";
    print "----------------------------------------------------------------\n";
    while (my $product = $sth->fetchrow_hashref) {
        printf "%2d | %-24s | %-12s | %-8d | %.2f\n",
            $product->{id}, $product->{name}, $product->{category},
            $product->{quantity}, $product->{price};
    }
}

# Generate report
sub generate_report {
    my $total_products = 0;
    my $total_stock_value = 0;
    my %category_summary;

    my $select_sql = qq{SELECT * FROM products};
    my $sth = $dbh->prepare($select_sql);
    $sth->execute();

    while (my $product = $sth->fetchrow_hashref) {
        $total_products++;
        $total_stock_value += $product->{quantity} * $product->{price};
        $category_summary{$product->{category}}{count}++;
        $category_summary{$product->{category}}{value} += $product->{quantity} * $product->{price};
    }

    open my $fh, '>', 'inventory_report.txt' or die "Cannot open file: $!";
    print $fh "Total number of products: $total_products\n";
    print $fh "Total stock value: $total_stock_value\n";
    print $fh "Category Summary:\n";

    foreach my $category (keys %category_summary) {
        print $fh "$category - $category_summary{$category}{count} products, Total value: $category_summary{$category}{value}\n";
    }

    close $fh;
    print "Report generated successfully!\n";
}

# Menu
while (1) {
    print "\nInventory Management System\n";
    print "1. Add a new product\n";
    print "2. Update a product\n";
    print "3. Delete a product\n";
    print "4. View all products\n";
    print "5. Generate report\n";
    print "6. Exit\n";
    print "Select an option (1-6): ";

    my $choice = <STDIN>; chomp($choice);

    if ($choice == 1) {
        add_product();
    } elsif ($choice == 2) {
        update_product();
    } elsif ($choice == 3) {
        delete_product();
    } elsif ($choice == 4) {
        view_products();
    } elsif ($choice == 5) {
        generate_report();
    } elsif ($choice == 6) {
        last;
    } else {
        print "Invalid option. Please try again.\n";
    }
}

$dbh->disconnect;
