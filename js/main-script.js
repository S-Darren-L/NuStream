function adminInfoCentreTableAddRow(tableID, suppliers) {
    suppliers.forEach(createTableRow);

    //Create Table Row
    function createTableRow(item, index) {
        // Get a reference to the table
        var tableRef = document.getElementById(tableID).getElementsByTagName('tbody')[0];
        // Insert a row in the table at row index
        var supplierRow = tableRef.insertRow(index);
        // Insert a cell in the row
        var supplierNameCell  = supplierRow.insertCell(0);
        var pricePerUnitCell  = supplierRow.insertCell(1);
        var contactNameCell  = supplierRow.insertCell(2);
        var contactNumberCell  = supplierRow.insertCell(3);
        var supportLocationCell  = supplierRow.insertCell(4);
        // var supplierIDHiddenCell  = supplierRow.insertCell(5);
        // Append a value to the cell
        // var supplierIDValue  = document.createTextNode(item[0]);
        var supplierNameValue = document.createTextNode(item[1]);
        var pricePerUnitValue  = document.createTextNode(item[2]);
        var contactNameValue  = document.createTextNode(item[3]);
        var contactNumberValue  = document.createTextNode(item[4]);
        var supportLocationValue  = document.createTextNode(item[5]);
        // Add value to cell
        // supplierIDHiddenCell.appendChild(supplierIDValue);
        // supplierIDHiddenCell.innerHTML = supplierIDValue;
        supplierNameCell.appendChild(supplierNameValue);
        pricePerUnitCell.appendChild(pricePerUnitValue);
        contactNameCell.appendChild(contactNameValue);
        contactNumberCell.appendChild(contactNumberValue);
        supportLocationCell.appendChild(supportLocationValue);
    }
}

function adminInfoCentreTableRowClick(){
    var table = document.getElementsByTagName("table")[0];
    var tbody = table.getElementsByTagName("tbody")[0];
    tbody.onclick = function (e) {
        e = e || window.event;
        var target = e.srcElement || e.target;
        while (target && target.nodeName !== "TR") {
            target = target.parentNode;
        }
        if (target) {
            var rowIndex = target.rowIndex - 1;
        }
        // alert(rowIndex);
        return rowIndex;
    };
}