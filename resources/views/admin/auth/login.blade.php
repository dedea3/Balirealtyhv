<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Bali Realty Holidays</title>
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-old-money-cream min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white p-8 shadow-lg">
            <div class="text-center mb-8">
                <h1 class="font-serif text-3xl font-semibold text-old-money-charcoal">Bali Realty</h1>
                <p class="text-gray-500 mt-2">Admin Panel</p>
            </div>
            
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded text-sm">
                    {{ $errors->first() }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="input-field"
                           placeholder="admin@balirealtyhv.com"
                           required 
                           autofocus>
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="input-field"
                           placeholder="••••••••"
                           required>
                </div>
                
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-old-money-charcoal focus:ring-old-money-charcoal">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>
                
                <button type="submit" class="btn-primary w-full">
                    Sign In
                </button>
            </form>
            
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-xs text-center text-gray-500">
                    Default credentials:<br>
                    Email: admin@balirealtyhv.com | Password: admin123
                </p>
            </div>
        </div>
    </div>
</body>
</html>
