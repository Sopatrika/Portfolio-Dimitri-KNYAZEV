
// ------------------------ Formulaire
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.formulaire form');
  
  if (!form) return;

  form.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Désactivation du bouton pendant l'envoi
    const submitBtn = e.target.querySelector('[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Envoi en cours...';

    try {
      // 1. Récupération des données
      const formData = {
        nom: this.nom.value.trim(),
        email: this.email.value.trim(),
        message: this.message.value.trim()
      };

      // 2. Validation
      if (!formData.nom || !formData.email || !formData.message) {
        throw new Error("Veuillez remplir tous les champs");
      }

      // 3. Configuration du webhook (À PERSONNALISER)
      const webhookPayload = {
        username: "Nouveau message depuis le portfolio !!!!!!!!!!!!!!!!!!!!!!!!!!!",  // Nom du bot
        avatar_url: "https://www.istockphoto.com/fr/vectoriel/point-dexclamation-signer-en-triangle-rouge-ic%C3%B4ne-de-vecteur-gm894875516-247346339",  // URL de l'avatar
        embeds: [{
          title: "📩 Nouveau Message",
          color: 0x5865F2,  // Couleur bleue Discord
          fields: [
            { name: "**Nom**", value: formData.nom, inline: true },
            { name: "**Email**", value: formData.email, inline: true },
            { name: "**Message**", value: formData.message }
          ],
          footer: { 
            text: "Formulaire de contact • " + new Date().toLocaleDateString(),
            icon_url: "https://example.com/icon.png"
          },
          thumbnail: { 
            url: "https://example.com/thumbnail.png" 
          }
        }]
      };

      // 4. Envoi à Discord
      const response = await fetch('https://discord.com/api/webhooks/1379500495101624351/TpCc6knaS_fRKENhK62wKQaW7e7cP6ujhhPdH8nJW0YDt7CMIllqT4UooVKX8e0u2G9V', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(webhookPayload)
      });

      if (!response.ok) throw new Error("Erreur lors de l'envoi à Discord");

      // 5. Feedback utilisateur
      alert("Message envoyé avec succès !");
      this.reset();

    } catch (error) {
      console.error("Erreur:", error);
      alert(error.message);
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Envoyer';
    }
  });
});
// ------------------------ Animation initial
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

// -------------------------------------- Animaton d'apparition au scroll des sections
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

// -------------------------------------- header en responsive
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