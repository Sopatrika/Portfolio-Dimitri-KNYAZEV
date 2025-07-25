<?php
// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    // 1. Validation des entrées
    $requiredFields = ['nom', 'email', 'message'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            http_response_code(400);
            exit(json_encode(['success' => false, 'message' => 'Tous les champs sont requis']));
        }
    }

    // 2. Nettoyage des données
    $data = [
        'nom' => htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8'),
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
        'message' => htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8')
    ];

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        exit(json_encode(['success' => false, 'message' => 'Email invalide']));
    }

    // 3. Envoi à Discord
    $webhookUrl = 'https://discord.com/api/webhooks/1387918061364838572/ITeExIgCkn36-AV2tzJz9kK-UYIKqAINO7cGVN5-chmjOxuvrbzgea9JXU-6Sa9jZDa8'; // REMPLACER
    
    $payload = [
        'username' => 'Nouveau message !!!!!!',
        'embeds' => [[
            'title' => '📨 Contact',
            'color' => 0x3498db,
            'fields' => [
                ['name' => 'Nom', 'value' => $data['nom'], 'inline' => true],
                ['name' => 'Email', 'value' => $data['email'], 'inline' => true],
                ['name' => 'Message', 'value' => substr($data['message'], 0, 1000)]
            ],
            'footer' => [
                'text' => 'Envoyé le ' . date('d/m/Y à H:i')
            ],
            'timestamp' => date('c')
        ]]
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($payload),
            'timeout' => 10
        ]
    ];

    $context = stream_context_create($options);
    $result = @file_get_contents($webhookUrl, false, $context);

    if ($result === false) {
        $error = error_get_last();
        http_response_code(500);
        exit(json_encode([
            'success' => false,
            'message' => 'Erreur lors de la communication avec Discord',
            'debug' => $error['message'] ?? 'Erreur inconnue'
        ]));
    }

    exit(json_encode(['success' => true, 'message' => 'Message envoyé avec succès']));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Portfolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Votre contenu HTML ici -->
    <script src="script.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dimitri KNYAZEV</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alef:wght@400;700&family=Sora:wght@100..800&display=swap" rel="stylesheet">
</head>

