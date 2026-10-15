<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Detector de Palíndromos - Laravel</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
<div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full">
    <h1 class="text-2xl font-bold text-slate-800 text-center mb-6">Verificador de Palíndromos</h1>
    
    <form id="palindromeForm" class="space-y-4">
        <div>
            <label for="text" class="block text-sm font-medium text-slate-700 mb-1">Ingresa una palabra o frase:</label>
            <input type="text" id="text" name="text" required placeholder="Ej: Anita lava la tina" 
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </div>
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition">
            Validar
        </button>
    </form>

    <div id="result" class="mt-6 p-4 rounded-xl hidden text-center font-medium"></div>
</div>

<script>
    document.getElementById('palindromeForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const text = document.getElementById('text').value;
        const resultDiv = document.getElementById('result');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch('/api/check-palindrome', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken 
                },
                body: JSON.stringify({ text })
            });

            const data = await response.json();
            resultDiv.classList.remove('hidden', 'bg-emerald-100', 'text-emerald-800', 'bg-rose-100', 'text-rose-800');

            if (data.is_palindrome) {
                resultDiv.classList.add('bg-emerald-100', 'text-emerald-800');
                resultDiv.textContent = `"${data.original_text}" ¡Es un palíndromo!`;
            } else {
                resultDiv.classList.add('bg-rose-100', 'text-rose-800');
                resultDiv.textContent = `"${data.original_text}" No es un palíndromo.`;
            }
        } catch (error) {
            console.error('Error procesando solicitud:', error);
        }
    });
</script>
</body>
</html>
