<!DOCTYPE html>
<html>
<head>
    <title>Test de Traducción</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ccc; }
        .btn { padding: 10px 20px; margin: 5px; cursor: pointer; }
        .result { margin-top: 10px; padding: 10px; background: #f5f5f5; }
    </style>
</head>
<body>
    <h1>Test del Sistema de Traducción</h1>
    
    <div class="test-section">
        <h2>Test básico de traducción</h2>
        <p data-translatable>Hello, this is a test text for automatic translation.</p>
        <p data-translatable>This system allows translating dynamic content in real time.</p>
        <button class="btn" onclick="testTranslation()">Translate to Spanish</button>
        <button class="btn" onclick="restoreEnglish()">Restore English</button>
        <div id="result" class="result"></div>
    </div>

    <script>
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        async function testTranslation() {
            const result = document.getElementById('result');
            result.innerHTML = 'Translating...';

            try {
                const response = await fetch('/api/translate/text', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCSRFToken()
                    },
                    body: JSON.stringify({
                        text: 'Hello, this is a test text for automatic translation.',
                        target_language: 'es',
                        source_language: 'en'
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    result.innerHTML = `
                        <strong>Translation successful:</strong><br>
                        Original: ${data.original_text}<br>
                        Translated: ${data.translated_text}
                    `;
                } else {
                    result.innerHTML = `<strong>Error:</strong> ${data.message}`;
                }
            } catch (error) {
                result.innerHTML = `<strong>Error:</strong> ${error.message}`;
            }
        }

        function restoreEnglish() {
            const result = document.getElementById('result');
            result.innerHTML = 'Text restored to original English.';
        }
    </script>
</body>
</html>
