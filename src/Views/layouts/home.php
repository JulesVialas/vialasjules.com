<?php
/**
 * Portfolio Website Layout
 * Main HTML template for the portfolio website with responsive design
 */

use App\Services\Language;
?>
<!DOCTYPE html>
<html lang="<?= Language::getCurrentLanguage() ?>">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jules Vialas - <?= Language::get('title.developer') ?></title>
  
  <!-- SEO Meta Tags -->
  <meta name="description" content="<?= Language::get('about.description') ?>">
  <meta name="keywords" content="développeur, web, mobile, PHP, JavaScript, portfolio">
  <meta name="author" content="Jules Vialas">
  
  <!-- Favicon -->
  <link rel="shortcut icon" href="./assets/images/logo.ico" type="image/x-icon">
  
  <!-- Stylesheets -->
  <link rel="stylesheet" href="./assets/css/style.css">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
  <main>
    <aside class="sidebar" data-sidebar>
      <div class="sidebar-info">
        <figure class="avatar-box">
          <img src="./assets/images/hero.jpeg" alt="Jules Vialas" width="80" height="80">
        </figure>
        <div class="info-content">
          <h1 class="name" title="Jules Vialas">Jules Vialas</h1>
          <p class="title"><?= Language::get('title.developer') ?></p>
        </div>
        <button class="info_more-btn" data-sidebar-btn>
          <span><?= Language::get('title.show_contacts') ?></span>
          <ion-icon name="chevron-down"></ion-icon>
        </button>
      </div>
      <div class="sidebar-info_more">
        <div class="separator"></div>
        <ul class="contacts-list">
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="mail-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title"><?= Language::get('contact.email') ?></p>
              <a href="mailto:jules.vialas@gmail.com" class="contact-link">jules.vialas@gmail.com</a>
            </div>
          </li>
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="phone-portrait-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title"><?= Language::get('contact.phone') ?></p>
              <a href="tel:+33781573531" class="contact-link">+33 7 81 57 35 31</a>
            </div>
          </li>
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="calendar-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title"><?= Language::get('contact.birthday') ?></p>
              <time datetime="2005-11-16"><?= Language::get('date.november') ?> 16, 2005</time>
            </div>
          </li>
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="location-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title"><?= Language::get('contact.location') ?></p>
              <address>Toulouse, France</address>
            </div>
          </li>
        </ul>
        <div class="separator"></div>
        <ul class="social-list">
          <li class="social-item">
            <a href="https://www.linkedin.com/in/julesvialas" class="social-link" target="_blank" rel="noopener noreferrer">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>
          <li class="social-item">
            <a href="https://github.com/JulesVialas" class="social-link" target="_blank" rel="noopener noreferrer">
              <ion-icon name="logo-github"></ion-icon>
            </a>
          </li>
        </ul>
      </div>
    </aside>
    <div class="main-content">
      <div class="language-selector-header">
        <a href="#" class="lang-switch" data-lang-switch data-lang="<?= Language::getCurrentLanguage() === 'fr' ? 'en' : 'fr' ?>">
          <ion-icon name="language-outline"></ion-icon>
          <span><?= Language::getCurrentLanguage() === 'fr' ? 'Français' : 'English' ?></span>
        </a>
      </div>
      <nav class="navbar">
        <ul class="navbar-list">
          <li class="navbar-item">
            <button class="navbar-link active" data-nav-link data-page="about"><?= Language::get('nav.about') ?></button>
          </li>
          <li class="navbar-item">
            <button class="navbar-link" data-nav-link data-page="resume"><?= Language::get('nav.resume') ?></button>
          </li>
          <li class="navbar-item">
            <button class="navbar-link" data-nav-link data-page="contact"><?= Language::get('nav.contact') ?></button>
          </li>
        </ul>
      </nav>
      <article class="about  active" data-page="about">
        <header>
          <h2 class="h2 article-title"><?= Language::get('about.title') ?></h2>
        </header>
        <section class="about-text">
          <p>
            <?= Language::get('about.description') ?>
          </p>
        </section>
        <section class="service">
          <h3 class="h3 service-title"><?= Language::get('services.title') ?></h3>
          <ul class="service-list">
            <li class="service-item">
              <div class="service-icon-box">
                <img src="./assets/images/home-automation-icon.svg" alt="home automation icon" width="40">
              </div>
              <div class="service-content-box">
                <h4 class="h4 service-item-title"><?= Language::get('service.domotique.title') ?></h4>
                <p class="service-item-text">
                  <?= Language::get('service.domotique.desc') ?>
                </p>
              </div>
            </li>
            <li class="service-item">
              <div class="service-icon-box">
                <img src="./assets/images/web-development-icon.svg" alt="Web development icon" width="40">
              </div>
              <div class="service-content-box">
                <h4 class="h4 service-item-title"><?= Language::get('service.webdev.title') ?></h4>
                <p class="service-item-text">
                  <?= Language::get('service.webdev.desc') ?>
                </p>
              </div>
            </li>
            <li class="service-item">
              <div class="service-icon-box">
                <img src="./assets/images/mobile-applications-icon.svg" alt="mobile app icon" width="40">
              </div>
              <div class="service-content-box">
                <h4 class="h4 service-item-title"><?= Language::get('service.mobile.title') ?></h4>
                <p class="service-item-text">
                  <?= Language::get('service.mobile.desc') ?>
                </p>
              </div>
            </li>
            <li class="service-item">
              <div class="service-icon-box">
                <img src="./assets/images/java-development-icon.svg" alt="java development icon" width="40">
              </div>
              <div class="service-content-box">
                <h4 class="h4 service-item-title"><?= Language::get('service.java.title') ?></h4>
                <p class="service-item-text">
                  <?= Language::get('service.java.desc') ?>
                </p>
              </div>
            </li>
          </ul>
        </section>
        <section class="clients">
          <h3 class="h3 clients-title"><?= Language::get('clients.title') ?></h3>
          <ul class="clients-list has-scrollbar">
            <li class="clients-item">
              <a href="https://www.subterra.fr" target="_blank" rel="noopener noreferrer">
                <img src="../../assets/images/logo-subterra.png" alt="Subterra logo">
              </a>
            </li>
          </ul>
        </section>
      </article>
      <article class="resume" data-page="resume">
        <header>
          <h2 class="h2 article-title"><?= Language::get('resume.title') ?></h2>
        </header>
        <section class="timeline">
          <div class="title-wrapper">
            <div class="icon-box">
              <ion-icon name="book-outline"></ion-icon>
            </div>
            <h3 class="h3"><?= Language::get('education.title') ?></h3>
          </div>
          <ol class="timeline-list">
            <li class="timeline-item">
              <h4 class="h4 timeline-item-title"><?= Language::get('edu.miage.title') ?></h4>
              <span>2025 — 2026</span>
              <p class="timeline-text">
                <?= Language::get('edu.miage.desc') ?>
              </p>
            </li>
            <li class="timeline-item">
              <h4 class="h4 timeline-item-title"><?= Language::get('edu.but.title') ?></h4>
              <span>2023 — 2025</span>
              <p class="timeline-text">
                <?= Language::get('edu.but.desc') ?>
              </p>
            </li>
            <li class="timeline-item">
              <h4 class="h4 timeline-item-title"><?= Language::get('edu.bac.title') ?></h4>
              <span>2020 — 2023</span>
              <p class="timeline-text">
                <?= Language::get('edu.bac.desc') ?>
              </p>
            </li>
          </ol>
        </section>
        <section class="timeline">
          <div class="title-wrapper">
            <div class="icon-box">
              <ion-icon name="book-outline"></ion-icon>
            </div>
            <h3 class="h3"><?= Language::get('experience.title') ?></h3>
          </div>
          <ol class="timeline-list">
            <li class="timeline-item">
              <h4 class="h4 timeline-item-title"><?= Language::get('exp.c1.cdd.title') ?></h4>
              <span>Jul. 2025 — Aug. 2025</span>
              <p class="timeline-text">
                <?= Language::get('exp.c1.cdd.desc') ?>
              </p>
            </li>
            <li class="timeline-item">
              <h4 class="h4 timeline-item-title"><?= Language::get('exp.c1.stage.title') ?></h4>
              <span>Apr. 2025 — Jul. 2025</span>
              <p class="timeline-text">
                <?= Language::get('exp.c1.stage.desc') ?>
              </p>
            </li>
            <li class="timeline-item">
              <h4 class="h4 timeline-item-title"><?= Language::get('exp.subterra.title') ?></h4>
              <span>Summer 2024</span>
              <p class="timeline-text">
                <?= Language::get('exp.subterra.desc') ?>
              </p>
            </li>
          </ol>
        </section>
      </article>
      <article class="contact" data-page="contact">
        <header>
          <h2 class="h2 article-title"><?= Language::get('contact.title') ?></h2>
        </header>
        <section class="contact-form">
          <h3 class="h3 form-title"><?= Language::get('contact.form_title') ?></h3>
          <form action="/contact" method="POST" class="form" data-form>
            <div class="input-wrapper">
              <input type="text" name="fullname" class="form-input" placeholder="<?= Language::get('contact.fullname') ?>" required data-form-input>
              <input type="email" name="email" class="form-input" placeholder="<?= Language::get('contact.email_address') ?>" required data-form-input>
            </div>
            <textarea name="message" class="form-input" placeholder="<?= Language::get('contact.message') ?>" required data-form-input></textarea>
            <button class="form-btn" type="submit" disabled data-form-btn>
              <ion-icon name="paper-plane"></ion-icon>
              <span><?= Language::get('contact.send') ?></span>
            </button>
            <div class="form-message" data-form-message style="display: none;"></div>
          </form>
        </section>
      </article>
    </div>
  </main>
  <script src="./assets/js/script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>