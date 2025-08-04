/**
 * Sistema de Traducción con Google Translate
 * Utiliza el widget oficial de Google Translate
 */

// Limpiar inmediatamente cualquier estado de traducción antes de que cargue la página SOLO si no hay preferencia guardada
(function () {
    // Verificar si hay una preferencia de idioma guardada POR TAB (sessionStorage)
    const savedLanguage = sessionStorage.getItem("preferred_language");
    const cookieLanguage = document.cookie
        .split(";")
        .find((cookie) => cookie.trim().startsWith("googtrans="));

    if (!savedLanguage && !cookieLanguage) {
        // Solo limpiar si no hay preferencia guardada
        sessionStorage.removeItem("preferred_language");
        localStorage.removeItem("googtrans");
        document.cookie =
            "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie =
            "googtrans=/auto/en; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }
})();

class GoogleTranslationManager {
    constructor() {
        // Detectar idioma preferido al inicializar
        this.currentLanguage = this.detectSavedLanguage();
        this.init();
    }

    detectSavedLanguage() {
        // Verificar sessionStorage primero (preferencia por tab)
        const savedLanguage = sessionStorage.getItem("preferred_language");
        if (
            savedLanguage &&
            (savedLanguage === "es" || savedLanguage === "en")
        ) {
            return savedLanguage;
        }

        // Verificar cookies de Google Translate como respaldo
        const cookieLanguage = document.cookie
            .split(";")
            .find((cookie) => cookie.trim().startsWith("googtrans="));

        if (cookieLanguage) {
            const match = cookieLanguage.match(/googtrans=\/[^\/]*\/([^;]*)/);
            if (match && match[1] === "es") {
                return "es";
            }
        }

        // Verificar hash de URL como último recurso
        if (window.location.hash.includes("#googtrans")) {
            const hashMatch = window.location.hash.match(
                /#googtrans\([^|]*\|([^)]*)\)/
            );
            if (hashMatch && hashMatch[1] === "es") {
                return "es";
            }
        }

        return "en"; // Idioma por defecto
    }

    init() {
        // Cargar Google Translate API
        this.loadGoogleTranslateAPI();

        // Configurar botones de idioma
        this.setupLanguageButtons();

        // Inicializar estado de botones según idioma detectado
        this.updateButtonStates(this.currentLanguage);

        // Solo limpiar si está en inglés, sino mantener el estado
        if (this.currentLanguage === "en") {
            this.clearTranslationState();
        } else {
            // Si hay un idioma guardado diferente a inglés, aplicarlo
            // Esperar a que Google Translate esté listo antes de aplicar traducción
            setTimeout(() => {
                this.applyTranslationOnLoad(this.currentLanguage);
            }, 2000);
        }

        // Configurar observador para ocultar elementos de Google Translate
        this.setupGoogleTranslateHider();
    }

    clearTranslationState() {
        // Limpiar completamente cualquier estado de traducción
        sessionStorage.removeItem("preferred_language");
        localStorage.removeItem("googtrans");

        // Limpiar cookies de Google Translate si existen
        document.cookie =
            "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie =
            "googtrans=/auto/en; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

        // Asegurar que el documento esté en idioma original
        document.documentElement.lang = "en";
        document.documentElement.removeAttribute("class");

        // Limpiar cualquier parámetro de URL relacionado con traducción
        if (window.location.search.includes("lang=")) {
            const url = new URL(window.location);
            url.searchParams.delete("lang");
            window.history.replaceState(
                {},
                document.title,
                url.pathname + url.search
            );
        }
    }

    applyTranslationOnLoad(targetLanguage) {
        if (targetLanguage === "es") {
            // Establecer cookies para Google Translate
            document.cookie = `googtrans=/en/es; path=/; max-age=86400`;
            document.cookie = `googtrans=/auto/es; path=/; max-age=86400`;

            // Actualizar URL si es necesario
            if (!window.location.hash.includes("#googtrans")) {
                window.location.hash = "#googtrans(en|es)";
            }

            // Activar traducción
            this.activateGoogleTranslation("es");
        }
    }

    loadGoogleTranslateAPI() {
        // Crear script para Google Translate
        if (!document.getElementById("google-translate-script")) {
            const script = document.createElement("script");
            script.id = "google-translate-script";
            script.src =
                "https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
            script.async = true;
            document.head.appendChild(script);
        }

        // Función global requerida por Google Translate
        window.googleTranslateElementInit = () => {
            new google.translate.TranslateElement(
                {
                    pageLanguage: "en",
                    includedLanguages: "en,es",
                    layout: google.translate.TranslateElement.InlineLayout
                        .SIMPLE,
                    autoDisplay: false,
                    multilanguagePage: false,
                    gaTrack: false,
                    gaId: null,
                },
                "google_translate_element"
            );

            // Ocultar el widget de Google Translate después de inicialización
            setTimeout(() => {
                const translateWidget = document.getElementById(
                    "google_translate_element"
                );
                if (translateWidget) {
                    // Ocultar completamente el widget
                    translateWidget.style.display = "none";
                    translateWidget.style.visibility = "hidden";
                    translateWidget.style.position = "absolute";
                    translateWidget.style.left = "-9999px";
                    translateWidget.style.top = "-9999px";

                    // También ocultar cualquier elemento relacionado que pueda aparecer
                    const relatedElements = document.querySelectorAll(
                        ".goog-te-gadget, .goog-te-banner-frame, .VIpgJd-yAWNEb-L7lbkb"
                    );
                    relatedElements.forEach((element) => {
                        element.style.display = "none";
                        element.style.visibility = "hidden";
                    });
                }
            }, 1000);
        };
    }

    setupLanguageButtons() {
        const spanishBtn = document.getElementById("translate-es");
        const englishBtn = document.getElementById("translate-en");

        if (spanishBtn) {
            spanishBtn.addEventListener("click", () => {
                this.translateToLanguage("es");
            });
        }

        if (englishBtn) {
            englishBtn.addEventListener("click", () => {
                this.translateToLanguage("en");
            });
        }
    }

    translateToLanguage(targetLanguage) {
        if (targetLanguage === "en") {
            // Restaurar idioma original (inglés)
            sessionStorage.removeItem("preferred_language");
            // Limpiar cookies y hash
            document.cookie =
                "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            if (window.location.hash.includes("#googtrans")) {
                window.location.hash = "";
            }
            // Recargar página para limpiar completamente
            window.location.reload();
        } else if (targetLanguage === "es") {
            // Guardar preferencia de idioma POR TAB
            sessionStorage.setItem("preferred_language", "es");

            // Activar traducción a español usando Google Translate
            this.activateGoogleTranslation("es");
        }

        this.currentLanguage = targetLanguage;
        this.updateButtonStates(targetLanguage);
    }

    activateGoogleTranslation(targetLanguage) {
        // Quitar la clase notranslate para permitir traducción
        document.body.classList.remove("notranslate");
        document.documentElement.classList.remove("notranslate");

        // Agregar clase que indica que estamos traduciendo
        document.body.classList.add("translating");

        // Esperar a que Google Translate esté disponible
        const checkGoogleTranslate = () => {
            if (
                typeof google !== "undefined" &&
                google.translate &&
                google.translate.TranslateElement
            ) {
                this.triggerGoogleTranslation(targetLanguage);
            } else {
                setTimeout(checkGoogleTranslate, 300);
            }
        };

        checkGoogleTranslate();
    }

    triggerGoogleTranslation(targetLanguage) {
        const langCode = targetLanguage === "es" ? "es" : "en";

        // Método mejorado: Buscar el selector de Google Translate con reintentos
        let attempts = 0;
        const maxAttempts = 15;

        const findAndTrigger = () => {
            // Buscar múltiples posibles selectores
            let selectElement = document.querySelector(".goog-te-combo");
            let googleWidget = null;

            if (!selectElement) {
                // Buscar otros posibles selectores tradicionales
                selectElement =
                    document.querySelector('select[class*="goog"]') ||
                    document.querySelector('select[id*="google"]') ||
                    document.querySelector(
                        "#google_translate_element select"
                    ) ||
                    document.querySelector(".goog-te-gadget select") ||
                    document.querySelector('[class*="translate"] select');
            }

            // Si no hay select tradicional, buscar el widget moderno de Google Translate
            if (!selectElement) {
                googleWidget =
                    document.querySelector(".VIpgJd-ZVi9od-xl07Ob-lTBxed") ||
                    document.querySelector(".goog-te-gadget-simple a") ||
                    document.querySelector('[class*="VIpgJd"] a');
            }

            if (selectElement) {
                // Asegurarse de que el elemento esté visible y habilitado
                selectElement.style.display = "block";
                selectElement.disabled = false;

                // Establecer el valor
                selectElement.value = langCode === "en" ? "" : langCode;

                // Disparar múltiples eventos para asegurar la activación
                const events = ["change", "input", "click", "focus", "blur"];
                events.forEach((eventType) => {
                    const event = new Event(eventType, {
                        bubbles: true,
                        cancelable: true,
                        composed: true,
                    });
                    selectElement.dispatchEvent(event);
                });

                // Verificar si el cambio tuvo efecto
                setTimeout(() => {
                    const newValue = selectElement.value;
                    if (newValue === (langCode === "en" ? "" : langCode)) {
                        document.body.classList.remove("translating");
                    } else {
                        this.alternativeTranslation(langCode);
                    }
                }, 1000);

                return true;
            } else if (googleWidget) {
                // Para el widget moderno, necesitamos hacer clic para abrir el menú
                googleWidget.click();

                // Esperar a que aparezca el menú y buscar la opción de español
                setTimeout(() => {
                    // Buscar el menú desplegable que aparece después del clic
                    const menu =
                        document.querySelector("body > iframe") ||
                        document.querySelector(".goog-te-menu-frame") ||
                        document.querySelector('[class*="goog-te-menu"]') ||
                        document.querySelector('iframe[class*="goog-te"]');

                    if (menu) {
                        // Para iframe, necesitamos acceder al contenido interno
                        if (menu.tagName === "IFRAME") {
                            this.handleGoogleTranslateIframe(menu, langCode);
                        } else {
                            this.handleGoogleTranslateMenu(menu, langCode);
                        }
                    } else {
                        this.alternativeTranslation(langCode);
                    }
                }, 1500);

                return true;
            } else {
                attempts++;
                if (attempts < maxAttempts) {
                    setTimeout(findAndTrigger, 500);
                    return false;
                } else {
                    this.alternativeTranslation(langCode);
                    return false;
                }
            }
        };

        // Comenzar búsqueda inmediatamente
        findAndTrigger();
    }

    handleGoogleTranslateMenu(menu, langCode) {
        // Buscar la opción de español en el menú
        const spanishOption =
            menu.querySelector(`[data-value="${langCode}"]`) ||
            menu.querySelector(`[value="${langCode}"]`) ||
            menu.querySelector(`a[href*="${langCode}"]`);

        if (spanishOption) {
            spanishOption.click();
        } else {
            this.useUrlMethod(langCode);
        }
    }

    handleGoogleTranslateIframe(iframe, langCode) {
        // Método 1: Intentar acceder al contenido del iframe
        try {
            const iframeDoc =
                iframe.contentDocument || iframe.contentWindow.document;

            if (iframeDoc) {
                // Buscar la opción de español dentro del iframe con múltiples selectores
                const possibleSelectors = [
                    `[data-value="${langCode}"]`,
                    `[value="${langCode}"]`,
                    `a[href*="${langCode}"]`,
                    'a[data-value="es"]',
                    'span[data-value="es"]',
                    'div[data-value="es"]',
                    '*[data-language="es"]',
                    '*[data-lang="es"]',
                ];

                let spanishOption = null;
                for (const selector of possibleSelectors) {
                    try {
                        spanishOption = iframeDoc.querySelector(selector);
                        if (spanishOption) {
                            break;
                        }
                    } catch (e) {
                        // Ignorar errores de selectores CSS inválidos
                    }
                }

                // Si no encuentra por selectores, buscar por texto
                if (!spanishOption) {
                    const allElements = iframeDoc.querySelectorAll(
                        "a, span, div, td, tr"
                    );
                    for (const element of allElements) {
                        const text =
                            element.textContent || element.innerText || "";

                        // Buscar específicamente "español" sin incluir "Seleccionar idioma"
                        if (
                            text.toLowerCase().trim() === "español" ||
                            text.toLowerCase().trim() === "spanish" ||
                            (text.toLowerCase().includes("español") &&
                                !text.toLowerCase().includes("seleccionar") &&
                                text.length < 20)
                        ) {
                            spanishOption = element;
                            break;
                        }
                    }

                    // Si aún no encuentra, buscar en elementos más pequeños y específicos
                    if (!spanishOption) {
                        const smallElements =
                            iframeDoc.querySelectorAll("span, td");
                        for (const element of smallElements) {
                            const text = (
                                element.textContent ||
                                element.innerText ||
                                ""
                            ).trim();
                            if (
                                text === "español" ||
                                text === "Español" ||
                                text === "Spanish"
                            ) {
                                // Verificar que no sea el elemento padre que contiene todo
                                if (
                                    element.children.length === 0 ||
                                    element.children.length < 3
                                ) {
                                    spanishOption = element;
                                    break;
                                }
                            }
                        }
                    }
                }

                if (spanishOption) {
                    // Buscar el elemento clickeable más específico
                    let clickableElement = spanishOption;

                    // Si es un contenedor grande, buscar el elemento clickeable dentro
                    if (
                        spanishOption.tagName === "DIV" &&
                        spanishOption.children.length > 0
                    ) {
                        const clickableChild =
                            spanishOption.querySelector(
                                'a, span[onclick], td[onclick], [role="button"]'
                            ) || spanishOption.querySelector("span, td");
                        if (clickableChild) {
                            clickableElement = clickableChild;
                        }
                    }

                    // Si el elemento clickeable es padre de muchos elementos, buscar el más específico
                    if (clickableElement.children.length > 2) {
                        for (const child of clickableElement.children) {
                            const childText = (child.textContent || "")
                                .trim()
                                .toLowerCase();
                            if (
                                childText === "español" ||
                                childText === "spanish"
                            ) {
                                clickableElement = child;
                                break;
                            }
                        }
                    }

                    // Intentar múltiples formas de hacer clic
                    try {
                        // Hacer foco primero
                        if (clickableElement.focus) {
                            clickableElement.focus();
                        }

                        // Clic directo
                        clickableElement.click();

                        // También disparar eventos adicionales
                        [
                            "mousedown",
                            "mouseup",
                            "click",
                            "pointerdown",
                            "pointerup",
                        ].forEach((eventType) => {
                            try {
                                const event = new MouseEvent(eventType, {
                                    bubbles: true,
                                    cancelable: true,
                                    view: iframe.contentWindow,
                                });
                                clickableElement.dispatchEvent(event);
                            } catch (e) {
                                // Error silencioso
                            }
                        });

                        // Verificar si el menú se cerró (indicativo de éxito)
                        setTimeout(() => {
                            const menuStillOpen = iframeDoc.querySelector(
                                ".VIpgJd-ZVi9od-vH1Gmf"
                            );
                            if (!menuStillOpen) {
                                document.body.classList.remove("translating");
                                return; // NO continuar con métodos alternativos
                            } else {
                                this.alternativeTranslationWithoutReload(
                                    langCode
                                );
                            }
                        }, 2000);
                    } catch (clickError) {
                        this.alternativeTranslationWithoutReload(langCode);
                    }

                    return;
                }
            }
        } catch (error) {
            // Error silencioso
        }

        // Si llegamos aquí, usar método alternativo SIN recarga
        this.alternativeTranslationWithoutReload(langCode);
    }

    alternativeTranslationWithoutReload(langCode) {
        // Solo establecer cookies sin recargar
        if (langCode !== "en") {
            // Guardar preferencia POR TAB
            sessionStorage.setItem("preferred_language", langCode);

            document.cookie = `googtrans=/en/${langCode}; path=/; max-age=86400`;
            document.cookie = `googtrans=/auto/${langCode}; path=/; max-age=86400`;

            // Actualizar hash de URL
            if (!window.location.hash.includes("#googtrans")) {
                window.location.hash = `#googtrans(en|${langCode})`;
            }

            // Intentar forzar traducción sin recarga
            setTimeout(() => {
                const body = document.body;
                if (body && !body.classList.contains("translated")) {
                    // Intentar re-trigger de Google Translate
                    if (window.google && window.google.translate) {
                        try {
                            // Forzar re-inicialización
                            window.google.translate.translate();
                        } catch (e) {
                            // Error silencioso
                        }
                    }
                }
            }, 1000);
        }
    }

    alternativeTranslation(langCode) {
        // Método 1: Intentar buscar todos los elementos clickeables en el widget
        try {
            const widgets = document.querySelectorAll(
                "#google_translate_element *"
            );

            let foundClickableElement = false;
            widgets.forEach((element, index) => {
                if (foundClickableElement) return; // Ya encontramos uno

                const text = element.textContent || element.innerText || "";

                if (
                    text.toLowerCase().includes("español") ||
                    text.toLowerCase().includes("spanish")
                ) {
                    element.click();
                    foundClickableElement = true;
                    return;
                }
            });

            if (foundClickableElement) {
                return; // No continuar con otros métodos
            }
        } catch (e) {
            // Error silencioso
        }

        // Método 2: Solo cookies y URL sin recarga (como último recurso)
        if (langCode !== "en") {
            // Guardar preferencia POR TAB
            sessionStorage.setItem("preferred_language", langCode);

            // Establecer cookies
            document.cookie = `googtrans=/en/${langCode}; path=/; max-age=86400`;
            document.cookie = `googtrans=/auto/${langCode}; path=/; max-age=86400`;

            // Cambiar URL sin recargar inmediatamente
            const currentUrl = window.location.href;
            if (!currentUrl.includes("#googtrans")) {
                const newUrl = currentUrl + `#googtrans(en|${langCode})`;
                window.history.pushState({}, "", newUrl);
            }
        }
    }

    useUrlMethod(langCode) {
        if (langCode !== "en") {
            // Método de último recurso: recargar con parámetros de Google Translate
            const url = new URL(window.location);
            url.searchParams.set("lang", langCode);
            // También agregar el parámetro que usa Google Translate
            document.cookie = `googtrans=/en/${langCode}; path=/`;
            setTimeout(() => {
                window.location.href = url.toString();
            }, 100);
        }
    }

    restoreOriginalLanguage() {
        // Para restaurar al inglés, buscar el selector y restaurar
        setTimeout(() => {
            const selectElement = document.querySelector(".goog-te-combo");
            if (selectElement) {
                selectElement.value = ""; // Valor vacío = idioma original

                // Disparar eventos para activar la restauración
                ["change", "input", "click"].forEach((eventType) => {
                    selectElement.dispatchEvent(
                        new Event(eventType, { bubbles: true })
                    );
                });
            } else {
                // Como alternativa, recargar la página para restaurar completamente
                window.location.reload();
            }
        }, 200);
    }

    updateButtonStates(activeLanguage) {
        const spanishBtn = document.getElementById("translate-es");
        const englishBtn = document.getElementById("translate-en");

        // Reset todos los estados
        [spanishBtn, englishBtn].forEach((btn) => {
            if (btn) {
                btn.classList.remove("bg-amber-200", "font-bold");
                btn.classList.add("bg-white");
            }
        });

        // Activar botón seleccionado
        const activeBtn = activeLanguage === "es" ? spanishBtn : englishBtn;
        if (activeBtn) {
            activeBtn.classList.remove("bg-white");
            activeBtn.classList.add("bg-amber-200", "font-bold");
        }

        // Actualizar el idioma del documento
        document.documentElement.lang = activeLanguage;
    }

    setupGoogleTranslateHider() {
        // Función para ocultar elementos de Google Translate SOLO LOS VISUALES
        const hideGoogleTranslateElements = () => {
            const elementsToHide = [
                ".goog-te-banner-frame",
                ".goog-te-banner",
                "#goog-gt-tt",
                ".goog-tooltip",
                ".goog-te-spinner-pos",
                ".goog-te-balloon-frame",
                "body > .skiptranslate",
            ];

            elementsToHide.forEach((selector) => {
                const elements = document.querySelectorAll(selector);
                elements.forEach((element) => {
                    element.style.display = "none";
                    element.style.visibility = "hidden";
                    element.style.position = "absolute";
                    element.style.left = "-9999px";
                    element.style.top = "-9999px";
                });
            });

            // El widget principal solo ocultarlo visualmente
            const widget = document.getElementById("google_translate_element");
            if (widget) {
                widget.style.display = "none";
                widget.style.visibility = "hidden";
                widget.style.position = "absolute";
                widget.style.left = "-9999px";
                widget.style.top = "-9999px";
            }

            // Ocultar iframes de menú pero NO eliminarlos
            const iframes = document.querySelectorAll(
                "iframe.VIpgJd-ZVi9od-xl07Ob-OEVmcd"
            );
            iframes.forEach((iframe) => {
                iframe.style.opacity = "0";
                iframe.style.position = "absolute";
                iframe.style.left = "-9999px";
                iframe.style.top = "-9999px";
            });

            // Asegurar que el body no tenga padding-top añadido por Google Translate
            if (document.body.style.paddingTop) {
                document.body.style.paddingTop = "";
            }
            if (document.body.style.marginTop) {
                document.body.style.marginTop = "";
            }
        };

        // Ejecutar inmediatamente
        hideGoogleTranslateElements();

        // Configurar observador MENOS agresivo
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === "childList") {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === Node.ELEMENT_NODE) {
                            // Solo ocultar banners y tooltips, NO el widget funcional
                            if (
                                node.matches &&
                                (node.matches(".goog-te-banner") ||
                                    node.matches(".goog-te-banner-frame") ||
                                    node.matches(".skiptranslate") ||
                                    node.matches("#goog-gt-tt"))
                            ) {
                                setTimeout(hideGoogleTranslateElements, 100);
                            }
                        }
                    });
                }

                // Verificar cambios de atributos en body
                if (
                    mutation.type === "attributes" &&
                    mutation.target === document.body
                ) {
                    if (mutation.attributeName === "style") {
                        if (
                            document.body.style.paddingTop ||
                            document.body.style.marginTop
                        ) {
                            document.body.style.paddingTop = "";
                            document.body.style.marginTop = "";
                        }
                    }
                }
            });
        });

        // Observar cambios en el documento
        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ["style"],
        });

        // Ejecutar menos frecuentemente
        setInterval(hideGoogleTranslateElements, 5000);
    }
}

// Inicializar el sistema de traducción cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", function () {
    window.translationManager = new GoogleTranslationManager();
});
