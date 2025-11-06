<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>BOSQ</title>
    <link rel="icon" type="image/png" href="/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <div class="flex">
        <div class="flex-1 bg-gray-100 min-h-screen">
            <header class="bg-[#133138] p-2 shadow-md flex justify-between items-center">
                <div class="text-xl text-white font-bold ml-2">BOSQ</div>
                <div class="mr-2 relative">
                    <div class="flex items-center">
                        <p class="text-sm text-white hover:cursor-pointer" onclick="toggleDropdown()">
                            <i class="fas fa-user mr-2"></i> Admin
                            <i class="fas fa-caret-down text-white ml-2"></i>
                        </p>
                        <div id="adminDropdown"
                            class="absolute right-0 mt-[160px] w-48 bg-white rounded-md shadow-lg hidden">
                            <ul class="py-1 text-gray-700">
                                <li>
                                    <a href="{{route('admin.index')}}" class="block px-4 py-2 text-sm hover:bg-gray-100">Pengaturan Pengguna</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.settingapp')}}" class="block px-4 py-2 text-sm hover:bg-gray-100">Pengaturan Aplikasi</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </header>
            <div class="px-6 py-2">
                <img src="img/header.png" alt="logo 1" class=" my-4 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                 @foreach($settingapp as $app)
                    <a href="{{$app->link}}">
                        <div class="hover:bg-[#8db1b9] bg-gray-200 shadow-md p-4 rounded-lg flex flex-col items-center">
                            <img src="{{asset('storage/icons/' . $app->icon)}}" alt="{{$app->icon}}" class="w-20 h-20 mb-2">
                            <p class="text-sm text-center">{{$app->name}}</p>
                        </div>
                    </a>
                 @endforeach
                </div>
            </div>
        </div>

        <script>
            function toggleDropdown() {
            const dropdown = document.getElementById('adminDropdown');
            dropdown.classList.toggle('hidden');
          }
          </script>
</body>

</html>