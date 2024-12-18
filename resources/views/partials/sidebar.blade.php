<?php
    $user = Auth::user();
?>
<aside class="main-sidebar elevation-4 sidebar-light-success">
    <a href="{{ route('dashboard') }}" class="brand-link ml-3">
        <span class="elevation-3" style="box-shadow: 0 0 0 rgba(0, 0, 0, 0), 0 0 0 rgba(0, 0, 0, 0) !important">PJP</span>
        <span class="brand-text font-weight-light">Online</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (empty($user->photo))
                    <img class="img-circle elevation-2" src="{{ asset('assets/img/blank-profile.png')}}" alt="Foto Profil">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('profil.index') }}" class="d-block">{{ ucwords(strtolower($user->nama)) }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ setActive('dashboard') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ setActiveMenu('master-data/*') }}">
                    <a href="#" class="nav-link {{ setActive('master-data/*') }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('master_data.tanggal.index') }}" class="nav-link {{ setActive('master-data/tanggal/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tanggal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('master_data.tahun.index') }}" class="nav-link {{ setActive('master-data/tahun/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tahun</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('master_data.materi.index') }}" class="nav-link {{ setActive('master-data/materi/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Materi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('master_data.karakter.index') }}" class="nav-link {{ setActive('master-data/karakter/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Karakter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('master_data.satuan.index') }}" class="nav-link {{ setActive('master-data/satuan/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Satuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('master_data.divisi.index') }}" class="nav-link {{ setActive('master-data/divisi/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Divisi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('master_data.kelas.index') }}" class="nav-link {{ setActive('master-data/kelas/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kelas</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('murid.index') }}" class="nav-link {{ setActive('murid/*') }}">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Murid</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kurikulum_target.index') }}" class="nav-link {{ setActive('kurikulum-target/*') }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Kurikulum & Target</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pencapaian_target.index') }}" class="nav-link {{ setActive('pencapaian-target/*') }}">
                        <i class="nav-icon fa-solid fa-chart-line"></i>
                        <p>Pencapaian Target</p>
                    </a>
                </li>
                <li class="nav-item {{ setActiveMenu('aktivitas/*') }}">
                    <a href="#" class="nav-link {{ setActive('aktivitas/*') }}">
                        <i class="nav-icon fa-solid fa-calendar-days"></i>
                        <p>
                            Aktivitas
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('aktivitas.jadwal.index') }}" class="nav-link {{ setActive('aktivitas/jadwal/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('aktivitas.hari_libur.index') }}" class="nav-link {{ setActive('aktivitas/hari-libur/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hari Libur</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('absensi.index') }}" class="nav-link {{ setActive('absensi/*') }}">
                        <i class="nav-icon far fa-calendar-check"></i>
                        <p>Absensi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kegiatan.index') }}" class="nav-link {{ setActive('kegiatan/*') }}">
                        <i class="nav-icon fa-solid fa-laptop-file"></i>
                        <p>Kegiatan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ setActive('laporan/*') }}">
                        <i class="nav-icon fa-solid fa-box-archive"></i>
                        <p>Laporan</p>
                    </a>
                </li>
                <li class="nav-item {{ setActiveMenu('master-user/*') }}">
                    <a href="#" class="nav-link {{ setActive('master-user/*') }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Master User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('master_user.user.index') }}" class="nav-link  {{ setActive('master-user/user/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('master_user.role.index') }}" class="nav-link  {{ setActive('master-user/role/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Role</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('master_user.permission.index') }}" class="nav-link  {{ setActive('master-user/permission/*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
