    <!DOCTYPE html>
    <html lang="fr">
    <head>
    <meta charset="UTF-8">
    <title>Export CELCAT → ICS (abonnement)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        input[type=text] { width: 80%; padding: 0.5rem; }
        button { padding: 0.5rem 1rem; }
        code { background: #eee; padding: 2px 4px; }
    </style>
    </head>
    <body>
    <h1>Export CELCAT → ICS (abonnement)</h1>
    <form action="/convert" method="get">
        <label>URL de votre calendrier CELCAT :</label><br><br>
        <input type="text" name="celcat_url" placeholder="https://edt.univ-tlse3.fr/calendar/cal?...">
        <button type="submit">Afficher ICS</button>
    </form>

    <p>Pour un abonnement iPhone, utilisez l’URL :</p>
    <p>
        <code>webcal://votresite/convert?celcat_url=…</code>
    </p>
    </body>
    </html>
