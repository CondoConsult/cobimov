function exportToPDF() {
    const element = document.getElementById('export-content');
    html2pdf()
        .from(element)
        .set({
            margin: 10,
            filename: 'cobimov_rep.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { orientation: 'portrait' }
        })
        .save();
}