<body>
    <canvas id="particleCanvas"></canvas>
    <div class="responsive_ecran_sombre"></div>
    <header>
        <nav class="header_nav">
            <a href="#presentation_section">Présentation</a>
            <a href="#competence_section">Compétences</a>
            <a href="#projets_section">Créations</a>
            <a href="#cv_section">CV</a>
            <a href="#contact_section">Contact</a>
        </nav>
        <div class="reponsive_nav_header">
            <div class="responsive_button_header">
                <div class="responsive_button_header_barre"></div>
                <div class="responsive_button_header_barre"></div>
                <div class="responsive_button_header_barre"></div>
        </div>
            <div class="reponsive_nav_header_menu">
                <u><a href="#presentation_section">Présentation</a></u>
                <u><a href="#competence_section">Compétences</a></u>
                <u><a href="#projets_section">Créations</a></u>
                <u><a href="#cv_section">CV</a></u>
                <u><a href="#contact_section">Contact</a></u>
            </div>
        </div>
    </header>
    <div class="intro-overlay">
        <div class="intro_titre">Bienvenue sur mon Portfolio</div>
        <div class="loading-bar"></div>
    </div>
    <main>
        <div class="homepage">
            <div class="homepage_flex">
                <div class="homepage_reseaux">
                    <div><a href="https://www.linkedin.com/in/dimitri-knyazev-77754132b/" target="_blank"><img src="img/icons8-linkedin-50.png" alt="" class="icones"></a></div>
                   <div><a href="https://github.com/Sopatrika" ><svg class="icones" width="40px" height="40px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>github [#142]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-140.000000, -7559.000000)" fill="#ffffff"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M94,7399 C99.523,7399 104,7403.59 104,7409.253 C104,7413.782 101.138,7417.624 97.167,7418.981 C96.66,7419.082 96.48,7418.762 96.48,7418.489 C96.48,7418.151 96.492,7417.047 96.492,7415.675 C96.492,7414.719 96.172,7414.095 95.813,7413.777 C98.04,7413.523 100.38,7412.656 100.38,7408.718 C100.38,7407.598 99.992,7406.684 99.35,7405.966 C99.454,7405.707 99.797,7404.664 99.252,7403.252 C99.252,7403.252 98.414,7402.977 96.505,7404.303 C95.706,7404.076 94.85,7403.962 94,7403.958 C93.15,7403.962 92.295,7404.076 91.497,7404.303 C89.586,7402.977 88.746,7403.252 88.746,7403.252 C88.203,7404.664 88.546,7405.707 88.649,7405.966 C88.01,7406.684 87.619,7407.598 87.619,7408.718 C87.619,7412.646 89.954,7413.526 92.175,7413.785 C91.889,7414.041 91.63,7414.493 91.54,7415.156 C90.97,7415.418 89.522,7415.871 88.63,7414.304 C88.63,7414.304 88.101,7413.319 87.097,7413.247 C87.097,7413.247 86.122,7413.234 87.029,7413.87 C87.029,7413.87 87.684,7414.185 88.139,7415.37 C88.139,7415.37 88.726,7417.2 91.508,7416.58 C91.513,7417.437 91.522,7418.245 91.522,7418.489 C91.522,7418.76 91.338,7419.077 90.839,7418.982 C86.865,7417.627 84,7413.783 84,7409.253 C84,7403.59 88.478,7399 94,7399" id="github-[#142]"> </path> </g> </g> </g> </g></svg></a></div>
                   <div><a href="https://www.instagram.com/dimitri_knyazev/"></a><img src="img/instagram-svgrepo-com.svg" alt="" class="icones"></div>
                </div>
                <div class="titres">
                    <h1 class="Titre">DIMITRI KNYAZEV</h1>
                    <div class="sous_titre">Je code l’interface et l’infrastructure de vos idées</div>
            </div>
        </div>
        <a href="#projets_section" class="homepage_scrollbar"><span>Découvrir mon travail</span><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#efeeff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v13M5 12l7 7 7-7"/></svg></a>
    </div>
    <!-------------------------------------------------------->
    <!-------------------- Présentation ---------------------->
    <!-------------------------------------------------------->
        <div class="presentation_section" id="presentation_section">
            <div class="presentation_section_left">
                <h1>A PROPOS DE MOI</h1>
                <p class="intro_section">Passionné par le développement web, je me spécialise dans la création de sites et d'applications modernes dans la formation du BUT Métiers du Multimédia et de l’Internet (MMI) durant lequel développé plusieurs projets personnels et professionnels qui m’ont permis de consolider mes compétences en HTML, CSS, JavaScript, PHP et MySQL.</p>
                <div class="section_interet_parcours">
                    <div class="section_interet_parcours_more">
                        <h2>Centres d'interêt</h2>
                        <ul>
                            <div class="section_centre_interet_parcours_more">
                                <img class="icones" src="img/icons8-développement-web-50 (1).png" alt="">
                                <li>Développement Web</li>
                            </div>
                            <div class="section_centre_interet_parcours_more">
                                <img class="icones" src="img/icons8-manette-50.png" alt="">
                                <li>Jeux-vidéos</li>
                            </div>
                        <div class="section_centre_interet_parcours_more">
                            <img class="icones" src="img/icons8-dessin-50.png" alt="">
                            <li>Dessin</li>
                        </div>
                        <div class="section_centre_interet_parcours_more">
                            <img class="icones" src="img/icons8-histoire-50.png" alt="">
                            <li>Histoire</li>
                        </div>
                        <div class="section_centre_interet_parcours_more">
                            <img class="icones" src="img/icons8-manga-48.png" alt="">
                            <li>Manga</li>
                        </div>
                        <div class="section_centre_interet_parcours_more">
                            <img class="icones" src="img/icons8-musculation-50.png" alt="">
                            <li>Musculation</li>
                        </div>
                    </ul>
                </div>
                
                <div class="section_interet_parcours_more">
                        <h2>Parcours</h2>
                        <ul>
                            <div class="section_centre_interet_parcours_more">
                                <li><b>2022-2024 : </b></li>
                                <p>Baccalauréat Technologique Sciences et Technologies de l'Industrie et du Développement Durable (STI2D) au lycée Louis Armand à Mulhouse.</p>
                            </div>
                            <div class="section_centre_interet_parcours_more">
                                <li><b>2024-2027 : </b></li>
                                <p>BUT Métiers du Multimédia et de l'Internet - Parcours Développement Web à l'IUT de Mulhouse.</p>
                            </div>
                    </ul>
                </div>
                </div>
            </div>
        </div>
        <!-------------------------------------------------------->
        <!--------------------- compétence ----------------------->
        <!-------------------------------------------------------->
        <div class="competence_section" id="competence_section">
            <h1>COMPETENCES</h1>
            <div class="competence_section_grid">
    <!-- Première paire -->
    <div class="desc_competence">
        <b>Développement Web</b>
    </div>
    <div class="bloc_competence">
        <div class="section_bloc_competence">
                        <b>Frontend</b>
                    <div class="element_competences">
                        <svg class="icones_competences" width="40px" height="40px" viewBox="0 0 20.00 20.00" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>html [#124]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke-width="0.0002" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-61.000000, -7639.000000)" fill="#EFEEFF"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M19.4350881,7485 L19.4279481,7485 L10.8119794,7485 L11.0180201,7487 L19.2300674,7487 C19.109707,7488.752 18.7455658,7492.464 18.6119454,7494.153 L13.99949,7495.451 L13.99949,7495.455 L13.98929,7495.46 L9.37377458,7493.836 L9.05757353,7490 L11.3199411,7490 L11.4800816,7492.063 L13.99337,7493 L13.99949,7493 L16.5086984,7492.1 L16.7667592,7489 L8.95659319,7489 C8.91885306,7488.599 8.43333144,7483.392 8.34867116,7483 L19.6370488,7483 C19.5738086,7483.66 19.5095484,7484.338 19.4350881,7485 L19.4350881,7485 Z M5,7479 L6.63812546,7497.148 L13.98929,7499 L21.3598345,7497.111 L23,7479 L5,7479 Z" id="html-[#124]"> </path> </g> </g> </g> </g></svg>
                        <div>HTML</div>
                    </div>
                    <div class="element_competences">
                        <svg class="icones_competences" fill="#ffffff" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="c133de6af664cd4f011a55de6b001b19"> <path display="inline" d="M483.111,0.501l-42.59,461.314l-184.524,49.684L71.47,461.815L28.889,0.501H483.111z M397.29,94.302 H255.831H111.866l6.885,55.708h137.08h7.7l-7.7,3.205l-132.07,55.006l4.38,54.453l127.69,0.414l68.438,0.217l-4.381,72.606 l-64.058,18.035v-0.057l-0.525,0.146l-61.864-15.617l-3.754-45.07h-0.205H132.1h-0.202l7.511,87.007l116.423,34.429v-0.062 l0.21,0.062l115.799-33.802l15.021-172.761h-131.03h-0.323l0.323-0.14l135.83-58.071L397.29,94.302z"> </path> </g> </g></svg>
                        <div>CSS</div>
                    </div>
                    <div class="element_competences">
                        <svg class="icones_competences" fill="#ffffff" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="5151e0c8492e5103c096af88a51e75c7"> <path display="inline" fill-rule="evenodd" clip-rule="evenodd" d="M1.008,0.5C0.438,0.583,0.48,1.27,0.521,1.958 c0,169.668,0,339.31,0,508.974c169.364,1.135,340.808,0.162,510.979,0.486c0-170.309,0-340.61,0-510.918 C341.342,0.5,171.167,0.5,1.008,0.5z M259.893,452.167c-11.822,11.919-30.478,18.938-53.429,18.938 c-37.643,0-58.543-18.34-71.884-43.711c12.842-8.2,25.966-16.122,39.344-23.795c5.456,15.262,23.886,32.42,44.683,21.857 c13.183-6.699,11.661-27.01,11.661-49.054c0-45.773,0-98.578,0-139.872c-0.042-0.688-0.083-1.375,0.482-1.458 c15.707,0,31.413,0,47.116,0c0,36.788,0,78.402,0,117.529C277.866,395.199,280.91,430.988,259.893,452.167z M470.696,409.917 c-2.674,39.884-35.243,61.063-79.17,61.188c-43.062,0.124-70.624-19.013-87.433-48.567c12.085-8.317,25.778-15.017,38.375-22.822 c10.08,15.761,27.537,30.91,53.429,28.652c16.131-1.406,34.856-14.555,24.285-34.482c-5.127-9.66-17.516-14.567-28.656-19.425 c-35.352-15.424-76.828-29.571-72.861-84.992c1.327-18.514,9.852-31.525,20.889-40.796c11.311-9.5,26.46-15.867,46.629-16.511 c36.629-1.173,56.723,15.12,70.429,37.884c-11.664,8.891-24.514,16.608-37.401,24.281c-4.229-12.995-24.644-25.658-41.772-17.969 c-7.789,3.493-14.788,13.761-10.684,26.224c3.66,11.115,18.589,17.199,30.599,22.344 C433.706,340.486,474.331,355.693,470.696,409.917z"> </path> </g> </g></svg>
                        <div>JavaScript</div>
                    </div>
                </div>
        <div class="section_bloc_competence">
                        <b>Backend</b>
                    <div class="element_competences">
                        <svg class="icones_competences" fill="#ffffff" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>php</title> <path d="M23.205 13.759h-1.178l-0.645 3.309h1.047c0.056 0.004 0.122 0.007 0.188 0.007 0.507 0 0.978-0.149 1.374-0.405l-0.010 0.006c0.371-0.33 0.623-0.786 0.688-1.301l0.001-0.010c0.048-0.138 0.076-0.296 0.076-0.461 0-0.291-0.087-0.562-0.236-0.788l0.003 0.005c-0.297-0.234-0.676-0.376-1.089-0.376-0.077 0-0.154 0.005-0.229 0.015l0.009-0.001zM26.448 15.486c-0.075 0.398-0.208 0.753-0.39 1.076l0.009-0.017c-0.194 0.338-0.427 0.628-0.698 0.876l-0.003 0.002c-0.316 0.302-0.699 0.538-1.125 0.682l-0.021 0.006c-0.441 0.131-0.947 0.207-1.472 0.207-0.048 0-0.095-0.001-0.142-0.002l0.007 0h-1.475l-0.409 2.102h-1.722l1.537-7.905h3.31c0.073-0.007 0.159-0.011 0.245-0.011 0.754 0 1.438 0.304 1.934 0.796l-0-0c0.319 0.41 0.512 0.933 0.512 1.5 0 0.245-0.036 0.482-0.103 0.705l0.004-0.017zM16.955 18.317l0.679-3.498c0.035-0.095 0.055-0.204 0.055-0.318 0-0.183-0.052-0.354-0.142-0.499l0.002 0.004c-0.195-0.142-0.439-0.228-0.703-0.228-0.055 0-0.109 0.004-0.162 0.011l0.006-0.001h-1.365l-0.88 4.53h-1.709l1.537-7.906h1.708l-0.409 2.102h1.522c0.093-0.010 0.2-0.016 0.309-0.016 0.625 0 1.205 0.193 1.683 0.524l-0.010-0.006c0.257 0.291 0.414 0.676 0.414 1.097 0 0.188-0.031 0.369-0.089 0.538l0.003-0.012-0.715 3.679zM11.926 17.423c-0.316 0.303-0.699 0.538-1.125 0.682l-0.021 0.006c-0.441 0.131-0.947 0.207-1.471 0.207-0.047 0-0.095-0.001-0.142-0.002l0.007 0h-1.476l-0.409 2.101h-1.722l1.537-7.905h3.312c0.073-0.007 0.159-0.011 0.245-0.011 0.754 0 1.438 0.304 1.934 0.796l-0-0c0.319 0.41 0.511 0.933 0.511 1.5 0 0.246-0.036 0.483-0.103 0.707l0.004-0.017c-0.146 0.774-0.533 1.441-1.079 1.934l-0.003 0.003zM16 8.112c-8.281 0-14.996 3.531-14.996 7.888s6.714 7.889 14.996 7.889 14.996-3.533 14.996-7.889-6.714-7.888-14.996-7.888zM9.764 13.759h-1.18l-0.644 3.309h1.047c0.056 0.004 0.121 0.007 0.187 0.007 0.507 0 0.979-0.149 1.375-0.405l-0.010 0.006c0.371-0.329 0.622-0.786 0.686-1.301l0.001-0.010c0.049-0.138 0.077-0.297 0.077-0.462 0-0.29-0.086-0.561-0.235-0.786l0.003 0.005c-0.297-0.234-0.676-0.376-1.089-0.376-0.077 0-0.154 0.005-0.229 0.015l0.009-0.001z"></path> </g></svg>
                        <div>PHP</div>
                    </div>
                    <div class="element_competences">
                        <svg class="icones_competences" fill="#ffffff" height="40px" width="40px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 490.667 490.667" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M245.333,0C172.928,0,96,22.421,96,64v192c0,42.027,75.115,64,149.333,64s149.333-21.973,149.333-64V64 C394.667,22.421,317.739,0,245.333,0z M373.333,256c0,20.181-52.565,42.667-128,42.667s-128-22.485-128-42.667v-29.909 c27.883,19.584,78.933,29.909,128,29.909s100.117-10.325,128-29.909V256z M373.333,192c0,17.813-48.704,42.667-128,42.667 s-128-24.853-128-42.667v-29.909c27.883,19.584,78.933,29.909,128,29.909s100.117-10.325,128-29.909V192z M373.333,128 c0,17.813-48.704,42.667-128,42.667s-128-24.853-128-42.667V98.091c27.883,19.584,78.933,29.909,128,29.909 s100.117-10.325,128-29.909V128z M245.333,106.667c-79.296,0-128-24.853-128-42.667c0-17.813,48.704-42.667,128-42.667 s128,24.853,128,42.667C373.333,81.813,324.629,106.667,245.333,106.667z"></path> </g> </g> <g> <g> <path d="M248.661,384.405l-3.157-0.533C226.795,380.821,224,375.957,224,373.333c0-4.245,8.512-10.667,21.355-10.667 c12.608,0,20.928,5.995,21.355,10.304c0.555,5.867,5.739,10.389,11.627,9.6c5.867-0.555,10.155-5.76,9.6-11.627 c-1.621-16.896-19.925-29.632-42.603-29.632c-23.936,0-42.688,14.059-42.688,32c0,16.704,13.248,27.328,39.403,31.595 l1.728-10.517l1.429,11.051c17.728,2.923,21.44,7.36,21.44,10.56c0,4.245-8.512,10.667-21.355,10.667 c-12.608,0-20.928-6.016-21.355-10.325c-0.555-5.867-5.611-10.24-11.627-9.6c-5.867,0.555-10.155,5.76-9.6,11.627 C204.331,435.264,222.635,448,245.312,448C269.248,448,288,433.941,288,416C288,399.317,274.773,388.693,248.661,384.405z"></path> </g> </g> <g> <g> <path d="M394.667,373.333c0-17.643-14.357-32-32-32h-21.333c-17.643,0-32,14.357-32,32V416c0,17.643,14.357,32,32,32h21.333 c4.928,0,9.536-1.216,13.696-3.2l0.085,0.085c2.091,2.069,4.821,3.115,7.552,3.115s5.461-1.045,7.531-3.115 c4.16-4.16,4.16-10.923,0-15.083l-0.085-0.085c2.005-4.16,3.221-8.789,3.221-13.717V373.333z M373.333,411.605l-3.136-3.136 c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.16-4.16,10.923,0,15.083l3.115,3.115h-16.896c-5.888,0-10.667-4.779-10.667-10.667 v-42.667c0-5.888,4.779-10.667,10.667-10.667h21.333c5.888,0,10.667,4.779,10.667,10.667V411.605z"></path> </g> </g> <g> <g> <path d="M469.333,426.667h-32V352c0-5.888-4.779-10.667-10.667-10.667c-5.888,0-10.667,4.779-10.667,10.667v85.333 c0,5.888,4.779,10.667,10.667,10.667h42.667c5.888,0,10.667-4.779,10.667-10.667C480,431.445,475.221,426.667,469.333,426.667z"></path> </g> </g> <g> <g> <path d="M175.445,385.109c-5.291-2.624-11.669-0.491-14.315,4.779l-11.797,23.616l-11.797-23.595 c-2.645-5.269-9.045-7.403-14.315-4.779c-5.269,2.645-7.424,9.045-4.779,14.315l18.965,37.909l-18.944,37.867 c-2.624,5.269-0.491,11.669,4.779,14.315c1.536,0.768,3.157,1.131,4.757,1.131c3.904,0,7.659-2.155,9.557-5.909l42.667-85.333 C182.848,394.155,180.715,387.755,175.445,385.109z"></path> </g> </g> <g> <g> <path d="M88.704,341.888c-4.331-1.472-9.152,0.043-11.904,3.712l-23.467,31.275L29.867,345.6 c-2.752-3.669-7.509-5.184-11.904-3.712c-4.352,1.451-7.296,5.525-7.296,10.112v85.333c0,5.888,4.779,10.667,10.667,10.667 S32,443.221,32,437.333V384l12.8,17.067c4.032,5.376,13.056,5.376,17.067,0L74.667,384v53.333c0,5.888,4.779,10.667,10.667,10.667 S96,443.221,96,437.333V352C96,347.413,93.056,343.339,88.704,341.888z"></path> </g> </g> </g></svg>
                        <div>MySQL</div>
                    </div>
                    </div>
        <div class="section_bloc_competence">
                        <b>Logiciel et CMS</b>
                    <div class="element_competences">
                        <svg class="icones_competences" width="40px" height="40px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>wordpress [#139]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-260.000000, -7559.000000)" fill="#ffffff"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M222.775,7404.202 C222.818,7404.521 222.842,7404.862 222.842,7405.23 C222.842,7406.988 222.679,7407.087 219.027,7417.644 C222,7415.91 224,7412.689 224,7409 C224,7407.261 223.556,7405.626 222.775,7404.202 L222.775,7404.202 Z M214.176,7409.875 L211.175,7418.593 C213.2,7419.189 215.346,7419.128 217.321,7418.434 C217.294,7418.391 217.27,7418.345 217.25,7418.296 L214.176,7409.875 Z M220.751,7408.495 C220.751,7407.259 220.307,7406.403 219.926,7405.737 C219.42,7404.913 218.944,7404.216 218.944,7403.392 C218.944,7402.473 219.642,7401.617 220.624,7401.617 C220.668,7401.617 220.71,7401.623 220.753,7401.625 C218.974,7399.995 216.604,7399 214,7399 C210.507,7399 207.433,7400.792 205.645,7403.507 C206.282,7403.527 207.137,7403.535 208.954,7403.393 C209.493,7403.361 209.556,7404.153 209.018,7404.216 C209.018,7404.216 208.476,7404.28 207.873,7404.312 L211.515,7415.144 L213.703,7408.58 L212.145,7404.311 C211.607,7404.28 211.097,7404.216 211.097,7404.216 C210.558,7404.184 210.621,7403.36 211.16,7403.392 C213.227,7403.551 214.285,7403.563 216.459,7403.392 C216.998,7403.36 217.062,7404.152 216.523,7404.216 C216.523,7404.216 215.98,7404.28 215.378,7404.311 L218.992,7415.061 C220.419,7410.293 220.751,7409.495 220.751,7408.495 L220.751,7408.495 Z M204,7409 C204,7412.958 206.3,7416.379 209.636,7418 L204.866,7404.93 C204.311,7406.174 204,7407.55 204,7409 L204,7409 Z" id="wordpress-[#139]"> </path> </g> </g> </g> </g></svg>
                        <div>Wordpress</div>
                    </div>
                    <div class="element_competences">
                        <svg class="icones_competences" fill="#ffffff" width="40px" height="40px" viewBox="0 0 32 32" id="Camada_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M28,25.6l-5.9,2.4l-9.7-9.6l-6.1,4.8L4,21.9V10.1l2.3-1.2l6.1,4.8L22.1,4L28,6.4V25.6z M15.7,16l6.3,5l0,0V11L15.7,16 L15.7,16z M6.3,19.7L6.3,19.7L10,16l-3.6-3.7l0,0L6.3,19.7L6.3,19.7z"></path></g></svg>
                        <div>VS Code</div>
                    </div>
                    <div class="element_competences">
                        <svg class="icones_competences" width="40px" height="40px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>github [#142]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-140.000000, -7559.000000)" fill="#ffffff"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M94,7399 C99.523,7399 104,7403.59 104,7409.253 C104,7413.782 101.138,7417.624 97.167,7418.981 C96.66,7419.082 96.48,7418.762 96.48,7418.489 C96.48,7418.151 96.492,7417.047 96.492,7415.675 C96.492,7414.719 96.172,7414.095 95.813,7413.777 C98.04,7413.523 100.38,7412.656 100.38,7408.718 C100.38,7407.598 99.992,7406.684 99.35,7405.966 C99.454,7405.707 99.797,7404.664 99.252,7403.252 C99.252,7403.252 98.414,7402.977 96.505,7404.303 C95.706,7404.076 94.85,7403.962 94,7403.958 C93.15,7403.962 92.295,7404.076 91.497,7404.303 C89.586,7402.977 88.746,7403.252 88.746,7403.252 C88.203,7404.664 88.546,7405.707 88.649,7405.966 C88.01,7406.684 87.619,7407.598 87.619,7408.718 C87.619,7412.646 89.954,7413.526 92.175,7413.785 C91.889,7414.041 91.63,7414.493 91.54,7415.156 C90.97,7415.418 89.522,7415.871 88.63,7414.304 C88.63,7414.304 88.101,7413.319 87.097,7413.247 C87.097,7413.247 86.122,7413.234 87.029,7413.87 C87.029,7413.87 87.684,7414.185 88.139,7415.37 C88.139,7415.37 88.726,7417.2 91.508,7416.58 C91.513,7417.437 91.522,7418.245 91.522,7418.489 C91.522,7418.76 91.338,7419.077 90.839,7418.982 C86.865,7417.627 84,7413.783 84,7409.253 C84,7403.59 88.478,7399 94,7399" id="github-[#142]"> </path> </g> </g> </g> </g></svg>
                        <div>Github</div>
                    </div>
                    </div>
    </div>
    <!-- Deuxième paire -->
    <div class="desc_competence">
        <b>Graphisme</b>
    </div>
    <div class="bloc_competence">
        <div class="element_competences"><div>Figma</div><svg class="icones_competences" fill="#ffffff" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>figma</title> <path d="M20.692 12.227c-2.084 0-3.773 1.689-3.773 3.773s1.689 3.773 3.773 3.773v0h0.122c2.084 0 3.773-1.689 3.773-3.773s-1.689-3.773-3.773-3.773v0zM20.814 21.611h-0.122c-3.099 0-5.611-2.512-5.611-5.611s2.512-5.611 5.611-5.611v0h0.122c3.099 0 5.611 2.512 5.611 5.611s-2.512 5.611-5.611 5.611v0zM11.186 21.611c-0 0-0.001 0-0.001 0-2.084 0-3.773 1.689-3.773 3.773s1.689 3.773 3.773 3.773c0.011 0 0.023-0 0.034-0h-0.002c0.003 0 0.007 0 0.011 0 2.121 0 3.843-1.714 3.854-3.833v-3.713zM11.216 30.996c-0.013 0-0.029 0-0.045 0-3.099 0-5.611-2.512-5.611-5.611s2.512-5.611 5.611-5.611c0.005 0 0.010 0 0.015 0h5.733v5.55c-0.012 3.135-2.557 5.672-5.693 5.672-0.003 0-0.006 0-0.009 0h0zM11.186 12.227c-2.084 0-3.773 1.689-3.773 3.773s1.689 3.773 3.773 3.773v0h3.895v-7.545zM16.918 21.611h-5.732c-3.099 0-5.611-2.512-5.611-5.611s2.512-5.611 5.611-5.611v0h5.733v11.222zM11.186 2.843c-2.084 0-3.773 1.689-3.773 3.773s1.689 3.773 3.773 3.773v0h3.895v-7.547zM16.918 12.227h-5.732c-3.099 0-5.612-2.512-5.612-5.612s2.512-5.612 5.612-5.612v0h5.733v11.223zM16.918 10.389h3.895c2.080-0.005 3.764-1.692 3.764-3.773s-1.684-3.768-3.764-3.773h-3.895zM20.814 12.227h-5.733v-11.223h5.733c3.099 0 5.612 2.512 5.612 5.612s-2.512 5.612-5.612 5.612v0z"></path> </g></svg></div>
        <div class="element_competences"><div>Photoshop</div><svg class="icones_competences" fill="#ffffff" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="2069a460dcf28295e231f3111e037552"> <path display="inline" d="M426.333,0.5H85.667C38.825,0.5,0.5,38.825,0.5,85.667v340.667c0,46.842,38.325,85.167,85.167,85.167 h340.667c46.842,0,85.167-38.325,85.167-85.167V85.667C511.5,38.825,473.175,0.5,426.333,0.5z M245.329,260.524 c-17.736,17.736-45.611,26.065-77.103,26.065c-8.326,0-15.927-0.365-21.72-1.451v91.945h-44.159V136.363 c15.927-2.895,38.009-5.069,68.05-5.069c32.582,0,56.473,6.878,72.039,19.911c14.48,11.947,23.89,31.131,23.89,53.936 C266.325,228.309,259.086,247.492,245.329,260.524z M337.981,380.706c-21.358,0-40.542-5.069-53.574-12.31l8.687-32.216 c10.135,6.154,29.322,12.671,45.249,12.671c19.545,0,28.236-7.964,28.236-19.549c0-11.943-7.239-18.099-28.96-25.7 c-34.391-11.947-48.866-30.769-48.505-51.403c0-31.131,25.7-55.383,66.604-55.383c19.549,0,36.562,5.069,46.695,10.496 l-8.687,31.493c-7.602-4.342-21.721-10.135-37.285-10.135c-15.928,0-24.615,7.602-24.615,18.46c0,11.224,8.326,16.655,30.77,24.618 c31.854,11.582,46.696,27.871,47.058,53.937C409.653,357.539,384.678,380.706,337.981,380.706z M221.8,206.95 c0,28.598-20.273,44.887-53.574,44.887c-9.049,0-16.289-0.362-21.72-1.809v-82.534c4.708-1.085,13.395-2.171,25.704-2.171 C202.979,165.323,221.8,179.803,221.8,206.95z"> </path> </g> </g></svg></div>
        <div class="element_competences"><div>Illustrator</div><svg class="icones_competences" fill="#ffffff" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="2069a460dcf28295e231f3111e03585e"> <path display="inline" d="M227.593,217.991l19.188,60.091h-62.627l18.825-60.091c4.346-14.48,7.964-31.493,11.582-45.611h0.724 C218.906,186.499,222.886,203.149,227.593,217.991z M511.5,85.667v340.667c0,46.842-38.325,85.167-85.167,85.167H85.667 C38.825,511.5,0.5,473.175,0.5,426.333V85.667C0.5,38.825,38.825,0.5,85.667,0.5h340.667C473.175,0.5,511.5,38.825,511.5,85.667z M324.246,380.885l-79.279-243.977h-56.83l-78.189,243.977h45.973l20.997-69.14h77.465l22.082,69.14H324.246z M399.52,204.597 h-44.888v176.288h44.888V204.597z M402.052,155.368c-0.362-13.756-9.772-24.252-24.977-24.252 c-14.842,0-24.976,10.496-24.976,24.252c0,13.395,9.772,23.891,24.614,23.891C392.279,179.258,402.052,168.762,402.052,155.368z"> </path> </g> </g></svg></div>
    </div>
    <!-- Troisième paire -->
    <div class="desc_competence">
        <b>Autre compétences</b>
    </div>
    <div class="bloc_competence">
        <div class="element_competences"><div>Premiere Pro</div><svg class="icones_competences" fill="#ffffff" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>adobepremierepro</title> <path d="M25.347 12.001v2.437c0 0.1-0.062 0.137-0.2 0.137-0.059-0.002-0.128-0.004-0.197-0.004-0.797 0-1.554 0.172-2.236 0.48l0.034-0.014c-0.25 0.114-0.462 0.27-0.636 0.461l-0.001 0.002v6.373c0 0.125-0.050 0.175-0.162 0.175h-2.462c-0.008 0.001-0.017 0.002-0.026 0.002-0.089 0-0.162-0.066-0.173-0.151l-0-0.001v-6.973l-0.012-0.937-0.025-0.975c0-0.287-0.025-0.562-0.050-0.85-0.001-0.005-0.001-0.012-0.001-0.018 0-0.056 0.037-0.104 0.088-0.119l0.001-0h2.224c0 0 0 0 0.001 0 0.121 0 0.223 0.085 0.249 0.198l0 0.002c0.103 0.329 0.163 0.707 0.163 1.098 0 0.018-0 0.036-0 0.054l0-0.003c0.376-0.432 0.823-0.792 1.325-1.062l0.025-0.012c0.542-0.307 1.191-0.487 1.881-0.487 0.006 0 0.013 0 0.019 0h-0.001c0.006-0.001 0.013-0.001 0.020-0.001 0.080 0 0.146 0.060 0.155 0.138l0 0.001zM16.825 15.938c-0.5 0.69-1.185 1.218-1.982 1.515l-0.030 0.010c-0.775 0.271-1.668 0.428-2.597 0.428-0.075 0-0.151-0.001-0.226-0.003l0.011 0-0.625-0.012-0.537-0.012v4.011c0.001 0.008 0.002 0.016 0.002 0.025 0 0.079-0.061 0.144-0.139 0.15l-0 0h-2.424c-0.1 0-0.15-0.050-0.15-0.162v-12.859c0-0.087 0.037-0.137 0.125-0.137l0.7-0.012 0.95-0.025 1.087-0.025 1.137-0.012c0.063-0.002 0.137-0.003 0.211-0.003 0.846 0 1.658 0.143 2.415 0.406l-0.052-0.016c0.654 0.226 1.213 0.576 1.676 1.026l-0.001-0.001c0.392 0.393 0.702 0.868 0.903 1.397l0.009 0.027c0.181 0.483 0.286 1.041 0.287 1.624v0c0.002 0.053 0.004 0.116 0.004 0.179 0 0.926-0.281 1.785-0.763 2.499l0.010-0.016zM25.685 1.379h-19.369c-2.933 0-5.311 2.378-5.311 5.311v0 18.62c0 0.001 0 0.003 0 0.004 0 2.931 2.376 5.307 5.307 5.307 0.002 0 0.003 0 0.005 0h19.369c0.001 0 0.003 0 0.004 0 2.931 0 5.307-2.376 5.307-5.307 0-0.002 0-0.003 0-0.005v0-18.62c0-0.001 0-0.003 0-0.004 0-2.931-2.376-5.307-5.307-5.307-0.002 0-0.003 0-0.005 0h0zM13.688 11.526c-0.396-0.16-0.855-0.253-1.336-0.253-0.049 0-0.097 0.001-0.145 0.003l0.007-0q-0.681-0.014-1.362 0.025v4.199l0.487 0.025h0.662c0.002 0 0.004 0 0.005 0 0.512 0 1.004-0.082 1.465-0.234l-0.033 0.009c0.411-0.123 0.759-0.354 1.022-0.66l0.002-0.003c0.244-0.32 0.391-0.725 0.391-1.165 0-0.043-0.001-0.085-0.004-0.128l0 0.006c0.003-0.039 0.005-0.085 0.005-0.131 0-0.769-0.479-1.426-1.155-1.689l-0.012-0.004z"></path> </g></svg></div>
                    <div class="element_competences">Gestion de projet</div>
                    <div class="element_competences">Communication marketing</div>
    </div>
    <!-- Quatrième paire -->
    <div class="desc_competence">
        <b>Langues</b>
    </div>
    <div class="bloc_competence">
        <!-- Contenu du quatrième bloc -->
         <div class="element_competences"><div>Anglais B2</div><img class="icones_competences" src="https://upload.wikimedia.org/wikipedia/commons/8/83/Flag_of_the_United_Kingdom_%283-5%29.svg" alt=""></div>
         <div class="element_competences"><div>Allemand A2</div><img class="icones_competences" src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Flag_of_Germany.svg" alt=""></div>
    </div>
    <div class="competence_barre"></div>
</div>
</div>
<!-------------------------------------------------------->
<!------------------- Réalisations ----------------------->
<!-------------------------------------------------------->
        <div class="projets_section" id="projets_section">
            <h1>MES REALISATIONS</h1>
            <div class="projets_section_grid">
                <div class="bloc_projet">
                    <img src="img/image_projet_1.png" alt="image du projet">
                    <h3 class="titre_projet">Site des pays du monde</h3>
                    <div class="projet_desc">
                        <p>Un projet d'études dans lequel j'ai développé un site portant sur la liste de tous les pays du monde avec l'affichage de leurs données associés (Drapeau, Capitale, Population, etc...) mais aussi de leur villes, langues officielles et organisations internationales, et ceci à partir d'une base de données. Un classement permet de les classer par des catégories (population, nom...) par ordre croissant ou décroissant. Un formulaire permet également d'intégrer un pays à la base de donnée</p><a href="https://github.com/Sopatrika/SAE-203.git" class="lien_projet" target="_blank">Lien vers le projet Github</a></div>
                    </div>
                    <div class="bloc_projet">
                        <img src="img/image_projet_2.png" alt="image du projet">
                        <h3 class="titre_projet">Portfolio MMI</h3>
                        <div class="projet_desc"><p>Mon tout premier projet en BUT MMI ! Un site portfolio dans qui doit afficher toute les SAE (projets) en première année de BUT MMI avec leur compétences, leurs description et les cours associés et ceci à partir d'une structure de données en Javascript. Dans la liste des SAE, lorsqu'on clique sur l'une des SAE, une page se charge avec toute les informations de celle ci.</p><a href="https://github.com/Sopatrika/Site-Portfolio-pour-un-Projet-en-1-re-ann-e.git" class="lien_projet" target="_blank">Lien vers le projet Github</a></div>
                    </div>
                    <div class="bloc_projet">
                        <img src="img/image_projet_3.png" alt="image du projet">
                        <h3 class="titre_projet">Mon Portfolio</h3>
                        <div class="projet_desc"><p>Le site ou vous etes actuellement. Développé en première année de BUT MMI, je présente mes réalisations, mes compétences et mon parcours ici.</p> <a href="" target="_blank" class="lien_projet">Lien vers le projet</a></div>
                    </div>
                    <div class="bloc_projet">
                        <img src="img/image_projet_4.png" alt="image du projet">
                        <h3 class="titre_projet">Fiche Produit Red Dead Redemption 2</h3>
                        <div class="projet_desc"><p>Un petit projet design d'une fiche produit pour le jeu Red Dead Redemption 2 que j'ai réalisé sur Figma durant mes études.</p><a href="https://www.figma.com/design/4nug42ptNs5mjZ2FjvvVM3/Fiche-Produit-Dimitri-KNYAZEV?node-id=0-1&t=vzLAR6YATkcZHi5M-1" target="_blank" class="lien_projet">Lien vers le projet</a></div>
                    </div>
            </div>
        </div>
        <!-------------------------------------------------------->
        <!-------------------------- CV -------------------------->
        <!-------------------------------------------------------->
        <div class="cv_section" id="cv_section">
             <h1>MON CV</h1>
            <div class="cv_section_flex">
                <p class="intro_section">Voici un bref aperçu de mon parcours professionnel et de ma formation. Vous pouvez également télécharger mon CV en PDF en cliquant dessus.</p>
                <div class="deux_cv">
                    <div class="CV">
                    <a class="image_cv" href="img/CV_Numerique_developpeur_Web_Dimitri_KNYAZEV.pdf" target="_blank"><img src="img/CV Numérique.svg" alt=""><div class="hover_cv">Cliquez dessus</div></a>
                    <h4>CV Numérique</h4>
                </div>
                <div class="CV">
                    <a class="image_cv" href="img/CV_Imprimable_Developpeur_Web_Dimitri_KNYAZEV.pdf" target="_blank"><img src="img/CV Imprimable.svg" alt=""><div class="hover_cv">Cliquez dessus</div></a>
                    <h4>CV Imprimable</h4>
                </div>
                </div>
            </div>
        </div>
        <div class="contact_section" id="contact_section">
            <!-------------------------------------------------------->
            <!------------------------- Contact ---------------------->
            <!-------------------------------------------------------->
            <h1>ME CONTACTER</h1>
            <div class="contact_section_flex">
                <div class="contact_left">
                    <p class="intro_section">Un projet en tête ou simplement envie d’échanger avec moi ? N’hésite pas à me contacter à partir de ce formulaire !</p>
                    <ul class="liste_contact">
                        <div class="element_contact">
                            <img class="icones" src="img/icons8-téléphone-50.png" alt="">
                            <div>
                                <b>Numéro de Téléphone</b>
                                <div>06 73 15 96 36</div>
                            </div>
                        </div>
                        <div class="element_contact">
                            <img class="icones" src="img/icons8-nouveau-message-50.png" alt="">
                            <div>
                                <b>Email</b>
                                <div>knydim@laposte.net</div>
                            </div>
                        </div>
                        <div class="element_contact">
                            <img class="icones" src="img/icons8-linkedin-50.png" alt="">
                            <div>
                                <b>Linkedin</b>
                                <div><a href="https://www.linkedin.com/in/dimitri-knyazev-77754132b/" target="_blank">Dimitri KNYAZEV</a></div>
                            </div>
                        </div>
                        <div class="element_contact">
                            <img class="icones" src="img/instagram-svgrepo-com.svg" alt="">
                            <div>
                                <b>Linkedin</b>
                                <div><a href="https://www.instagram.com/dimitri_knyazev/" target="_blank">dimitri_knyazev</a></div>
                            </div>
                        </div>
                    </ul>
                </div>
                <div class="formulaire">
                    <form>
                        <div class="element_formulaire">
                            <label class="label_formulaire" for="">Nom et Prénom</label>
                            <input class="input_formulaire" type="text" id="nom" name="nom" required>
                        </div>
                        <div class="element_formulaire">
                            <label class="label_formulaire" for="Email">Email</label>
                            <input class="input_formulaire" type="text" id="email" name="email" required>
                        </div>
                        <div class="element_formulaire">
                            <label class="label_formulaire" for="message">Message</label>
                            <textarea id="message" name="message" required placeholder="Ecrivez votre message..."></textarea>
                        </div>
                        <button type="submit" class="formulaire_submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <a href="#" class="bouton_retour">
            <img src="img/icons8-flèche-64.png" alt="Retour">
        </a>
        <div class="footer_colonnes">
        <div class="footer_colonne">
            <h4>Retour</h4>
            <div><a href="#presentation_section">Qui je suis</a></div>
            <div><a href="#competence_section">Mes compétences</a></div>
            <div><a href="#projets_section">Mes réalisations</a></div>
            <div><a href="#cv_section">Mon cv</a></div>
            <div><a href="#contact_section">Contact</a></div>
        </div>
        <div class="footer_colonne">
            <h4>Contact</h4>
            <div>06 73 15 96 36</div>
            <div>knydim@laposte.net</div>
            <div><a href="https://www.linkedin.com/in/dimitri-knyazev-77754132b/" target="_blank">Linkedin</a></div>
            <div><a href="https://github.com/Sopatrika" target="_blank"></a>Github</div>
            <div><a href="https://www.instagram.com/dimitri_knyazev/">Instagram</a></div>
        </div>
        <div class="footer_colonne">
            <h4>Lien utile</h4>
            <div><a href="https://www.iutmulhouse.uha.fr/" target="_blank">IUT de Mulhouse</a></div>
            <div><a href="img/CV Développeur Web Dimitri KNYAZEV - Copie.pdf" target="_blank">CV Numérique</a></div>
            <div><a href="img/CV Développeur Web Dimitri KNYAZEV - Copie.pdf" target="_blank">CV Imprimable</a></div>
        </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>