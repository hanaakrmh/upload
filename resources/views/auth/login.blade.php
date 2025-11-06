<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Login | BOSQ</title>
  <link rel="icon" type="image/png" href="/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url({{asset('background.jpg')}});
      background-size: cover;
      background-position: center;
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="relative flex  items-center justify-center min-h-screen bg-gray-100">

  <div class="absolute inset-0 bg-black bg-opacity-70"></div>

  <div class="relative flex flex-col md:flex-row items-center mx-4 md:mx-[120px] rounded-xl shadow-lg z-10 overflow-auto">
  <div class="flex-1 text-white md:mr-[200px] text-center md:text-left">
    <h1 class="text-2xl md:text-4xl font-bold mb-4">Hi, Welcome Back!</h1>
    <p class="mb-4 text-justify">
      <strong>BOSQ</strong> (Borneo One Service Quarantine) adalah merupakan sebuah portal utama (rumah layanan) yang
      menghimpun berbagai website pelayanan karantina yang ada di Balai Besar Karantina Hewan, Ikan, dan Tumbuhan Kalimantan Timur.
    </p>
  </div>
  <div class="flex-1 w-full">
    <div class="bg-white p-6 md:p-[40px] rounded-[25px] shadow-lg max-w-sm md:max-w-md lg:max-w-lg">
      <img src="{{asset('logo.png')}}" alt="Logo" class="mx-auto mb-4 w-[80px] md:w-[120px]">
      <h2 class="text-xl md:text-2xl font-semibold text-center mb-6">Login</h2>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700 font-semibold mb-2" for="username">Username</label>
          <input type="text" id="username" placeholder="Username" name="username"
            class="w-full p-3 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
        </div>
        <div class="mb-[30px] relative">
          <label class="block text-gray-700 font-semibold mb-2" for="password">Password</label>
          <div class="relative">
            <input type="password" id="password" placeholder="********" name="password"
              class="w-full p-3 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
            <i id="togglePassword"
              class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-500 cursor-pointer"></i>
          </div>
        </div>
        <button type="submit"
          class="w-full py-3 bg-blue-800 text-white font-semibold rounded-xl hover:bg-blue-900 transition duration-200">
          {{ __('Login') }}
        </button>
      </form>
    </div>
  </div>
</div>


  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      // Toggle the eye icon
      this.classList.toggle('fa-eye-slash');
    });
  </script>
</body>

</html>