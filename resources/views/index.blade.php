<!-- resources/views/index.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Números Romanos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Conversor de Números Romanos</h1>

        <form action="{{ url('/convert') }}" method="POST">
            @csrf
            <label for="number">Número:</label>
            <input type="text" id="number" name="number" required placeholder="Digite o número">

            <label for="conversion_type">Tipo de Conversão:</label>
            <select id="conversion_type" name="conversion_type" required>
                <option value="roman_to_integer">Romano para Inteiro</option>
                <option value="integer_to_roman">Inteiro para Romano</option>
            </select>

            <button type="submit">Converter</button>
        </form>

        @if(session('result'))
            <div class="result">
                <p>Resultado: {{ session('result') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="error">
                <p>Erro: {{ session('error') }}</p>
            </div>
        @endif
    </div>
</body>
</html>
