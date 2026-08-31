# Refonte du Générateur d'affiche de formation

## Plan d'implémentation

### Templates SVG (composants Blade)
- [ ] `resources/views/generator/models/professional.blade.php` — modèle professionnel complet
- [ ] `resources/views/generator/models/academic.blade.php` — modèle académique complet
- [ ] `resources/views/generator/models/startup.blade.php` — modèle startup complet

### Logique Alpine.js
- [ ] `resources/js/poster-generator.js` — composant Alpine dédié (logique + export robuste)
- [ ] Enregistrer le composant dans `resources/js/app.js`

### Interface utilisateur
- [ ] `resources/views/generator.blade.php` — refonte complète (layout 2 colonnes, choix modèle/palette/format, aperçu temps réel)

### Vérifications finales
- [ ] Vérifier le build (npm run build)
- [ ] Tester les exports SVG/PNG/PDF et le partage WhatsApp
