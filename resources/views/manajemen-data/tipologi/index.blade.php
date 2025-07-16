 @extends('layouts.app')
 @section('title', 'CSR PLN Nusantara Power UP Paiton')
 @section('content')

     <div class="row">
         <div class="col-lg-12 d-flex align-items-stretch">
             <div class="card w-100">
                 <div class="card-body p-4">
                     <h5 class="card-title fw-semibold mb-4">Data Tipologi</h5>
                     <div class="table-responsive">
                         <table class="table text-nowrap mb-0 align-middle">
                             <thead class="text-dark fs-4">
                                 <tr>
                                     <th class="border-bottom-0">
                                         <h6 class="fw-semibold mb-0">No</h6>
                                     </th>
                                     <th class="border-bottom-0">
                                         <h6 class="fw-semibold mb-0">Kode</h6>
                                     </th>
                                     <th class="border-bottom-0">
                                         <h6 class="fw-semibold mb-0">Deskripsi</h6>
                                     </th>
                                     <th class="border-bottom-0">
                                         <h6 class="fw-semibold mb-0">Aksi</h6>
                                     </th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($tipologi as $data)
                                     <tr>
                                         <td class="border-bottom-0">
                                             <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                         </td>
                                         <td class="border-bottom-0">
                                             <h6 class="fw-semibold mb-0">{{ $data->kode }}</h6>
                                             {{-- <span class="fw-normal">{{ $data->deskripsi }}</span> --}}
                                         </td>
                                         <td class="border-bottom-0">
                                             <p class="mb-0 fw-normal">{{ $data->deskripsi }}</p>
                                         </td>
                                         <td class="border-bottom-0">
                                             <div class="dropdown">
                                                 <button class="btn btn-sm btn-light border-0" type="button"
                                                     id="dropdownMenuButton{{ $data->id }}" data-bs-toggle="dropdown"
                                                     aria-expanded="false">
                                                     <i class="fas fa-ellipsis-h"></i> {{-- tiga titik horizontal --}}
                                                 </button>
                                                 <ul class="dropdown-menu"
                                                     aria-labelledby="dropdownMenuButton{{ $data->id }}">
                                                     <li><a class="dropdown-item"
                                                             href="{{ route('tipologi.create') }}">Create</a></li>
                                                     <li><a class="dropdown-item"
                                                             href="{{ route('tipologi.edit', $data->id) }}">Edit</a></li>
                                                     <li>
                                                         <form action="{{ route('tipologi.destroy', $data->id) }}"
                                                             method="POST"
                                                             onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                             @csrf
                                                             @method('DELETE')
                                                             <button type="submit"
                                                                 class="dropdown-item text-danger">Delete</button>
                                                         </form>
                                                     </li>
                                                 </ul>
                                             </div>
                                         </td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
