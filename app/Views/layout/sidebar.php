      <!-- Main Sidebar Container -->
      <!--<aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">-->
      <?php helper('settings');
      $seg = segment()->uri->getSegment(1) ?>
      <aside class="main-sidebar sidebar-bg-dark  sidebar-color-primary shadow">
        <div class="brand-container">
          <a href="javascript:;" class="brand-link">
            <img src="<?= base_url('ams_logoo.png') ?>" alt="AdminLTE Logo" class="brand-image opacity-80 shadow">
            <span class="brand-text fw-light">GIS KEHATAN</span>
          </a>
          <a class="pushmenu mx-1" data-lte-toggle="sidebar-mini" href="javascript:;" role="button"><i class="fas fa-angle-double-left"></i></a>
        </div>
        <!-- Sidebar -->
        <div class="sidebar">
          <nav class="mt-2">
            <!-- Sidebar Menu -->
            <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="<?= base_url() ?>" class="nav-link <?= $seg ? '' : 'active' ?> ">
                  <i class="nav-icon fa fa-desktop"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?= base_url('rumahsakit') ?>" class="nav-link <?= $seg == 'rumahsakit' ? 'active' : '' ?>">
                  <i class="nav-icon far fa-user"></i>
                  <p>Rumah Sakit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('rsia') ?>" class="nav-link <?= $seg == 'rsia' ? 'active' : '' ?>">
                  <i class="nav-icon far fa-user"></i>
                  <p>Rumah Sakit Ibu dan Anak</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('klinik') ?>" class="nav-link <?= $seg == 'klinik' ? 'active' : '' ?>">
                  <i class="nav-icon far fa-user"></i>
                  <p>Klinik</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('puskesmas') ?>" class="nav-link <?= $seg == 'puskesmas' ? 'active' : '' ?>">
                  <i class="nav-icon far fa-user"></i>
                  <p>Puskesmas</p>
                </a>
              </li>
              

          </nav>
        </div>
        <!-- /.sidebar -->
      </aside>