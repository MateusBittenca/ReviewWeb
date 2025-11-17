// Google Reviews System - Simplified Version
class GoogleReviewsSystem {
    constructor() {
        this.init();
    }
    
    init() {
        this.initStarRating();
        this.bindFormEvents();
        this.initFileUploads();
    }
    
    initStarRating() {
        // Listen for slider changes
        const slider = document.getElementById('positiveScore');
        if (slider) {
            slider.addEventListener('input', (e) => {
                this.updateProgress();
            });
        }
    }
    
    bindFormEvents() {
        // Form validation and progress update
        document.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('input', () => this.updateProgress());
            field.addEventListener('change', () => this.updateProgress());
        });
        
        // Save button functionality
        document.querySelector('.btn-secondary').addEventListener('click', (e) => {
            e.preventDefault();
            this.saveCompany();
        });
        
        // Publish button functionality
        document.querySelector('.btn-primary').addEventListener('click', (e) => {
            e.preventDefault();
            this.publishCompany();
        });
    }
    
    initFileUploads() {
        // Logo upload
        const logoArea = document.querySelector('.upload-area');
        if (logoArea) {
            logoArea.addEventListener('click', () => {
                document.getElementById('logoFile').click();
            });
        }
        
        // Background upload
        const bgArea = document.querySelectorAll('.upload-area')[1];
        if (bgArea) {
            bgArea.addEventListener('click', () => {
                document.getElementById('bgFile').click();
            });
        }
        
        // File change handlers
        document.getElementById('logoFile').addEventListener('change', (e) => {
            this.handleFileUpload(e.target, 'logo');
        });
        
        document.getElementById('bgFile').addEventListener('change', (e) => {
            this.handleFileUpload(e.target, 'background');
        });
    }
    
    handleFileUpload(input, type) {
        const file = input.files[0];
        if (file) {
            // Map type to correct element IDs
            const elementIds = {
                'logo': {
                    preview: 'logoPreview',
                    placeholder: 'logoPlaceholder', 
                    previewImg: 'logoPreviewImg'
                },
                'background': {
                    preview: 'bgPreview',
                    placeholder: 'bgPlaceholder',
                    previewImg: 'bgPreviewImg'
                }
            };
            
            const ids = elementIds[type];
            if (!ids) {
                console.error('Unknown type:', type);
                return;
            }
            
            // Show preview container
            const previewContainer = document.getElementById(ids.preview);
            const placeholder = document.getElementById(ids.placeholder);
            const previewImg = document.getElementById(ids.previewImg);
            
            console.log('Elements found:', {
                previewContainer: !!previewContainer,
                placeholder: !!placeholder,
                previewImg: !!previewImg,
                type: type,
                ids: ids
            });
            
            if (previewContainer && placeholder && previewImg) {
                // Hide placeholder
                placeholder.classList.add('hidden');
                
                // Show preview
                previewContainer.classList.remove('hidden');
                
                // Create preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
                
                console.log('Preview updated successfully for:', type);
            } else {
                console.error('Missing elements for type:', type, {
                    previewContainer: !!previewContainer,
                    placeholder: !!placeholder,
                    previewImg: !!previewImg,
                    ids: ids
                });
            }
        }
    }
    
    updateProgress() {
        const fields = [
            'businessName',
            'url',
            'negativeEmail',
            'positiveScore',
            'businessWebsite',
            'contactNumber',
            'businessAddress',
            'googleBusinessUrl'
        ];
        
        let completed = 0;
        fields.forEach(field => {
            const element = document.getElementById(field);
            if (element && element.value.trim() !== '') {
                completed++;
            }
        });
        
        const progress = (completed / fields.length) * 100;
        document.querySelector('.progress-bar').style.width = progress + '%';
        
        // Update progress text
        const progressText = document.querySelector('.text-sm.font-medium.text-gray-600');
        progressText.textContent = `${completed}/${fields.length} etapas completas`;
    }
    
    validateForm() {
        const requiredFields = [
            'businessName',
            'url',
            'negativeEmail',
            'googleBusinessUrl'
        ];
        
        const errors = [];
        
        requiredFields.forEach(field => {
            const element = document.getElementById(field);
            if (!element || !element.value.trim()) {
                errors.push(`Campo ${this.getFieldLabel(field)} é obrigatório`);
            }
        });
        
        return errors;
    }
    
    getFieldLabel(fieldId) {
        const labels = {
            'businessName': 'Nome da Empresa',
            'url': 'URL',
            'negativeEmail': 'Email para feedback negativo',
            'googleBusinessUrl': 'URL do Google My Business'
        };
        return labels[fieldId] || fieldId;
    }
    
    collectFormData() {
        return {
            businessName: document.getElementById('businessName').value,
            url: document.getElementById('url').value,
            negativeEmail: document.getElementById('negativeEmail').value,
            positiveScore: document.getElementById('positiveScore').value,
            businessWebsite: document.getElementById('businessWebsite').value,
            contactNumber: document.getElementById('contactNumber').value,
            businessAddress: document.getElementById('businessAddress').value,
            googleBusinessUrl: document.getElementById('googleBusinessUrl').value,
            prizeDraw: document.getElementById('prizeDraw').checked,
            logoFile: document.getElementById('logoFile').files[0],
            bgFile: document.getElementById('bgFile').files[0]
        };
    }
    
    saveCompany() {
        const errors = this.validateForm();
        if (errors.length > 0) {
            this.showNotification(errors.join('<br>'), 'error');
            return;
        }
        
        const formData = this.collectFormData();
        console.log('Saving company:', formData);
        
        // Simulate API call
        this.showNotification('Empresa salva com sucesso!', 'success');
    }
    
    publishCompany() {
        const errors = this.validateForm();
        if (errors.length > 0) {
            this.showNotification(errors.join('<br>'), 'error');
            return;
        }
        
        const formData = this.collectFormData();
        
        // Generate unique token for public page
        const token = this.generateToken();
        
        // Simulate API call to create company and generate public page
        this.showNotification('Empresa publicada com sucesso!', 'success');
        
        // Redirect to public page preview
        setTimeout(() => {
            window.location.href = `/r/${token}`;
        }, 2000);
    }
    
    generateToken() {
        // Generate a unique token for the public page
        return 'preview_' + Math.random().toString(36).substr(2, 9);
    }
    
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = message;
        
        // Style the notification
        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '1rem 1.5rem',
            borderRadius: '12px',
            color: 'white',
            fontWeight: '500',
            zIndex: '1000',
            transform: 'translateX(100%)',
            transition: 'transform 0.3s ease',
            background: type === 'error' ? '#ef4444' : type === 'success' ? '#10b981' : '#8b5cf6',
            maxWidth: '400px',
            boxShadow: '0 10px 25px rgba(0, 0, 0, 0.1)'
        });
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 5 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }
    
    removeLogo() {
        const logoFile = document.getElementById('logoFile');
        const logoPreview = document.getElementById('logoPreview');
        const logoPlaceholder = document.getElementById('logoPlaceholder');
        
        // Clear file input
        logoFile.value = '';
        
        // Hide preview and show placeholder
        logoPreview.classList.add('hidden');
        logoPlaceholder.classList.remove('hidden');
        
        this.showNotification('Logo removido com sucesso!', 'success');
    }
    
    removeBackground() {
        const bgFile = document.getElementById('bgFile');
        const bgPreview = document.getElementById('bgPreview');
        const bgPlaceholder = document.getElementById('bgPlaceholder');
        
        // Clear file input
        bgFile.value = '';
        
        // Hide preview and show placeholder
        bgPreview.classList.add('hidden');
        bgPlaceholder.classList.remove('hidden');
        
        this.showNotification('Imagem de fundo removida com sucesso!', 'success');
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.googleReviewsSystem = new GoogleReviewsSystem();
});

// Global functions for HTML onclick events
function removeLogo() {
    if (window.googleReviewsSystem) {
        window.googleReviewsSystem.removeLogo();
    }
}

function removeBackground() {
    if (window.googleReviewsSystem) {
        window.googleReviewsSystem.removeBackground();
    }
}

function handleFileUpload(input, type) {
    if (window.googleReviewsSystem) {
        window.googleReviewsSystem.handleFileUpload(input, type);
    }
}
