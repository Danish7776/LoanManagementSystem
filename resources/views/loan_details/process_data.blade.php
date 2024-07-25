<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f8f9fa;
    }
    h1 {
        color: #343a40;
    }
    p {
        font-size: 16px;
    }
    form {
        margin-bottom: 20px;
    }
    button {
        padding: 10px 20px;
        background-color: #007bff;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 5px;
    }
    button:hover {
        background-color: #0056b3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #dddddd;
    }
    th {
        background-color: #007bff;
        color: white;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
</style>

<body>
    <h1>Process Data</h1>
    
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('process.data.process') }}" method="POST">
        @csrf
        <button type="submit">Process Data</button>
    </form>

    @if(!empty($emiDetails))
        <h2>EMI Details</h2>
        <table>
            <thead>
                <tr>
                    @foreach(array_keys((array)$emiDetails->first()) as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($emiDetails as $detail)
                    <tr>
                        @foreach((array)$detail as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
