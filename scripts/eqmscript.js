// JavaScript for sorting the table
const table = document.querySelector(".equipment-table");
const headers = table.querySelectorAll("th");

headers.forEach(header => {
    header.addEventListener("click", () => {
        const columnId = header.id;
        sortTable(columnId);
    });
});

function sortTable(columnId) {
    // Implement sorting logic based on the columnId
    // Update the table rows accordingly
    // Example: Sort rows based on the selected column
    const rows = Array.from(table.querySelectorAll("tbody tr"));
    rows.sort((a, b) => {
        // Implement your sorting comparison logic here
        const valueA = a.querySelector(`td:nth-child(${Array.from(headers).indexOf(header) + 1}`).textContent;
        const valueB = b.querySelector(`td:nth-child(${Array.from(headers).indexOf(header) + 1}`).textContent;

        if (valueA > valueB) return 1;
        if (valueA < valueB) return -1;
        return 0;
    });

    // Update the table with sorted rows
    const tbody = table.querySelector("tbody");
    tbody.innerHTML = "";
    rows.forEach(row => tbody.appendChild(row));
}