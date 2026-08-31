/**
 * =====================================================
 *  GÉNÉRATEUR D'AFFICHE — Composant Alpine.js amélioré
 *  Separation : logique métier / template SVG / UI
 *  Version améliorée avec meilleure UX et conversion
 * =====================================================
 */

window.posterGenerator = function (serverFormation) {
    return {
        // ---- Données ----
        formation: serverFormation || {},
        model: 'professional',
        format: 'vertical', // vertical (WhatsApp/PDF) | carre (Instagram) | paysage (Facebook)
        selected: 0,
        missing: [],
        isLoading: false,

        // ---- Palettes étendues ----
        palettes: [
            { name: 'Orange', colors: ['#F97316', '#EA580C', '#C2410C'] },
            { name: 'Bleu', colors: ['#3B82F6', '#2563EB', '#1D4ED8'] },
            { name: 'Vert', colors: ['#10B981', '#059669', '#047857'] },
            { name: 'Violet', colors: ['#8B5CF6', '#7C3AED', '#6D28D9'] },
            { name: 'Slate', colors: ['#475569', '#334155', '#1e293b'] },
            { name: 'Rose', colors: ['#EC4899', '#DB2777', '#BE185D'] },
            { name: 'Teal', colors: ['#14B8A6', '#0D9488', '#0F766E'] },
            { name: 'Ambre', colors: ['#F59E0B', '#D97706', '#B45309'] },
            { name: 'Cyan', colors: ['#06B6D4', '#0891B2', '#0E7490'] },
            { name: 'Indigo', colors: ['#6366F1', '#4F46E5', '#4338CA'] },
            { name: 'Émeraude', colors: ['#10B981', '#059669', '#047857'] },
            { name: 'Rouge', colors: ['#EF4444', '#DC2626', '#B91C1C'] },
        ],

        // ---- Accesseurs calculés (aperçu UI) ----
        get activePalette() {
            return this.palettes[this.selected] || this.palettes[0];
        },

        get editUrl() {
            return '/admin/formations/' + (this.formation.slug || '') + '/edit';
        },

        get completionScore() {
            const fields = [
                'title', 'start_date', 'price', 'delivery_link', 
                'trainer_name', 'short_description', 'full_description'
            ];
            const completed = fields.filter(field => this.formation[field]).length;
            return Math.round((completed / fields.length) * 100);
        },

        // ---- Variables partagées injectées dans les templates SVG ----
        get p_title() { return this.smartTitle(); },
        get p_subtitle() { return this.smartSubtitle(); },
        get p_badge() { return this.smartBadge(); },
        get p_description() { return this.smartDescription(); },
        get p_trainer() { return this.formation.trainer_name || 'Formateur'; },
        get p_price() { return this.formatPrice(this.formation.price); },
        get p_duration() { return this.formatDuration(); },
        get p_mode() { return this.formatMode(); },
        get p_start() { return this.formatDate(this.formation.start_date); },
        get p_end() { return this.formation.end_date ? this.formatDate(this.formation.end_date) : ''; },
        get p_place() { return this.formatPlace(); },
        get p_image() { return this.formation.image || ''; },
        get p_benefits() { return this.smartBenefits(); },
        get p_cta() { return this.smartCTA(); },
        get p_contact() { return this.formatContact(); },
        get p_urgency() { return this.urgencyText(); },
        get p_showUrgency() { return this.showUrgency(); },
        get p_footer() { return this.formatFooter(); },
        get p_places() { return this.placesLabel() === '—' ? 'N/A' : this.placesLabel(); },
        get p_category() { return this.formation.category || 'Formation'; },

        // ---- Initialisation ----
        init() {
            console.log('=== INITIALISATION POSTER GENERATOR ===');
            console.log('Formation reçue:', this.formation);
            console.log('Formation existe:', !!this.formation);
            console.log('Formation title:', this.formation?.title);
            
            this.formation = this.formation || {};
            this.validateMissing();
            this.detectBestPalette();
            
            console.log('Palette sélectionnée:', this.selected);
            console.log('Palette active:', this.activePalette);
        },

        // =====================================================
        //  CONTENU MARKETING INTELLIGENT AMÉLIORÉ
        // =====================================================
        smartTitle(f) {
            f = f || this.formation;
            if (!f.title) return 'Formation';
            
            // Tronquer intelligemment pour l'affiche
            const maxLength = this.model === 'startup' ? 26 : 30;
            if (f.title.length <= maxLength) return f.title;
            
            return f.title.substring(0, maxLength - 3) + '...';
        },

        smartSubtitle(f) {
            f = f || this.formation;
            if (f.short_description) {
                return this.truncateText(f.short_description, 80);
            }
            if (f.full_description) {
                const parts = f.full_description.split(/[.!]/).filter(Boolean);
                const subtitle = parts.slice(0, 2).join('. ') + '.';
                return this.truncateText(subtitle, 80);
            }
            return 'Rejoignez cette formation pour développer vos compétences.';
        },

        smartBadge(f) {
            f = f || this.formation;
            const badges = {
                'Actif': '🚀 Nouvelle session',
                'Brouillon': '📅 Bientôt disponible',
                'Complet': '⭐ Session exceptionnelle',
                'Terminé': '🎓 Formation certifiante'
            };
            
            if (badges[f.status]) return badges[f.status];
            if (f.start_date) {
                const daysUntil = Math.ceil((new Date(f.start_date) - new Date()) / (1000 * 60 * 60 * 24));
                if (daysUntil <= 7) return '🔥 Dernières places';
                if (daysUntil <= 30) return '⏰ Prochainement';
            }
            return '✨ Inscription ouverte';
        },

        smartDescription(f) {
            f = f || this.formation;
            const desc = f.full_description || f.short_description || this.smartSubtitle(f);
            return this.truncateText(desc, 160);
        },

        smartBenefits(f) {
            f = f || this.formation;
            if (f.learning_points && f.learning_points.length) {
                return f.learning_points.slice(0, 5).map(b => this.truncateText(b, 40));
            }
            if (f.objectives && f.objectives.length) {
                return f.objectives.slice(0, 5).map(b => this.truncateText(b, 40));
            }
            return [
                'Compétences pratiques actionnables',
                'Projets concrets du monde réel',
                'Accompagnement personnalisé',
                'Certification reconnue',
                'Réseau professionnel'
            ];
        },

        smartCTA(f) {
            f = f || this.formation;
            const ctas = [
                'Inscrivez-vous maintenant →',
                'Réservez votre place →',
                'Rejoignez la formation →',
                'Commencez votre parcours →'
            ];
            
            // CTA personnalisé selon le mode
            if (f.mode === 'En ligne') return 'Formez-vous en ligne →';
            if (f.mode === 'Présentiel') return 'Réservez votre place →';
            
            return ctas[Math.floor(Math.random() * ctas.length)];
        },

        urgencyText() {
            const places = this.formation.remaining_places;
            if (!places) return 'Places limitées';
            if (places <= 3) return '⚡ Plus que ' + places + ' places';
            if (places <= 5) return '🔥 Dernières places';
            if (places <= 10) return '⏰ Places en cours';
            return 'Places disponibles';
        },

        showUrgency() {
            const places = this.formation.remaining_places;
            return places > 0 && places <= 10;
        },

        // ---- Utilitaires de texte ----
        truncateText(text, maxLength) {
            if (!text) return '';
            if (text.length <= maxLength) return text;
            return text.substring(0, maxLength - 3) + '...';
        },

        // ---- Détection automatique de palette ----
        detectBestPalette() {
            const category = this.formation.category?.toLowerCase() || '';
            
            if (category.includes('tech') || category.includes('développement') || category.includes('informatique')) {
                this.selected = 1; // Bleu
            } else if (category.includes('business') || category.includes('marketing') || category.includes('vente')) {
                this.selected = 0; // Orange
            } else if (category.includes('design') || category.includes('créatif')) {
                this.selected = 5; // Rose
            } else if (category.includes('finance') || category.includes('comptabilité')) {
                this.selected = 7; // Ambre
            } else if (category.includes('santé') || category.includes('médical')) {
                this.selected = 2; // Vert
            }
        },

        // ---- Mis en forme ----
        formatPrice(p) {
            if (p === null || p === undefined || p === '' || Number(p) === 0) return 'Gratuit';
            return new Intl.NumberFormat('fr-FR').format(Number(p)) + ' ' + (this.formation.currency || 'FCFA');
        },

        formatDate(d) {
            if (!d) return 'À planifier';
            const date = new Date(d);
            if (isNaN(date)) return d;
            return date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });
        },

        formatDuration(f) {
            f = f || this.formation;
            if (f.duration) return f.duration;
            if (f.start_date && f.end_date) {
                const start = new Date(f.start_date);
                const end = new Date(f.end_date);
                const days = Math.round((end - start) / (1000 * 60 * 60 * 24));
                if (days > 0) return days + ' jour' + (days > 1 ? 's' : '');
            }
            return 'N/A';
        },

        formatMode(f) {
            f = f || this.formation;
            const map = { 
                'En ligne': '🌐 En ligne', 
                'Présentiel': '📍 Présentiel', 
                'Hybride': '🔄 Hybride' 
            };
            return map[f.mode] || f.mode || '🌐 En ligne';
        },

        formatPlace(f) {
            f = f || this.formation;
            return f.delivery_link || f.location || 'Lieu communiqué après inscription';
        },

        formatFooter(f) {
            f = f || this.formation;
            const parts = [];
            if (f.trainer_name) parts.push('Avec ' + f.trainer_name);
            if (f.registration_link) parts.push('Contact : ' + f.registration_link);
            return parts.join(' • ');
        },

        formatContact(f) {
            f = f || this.formation;
            const parts = [];
            if (f.trainer_name) parts.push('Formateur : ' + f.trainer_name);
            if (f.registration_link) parts.push('Inscription : ' + f.registration_link);
            else if (f.delivery_link) parts.push('Info : ' + f.delivery_link);
            return parts.join('  |  ');
        },

        // ---- Places ----
        placesLabel() {
            const p = this.formation.remaining_places;
            if (p === null || p === undefined) return '—';
            return p + ' place' + (p > 1 ? 's' : '');
        },

        // =====================================================
        //  VALIDATION / DONNÉES MANQUANTES AMÉLIORÉE
        // =====================================================
        validateMissing() {
            const missing = [];
            const f = this.formation;
            if (!f.title) missing.push('Titre de la formation');
            if (!f.start_date) missing.push('Date de début');
            if (!f.price && f.price !== 0) missing.push('Prix');
            if (!f.delivery_link && !f.location) missing.push('Lieu ou lien de formation');
            if (!f.trainer_name) missing.push('Nom du formateur');
            if (!f.short_description && !f.full_description) missing.push('Description de la formation');
            if (!f.category) missing.push('Catégorie');
            this.missing = missing;
        },

        // =====================================================
        //  CONTRÔLES AMÉLIORÉS
        // =====================================================
        shufflePalette() {
            this.selected = Math.floor(Math.random() * this.palettes.length);
        },

        resetPalette() {
            this.selected = 0;
            this.detectBestPalette();
        },

        regenerate() {
            this.isLoading = true;
            // Animation de régénération
            setTimeout(() => {
                this.shufflePalette();
                this.isLoading = false;
            }, 300);
        },

        // =====================================================
        //  EXPORT ROBUSTE AMÉLIORÉ
        //  Matérialise le SVG : applique x-text, x-show, :href
        //  et supprime les éléments cachés avant sérialisation.
        // =====================================================
        resolveSVG(svg) {
            const clone = svg.cloneNode(true);

            // Appliquer x-text -> textContent
            clone.querySelectorAll('[x-text]').forEach((el) => {
                const expr = el.getAttribute('x-text');
                const value = this.evaluate(expr);
                if (value !== undefined && value !== null) {
                    el.textContent = value;
                }
                el.removeAttribute('x-text');
            });

            // Appliquer :href -> href
            clone.querySelectorAll('[*\\:href], [href]').forEach((el) => {
                const expr = el.getAttribute(':href');
                if (expr) {
                    const value = this.evaluate(expr);
                    if (value) el.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', value);
                    el.removeAttribute(':href');
                }
            });

            // Appliquer :fill (définitions) gérées par le template Alpine
            clone.querySelectorAll('[fill]').forEach(() => {});

            // Appliquer x-show -> display none si faux
            clone.querySelectorAll('[x-show]').forEach((el) => {
                const expr = el.getAttribute('x-show');
                const show = !!this.evaluate(expr);
                el.removeAttribute('x-show');
                if (!show) {
                    el.style.setProperty('display', 'none');
                }
            });

            // Appliquer :transform
            clone.querySelectorAll('[*\\:transform]').forEach((el) => {
                const expr = el.getAttribute(':transform');
                if (expr) {
                    const value = this.evaluate(expr);
                    if (value) el.setAttribute('transform', value);
                    el.removeAttribute(':transform');
                }
            });

            // Nettoyer les attributs Alpine
            clone.querySelectorAll('[x-data], [x-init], [x-for], [x-if], [x-else], [x-else-if]').forEach((el) => {
                el.removeAttribute('x-data');
                el.removeAttribute('x-init');
                el.removeAttribute('x-for');
                el.removeAttribute('x-if');
                el.removeAttribute('x-else');
                el.removeAttribute('x-else-if');
            });

            return clone;
        },

        evaluate(expr) {
            // Évaluation sûre des expressions Alpine simples
            try {
                const f = this.formation;
                // Valeurs marketing calculées
                const p = {
                    title: this.p_title, subtitle: this.p_subtitle, badge: this.p_badge,
                    description: this.p_description, trainer: this.p_trainer, price: this.p_price,
                    duration: this.p_duration, mode: this.p_mode, start: this.p_start,
                    end: this.p_end, place: this.p_place, image: this.p_image,
                    benefits: this.p_benefits, cta: this.p_cta, contact: this.p_contact,
                    urgency: this.p_urgency, showUrgency: this.p_showUrgency, footer: this.p_footer,
                    places: this.p_places, category: this.p_category,
                };
                // eslint-disable-next-line no-new-func
                return new Function(
                    'formation', 'model', 'selected', 'palettes', 'p',
                    'formatPrice', 'formatDate', 'formatDuration', 'formatMode',
                    'formatPlace', 'formatFooter', 'formatContact', 'placesLabel',
                    'smartTitle', 'smartSubtitle', 'smartBadge', 'smartDescription',
                    'smartBenefits', 'smartCTA', 'urgencyText', 'showUrgency',
                    'return (' + expr + ')'
                )(f, this.model, this.selected, this.palettes, p,
                    this.formatPrice.bind(this), this.formatDate.bind(this),
                    this.formatDuration.bind(this), this.formatMode.bind(this),
                    this.formatPlace.bind(this), this.formatFooter.bind(this),
                    this.formatContact.bind(this), this.placesLabel.bind(this),
                    this.smartTitle.bind(this), this.smartSubtitle.bind(this),
                    this.smartBadge.bind(this), this.smartDescription.bind(this),
                    this.smartBenefits.bind(this), this.smartCTA.bind(this),
                    this.urgencyText.bind(this), this.showUrgency.bind(this));
            } catch (e) {
                console.warn('Évaluation échouée :', expr, e);
                return expr;
            }
        },

        serialize(clone) {
            const serializer = new XMLSerializer();
            let str = serializer.serializeToString(clone);
            // Retirer les espaces de nom superflus laissés par SVG
            str = '<?xml version="1.0" encoding="UTF-8"?>\n' + str;
            return str;
        },

        // ---- Téléchargements améliorés ----
        downloadSVG() {
            const svg = document.getElementById('poster-preview');
            const resolved = this.resolveSVG(svg);
            const str = this.serialize(resolved);
            const blob = new Blob([str], { type: 'image/svg+xml;charset=utf-8' });
            this.triggerDownload(URL.createObjectURL(blob), 'affiche-' + (this.formation.slug || 'formation') + '.svg');
        },

        downloadPNG() {
            const svg = document.getElementById('poster-preview');
            const resolved = this.resolveSVG(svg);
            const str = this.serialize(resolved);
            const blob = new Blob([str], { type: 'image/svg+xml;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const img = new Image();
            
            // Dimensions selon le format choisi
            const dimensions = this.getFormatDimensions();
            
            img.onload = () => {
                const canvas = document.createElement('canvas');
                canvas.width = dimensions.width;
                canvas.height = dimensions.height;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                canvas.toBlob((blobPng) => {
                    this.triggerDownload(URL.createObjectURL(blobPng), 'affiche-' + (this.formation.slug || 'formation') + '.png');
                }, 'image/png');
                URL.revokeObjectURL(url);
            };
            img.onerror = () => {
                alert('Erreur lors de la génération PNG.');
                URL.revokeObjectURL(url);
            };
            img.src = url;
        },

        downloadPDF() {
            const svg = document.getElementById('poster-preview');
            const resolved = this.resolveSVG(svg);
            const str = this.serialize(resolved);
            const blob = new Blob([str], { type: 'image/svg+xml;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const img = new Image();
            
            // Dimensions selon le format choisi
            const dimensions = this.getFormatDimensions();
            
            img.onload = () => {
                const canvas = document.createElement('canvas');
                canvas.width = dimensions.width;
                canvas.height = dimensions.height;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({ 
                    orientation: dimensions.width > dimensions.height ? 'landscape' : 'portrait', 
                    unit: 'px', 
                    format: [dimensions.width, dimensions.height] 
                });
                pdf.addImage(imgData, 'PNG', 0, 0, dimensions.width, dimensions.height);
                pdf.save('affiche-' + (this.formation.slug || 'formation') + '.pdf');
                URL.revokeObjectURL(url);
            };
            img.onerror = () => {
                alert('Erreur lors de la génération PDF.');
                URL.revokeObjectURL(url);
            };
            img.src = url;
        },

        getFormatDimensions() {
            const formats = {
                'vertical': { width: 1080, height: 1620 },   // WhatsApp 2:3
                'carre': { width: 1080, height: 1080 },     // Instagram 1:1
                'paysage': { width: 1920, height: 1080 }    // Facebook 16:9
            };
            return formats[this.format] || formats['vertical'];
        },

        triggerDownload(url, filename) {
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            a.remove();
            URL.revokeObjectURL(url);
        },

        // ---- Partages améliorés ----
        shareWhatsApp() {
            const f = this.formation;
            const text = [
                '🎓 *' + (f.title || 'Formation') + '*',
                '',
                this.smartSubtitle(),
                '',
                '💰 ' + this.formatPrice(f.price),
                '📅 ' + this.formatDate(f.start_date) + (f.end_date ? ' → ' + this.formatDate(f.end_date) : ''),
                '📍 ' + this.formatPlace(f),
                '🕒 ' + this.formatDuration() + ' • ' + this.formatMode(),
                (f.remaining_places && f.remaining_places <= 10 ? '⚠️ *Plus que ' + f.remaining_places + ' places* 🏃💨' : ''),
                '',
                '👉 ' + (f.registration_link || f.delivery_link || 'Inscrivez-vous maintenant'),
            ].filter(Boolean).join('\n');
            const url = 'https://wa.me/?text=' + encodeURIComponent(text);
            window.open(url, '_blank');
        },

        shareFacebook() {
            const f = this.formation;
            const text = [
                '🎓 ' + (f.title || 'Formation'),
                this.smartSubtitle(),
                '💰 ' + this.formatPrice(f.price) + ' • 📅 ' + this.formatDate(f.start_date),
            ].filter(Boolean).join(' | ');
            const url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(f.registration_link || f.delivery_link || window.location.href) + '&quote=' + encodeURIComponent(text);
            window.open(url, '_blank');
        },

        // ---- Nouveau : Partage LinkedIn ----
        shareLinkedIn() {
            const f = this.formation;
            const url = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(f.registration_link || f.delivery_link || window.location.href);
            window.open(url, '_blank');
        },

        // ---- Nouveau : Copier le lien ----
        copyLink() {
            const f = this.formation;
            const link = f.registration_link || f.delivery_link || window.location.href;
            navigator.clipboard.writeText(link).then(() => {
                alert('Lien copié dans le presse-papier !');
            }).catch(() => {
                alert('Impossible de copier le lien');
            });
        },
    };
};