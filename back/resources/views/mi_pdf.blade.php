<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; margin-bottom: 20px; }
        h2 { margin-top: 30px; font-size: 16px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        td { font-size: 14px; }
    </style>
</head>
<body>
    <h1>Reporte de Consultas</h1>

    @foreach($consultas as $consulta)
        <h2>{{ $consulta['titulo'] }}</h2>
        
        <table>
            <thead>
                <tr>
                    @foreach($consulta['columnas'] as $columna)
                        <th>{{ ucfirst($columna) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($consulta['datos'] as $fila)
                    <tr>
                        @foreach($consulta['columnas'] as $columna)
                            <td>{{ $fila->$columna ?? 'N/A' }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($consulta['columnas']) }}">No hay datos disponibles</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

</body>
</html>