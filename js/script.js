
// ------------------------ Formulaire --------------------------------------
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.formulaire form');
    if (!form) return;

    // Création d'un élément pour afficher les erreurs
    const errorDisplay = document.createElement('div');
    errorDisplay.className = 'error-message';
    form.parentNode.insertBefore(errorDisplay, form.nextSibling);

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = form.querySelector('[type="submit"]');
        submitBtn.disabled = true;
        errorDisplay.textContent = '';
        errorDisplay.style.display = 'none';

        try {
            const formData = new FormData(form);
            const response = await fetch('', { // Envoi à la même page
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.message || 'Erreur lors de l\'envoi');
            }

            // Feedback visuel
           submitBtn.textContent = '✓ Envoyé';
            submitBtn.classList.add('submit_success');
            submitBtn.style.backgroundColor = '#4CAF50'; // Vert
            
            // Réinitialisation après 2 secondes
            setTimeout(() => {
                form.reset();
                submitBtn.textContent = 'Envoyer';
                submitBtn.classList.remove('submit_success');
                submitBtn.style.backgroundColor = '';
            }, 2000);


        } catch (error) {
            errorDisplay.textContent = error.message;
            errorDisplay.style.display = 'block';
            console.error('Erreur:', error);
        } finally {
            submitBtn.disabled = false;
        }
    });
});

// ------------------------ Animation initial --------------------------------------
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
    }, "-=0.3")
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
                this.size = Math.random() * 3 + 1; // Taille entre 1 et 6 pixels
                this.speedY = Math.random() + 0.1; // Vitesse verticale aléatoire
                this.color = `#${Math.floor(Math.random() * 0x3548e0 + 0x05041D).toString(16).padStart(6, '0')}`; // Nuances de rouge
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
        const particleCount = 50;
        
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

// -------------------------------------- Opacité du header selon le scroll --------------------------------------
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

// -------------------------------------- Animaton d'apparition au scroll des sections --------------------------------------
const sections = document.querySelectorAll('.presentation_section, .competence_section, .projets_section, .cv_section, .contact_section');
window.addEventListener('scroll', () => {
    const triggerBottom = window.innerHeight * 0.8; // Déclenchement quand 80% de l'élément est visible

    sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;

        if (sectionTop < triggerBottom) {
            section.classList.add('section_visible');
        }
    });
});

// Déclenche une première vérification au chargement
window.dispatchEvent(new Event('scroll'));

// -------------------------------------- header en responsive --------------------------------------
const navButton = document.querySelector(".responsive_button_header");
const darkScreen = document.querySelector(".responsive_ecran_sombre");
const menu = document.querySelector(".reponsive_nav_header_menu");

navButton.addEventListener("click", function(e) {
    // Basculer l'état du menu
    menu.classList.toggle("reponsive_nav_header_menu_open");
    darkScreen.classList.toggle("responsive_ecran_sombre_open");
    
    // Transformer le bouton en croix
    navButton.classList.toggle("menu-open");
});

darkScreen.addEventListener("click", function() {
    // Fermer le menu et réinitialiser le bouton
    menu.classList.remove("reponsive_nav_header_menu_open");
    darkScreen.classList.remove("responsive_ecran_sombre_open");
    navButton.classList.remove("menu-open");
});