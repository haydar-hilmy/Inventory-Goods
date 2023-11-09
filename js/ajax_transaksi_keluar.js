function hitung_total_harga(getJumlah) {
    let jumlah = parseFloat(getJumlah);
    let harga_masuk = parseFloat(document.getElementById("h_keluar").value);
    let harga_total = jumlah * harga_masuk;
    document.getElementById("t_harga").value = harga_total;
}


$(document).ready(function () {
    $("#show-more-option").hide();

    $("#pelanggan").change(function() {
        $("#nama_barang").prop("disabled", false);
      });
    
    $("#nama_barang").change(function () {
        $("#show-more-option").show(200);
        let id_barang = $("#nama_barang").val(); // mendapatkan id barang
        let id_pelanggan = $("#pelanggan").val(); // mendapatkan id pelanggan
        var show_more_option = $("#show-more-option");
        show_more_option.load("./php/get_content2.php?id="+id_barang+"&id_pelanggan="+id_pelanggan, function (responseTxt, statusTxt, xhr) {
            if (statusTxt == "success") {
                show_more_option.html(responseTxt);
            }
        });
    });

});