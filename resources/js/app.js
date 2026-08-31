

import Alpine from 'alpinejs';
import './poster-generator';

window.inscriptionSidebar = (formationId, price) => ({
    view: 'summary',
    status: '',
    error: '',
    loading: false,
    success: false,
    form: {
        formation_id: formationId,
        nom_complet: '',
        telephone: '',
        email: '',
    },
    async submit(event) {
        this.error = '';
        this.status = '';
        this.loading = true;

        try {
            const formData = new FormData(event.target);
            const response = await fetch(event.target.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: formData,
            });

            const data = await response.json();

            if (!response.ok) {
                this.error = data.message || 'Une erreur est survenue. Veuillez vérifier vos informations.';
                if (data.errors) {
                    const firstError = Object.values(data.errors).flat()[0];
                    if (firstError) {
                        this.error = firstError;
                    }
                }
            } else {
                this.success = true;
                this.status = data.message || 'Votre inscription a bien été enregistrée.';
                this.form.nom_complet = '';
                this.form.telephone = '';
                this.form.email = '';
            }
        } catch (error) {
            this.error = 'Impossible d’envoyer votre inscription. Veuillez réessayer.';
        } finally {
            this.loading = false;
        }
    },
});

window.nouvelleFormation = (formation = null) => ({
    form: {
        name: formation?.title ?? '',
        short_description: formation?.short_description ?? '',
        full_description: formation?.full_description ?? '',
        category: formation?.category ?? '',
        level: formation?.level ?? 'Débutant',
        start_date: formation?.start_date ? this.formatDateForInput(formation.start_date) : '',
        end_date: formation?.end_date ? this.formatDateForInput(formation.end_date) : '',
        mode: formation?.mode ?? 'En ligne',
        delivery_link: formation?.delivery_link ?? formation?.location ?? '',
        price: formation?.price ?? '',
        currency: formation?.currency ?? 'FCFA',
        max_places: formation?.max_places ?? '',
        trainer_name: formation?.trainer_name ?? '',
        objectives: formation?.objectives && formation.objectives.length > 0 ? formation.objectives : ['Définir un objectif clair'],
        modules: formation?.modules && formation.modules.length > 0 ? formation.modules : [
            { title: 'Module 1 : Introduction', description: 'Présentation du programme et des résultats attendus.' },
        ],
        practical_info: formation?.practical_info && formation.practical_info.length > 0 ? formation.practical_info : ['Ajouter une information pratique'],
    },
    init() {
        console.log('=== INITIALISATION FORMULAIRE ===');
        console.log('Formation reçue:', formation);
        console.log('Formulaire initialisé:', this.form);
    },
    formatDateForInput(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        if (isNaN(date)) return dateString;
        return date.toISOString().split('T')[0];
    },
    errors: {},
    statusMessage: null,
    dragging: false,
    coverPreview: null,
    submitLoading: false,
    get shortDescriptionCount() {
        return this.form.short_description.length;
    },
    get isSubmitDisabled() {
        return this.submitLoading;
    },
    setCover(file) {
        if (!file) {
            this.coverPreview = null;
            return;
        }

        const reader = new FileReader();
        reader.onload = event => {
            this.coverPreview = event.target.result;
        };
        reader.readAsDataURL(file);
    },
    removeCover() {
        this.coverPreview = null;
        this.$refs.coverInput.value = null;
    },
    setInitialCover(source) {
        if (source) {
            this.coverPreview = source;
        }
    },
    addObjective() {
        this.form.objectives.push('Nouvel objectif');
        this.$nextTick(() => {
            document.querySelector('.objective-list textarea:last-of-type')?.focus();
        });
    },
    removeObjective(index) {
        if (this.form.objectives.length > 1) {
            this.form.objectives.splice(index, 1);
        }
    },
    addModule() {
        this.form.modules.push({ title: '', description: '' });
        this.$nextTick(() => {
            document.querySelector('.module-list input:last-of-type')?.focus();
        });
    },
    removeModule(index) {
        if (this.form.modules.length > 1) {
            this.form.modules.splice(index, 1);
        }
    },
    addPracticalInfo() {
        this.form.practical_info.push('');
        this.$nextTick(() => {
            document.querySelector('.practical-info-list textarea:last-of-type')?.focus();
        });
    },
    removePracticalInfo(index) {
        if (this.form.practical_info.length > 1) {
            this.form.practical_info.splice(index, 1);
        }
    },
    onDrop(event) {
        this.dragging = false;
        const file = event.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            this.$refs.coverInput.files = dataTransfer.files;
            this.setCover(file);
        }
    },
    onFileChange(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            this.setCover(file);
        }
    },
    validate() {
        this.errors = {};
        if (!this.form.name.trim()) {
            this.errors.name = 'Le nom de la formation est requis.';
        }
        if (!this.form.short_description.trim()) {
            this.errors.short_description = 'La description courte est requise.';
        }
        if (!this.form.full_description.trim()) {
            this.errors.full_description = 'La description complète est requise.';
        }
        if (!this.form.category) {
            this.errors.category = 'La catégorie est requise.';
        }
        if (!this.form.price || Number(this.form.price) <= 0) {
            this.errors.price = 'Le prix doit être supérieur à 0.';
        }
        if (!this.form.max_places || Number(this.form.max_places) <= 0) {
            this.errors.max_places = 'Le nombre de places doit être supérieur à 0.';
        }
        if (this.form.mode === 'En ligne' && !this.form.delivery_link.trim()) {
            this.errors.delivery_link = 'Le lien de plateforme est requis pour une formation en ligne.';
        }
        if (this.form.mode === 'Présentiel' && !this.form.delivery_link.trim()) {
            this.errors.delivery_link = 'L’adresse est requise pour une formation en présentiel.';
        }
        if (this.form.mode === 'En ligne' && !this.form.delivery_link.trim()) {
            this.errors.delivery_link = 'Le lien de plateforme est requis pour une formation en ligne.';
        }
        if (this.form.mode === 'Présentiel' && !this.form.delivery_link.trim()) {
            this.errors.delivery_link = 'L’adresse est requise pour une formation en présentiel.';
        }

        return Object.keys(this.errors).length === 0;
    },
    submit(event) {
        console.log('=== SUBMIT DU FORMULAIRE DEBUT ===');
        console.log('Formulaire actuel:', this.form);
        console.log('Validation en cours...');

        if (!this.validate()) {
            console.log("FORMULAIRE INVALIDE - Erreurs:", this.errors);
            this.statusMessage = 'Veuillez corriger les erreurs avant de soumettre.';
            event.preventDefault();
            return false;
        }

        console.log('Formulaire valide, soumission en cours...');
        console.log('Target action:', event.target.action);
        console.log('Target method:', event.target.method);
        console.log('Has file:', this.$refs.coverInput?.files?.length > 0);
        
        this.submitLoading = true;
        this.statusMessage = null;
        
        // Laisser le formulaire se soumettre normalement
        setTimeout(() => {
            console.log('=== SUBMIT FORMULAIRE FIN - Autorisé ===');
        }, 100);
        
        return true;
    },
});

window.Alpine = Alpine;

Alpine.start();
