<?= $this->extend("layout/master") ?>

<?= $this->section("content") ?>

<!-- Main content -->
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-9 mt-2">
        <h3 class="card-title">Rumah Sakit</h3>
      </div>
      <div class="col-3">
        <button type="button" class="btn float-end btn-success" onclick="save()" title="<?= lang("Tambah") ?>"> <i class="fa fa-plus"></i> <?= lang('Tambah') ?></button>
      </div>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <table id="data_table" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Rumah Sakit</th>
          <th>Kecamatan</th>
          <th>Nomor Telpon</th>
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
            <input type="hidden" id="id_rs" name="id_rs" class="form-control" placeholder="Id rs" maxlength="4" required>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="nama_rs" class="col-form-label"> Nama Rumah Sakit: <span class="text-danger">*</span> </label>
                <input type="text" id="nama_rs" name="nama_rs" class="form-control" placeholder="Nama Rumah Sakit">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="kecamatan" class="col-form-label"> Kecamatan: <span class="text-danger">*</span> </label>
                <input type="text" id="kecamatan" name="kecamatan" class="form-control" placeholder="Kecamatan">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="notelp" class="col-form-label"> No. Telpon: <span class="text-danger">*</span> </label>
                <input type="text" id="notelp" name="notelp" class="form-control" placeholder="Nomor Telpon">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="deskripsi" class="col-form-label"> Deskripsi: </label>
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" placeholder="Deskripsi">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="Latitude" class="col-form-label"> Latitude: <span class="text-danger">*</span> </label>
                <input type="text" id="Latitude" name="Latitude" class="form-control" placeholder="Latitude">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="longitude" class="col-form-label"> Longitude: <span class="text-danger">*</span> </label>
                <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Longitude">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="gambar" class="col-form-label"> Gambar: </label>
                <input type="file" id="gambar" name="gambar" class="form-control" placeholder="Gambar" >
              </div>
            </div>
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

  function save(id_rs) {
    // reset the form 
    $("#data-form")[0].reset();
    $(".form-control").removeClass('is-invalid').removeClass('is-valid');
    if (typeof id_rs === 'undefined' || id_rs < 1) { //add
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
          id_rs: id_rs
        },
        dataType: 'json',
        success: function(response) {
          $('#model-header').removeClass('bg-success').addClass('bg-info');
          $("#info-header-modalLabel").text('<?= lang("Ubah") ?>');
          $("#form-btn").text(submitText);
          $('#data-modal').modal('show');
          //insert data to form
          $("#data-form #id_rs").val(response.id_rs);
          $("#data-form #nama_rs").val(response.nama_rs);
          $("#data-form #kecamatan").val(response.kecamatan);
          $("#data-form #deskripsi").val(response.deskripsi);
          $("#data-form #Latitude").val(response.Latitude);
          $("#data-form #longitude").val(response.longitude);
          $("#data-form #notelp").val(response.notelp);
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

  function remove(id_rs) {
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
            id_rs: id_rs
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
</script>


<?= $this->endSection() ?>