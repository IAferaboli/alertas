@extends('beautymail::templates.minty')

@section('content')



    @include('beautymail::templates.minty.contentStart')

    <tr>
        <td colspan="3" style="text-align: center">
            <h2> Parte diario del día {{ $date }} </h2>
        </td>
    </tr>

    @if ($interventions->count())

        <tr>
            {{-- <td width="100%" height="10"></td> --}}
            <td class="title" width="20%">Día</td>
            <td class="title" width="20%">Hora</td>
            <td class="title" width="80%">Detalle</td>

        </tr>
        <tr>
            <td height="15"></td>
        </tr>


        @foreach ($interventions as $intervention)
            <tr>
                <td width="20%" class="paragraph">{{ $intervention->date }}</td>
                <td width="20%" class="paragraph">{{ $intervention->hour }}</td>
                <td width="80%" class="paragraph">{{ $intervention->detail }}</td>
            </tr>
        @endforeach

    @else


        <tr>
            <td style="text-align: center">Jornada sin novedad.</td>
        </tr>


    @endif



    <tr>
        <td height="30"></td>
    </tr>
    {{-- <tr>
		<td colspan="3">
			@include('beautymail::templates.minty.button', ['text' => 'Sign in', 'link' => '#'])
		</td>
	</tr> --}}
    <tr>
        <td colspan="3" width="auto" style="text-align: center">
            <a href="www.villaconstitucion.gob.ar"><img width="10%" src="http://villaconstitucion.gob.ar/wp-content/themes/wp-mvc-2/assets/images/logo.png" alt=""></a>
        </td>
    </tr>

    <tr>
        <td colspan="3" width="auto" style="text-align: center">
            <h5>App. creada por la Dirección de Sistemas y Tecnología - {{ Date('Y') }}</h5>
        </td>
    </tr>
    <tr>
        <td height="15"></td>
    </tr>


    @include('beautymail::templates.minty.contentEnd')

@stop
