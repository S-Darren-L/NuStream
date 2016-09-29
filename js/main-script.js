function addRow(tableID, suppliers) {

    alert(suppliers.length);
    suppliers.forEach(createTableRow);

    //Create Table Row
    function createTableRow(item, index) {
        alert(suppliers[0]);
        // Get a reference to the table
        var tableRef = document.getElementById(tableID).getElementsByTagName('tbody')[index];
        // Insert a row in the table at row index
        var supplierRow = tableRef.insertRow(index);
        // Insert a cell in the row
        var supplierNameCell  = supplierRow.insertCell(0);
        var pricePerUnitCell  = supplierRow.insertCell(1);
        var contactNameCell  = supplierRow.insertCell(2);
        var contactNumberCell  = supplierRow.insertCell(3);
        var supportLocationCell  = supplierRow.insertCell(4);
        // Append a value to the cell
        var supplierNameValue  = document.createTextNode(item[index][0]);
        var pricePerUnitValue  = document.createTextNode(item[index][1]);
        var contactNameValue  = document.createTextNode(item[index][2]);
        var contactNumberValue  = document.createTextNode(item[index][3]);
        var supportLocationValue  = document.createTextNode(item[index][4]);
        // Add value to cell
        supplierNameCell.appendChild(supplierNameValue);
        pricePerUnitCell.appendChild(pricePerUnitValue);
        contactNameCell.appendChild(contactNameValue);
        contactNumberCell.appendChild(contactNumberValue);
        supportLocationCell.appendChild(supportLocationValue);
    }


}