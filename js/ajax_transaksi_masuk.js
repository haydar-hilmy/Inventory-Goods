function hitung_total_harga(getJumlah) {
    let jumlah = parseFloat(getJumlah);
    let harga_masuk = parseFloat(document.getElementById("h_masuk").value);
    let harga_total = jumlah * harga_masuk;
    document.getElementById("t_harga").value = harga_total;
}


$(document).ready(function () {
    $("#show-more-option").hide();
    
    $("#nama_barang").change(function () {
        $("#show-more-option").show(200);
        let id_barang = $("#nama_barang").val(); // mendapatkan id barang
        var show_more_option = $("#show-more-option");
        show_more_option.load("./php/get_content1.php?id="+id_barang, function (responseTxt, statusTxt, xhr) {
            if (statusTxt == "success") {
                show_more_option.html(responseTxt);
            }
        });
    });

});