<div class="modal fade text-center" id="addAlarm" tabindex="-1" aria-labelledby="alarm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="alarmName" placeholder="Label">
                </div>
                <div class="form-group">
                    <input type="time" class="form-control" id="alarmTime" placeholder="Label">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input repeat" type="radio" name="repeat" id="daily"
                                value="daily">
                            <label class="form-check-label" for="daily">
                                Daily
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input repeat" type="radio" name="repeat" id="weekly"
                                value="weekly">
                            <label class="form-check-label" for="weekly">
                                Weekly
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input repeat" type="radio" name="repeat" id="monthly"
                                value="monthly">
                            <label class="form-check-label" for="monthly">
                                Monthly
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input repeat" type="radio" name="repeat" id="once"
                                value="none">
                            <label class="form-check-label" for="once">
                                Once
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnAlarmSave">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('addAlarm');
            var btn = document.getElementById('btnAlarmSave');
            var table = document.getElementById('tableAlarm');
            if (modal && btn) {
                var myModal = new bootstrap.Modal(modal);
                btn.addEventListener('click', function() {
                    var alarmName = document.getElementById('alarmName');
                    var alarmTime = document.getElementById('alarmTime');
                    var alarmRepeat = document.querySelector('input[name="repeat"]:checked');
                    var __token = "{{ csrf_token() }}";
                    axios.get('/setAlarm', {
                        params: {
                            lable: alarmName.value,
                            time: alarmTime.value,
                            repeat: alarmRepeat.value,
                            __token: __token
                        }
                    }).then(function(response) {
                        var item = response.data.alarm;
                        var row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${item.lable}</td>
                    <td>${item.time}</td>
                    <td>${item.repeat}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" data-id="${item.id}">Hapus</button>
                    </td>`;
                        table.appendChild(row);
                        alarmName.value = '';
                        alarmTime.value = '';
                        alarmRepeat.value = '';
                        myModal.hide();
                    }).catch(function(error) {
                        console.log(error);
                    });
                });
            }
        });
    </script>
@endpush
