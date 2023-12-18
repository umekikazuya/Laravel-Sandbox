<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env('APP_NAME')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body class="font-sans bg-gray-100">
        <div class="max-w-xl mx-auto flex flex-col h-screen">
            <h1 class="my-4 text-3xl font-bold">{{env('APP_NAME')}}</h1>
            <ul class="flex-1 overflow-y-auto">
                @foreach ($chat as $o)
                    @if ($o->user_identifier === session('user_identifier'))
                        <!-- Message from self -->
                        <li class="flex items-end mb-4 justify-end">
                            <div class="mr-3">
                                <div class="bg-blue-500 text-white p-3 rounded-lg shadow">
                                    <p class="text-sm text-gray-600">{{ $o->user_name }}</p>
                                    <p class="text-md">{{ $o->message }}</p>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                    <span class="text-sm font-semibold"></span>
                                </div>
                            </div>
                        </li>
                    @else
                        <!-- Message from others -->
                        <li class="flex items-start mb-4">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                    <span class="text-sm font-semibold"></span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="bg-white p-3 rounded-lg shadow">
                                    <p class="text-sm text-gray-600">{{ $o->user_name }}</p>
                                    <p class="text-md">{{ $o->message }}</p>
                                </div>
                            </div>
                        </li>
                    @endif


                @endforeach
            </ul>
        </div>
        <form class="flex items-center p-4 border-t border-gray-300" action="/chat" method="POST">
            @csrf
            <input type="hidden" name="user_identifier" value="{{ session('user_identifier') }}">
            <input class="flex-1 px-4 py-2 mr-2 border rounded-full focus:outline-none focus:border-blue-500" type="text" name="user_name" placeholder="UserName" maxlength="20" value="{{session('user_name')}}" required>
            <input class="flex-1 px-4 py-2 mr-2 border rounded-full focus:outline-none focus:border-blue-500" type="text" name="message" placeholder="Input message." maxlength="200" autofocus required>
            <button class="bg-blue-500 text-white px-6 py-2 rounded-full focus:outline-none hover:bg-blue-600" type="submit">Send</button>
        </form>
    </body>
</html>
