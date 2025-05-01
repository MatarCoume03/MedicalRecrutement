import './bootstrap';
import Alpine from 'alpinejs';
import 'focus-visible'; // Pour la gestion du focus
// resources/js/app.js
import './components/competence-selector';
import './components/document-uploader';

// Initialisation d'Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Gestion du drag and drop pour les fichiers
document.addEventListener('DOMContentLoaded', function() {
    const dropzones = document.querySelectorAll('.dropzone');
    
    dropzones.forEach(dropzone => {
        const input = dropzone.querySelector('input[type="file"]');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropzone.classList.add('dropzone-active');
        }
        
        function unhighlight() {
            dropzone.classList.remove('dropzone-active');
        }
        
        dropzone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            input.files = files;
            
            // Mettre à jour l'affichage avec le nom du fichier
            if (files.length > 0) {
                const fileNameDisplay = dropzone.querySelector('.file-name');
                if (fileNameDisplay) {
                    fileNameDisplay.textContent = files[0].name;
                }
            }
        }
    });
    
    // Initialiser Alpine.js pour les composants interactifs
    document.addEventListener('alpine:init', () => {
        Alpine.data('documentUpload', () => ({
            file: null,
            
            updateFile(event) {
                this.file = event.target.files[0];
            },
            
            clearFile() {
                this.file = null;
                const input = this.$refs.fileInput;
                input.value = '';
            }
        }));
    });
});