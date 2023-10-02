<?= $this->extend("layout/master") ?>

<?= $this->section("content") ?>

<!-- Main content -->
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-9 md-2">
        <h3 class="card-title">Klinik</h3>
      </div>
      <div class="col-3">
        <!-- <div class="btn-group">
          <button type="button" class=" btn btn-lg dropdown-toggle btn-warning" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa fa-upload"></i> Import Excel</button>
          <div class="dropdown-menu">
            <a class="dropdown-item text-info" onclick="unduh()"> <i class="fa fa-upload "></i> Import</a>
            <a class="dropdown-item text-info" href="<?php base_url() ?>/download" target="_blank"> <i class="fa fa-download"></i> Download Contoh</a>
          </div>
        </div> -->
        <button type="button" class="btn btn-success float-end btn-lg" onclick="save()" title="<?= lang("Tambah") ?>"> <i class="fa fa-plus"></i> <?= lang('Tambah') ?></button>
      </div>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <table id="data_table" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama klinik</th>
          <th>Kecamatan</th>
          <th>Deskripsi</th>
          <th>Latitude</th>
          <th>Longitude</th>
          <th>Gambar</th>
          <th>Dibuat</th>
          <th>Diubah</th>

          <th></th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

<!-- /Main content -->

<!-- ADD modal content -->
<div id="data-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="text-center bg-info p-3" id="model-header">
        <h4 class="modal-title text-white" id="info-header-modalLabel"></h4>
      </div>
      <div class="modal-body">
        <form id="data-form" class="pl-3 pr-3">
          <div class="row">
            <input type="hidden" id="id_klinik" name="id_klinik" class="form-control" placeholder="Id klinik" maxlength="4" required>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="nama_klinik" class="col-form-label"> Nama klinik: <span class="text-danger">*</span> </label>
                <input type="text" id="nama_klinik" name="nama_klinik" class="form-control" placeholder="Nama klinik" minlength="0" maxlength="255" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="kecamatan" class="col-form-label"> Kecamatan: <span class="text-danger">*</span> </label>
                <input type="text" id="kecamatan" name="kecamatan" class="form-control" placeholder="Kecamatan" minlength="0" maxlength="255" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="deskripsi" class="col-form-label"> Deskripsi: <span class="text-danger">*</span> </label>
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" placeholder="Deskripsi" minlength="0" maxlength="255" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="Latitude" class="col-form-label"> Latitude: <span class="text-danger">*</span> </label>
                <input type="text" id="Latitude" name="Latitude" class="form-control" placeholder="Latitude" minlength="0" maxlength="255" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="longitude" class="col-form-label"> Longitude: <span class="text-danger">*</span> </label>
                <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Longitude" minlength="0" maxlength="255" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="gambar" class="col-form-label"> Gambar: </label>
                <input type="file" id="gambar" name="gambar" class="form-control" placeholder="Gambar" minlength="0" maxlength="255">
              </div>
            </div>
            <!-- <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="is_jadwal" class="col-form-label"> Is jadwal: </label>
                <input type="number" id="is_jadwal" name="is_jadwal" class="form-control" placeholder="Is jadwal" minlength="0" maxlength="3">
              </div>
            </div> -->
          </div>

          <div class="form-group text-center">
            <div class="btn-group">
              <button type="submit" class="btn btn-success mr-2" id="form-btn"><?= lang("Simpan") ?></button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= lang("Batal") ?></button>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- /ADD modal content -->

<!-- import modal content -->
<div id="excel-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="text-center bg-info p-3" id="model-header">
        <h4 class="modal-title text-white" id="info-header-modalLabel"></h4>
      </div>
      <div class="modal-body">
        <form id="excel-form" class="pl-3 pr-3">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="excel" class="col-form-label"> File: </label>
                <input type="file" id="excel" name="excel" class="form-control" placeholder="excel">
              </div>
            </div>
            <!-- <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="is_jadwal" class="col-form-label"> Is jadwal: </label>
                <input type="number" id="is_jadwal" name="is_jadwal" class="form-control" placeholder="Is jadwal" minlength="0" maxlength="3">
              </div>
            </div> -->
          </div>

          <div class="form-group text-center">
            <div class="btn-group">
              <button type="submit" class="btn btn-success mr-2" id="form-btn"><?= lang("Import") ?></button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= lang("Batal") ?></button>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- /ADD modal content -->








<?= $this->endSection() ?>
<!-- /.content -->


