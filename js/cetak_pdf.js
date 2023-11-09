function generatePDF() {
    const element = document.getElementById('good-table');

    // Membuat objek konfigurasi untuk mengatur ukuran kertas dan margin
    const pdfOptions = {
        margin: 10, // Atur margin halaman (opsional)
        filename: 'laporan.pdf', // Nama file PDF (opsional)
        image: { type: 'jpeg', quality: 0.98 }, // Opsi gambar (opsional)
        html2canvas: { scale: 2 }, // Opsi html2canvas (opsional)
        jsPDF: { 
            unit: 'mm', // Satuan pengukuran (mm, cm, in, pt, atau px)
            format: 'a4', // Ukuran kertas (a0, a1, a2, a3, a4, a5, letter, legal, ledger, tabloid)
            orientation: 'landscape' // Orientasi kertas (portrait atau landscape)
        }
    };

    html2pdf().from(element).set(pdfOptions).save();

    setTimeout(() => {
        window.location.href = 'lap_persediaan.php';
    }, 1500);
}

window.addEventListener('load', generatePDF);
