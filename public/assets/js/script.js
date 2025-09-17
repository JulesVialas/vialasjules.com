/**
 * Portfolio Website JavaScript
 * Modern ES6+ interactive functionality for portfolio navigation and forms
 */

'use strict';

/**
 * Utility function to toggle element active state
 * @param {Element} elem - Element to toggle
 */
const toggleElement = (elem) => elem?.classList.toggle('active');

/**
 * Initialize sidebar functionality
 */
const initializeSidebar = () => {
  const sidebar = document.querySelector('[data-sidebar]');
  const sidebarBtn = document.querySelector('[data-sidebar-btn]');

  if (sidebar && sidebarBtn) {
    sidebarBtn.addEventListener('click', () => toggleElement(sidebar));
  }
};

/**
 * Initialize form validation and submission
 */
const initializeFormValidation = () => {
  const form = document.querySelector('[data-form]');
  const formInputs = document.querySelectorAll('[data-form-input]');
  const formBtn = document.querySelector('[data-form-btn]');
  const formMessage = document.querySelector('[data-form-message]');

  if (!form || !formInputs.length || !formBtn) return;

  const validateForm = () => {
    if (form.checkValidity()) {
      formBtn.removeAttribute('disabled');
    } else {
      formBtn.setAttribute('disabled', '');
    }
  };

  const showMessage = (message, isSuccess = false) => {
    if (formMessage) {
      formMessage.textContent = message;
      formMessage.className = `form-message ${isSuccess ? 'success' : 'error'}`;
      formMessage.style.display = 'block';
      
      // Hide message after 5 seconds
      setTimeout(() => {
        formMessage.style.display = 'none';
      }, 5000);
    }
  };

  const setFormLoading = (loading) => {
    if (loading) {
      formBtn.setAttribute('disabled', '');
      formBtn.innerHTML = '<ion-icon name="hourglass-outline"></ion-icon><span>Envoi en cours...</span>';
    } else {
      formBtn.innerHTML = '<ion-icon name="paper-plane"></ion-icon><span>Envoyer le message</span>';
      validateForm();
    }
  };

  // Add input event listeners
  formInputs.forEach(input => {
    input.addEventListener('input', validateForm);
  });

  // Handle form submission
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    if (!form.checkValidity()) return;
    
    setFormLoading(true);
    
    try {
      const formData = new FormData(form);
      const response = await fetch('/contact', {
        method: 'POST',
        body: formData
      });
      
      const result = await response.json();
      
      if (result.status === 'success') {
        showMessage(result.message, true);
        form.reset();
      } else {
        showMessage(result.message, false);
      }
    } catch (error) {
      showMessage('Erreur de connexion. Veuillez réessayer.', false);
    } finally {
      setFormLoading(false);
    }
  });
};

/**
 * Initialize navigation functionality
 */
const initializeNavigation = () => {
  const navigationLinks = document.querySelectorAll('[data-nav-link]');
  const pages = document.querySelectorAll('[data-page]');

  if (!navigationLinks.length || !pages.length) return;

  // Check URL parameter for initial page
  const urlParams = new URLSearchParams(window.location.search);
  const initialPage = urlParams.get('page');

  if (initialPage) {
    // Set initial page from URL parameter
    pages.forEach(page => {
      if (initialPage === page.dataset.page) {
        page.classList.add('active');
      } else {
        page.classList.remove('active');
      }
    });

    navigationLinks.forEach(navLink => {
      if (navLink.dataset.page === initialPage) {
        navLink.classList.add('active');
      } else {
        navLink.classList.remove('active');
      }
    });
  }

  navigationLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      
      const targetPage = link.dataset.page;
      
      // Update active page
      pages.forEach(page => {
        if (targetPage === page.dataset.page) {
          page.classList.add('active');
        } else {
          page.classList.remove('active');
        }
      });
      
      // Update active navigation link
      navigationLinks.forEach(navLink => {
        if (navLink === link) {
          navLink.classList.add('active');
        } else {
          navLink.classList.remove('active');
        }
      });
      
      // Smooth scroll to top
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  });
};

/**
 * Initialize language switching functionality
 */
const initializeLanguageSwitch = () => {
  const langLinks = document.querySelectorAll('[data-lang-switch]');
  
  langLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const lang = link.dataset.lang;
      
      // Get current active page
      const activePage = document.querySelector('[data-page].active');
      const currentPage = activePage ? activePage.dataset.page : 'about';
      
      // Add language parameter to current URL and preserve current page
      const url = new URL(window.location);
      url.searchParams.set('lang', lang);
      url.searchParams.set('page', currentPage);
      window.location.href = url.toString();
    });
  });
};

/**
 * Initialize all functionality when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', () => {
  initializeSidebar();
  initializeFormValidation();
  initializeNavigation();
  initializeLanguageSwitch();
});