<!-- page script -->
<?= $this->section("pageScript") ?>
<script>
  // dataTables
  $(function() {
    var table = $('#data_table').removeAttr('width').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "scrollY": '45vh',
      "scrollX": true,
      "scrollCollapse": false,
      "responsive": false,
      "ajax": {
        "url": '<?php echo base_url($controller . "/getAll") ?>',
        "type": "POST",
        "dataType": "json",
        async: "true"
      }
    });
  });

  var urlController = '';
  var submitText = '';

  function getUrl() {
    return urlController;
  }

  function getSubmitText() {
    return submitText;
  }

  function save(id_klinik) {
    // reset the form 
    $("#data-form")[0].reset();
    $(".form-control").removeClass('is-invalid').removeClass('is-valid');
    if (typeof id_klinik === 'undefined' || id_klinik < 1) { //add
      urlController = '<?= base_url($controller . "/add") ?>';
      submitText = '<?= lang("Simpan") ?>';
      $('#model-header').removeClass('bg-info').addClass('bg-success');
      $("#info-header-modalLabel").text('<?= lang("Tambah") ?>');
      $("#form-btn").text(submitText);
      $('#data-modal').modal('show');
    } else { //edit
      urlController = '<?= base_url($controller . "/edit") ?>';
      submitText = '<?= lang("Perbarui") ?>';
      $.ajax({
        url: '<?php echo base_url($controller . "/getOne") ?>',
        type: 'post',
        data: {
          id_klinik: id_klinik
        },
        dataType: 'json',
        success: function(response) {
          $('#model-header').removeClass('bg-success').addClass('bg-info');
          $("#info-header-modalLabel").text('<?= lang("Ubah") ?>');
          $("#form-btn").text(submitText);
          $('#data-modal').modal('show');
          //insert data to form
          $("#data-form #id_klinik").val(response.id_klinik);
          $("#data-form #nama_klinik").val(response.nama_klinik);
          $("#data-form #kecamatan").val(response.kecamatan);
          $("#data-form #deskripsi").val(response.deskripsi);
          $("#data-form #Latitude").val(response.Latitude);
          $("#data-form #longitude").val(response.longitude);
          $("#data-form #gambar").val(response.gambar);
          $("#data-form #is_jadwal").val(response.is_jadwal);
          $("#data-form #created_at").val(response.created_at);
          $("#data-form #updated_at").val(response.updated_at);

        }
      });
    }
    $.validator.setDefaults({
      highlight: function(element) {
        $(element).addClass('is-invalid').removeClass('is-valid');
      },
      unhighlight: function(element) {
        $(element).removeClass('is-invalid').addClass('is-valid');
      },
      errorElement: 'div ',
      errorClass: 'invalid-feedback',
      errorPlacement: function(error, element) {
        if (element.parent('.input-group').length) {
          error.insertAfter(element.parent());
        } else if ($(element).is('.select')) {
          element.next().after(error);
        } else if (element.hasClass('select2')) {
          //error.insertAfter(element);
          error.insertAfter(element.next());
        } else if (element.hasClass('selectpicker')) {
          error.insertAfter(element.next());
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form) {
        // var form = $('#data-form');
        $(".text-danger").remove();
        $.ajax({
          // fixBug get url from global function only
          // get global variable is bug!
          url: getUrl(),
          type: 'post',
          data: new FormData(form),
          processData: false,
          contentType: false,
          cache: false,
          dataType: 'json',
          beforeSend: function() {
            $('#form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
          },
          success: function(response) {
            if (response.success === true) {
              Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: response.messages,
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                $('#data_table').DataTable().ajax.reload(null, false).draw(false);
                $('#data-modal').modal('hide');
              })
            } else {
              if (response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var ele = $("#" + index);
                  ele.closest('.form-control')
                    .removeClass('is-invalid')
                    .removeClass('is-valid')
                    .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');
                  ele.after('<div class="invalid-feedback">' + response.messages[index] + '</div>');
                });
              } else {
                Swal.fire({
                  toast: false,
                  position: 'bottom-end',
                  icon: 'error',
                  title: response.messages,
                  showConfirmButton: false,
                  timer: 3000
                })

              }
            }
            $('#form-btn').html(getSubmitText());
          }
        });
        return false;
      }
    });

    $('#data-form').validate({

      //insert data-form to database

    });
  }

  function remove(id_klinik) {
    Swal.fire({
      title: "<?= lang("Hapus") ?>",
      text: "<?= lang("Yakin ingin menghapus ?") ?>",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<?= lang("Konfirmasi") ?>',
      cancelButtonText: '<?= lang("Batal") ?>'
    }).then((result) => {

      if (result.value) {
        $.ajax({
          url: '<?php echo base_url($controller . "/remove") ?>',
          type: 'post',
          data: {
            id_klinik: id_klinik
          },
          dataType: 'json',
          success: function(response) {

            if (response.success === true) {
              Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: response.messages,
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                $('#data_table').DataTable().ajax.reload(null, false).draw(false);
              })
            } else {
              Swal.fire({
                toast: false,
                position: 'bottom-end',
                icon: 'error',
                title: response.messages,
                showConfirmButton: false,
                timer: 3000
              })
            }
          }
        });
      }
    })
  }

  function unduh() {
    $('#excel-modal').modal('show');
    $('#excel-form').submit(function(event) {
      event.preventDefault();
      // $this[0].reset();
      var formData = $(this).serialize();
      $.ajax({
        // fixBug get url from global function only
        // get global variable is bug!
        url: '<?php echo base_url($controller . "/import") ?>',
        type: 'post',
        data: formData,
        // data: new FormData(form),
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        beforeSend: function() {
          $('#form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(response) {

        }

      });
    })
  }
</script>


<?= $this->endSection() ?>