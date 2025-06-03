document.addEventListener('DOMContentLoaded', () => {
    const tl = gsap.timeline({ defaults: { ease: "power3.inOut" } });
    
    // Initialisation - Titre complètement masqué à gauche
    gsap.set(".intro_titre", {clipPath: "polygon(0 0, 0 0, 0 100%, 0% 100%)",opacity: 1,});
    gsap.set(".loading-bar", { width: "0%" });
    // Animation principale
    tl.to(".intro_titre", {clipPath: "polygon(0 0, 100% 0, 100% 100%, 0% 100%)",duration: 1.2,ease: "power4.out"}, "+=0.3")
    .to(".loading-bar", {width: "70%",duration: 2,ease: "power1.inOut"}, "-=1.0") // Ajustement du timing
    .to(".intro_titre", {clipPath: "polygon(100% 0, 100% 0, 100% 100%, 100% 100%)",duration: 0.8,ease: "power2.in"}, "-=0.5")
    .to(".loading-bar", {opacity: 0,duration: 0.5}, "-=1")
    .to(".intro-overlay", {y: "-100%",duration: 0.5,ease: "power2.in",
        onComplete: () => {
            document.querySelector('.intro-overlay').style.display = 'none';
            document.querySelector('body').style.overflow = 'auto';
        }
    }, "-=0.3");
});

// --------------------------------------- canvas ---------------------------------------------//
        // Initialisation du canvas
        const canvas = document.getElementById('particleCanvas');
        const ctx = canvas.getContext('2d'); //met en 2d le canvas
        // Ajustement de la taille du canvas
        function resizeCanvas() { //Redimensionne le canvas pour qu'il couvre toute la fenêtre.
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas(); //Réajuste le canvas si la fenêtre est redimensionnée
        
        // Classe Particule
        class Particle {
            constructor() {
                this.reset(); //Réinitialise les propriétés de la particule (position, taille, etc.).
                this.y = Math.random() * canvas.height; // Position aléatoire en Y
            }
            
            reset() {
                this.x = Math.random() * canvas.width; // Position X aléatoire
                this.y = canvas.height + Math.random() * 100; // Part juste en bas de l'écran
                this.size = Math.random() * 5 + 1; // Taille entre 1 et 6 pixels
                this.speedY = Math.random() * 3 + 1; // Vitesse verticale aléatoire
                this.color = `hsl(${Math.random() * 20 + 350}, 100%, ${Math.random() * 30 + 50}%)`; // Nuances de rouge
                this.alpha = Math.random() * 0.5 + 0.1; // Transparence aléatoire
            }
            
            update() {
                this.y -= this.speedY; //Fait monter la particule
                if (this.y < -this.size) { // Si hors de l'écran
                this.reset(); // Réapparaît en bas
                }
            }
            
            draw() {
                ctx.globalAlpha = this.alpha; // Applique la transparence
                ctx.fillStyle = this.color; // Définit la couleur
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2); // Dessine un cercle
                ctx.fill(); // Remplit le cercle
            }
        }
        
        // Création des particules
        const particles = [];
        const particleCount = 150;
        
        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle()); // Ajoute 150 particules
        }
        
        // Animation
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Efface le canvas
            
            // Mise à jour et dessin des particules
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });
            requestAnimationFrame(animate); //Boucle l'animation
        }
        
        animate(); // Lance l'animation

//opacité du header selon le scroll
const header = document.querySelector('header') //variable header
const delay_scroll = 100;
window.addEventListener('scroll', () => { //déclenche une fonction lorsqu'on scroll
    if(scrollY > delay_scroll) { //Si le scroll en Y est supérieur à 150px
        header.classList.add('header-visible') //Ajoute une classe pour rendre opaque le header
    }
    else {
        header.classList.remove('header-visible') //Enleve la classe
    }
})

document.addEventListener('DOMContentLoaded', function() {
    // Sélectionnez toutes vos sections
    const sections = document.querySelectorAll('.presentation_section, .competence_section, .projets_section, .cv_section, .contact_section');
    
    // Configuration de l'Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('section_visible');
            }
        });
    }, {
        threshold: 0.3
    });

    // Observez chaque section
    sections.forEach(section => {
        observer.observe(section);
    });
});

//header en responsive
const nav_responsive = document.querySelector(".reponsive_nav_header > svg");
const ecran_sombre = document.querySelector(".responsive_ecran_sombre");
const ecran_sombre_open = document.querySelector(".responsive_ecran_sombre_open");
nav_responsive.addEventListener("click", function(e) {
    document.querySelector(".reponsive_nav_header_menu").classList.toggle("reponsive_nav_header_menu_open");
    ecran_sombre.classList.toggle("responsive_ecran_sombre_open");
});

ecran_sombre_open.addEventListener("click", function(k) {
    document.querySelector(".reponsive_nav_header_menu").classList.remove("reponsive_nav_header_menu_open");
    ecran_sombre.classList.remove("responsive_ecran_sombre_open");
})
// -------------------------- Formulaire de message
// document.addEventListener('DOMContentLoaded', function() {
//   console.log("DOM chargé - début du script"); // Debug 1
  
//   const form = document.querySelector('.formulaire form');
  
//   if (!form) {
//     console.error("ERREUR: Formulaire non trouvé");
//     return;
//   }

//   console.log("Formulaire trouvé:", form); // Debug 2

//   form.addEventListener('submit', async function(e) {
//     e.preventDefault();
//     console.log("Submit déclenché"); // Debug 3

//     // Récupération des valeurs
//     const formData = {
//       nom: document.getElementById('nom').value.trim(),
//       email: document.getElementById('email').value.trim(),
//       message: document.getElementById('message').value.trim()
//     };

//     console.log("Données du formulaire:", formData); // Debug 4

//     // Validation basique
//     if (!formData.nom || !formData.email || !formData.message) {
//       alert("Veuillez remplir tous les champs");
//       return;
//     }

//     // Webhook Discord - REMPLACEZ PAR VOTRE URL
//     const webhookURL = 'https://discord.com/api/webhooks/1379500495101624351/TpCc6knaS_fRKENhK62wKQaW7e7cP6ujhhPdH8nJW0YDt7CMIllqT4UooVKX8e0u2G9V';

//     // Payload Discord
//     const payload = {
//       content: `**Nouveau message**\n**Nom:** ${formData.nom}\n**Email:** ${formData.email}\n**Message:** ${formData.message}`,
//       username: "Site Web Form",
//       avatar_url: ""
//     };

//     try {
//       console.log("Tentative d'envoi..."); // Debug 5
      
//       const response = await fetch(webhookURL, {
//         method: 'POST',
//         headers: {
//           'Content-Type': 'application/json',
//         },
//         body: JSON.stringify(payload)
//       });

//       console.log("Réponse reçue:", response); // Debug 6

//       if (!response.ok) {
//         throw new Error(`Erreur HTTP: ${response.status}`);
//       }

//       alert("Message envoyé avec succès à Discord!");
//       form.reset();
//     } catch (error) {
//       console.error("Erreur complète:", error); // Debug 7
//       alert(`Erreur d'envoi: ${error.message}`);
//     }
//   });
// });

// console.log("URL du webhook:", webhookURL);