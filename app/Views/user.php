<?= $this->extend("layout/master") ?>

<?= $this->section("content") ?>

<!-- Main content -->
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-9 mt-2">
        <h3 class="card-title">Pengguna</h3>
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
          <th>Email</th>
          <th>Username</th>
          <th>Nik</th>
          <th>Nama lengkap</th>
          <th>Telpon</th>
          <th>Tanggal Lahir</th>
          <th>Tempat Lahir</th>
          <th>Gender</th>
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
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="text-center bg-info p-3" id="model-header">
        <h4 class="modal-title text-white" id="info-header-modalLabel"></h4>
      </div>
      <div class="modal-body">
        <form id="data-form" class="pl-3 pr-3">
          <div class="row">
            <input type="hidden" id="id_user_detail" name="id_user_detail" class="form-control" placeholder="Id user detail" maxlength="6" required>
          </div>
          <div class="row">
            <div class="alert alert-primary" role="alert">
              Form Untuk Tabel User
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="email" class="col-form-label"> Email Pengguna: <span class="text-danger">*</span> </label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Email Pengguna">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="username" class="col-form-label"> Username: <span class="text-danger">*</span> </label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="password" class="col-form-label"> Kata Sandi: <span class="text-danger">*</span> </label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Kata Sandi">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="confpassword" class="col-form-label"> Konfirmasi Kata Sandi: <span class="text-danger">*</span> </label>
                <input type="password" id="confpassword" name="confpassword" class="form-control" placeholder="Kata Sandi">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="alert alert-primary" role="alert">
              Form Untuk Tabel User Detail
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="nik" class="col-form-label"> Nik: </label>
                <input type="text" id="nik" name="nik" class="form-control" placeholder="Nik" minlength="0" maxlength="16">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="nama_lengkap" class="col-form-label"> Nama lengkap: <span class="text-danger">*</span> </label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Nama lengkap">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="telpon" class="col-form-label"> Telpon: </label>
                <input type="text" id="telpon" name="telpon" class="form-control" placeholder="Nomor Telpon">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="tgl_lahir" class="col-form-label"> Tanggal Lahir: </label>
                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control" dateISO="true">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="tmp_lahir" class="col-form-label"> Tempat Lahir: </label>
                <input type="text" id="tmp_lahir" name="tmp_lahir" class="form-control" placeholder="Tempat Lahir">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="jns_kelamin" class="col-form-label"> Gender: </label>
                <select name="jns_kelamin" id="jns_kelamin" class="form-control">
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="Laki-Laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
                <!-- <input type="text" id="jns_kelamin" name="jns_kelamin" class="form-control" placeholder="Gender"> -->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="img_user" class="col-form-label"> Gambar: </label>
                <input type="file" id="img_user" name="img_user" class="form-control" placeholder="Gambar">
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
     "scrollY": true,
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

  function save(id_user_detail) {

    // reset the form 
    $("#data-form")[0].reset();

    $("#data-form #username").prop("disabled", false);
    $("#data-form #email").prop("disabled", false); 
    $(".form-control").removeClass('is-invalid').removeClass('is-valid');
    if (typeof id_user_detail === 'undefined' || id_user_detail < 1) { //add
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
          id_user_detail: id_user_detail
        },
        dataType: 'json',
        success: function(response) {
          $('#model-header').removeClass('bg-success').addClass('bg-info');
          $("#info-header-modalLabel").text('<?= lang("Ubah") ?>');
          $("#form-btn").text(submitText);
          $('#data-modal').modal('show');
          //insert data to form
          $("#data-form #username").prop("disabled", true);
          $("#data-form #email").prop("disabled", true);
          $("#data-form #email").val(response.email_user);
          $("#data-form #username").val(response.username);
          $("#data-form #id_user_detail").val(response.id_user_detail);
          $("#data-form #nik").val(response.nik);
          $("#data-form #nama_lengkap").val(response.nama_lengkap);
          $("#data-form #telpon").val(response.telpon);
          $("#data-form #tgl_lahir").val(response.tgl_lahir);
          $("#data-form #tmp_lahir").val(response.tmp_lahir);
          $("#data-form #jns_kelamin").val(response.jns_kelamin);
          $("#data-form #img_user").val(response.img_user);
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



  function remove(id_user_detail) {
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
            id_user_detail: id_user_detail
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