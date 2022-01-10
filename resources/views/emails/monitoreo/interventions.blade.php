<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css">
    <title>Intervenciones</title>
</head>

<body>
    <!-- responsive table-->
    <div class="mt-2">
        <table class="max-w-5xl mx-auto table-auto">
            <thead class="justify-between">
                <tr class="bg-green-600">

                    <th class="px-16 py-2">
                        <span class="text-gray-100 font-semibold">Día</span>
                    </th>

                    <th class="px-16 py-2">
                        <span class="text-gray-100 font-semibold">Hora</span>
                    </th>

                    <th class="px-16 py-2">
                        <span class="text-gray-100 font-semibold">Detalle</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-200">
                @foreach ($interventions as $intervention)
                    <tr class="bg-white border-b-2 border-gray-200">
                        <td class="px-16 py-2 flex flex-row items-center">
                            <span>{{ $intervention->date }}</span>
                        </td>


                        <td class="px-16 py-2 items-center">
                            <span> {{ $intervention->hour }}
                            </span>
                        </td>
                        <td class="px-16 py-2">
                            <span>{{ $intervention->detail }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-gray-900 mt-10">
        <footer class="flex flex-wrap items-center justify-between p-3 m-auto">
            <div class="container mx-auto flex flex-col flex-wrap items-center justify-between">

                <ul class="flex mx-auto text-white text-center">
                    <a href="http://villaconstitucion.gov.ar"><img class="object-scale-down h-24 w-full" src="{{asset('img/mvc-logo.png')}}" alt=""></a>
                </ul>
                <div class="flex mt-2 mx-auto text-white text-center">
                    <span> Dirección de Tecnología y Sistemas - {{ Date('Y') }}</span>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
