<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Pengaturan Pengguna | BOSQ</title>
    <link rel="icon" type="image/png" href="/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <div class="flex bg-gray-100 min-h-screen">
        <div class="mx-auto shadow-lg flex-1">
            <div class="flex">
                <div class="mx-4 my-4 flex items-center">
                    <button onclick="window.location.href='/'"
                        class="text-blue-500 bg-white py-1 px-2 rounded-2xl hover:text-white hover:bg-blue-500 mr-2">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <h1 class="text-md font-bold">Pengaturan Pengguna</h1>
                </div>
                <div class="ml-auto mr-4 mt-4">
                    <button onclick="openModal()"
                        class="bg-blue-500 text-xs text-white px-4 py-2 shadow-md rounded-lg hover:bg-blue-600">
                        Tambah Pengguna
                    </button>
                </div>
            </div>

            <div class="bg-white px-6 pb-6 pt-4 mx-6 rounded-xl">
                <div class="flex justify-between items-center mb-3">
                    <p class="text-center font-bold text-lg">Daftar Pengguna</p>
                    <form method="GET" action="{{ route('admin.index') }}" class="relative">
                        <input type="text" name="username" value="{{ request('username') }}"
                            placeholder="Cari pengguna..."
                            class="px-4 py-2 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <button type="submit" class="absolute right-2 top-1.5 text-blue-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full bg-white border rounded-xl">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                                <th class="text-md py 3 px-6 text-center w-[30px]">No</th>
                                <th class="text-md py-3 px-6 text-left">Nama Pengguna</th>
                                <th class="text-md py-3 px-6 text-left">Password</th>
                                <th class="text-md py-3 px-6 text-center">Peran</th>
                                <th class="text-md py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-xs font-light">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-2 px-6 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-6 text-left">{{ $user->username }}</td>
                                    <td class="py-2 px-6 text-left">{{ $user->realpassword }}</td>
                                    <td class="py-2 px-6 text-center">{{ $user->role }}</td>
                                    <td class="py-2 px-6 text-center">
                                        <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600"
                                            onclick="openModalDelete({{ $user->id }})">Delete</button>
                                        <button class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600"
                                            onclick="openModalEdit({{ $user->id }}, '{{ $user->username }}', '{{ $user->role }}', '{{ $user->realpassword }}')">
                                            Edit
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center mt-4">
                    <nav class="flex items-center space-x-2">
                        {{-- Previous Page Link --}}
                        @if ($users->onFirstPage())
                            <span
                                class="px-3 py-2 border rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}"
                                class="px-3 py-2 border rounded-lg bg-white text-gray-700 hover:bg-gray-100 hover:text-blue-500">Previous</a>
                        @endif

                        {{-- Pagination Links --}}
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <span
                                    class="px-3 py-2 border rounded-lg bg-blue-500 text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-2 border rounded-lg bg-white text-gray-700 hover:bg-gray-100 hover:text-blue-500">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}"
                                class="px-3 py-2 border rounded-lg bg-white text-gray-700 hover:bg-gray-100 hover:text-blue-500">Next</a>
                        @else
                            <span
                                class="px-3 py-2 border rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">Next</span>
                        @endif
                    </nav>
                </div>
            </div>

            <!--Modal Tambah Data-->
            <div id="modal"
                class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-[400px] p-6">
                    <h2 class="text-sm font-bold mb-4">Tambah Pengguna</h2>
                    <form method="POST" action="{{ route('add.user') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="nama" class="block text-xs font-medium mb-1">Nama Pengguna</label>
                            <input type="text" id="nama" required
                                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nama pengguna" name="username" required
                                autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label for="role" class="block text-xs font-medium mb-1">Peran</label>
                            <select
                                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="role" name="role" required>
                                <option class="text-sm" value="user">User</option>
                                <option class="text-sm" value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-xs font-medium mb-1">Password</label>
                            <input type="text" id="password" required
                                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan password" name="password" 
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$"
                                title="Password harus terdiri dari minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka"
                                autocomplete="off">
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeModal()"
                                class="bg-gray-500 text-white px-4 py-2 text-xs rounded-lg hover:bg-gray-600">Batal</button>
                            <button type="submit" 
                                class="bg-blue-500 text-white px-4 py-2 text-xs rounded-lg hover:bg-blue-600">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!--Modal Delete-->
            <div id="deleteModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h2 class="text-md font-semibold text-gray-700 mb-4">Konfirmasi Hapus</h2>
                    <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus data ini?
                    </p>
                    <div class="flex justify-end space-x-4">
                        <button class="text-xs px-4 py-2 shadow-md text-gray-700 bg-gray-200 rounded hover:bg-gray-300"
                            onclick="closeModalDelete()">
                            Batal
                        </button>
                        <form method="POST" action="{{ route('delete.user') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="userId" value="">
                            <button class="text-xs px-4 py-2 shadow-md text-white bg-red-500 rounded hover:bg-red-600"
                                onclick="deleteData()">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div id="modalEdit"
                class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-[400px] p-6">
                    <h2 class="text-sm font-bold mb-4">Edit Pengguna</h2>
                    <form method="POST" enctype="multipart/form-data" action="{{route('update.user')}}">
                        @csrf
                        <div>
                            <input type="hidden" name="userId" id="userId">
                        </div>
                        <div class="mb-4">
                            <label for="editUsername" class="block text-xs font-medium mb-1">Nama Pengguna</label>
                            <input type="text" id="editUsername"
                                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nama pengguna" name="username">
                        </div>
                        <div class="mb-4">
                            <label for="Role" class="block text-xs font-medium mb-1">Peran</label>
                            <select
                                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="editRole" name="role">
                                <option class="text-sm" value="user">User</option>
                                <option class="text-sm" value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="editPassword" class="block text-xs font-medium mb-1">Password</label>
                            <input type="text" id="editPassword"
                                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan password" name="password" >
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeModalEdit()"
                                class="bg-gray-500 text-white text-xs px-4 py-2 rounded-lg hover:bg-gray-600">Batal</button>
                            <button type="submit"
                                class="bg-blue-500 text-white text-xs px-4 py-2 rounded-lg hover:bg-blue-600">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>


            <script>
                function openModal() {
                    document.getElementById('modal').classList.remove('hidden');
                }

                function closeModal() {
                    document.getElementById('modal').classList.add('hidden');
                }

                function openModalDelete($id) {
                    document.getElementById('deleteModal').classList.remove('hidden');
                    document.querySelector('input[name=userId]').value = $id;
                }

                // Fungsi untuk menutup modal
                function closeModalDelete() {
                    document.getElementById('deleteModal').classList.add('hidden');
                }

                // Fungsi untuk menghapus data
                function deleteData() {
                    const userId = document.querySelector('input[name=userId]').value;
                    alert("Data " + userId + " berhasil dihapus!");
                    closeModalDelete();
                    // Tambahkan logika penghapusan data di sini
                }

                function openModalEdit(userId, username, role, password) {
                    // Mengisi input modal dengan data pengguna yang akan diedit
                    document.getElementById('userId').value = userId; 
                    document.getElementById('editUsername').value = username;
                    document.getElementById('editRole').value = role;
                    document.getElementById('editPassword').value = password;

                    // Menampilkan modal
                    document.getElementById('modalEdit').classList.remove('hidden');
                }


                function closeModalEdit() {
                    document.getElementById('modalEdit').classList.add('hidden');
                }
            </script>
</body>

</html>
