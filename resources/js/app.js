import axios from 'axios';
window.$ = window.jQuery = require('jquery');
window.axios = axios;
$(function () {
    // get location
    var location = $('#location');
    $.ajax({
        url: '/getLocation',
        type: 'GET',
        success: function (res) {
            location.text(res.location.name);
            var id = res.location.id
            var date = new Date();
            var today = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
            getJadwal(id, today)
        }
    })
    // set location
    var modalLokasi = $('#modalLokasi')
    var inputLokasi = $('#inputLokasi');
    var div = $('#radioContainer');
    var btnSetLocation = $('#btnSetLocation');
    var btnSearch = $('#btnSearchLocation');
    var loading = `<div class="spinner-grow spinner-grow-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>`
    var loadingLocation = $('#loadingLocation');
    modalLokasi.on('shown.bs.modal', function () {
        btnSearch.on('click', function () {
            loadingLocation.html(loading);
            var kota = inputLokasi.val();
            var uri = `https://api.myquran.com/v2/sholat/kota/cari/${kota}`
            if (kota == '') {
                div.empty();
                return
            }
            div.empty();
            $.ajax({
                url: uri,
                type: 'GET',
                success: (res) => {
                    setTimeout(() => {
                        loadingLocation.empty();
                        var locations = res.data;
                        locations.forEach(item => {
                            div.append(`<div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="locationSelected" value="${item.id}" id="${item.id}">
                                    <label class="form-check-label" for="${item.id}">
                                        ${item.lokasi}
                                    </label>
                                    </div>`)
                        })
                    }, 1000);
                }
            })
        })
        btnSetLocation.on('click', function () {
            btnSetLocation.attr('disabled', true);
            btnSetLocation.html(loading + ' Loading...');
            var selected = $('.form-check-input:checked').val();
            if (selected == undefined) {
                alert('Pilih kota terlebih dahulu');
                return
            }
            var uri = `https://api.myquran.com/v2/sholat/kota/${selected}`
            $.ajax({
                url: uri,
                type: 'GET',
                success: function (res) {
                    if (res.status == true) {
                        $.ajax({
                            url: '/setLocation',
                            type: 'GET',
                            data: {
                                location: res.data
                            },
                            success: function (res) {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        })
                    }
                }
            })
        })
    })
    modalLokasi.on('hidden.bs.modal', function () {
        inputLokasi.val('');
        div.empty();
        loadingLocation.empty();
    })
    // get jadwal sholat from api
    function getJadwal(id, date) {
        var uri = `https://api.myquran.com/v2/sholat/jadwal/${id}/${date}/`
        var dzuhur = $('#dzuhur');
        var ashar = $('#ashar');
        var maghrib = $('#maghrib');
        var isyak = $('#isyak');
        var subuh = $('#subuh');
        var terbit = $('#terbit');
        var dhuha = $('#dhuha');
        $.ajax({
            url: uri,
            type: 'GET',
            success: function (res) {
                const jadwal = res.data.jadwal
                dzuhur.text(jadwal.dzuhur + ' WIB');
                ashar.text(jadwal.ashar + ' WIB');
                maghrib.text(jadwal.maghrib + ' WIB');
                isyak.text(jadwal.isya + ' WIB');
                subuh.text(jadwal.subuh + ' WIB');
                terbit.text(jadwal.terbit + ' WIB');
                dhuha.text(jadwal.dhuha + ' WIB');
            }
        })
    }
    // set waktu wib automatically
    function updateTime() {
        const element = document.querySelector('.wib');
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        element.textContent = `${hours}:${minutes}:${seconds} WIB`;
    }
    setInterval(updateTime, 1000);
    updateTime();
})

// alarm
$(function () {
    var table = $('#tableAlarm');
    $.ajax({
        url: '/getAlarm',
        type: 'GET',
        success: function (res) {
            res.alarms.forEach(item => {
                table.append(`<tr>
                    <td>${item.lable}</td>
                    <td>${item.time}</td>
                    <td>${item.repeat}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" id="btnDeleteAlarm" data-id="${item.id}">Hapus</button>
                    </td>
                </tr>`)
            })
        }
    })
    table.on('click', '.btn-danger', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/deleteAlarm',
            type: 'GET',
            data: { id: id },
            success: function (res) {
                // Menghapus baris tabel setelah berhasil dihapus
                $(this).closest('tr').remove();
            }.bind(this) // bind untuk memastikan `this` mengacu pada tombol yang diklik
        });
    });

    // run alarm
    var audio = new Audio("/alarm.mp3");
    // audio.play();
    setInterval(() => {
        $.ajax({
            url: '/getAlarm',
            type: 'GET',
            success: function (res) {
                console.log(res);
                res.alarms.forEach(item => {
                    var time = item.time.split(':');
                    var alarm = new Date();
                    alarm.setHours(time[0]);
                    alarm.setMinutes(time[1]);
                    alarm.setSeconds(0);
                    var now = new Date();
                    if (alarm.getTime() == now.getTime()) {
                        audio.play();
                        audio.loop = true;
                        setTimeout(() => {
                            const comfirm = confirm(`Alarm ${item.lable} telah berbunyi, klik OK untuk mematikan alarm`);
                            if (comfirm) {
                                audio.pause();
                                audio.currentTime = 0;
                            }
                        }, 1000);
                    }
                })
            }
        })
    }, 1000);

});
