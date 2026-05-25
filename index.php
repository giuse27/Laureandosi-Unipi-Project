<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portale Laureandosi</title>

    <!-- Importo un font elegante da Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">

    <style>
        /* Reset base */
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Poppins', sans-serif;
            /* Sfondo sfumato animato (colori accademici/eleganti) */
            background: linear-gradient(-45deg, #0b132b, #1c2541, #3a506b, #1c2541);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: #ffffff;
            overflow: hidden;
        }

        /* Animazione dello sfondo */
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Contenitore principale per centrare la card */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            z-index: 10;
        }

        /* Stile Glassmorphism (Effetto Vetro) */
        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 90%;
            /* Animazione di entrata */
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1.2s ease-out forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Icona animata */
        .icon {
            font-size: 5rem;
            margin-bottom: 20px;
            display: inline-block;
            animation: floatIcon 3s ease-in-out infinite;
        }

        @keyframes floatIcon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* Stile della tipografia */
        h1 {
            font-size: 2.2rem;
            font-weight: 300;
            margin: 0;
            line-height: 1.4;
        }

        .highlight {
            font-weight: 600;
            /* Testo sfumato dorato */
            background: -webkit-linear-gradient(#f6d365, #ffb347);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 3.5rem;
            display: block;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 0px 5px 15px rgba(255, 179, 71, 0.2);
        }

        p.subtitle {
            font-size: 1.1rem;
            font-weight: 300;
            margin-top: 25px;
            color: #d1d5db;
        }

        /* Quadrati sfocati fluttuanti sullo sfondo (effetto particelle) */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particles li {
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.05);
            animation: rise 25s linear infinite;
            bottom: -150px;
        }

        /* Posizionamento casuale delle particelle */
        .particles li:nth-child(1) { left: 25%; width: 80px; height: 80px; animation-delay: 0s; }
        .particles li:nth-child(2) { left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s; }
        .particles li:nth-child(3) { left: 70%; width: 40px; height: 40px; animation-delay: 4s; }
        .particles li:nth-child(4) { left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s; }
        .particles li:nth-child(5) { left: 65%; width: 30px; height: 30px; animation-delay: 0s; }
        .particles li:nth-child(6) { left: 75%; width: 110px; height: 110px; animation-delay: 3s; }
        .particles li:nth-child(7) { left: 35%; width: 150px; height: 150px; animation-delay: 7s; }
        .particles li:nth-child(8) { left: 50%; width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s; }
        .particles li:nth-child(9) { left: 20%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 35s; }
        .particles li:nth-child(10) { left: 85%; width: 100px; height: 100px; animation-delay: 0s; animation-duration: 11s; }

        @keyframes rise {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; border-radius: 0; }
            100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; border-radius: 50%; }
        }
    </style>
</head>
<body>

<!-- Sfondo animato -->
<ul class="particles">
    <li></li><li></li><li></li><li></li><li></li>
    <li></li><li></li><li></li><li></li><li></li>
</ul>

<!-- Contenuto in primo piano -->
<div class="container">
    <div class="card">
        <span class="icon">🎓</span>
        <h1>Benvenuto nel portale <span class="highlight">Laureandosi</span></h1>
        <p class="subtitle">La piattaforma dedicata al tuo traguardo più importante.</p>
    </div>
</div>

</body>
</html>