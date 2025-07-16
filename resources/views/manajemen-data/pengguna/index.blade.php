 @extends('layouts.app')
 @section('title', 'CSR PLN Nusantara Power UP Paiton')
 @section('content')
     @push('styles')
         <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
     @endpush
     <style>
         /* Jarak di atas input pencarian */
         div.dataTables_filter {
             margin-bottom: 20px;
         }

         /* Margin atas bawah pada pagination */
         div.dataTables_paginate {
             margin-top: 20px;
         }

         /* Zebra striping: putih dan abu muda */
         #usersTable tbody tr:nth-child(odd) {
             background-color: #ffffff;
         }

         #usersTable tbody tr:nth-child(even) {
             background-color: #f9f9f9;
         }

         /* Jika ingin warna tetap saat hover hilang */
         #usersTable tbody tr:hover {
             background-color: #e0e0e0;
         }
     </style>

     <div class="row">
         <div class="col-lg-12 d-flex align-items-stretch">
             <div class="card w-100">
                 <div class="card-body p-4">
                     <h5 class="card-title fw-semibold mb-4">Data Pengguna</h5>
                     <div class="table-responsive">
                         <table id="usersTable" class="table table-bordered text-nowrap mb-0 align-middle">
                             <thead class="text-dark fs-4">
                                 <tr>
                                     <th>
                                         <h6 class="fw-semibold mb-0">No</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Nama</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Username</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Aksi</h6>
                                     </th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($users as $index => $data)
                                     <tr>
                                         <td>
                                             <h6 class="fw-semibold mb-0">{{ $index + 1 }}</h6>
                                         </td>
                                         <td>
                                             <h6 class="fw-semibold mb-1">{{ $data->nama }}</h6>
                                             <span class="fw-normal">{{ $data->role }}</span>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->username }}</p>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">Aksis</p>
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


     @push('scripts')
         <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
         <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
         <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
         <script>
             $(document).ready(function() {
                 $('#usersTable').DataTable({
                     language: {
                         search: "Cari:",
                         lengthMenu: "Tampilkan _MENU_ data",
                         zeroRecords: "Data tidak ditemukan",
                         paginate: {
                             previous: "Sebelumnya",
                             next: "Berikutnya"
                         }
                     }
                 });
             });
         </script>
     @endpush
 @endsection
