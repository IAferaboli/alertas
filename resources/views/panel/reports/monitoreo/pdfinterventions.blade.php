<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">

    <style>
        @page {
            margin: 0px 0px;
        }

        body {
            margin-top: 3cm;
            margin-bottom: 2cm;
            margin-left: 2cm;
            margin-right: 2cm;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        .pagenum:before {
            content: counter(page);
        }

    </style>
</head>

<body>


    <header>
        <img style="width: 100%" src="{{ asset('img/superior.jpg') }}" alt="">
    </header>

    <main>

        <!-- This example requires Tailwind CSS v2.0+ -->
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th scope="col" class="px-1 py-1 text-left text-xs font-medium  uppercase tracking-wider">
                        Fecha
                    </th>
                    <th scope="col" class="px-1 py-1 text-left text-xs font-medium  uppercase tracking-wider">
                        Hora
                    </th>
                    <th scope="col" class="px-1 py-1 text-left text-xs font-medium uppercase tracking-wider">
                        Intervención
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                {{-- @foreach ($interventions as $intervention)

                    <tr>
                        <td class="px-0 py-0 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $intervention->date }}</div>
                        </td>
                        <td class="px-0 py-0 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $intervention->hour }}</div>
                        </td>
                        <td class="px-0 py-0 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $intervention->detail }}</div>
                        </td>

                    </tr>
                @endforeach --}}

                <!-- More people... -->
            </tbody>
        </table>
    </main>

    <footer>
        <div class="text-center">
            <small>Reporte creado desde {{ env('APP_NAME') }} - {{ date('d/m/Y - H:i:s') }} - Página</small>
            <small class="pagenum"></small>
        </div>
    </footer>

</body>

</html>
