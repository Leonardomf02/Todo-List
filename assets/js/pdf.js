function generatePDF() {
    const table = document.querySelector('table');
    const rows = table.querySelectorAll('tr');

    const data = [];
    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].children;
        const rowData = [];
        for (let j = 0; j < cells.length; j++) {
            // Exclude the third column (index 2) and the last column
            if (j !== 2 && j !== cells.length - 1) {
                rowData.push(cells[j].textContent.trim());
            }
        }
        data.push(rowData);
    }

    const columnWidths = ['15%', '40%', '20%', '25%'];  

    const docDefinition = {
        content: [{
            table: {
                headerRows: 1,
                widths: columnWidths,
                body: data,
            },
        }],
        styles: {
            header: {
                fillColor: '#CCCCCC',
                color: 'black',
                fontSize: 16,
                bold: true,
                margin: [0, 0, 0, 10]
            },
            body: {
                fontSize: 14,
                margin: [0, 5, 0, 5]
            }
        },
        defaultStyle: {
            fontSize: 12,
        }
    };

    data[0].forEach((value, index) => {
        docDefinition.content[0].table.body[0][index] = { text: value, style: 'header' };
    });

    pdfMake.createPdf(docDefinition).download('tasks.pdf');
}
