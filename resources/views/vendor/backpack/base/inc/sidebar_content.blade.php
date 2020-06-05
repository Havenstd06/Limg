<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon la la-users'></i> Users</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('image') }}'><i class='nav-icon la la-image'></i> Images</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('album') }}'><i class='nav-icon las la-images'></i> Albums</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('domain') }}'><i class='nav-icon las la-network-wired '></i> Domains</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('files') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('backup') }}'><i class='nav-icon la la-hdd-o'></i> Backups</a></li>