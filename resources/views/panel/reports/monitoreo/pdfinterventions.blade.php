<html>
<head>

    <style>
        
   .pagenum:before {
        content: counter(page);
    }
    </style>
   
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" integrity="undefined" crossorigin="anonymous">
</head>
<body>
    

<div class="card">
    <div class="card-header">
        asd
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($interventions as $intervention)
                    <tr>
                        <td>{{$intervention->date}}</td>
                        <td>{{$intervention->hour}}</td>
                        <td>{{$intervention->detail}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<footer class="fixed-bottom">
<span class="pagenum"></span>
</footer>

</body>
</html>


