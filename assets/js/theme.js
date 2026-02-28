/**
 * Multiloquent theme — vanilla JS
 *
 * Responsibilities:
 *  - Slide-in sidebar toggle (hamburger button)
 *  - Close sidebar on overlay click or Escape key
 *  - Mark current nav item as active
 *  - Lazy nav-submenu disclosure for keyboard users
 */
(function () {
  'use strict';

  /* ------------------------------------------------------------------ */
  /*  Sidebar toggle                                                       */
  /* ------------------------------------------------------------------ */
  const sidebar  = document.getElementById('sidebar');
  const overlay  = document.getElementById('sidebar-overlay');
  const toggleBtns = document.querySelectorAll('.sidebar-toggle');

  if (sidebar && overlay) {
    function openSidebar() {
      sidebar.classList.remove('-translate-x-full');
      overlay.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      toggleBtns.forEach(btn => btn.setAttribute('aria-expanded', 'true'));
      // Move focus into sidebar for accessibility
      const firstLink = sidebar.querySelector('a, button');
      if (firstLink) firstLink.focus();
    }

    function closeSidebar() {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
      document.body.style.overflow = '';
      toggleBtns.forEach(btn => btn.setAttribute('aria-expanded', 'false'));
    }

    toggleBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const isOpen = btn.getAttribute('aria-expanded') === 'true';
        isOpen ? closeSidebar() : openSidebar();
      });
    });

    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') closeSidebar();
    });
  }

  /* ------------------------------------------------------------------ */
  /*  Mark current page link as active in sidebar nav                     */
  /* ------------------------------------------------------------------ */
  const currentUrl = window.location.href.replace(/#.*$/, '');
  document.querySelectorAll('#sidebar a[href]').forEach(link => {
    const href = link.href.replace(/#.*$/, '');
    if (href === currentUrl) {
      link.setAttribute('aria-current', 'page');
      link.classList.add('font-semibold', 'text-[var(--color-primary)]');
    }
  });

  /* ------------------------------------------------------------------ */
  /*  Submenu disclosure buttons (keyboard-friendly nested menus)         */
  /* ------------------------------------------------------------------ */
  document.querySelectorAll('#sidebar .menu-item-has-children').forEach(item => {
    const link    = item.querySelector(':scope > a');
    const submenu = item.querySelector(':scope > ul');
    if (!link || !submenu) return;

    // Hide submenu by default (CSS handles visibility, but set aria state)
    submenu.hidden = true;

    // Create disclosure button
    const btn = document.createElement('button');
    btn.setAttribute('aria-expanded', 'false');
    btn.setAttribute('aria-label', link.textContent.trim() + ' submenu');
    btn.className = 'ml-1 p-0.5 rounded hover:bg-[var(--color-surface-alt)] transition-colors';
    btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
      <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
    </svg>`;

    link.insertAdjacentElement('afterend', btn);

    btn.addEventListener('click', e => {
      e.preventDefault();
      const expanded = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', String(!expanded));
      submenu.hidden = expanded;
      btn.querySelector('svg').style.transform = expanded ? '' : 'rotate(180deg)';
    });
  });

  /* ------------------------------------------------------------------ */
  /*  Smooth scroll for anchor links within the page                      */
  /* ------------------------------------------------------------------ */
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', e => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

})();
