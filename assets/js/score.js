/**
 * Animation de compte à rebours du score
 * Cette fonction anime l'affichage du score final en le comptant de 0 à la valeur cible
 */
(function(){
  // Récupération de l'élément HTML qui affiche le score
  const el = document.getElementById('qz-pts');
  
  // Vérification que l'élément existe dans le DOM
  if (!el) return;
  
  // Récupération de la valeur cible du score depuis le contenu HTML
  // parseInt convertit le texte en nombre entier
  // || 0 définit une valeur par défaut si la conversion échoue
  
  const target = parseInt(el.dataset.target) || 0;

  
  // Si le score cible est 0 ou indéfini, affiche 0 et arrête
  if (!target) { 
    el.textContent = '0'; 
    return; 
  }
  
  // Configuration de l'animation
  const steps = 60; // Nombre d'étapes pour le compte à rebours
  const ms = 1200 / steps; // Durée entre chaque étape en millisecondes (1.2 secondes au total)
  const inc = target / steps; // Incrément par étape
  let cur = 0; // Valeur courante du compteur
  
  // Initialisation : affiche 0 au démarrage de l'animation
  el.textContent = '0';
  
  // Intervalle qui met à jour le score à chaque étape
  const t = setInterval(() => {
    // Augmente la valeur courante par l'incrément
    cur += inc;
    
    // Vérification si la valeur cible est atteinte
    if (cur >= target) { 
      // Force la valeur finale exacte (évite les arrondis)
      cur = target; 
      // Arrête l'intervalle (fin de l'animation)
      clearInterval(t); 
    }
    
    // Affiche la valeur arrondie dans l'élément HTML
    el.textContent = Math.round(cur);
  }, ms);
})();



