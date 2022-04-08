@extends('../layout/' . $layout)

@section('subhead')
    <title>Sistem Present & Payrol Gocay</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Data barang</h2>
                        <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview" class="ml-auto flex items-center btn btn-primary">
                            <i data-feather="plus" class="w-4 h-4 mr-3"></i> Tambah Barang
                        </a>
                    </div>
                    
                </div> 
                <!-- END: General Report -->

                <!-- BEGIN: Weekly Top Products -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <form method="get" action="">
                                @csrf
                                <div class="flex items-center text-gray-700 dark:text-gray-300 mr-2 w-1\/2">
                                    <input type="text" name="filter_nama" class="form-control w-25 mr-2" placeholder="Nama Barang" autofocus value="{{Request::old('filter_nama')}}">
                                    <!-- <input type="date" class="form-control mr-2" name="filter_tanggal" placeholder="Tanggal"> -->
                                    <input class="datepicker form-control w-25 mr-2" id="post-form-2" data-single-mode="true">
                                    <button type='submit' class="btn btn-primary flex items-center search">
                                        <i data-feather="search" class="w-4 h-5 mr-2 ml-2"></i>
                                    </button>
                                </div>
                            </form>
                            
                            <!-- <a href="{{ route('barang') }}" class="btn btn-success flex items-center">
                                <i data-feather="refresh-cw" class="hidden sm:block w-4 h-4"></i>
                            </a> -->
                        </div>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        @if ($barangs)
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">No</th>
                                    <th class="text-center whitespace-nowrap">Nama Barang</th>
                                    <th class="text-center whitespace-nowrap">Jenis</th>
                                    @if (Auth::user()->role != 'admin')
                                    <th class="text-center whitespace-nowrap">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; ?>
                            @foreach ($barangs as $item) 
                                <tr class="intro-x tabel-pegawai{{ $item->pegawai_id }}">
                                    <td class="w-20">
                                    {{ ++ $i }}
                                    </td>
                                    <td class="w-20 text-center">
                                        {{ $item->nama }}
                                    </td> 
                                    <td class="w-20 text-center">
                                        {{ $item->jenis_id }}
                                    </td> 
                                     
                                    @if (Auth::user()->role == 'su')
                                    <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3 barang-edit" href="javascript:void(0)" data-toggle="modal" 
                                                id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                </a>
                                                <a class="flex items-center text-theme-6" href="/barangdelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
                                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                        @endif
                                </tr>
                               
                            @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="text-center mt-10">
                            <button class="btn btn-danger text-center w-full">
                                    Data Tidak Ditemukan
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                        <div class="pagination">
                            @if ($barangs)
                                {{ $barangs->appends($data_request)->links() }}
                            @else

                            @endif
                        </div>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->

                 <!-- BEGIN: Modal Content -->
                <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- BEGIN: Modal Header -->
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">Tambah item</h2>
                                <div class="dropdown sm:hidden">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false">
                                        <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-600"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                            <a href="javascript:;"
                                                class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Modal Header -->
                            <!-- BEGIN: Modal Body -->
                            <form method="POST" action="">
                                @csrf
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                
                                <div class="col-span-12 sm:col-span-12">
                                    <label for="modal-form-1" class="form-label">Nama Pegawai</label>
                                    <input id="modal-form-1" name="nama" type="text" class="form-control" placeholder="Nama Pegawai">
                                </div>
                            </div>
                            <!-- END: Modal Body -->
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer text-right">
                                <button type="button" data-dismiss="modal"
                                    class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                <button type="submit" class="btn btn-primary w-20">Send</button>
                            </div>
                            </form>
                            <!-- END: Modal Footer -->
                        </div>
                    </div>
                </div>
                <!-- END: Modal Content -->

            </div>
        </div>
        
    </div>

    
@endsection
