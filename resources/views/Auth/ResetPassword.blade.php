<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }} | Recuperar contraseña</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg border border-gray-300 p-8">
        <h1 class="text-2xl font-bold text-gray-600 text-center mb-10">
            Restablecer Contraseña
        </h1>

        <form class="grid grid-cols-1 gap-4" action="{{ route('password.reset.store', ['token' => $token]) }}"
            method="POST" >
            @csrf

            @if(session('status'))
                <p
                    class="text-green-700 pl-8 pr-4 py-2 bg-green-100 border-l-8 border-green-700 text-xs font-bold uppercase">
                    {{ session('status') }}
                </p>
            @endif

            <div class="grid grid-cols-1 gap-2">
                <label for="email" class="text-lg font-bold text-gray-600">
                    Correo:
                </label>

                <input type="email" name="email" id="email"
                    class="border border-gray-200 placeholder:text-gray-400 text-gray-600 px-4 py-2 rounded-lg"
                    placeholder="Tu Correo" value="{{ $email }}" required />

                @if($errors->has('email'))
                    <p class="text-red-700 pl-8 pr-4 py-2 bg-red-100 border-l-8 border-red-700 text-xs font-bold uppercase">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-2">
                <label for="password" class="text-lg font-bold text-gray-600">
                    Contraseña:
                </label>

                <input type="password" name="password" id="password"
                    class="border border-gray-200 placeholder:text-gray-400 text-gray-600 px-4 py-2 rounded-lg"
                    placeholder="Tu Contraseña" required />


                @if($errors->has('password'))
                    <p class="text-red-700 pl-8 pr-4 py-2 bg-red-100 border-l-8 border-red-700 text-xs font-bold uppercase">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-2">
                <label for="password_confirmation" class="text-lg font-bold text-gray-600">
                    Repetir Contraseña:
                </label>

                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="border border-gray-200 placeholder:text-gray-400 text-gray-600 px-4 py-2 rounded-lg"
                    placeholder="Repetir Contraseña" required />

                @if($errors->has('password_confirmation'))
                    <p class="text-red-700 pl-8 pr-4 py-2 bg-red-100 border-l-8 border-red-700 text-xs font-bold uppercase">
                        {{ $errors->first('password_confirmation') }}
                    </p>
                @endif
            </div>

            <button type="submit"
                class="bg-rose-900 text-white px-4 py-2 rounded-lg font-bold hover:bg-rose-950 cursor-pointer trensition-colors">
                Restablecer Contraseña
            </button>
        </form>
    </div>
</body>

</html>
