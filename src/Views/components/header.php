<?php use App\Services\Language; ?>
<section>
  <nav class="navbar navbar-light">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="d-flex justify-content-center flex-grow-1">
        <ul class="navbar-nav d-flex flex-row align-items-center">
          <li class="nav-item mx-2 mx-md-3">
            <a class="nav-link fw-semibold text-dark" aria-current="page" href="/"><?= Language::get('nav.home') ?></a>
          </li>
          <li class="nav-item mx-2 mx-md-3">
            <a class="nav-link fw-semibold text-dark" aria-current="page" href="/about"><?= Language::get('nav.about') ?></a>
          </li>
          <li class="nav-item mx-2 mx-md-3">
            <a class="nav-link fw-semibold text-dark" aria-current="page" href="/contact"><?= Language::get('nav.contact') ?></a>
          </li>
          <li class="nav-item mx-2 mx-md-3 d-flex align-items-center">
            <a href="?lang=<?= Language::getCurrentLang() === 'fr' ? 'en' : 'fr' ?>" 
               class="btn rounded-circle p-2 d-flex align-items-center justify-content-center border-0 shadow-none"
               style="outline: none !important; height: 36px; width: 36px;">
              <img src="https://flagcdn.com/w20/<?= Language::getCurrentLang() === 'fr' ? 'fr' : 'us' ?>.png" 
                   width="20" height="15" alt="<?= Language::getCurrentLang() === 'fr' ? 'Français' : 'English' ?>" 
                   class="rounded-1">
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</section>