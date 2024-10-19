function createTable() {
    // Get number of rows and columns from the user
    const rows = prompt('Input number of rows');
    const cols = prompt('Input number of columns');
    
    // Get the table element
    const table = document.getElementById('myTable');
    
    // Clear the table
    table.innerHTML = '';

    // Create the table
    for (let i = 0; i < rows; i++) {
        const row = document.createElement('tr');
        for (let j = 0; j < cols; j++) {
            const cell = document.createElement('td');
            cell.textContent = `Row-${i} Column-${j}`;
            row.appendChild(cell);
        }
        table.appendChild(row);
    }
}