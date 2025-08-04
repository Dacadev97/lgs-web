/**
 * Sistema de Traducción Automática
 * Utiliza Google Translate API para traducir contenido dinámico
 */

class TranslationManager {
    constructor() {
        this.currentLanguage = 'en'; // Idioma por defecto (inglés)
        this.apiBaseUrl = '/api/translate';
        this.isTranslating = false;
        this.originalContent = new Map(); // Guarda el contenido original
        
        this.init();
    }

    init() {
        // Configurar botones de idioma
        this.setupLanguageButtons();
        
        // Guardar contenido original al cargar la página
        this.saveOriginalContent();
        
        // Verificar si hay un idioma guardado en localStorage
        const savedLanguage = localStorage.getItem('preferred_language');
        if (savedLanguage && savedLanguage !== 'en') {
            this.translateToLanguage(savedLanguage);
        }
    }

    setupLanguageButtons() {
        const spanishBtn = document.getElementById('translate-es');
        const englishBtn = document.getElementById('translate-en');

        if (spanishBtn) {
            spanishBtn.addEventListener('click', () => {
                this.translateToLanguage('es');
            });
        }

        if (englishBtn) {
            englishBtn.addEventListener('click', () => {
                this.translateToLanguage('en');
            });
        }
    }

    saveOriginalContent() {
        // Selectores de elementos que se deben traducir
        const selectorsToTranslate = [
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'p', 'span', 'div', 'li', 'a',
            '[data-translatable]',
            '.bio-content',
            '.composition-title',
            '.composition-description',
            '.category-name',
            '.latest-composition-title'
        ];

        selectorsToTranslate.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                // Solo guardar elementos que tienen texto y no contienen solo otros elementos
                const textContent = element.textContent.trim();
                if (textContent && !this.containsOnlyChildElements(element)) {
                    this.originalContent.set(element, {
                        text: textContent,
                        html: element.innerHTML
                    });
                }
            });
        });

        console.log('Contenido original guardado:', this.originalContent.size, 'elementos');
    }

    containsOnlyChildElements(element) {
        // Verificar si el elemento contiene solo otros elementos (no texto directo)
        const children = element.children;
        const textNodes = Array.from(element.childNodes).filter(node => 
            node.nodeType === Node.TEXT_NODE && node.textContent.trim()
        );
        return children.length > 0 && textNodes.length === 0;
    }

    async translateToLanguage(targetLanguage) {
        if (this.isTranslating) {
            console.log('Traducción en progreso...');
            return;
        }

        if (this.currentLanguage === targetLanguage) {
            console.log('Ya está en el idioma seleccionado');
            return;
        }

        this.isTranslating = true;
        this.updateButtonStates(targetLanguage);

        try {
            if (targetLanguage === 'en') {
                // Restaurar contenido original
                this.restoreOriginalContent();
            } else {
                // Traducir al idioma objetivo
                await this.translatePageContent(targetLanguage);
            }

            this.currentLanguage = targetLanguage;
            localStorage.setItem('preferred_language', targetLanguage);

        } catch (error) {
            console.error('Error en traducción:', error);
            this.showTranslationError();
        } finally {
            this.isTranslating = false;
        }
    }

    restoreOriginalContent() {
        this.originalContent.forEach((content, element) => {
            if (element && element.parentNode) {
                element.innerHTML = content.html;
            }
        });
        console.log('Contenido original restaurado');
    }

    async translatePageContent(targetLanguage) {
        // Recopilar elementos para traducir
        const elementsToTranslate = [];
        
        this.originalContent.forEach((content, element) => {
            if (element && element.parentNode) {
                elementsToTranslate.push({
                    element: element,
                    selector: this.getElementSelector(element),
                    text: content.text
                });
            }
        });

        if (elementsToTranslate.length === 0) {
            console.log('No hay elementos para traducir');
            return;
        }

        console.log(`Traduciendo ${elementsToTranslate.length} elementos a ${targetLanguage}`);

        // Dividir en chunks para evitar requests muy grandes
        const chunkSize = 10;
        const chunks = this.chunkArray(elementsToTranslate, chunkSize);

        for (const chunk of chunks) {
            await this.translateChunk(chunk, targetLanguage);
        }
    }

    async translateChunk(elements, targetLanguage) {
        const requestData = {
            elements: elements.map(item => ({
                selector: item.selector,
                text: item.text
            })),
            target_language: targetLanguage,
            source_language: 'en'
        };

        try {
            const response = await fetch(`${this.apiBaseUrl}/page`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify(requestData)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                // Aplicar traducciones
                result.translations.forEach((translation, index) => {
                    const element = elements[index].element;
                    if (element && element.parentNode) {
                        element.textContent = translation.translated_text;
                    }
                });
            } else {
                throw new Error(result.message || 'Translation failed');
            }

        } catch (error) {
            console.error('Error en chunk de traducción:', error);
            // En caso de error, mantener el texto original
        }
    }

    chunkArray(array, size) {
        const chunks = [];
        for (let i = 0; i < array.length; i += size) {
            chunks.push(array.slice(i, i + size));
        }
        return chunks;
    }

    getElementSelector(element) {
        // Crear un selector único para el elemento
        const tag = element.tagName.toLowerCase();
        const id = element.id ? `#${element.id}` : '';
        const classes = element.className ? `.${element.className.replace(/\s+/g, '.')}` : '';
        
        return `${tag}${id}${classes}`;
    }

    getCSRFToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : '';
    }

    updateButtonStates(activeLanguage) {
        const spanishBtn = document.getElementById('translate-es');
        const englishBtn = document.getElementById('translate-en');

        // Reset estados
        if (spanishBtn) {
            spanishBtn.classList.remove('bg-amber-200', 'font-bold');
            spanishBtn.classList.add('bg-white');
        }
        if (englishBtn) {
            englishBtn.classList.remove('bg-amber-200', 'font-bold');
            englishBtn.classList.add('bg-white');
        }

        // Activar botón seleccionado
        const activeBtn = activeLanguage === 'es' ? spanishBtn : englishBtn;
        if (activeBtn) {
            activeBtn.classList.remove('bg-white');
            activeBtn.classList.add('bg-amber-200', 'font-bold');
        }
    }

    showTranslationError() {
        console.error('Error al traducir la página');
        // Podríamos mostrar un toast o mensaje de error aquí
    }

    // Método público para traducir texto específico (útil para contenido dinámico)
    async translateText(text, targetLanguage) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/text`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify({
                    text: text,
                    target_language: targetLanguage,
                    source_language: 'en'
                })
            });

            const result = await response.json();
            return result.success ? result.translated_text : text;

        } catch (error) {
            console.error('Error traduciendo texto:', error);
            return text;
        }
    }
}

// Inicializar el sistema de traducción cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    window.translationManager = new TranslationManager();
});

// Función global para traducir contenido dinámico que se carga posteriormente
window.translateDynamicContent = function() {
    if (window.translationManager) {
        window.translationManager.saveOriginalContent();
        if (window.translationManager.currentLanguage !== 'en') {
            window.translationManager.translateToLanguage(window.translationManager.currentLanguage);
        }
    }
};
