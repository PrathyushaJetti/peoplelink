<?php include('header.php'); ?>



<style>

/* =========================================================
   PEOPLELINK ABOUT US PAGE
   COMPLETE SINGLE PAGE
========================================================= */

:root {
    --pl-blue: #07579D;
    --pl-sky: #1689CF;
    --pl-green: #42B82A;
    --pl-orange: #F58A16;
    --pl-red: #E51E4D;
    --pl-purple: #6333C5;
    --pl-dark: #092B4C;
    --pl-text: #536C80;
    --pl-light: #F5F9FC;
    --pl-border: #DFEAF1;
    --pl-white: #FFFFFF;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html {
    scroll-behavior: smooth;
}

body {
    margin: 0;
    font-family: "Inter", sans-serif;
    color: var(--pl-dark);
    background: #ffffff;
    overflow-x: hidden;
}

img {
    max-width: 100%;
}

button,
a {
    font-family: inherit;
}

a {
    text-decoration: none;
}

.pl-about-page {
    width: 100%;
    overflow: hidden;
}


/* =========================================================
   COMMON CONTAINER
========================================================= */

.pl-container {
    width: min(1380px, calc(100% - 40px));
    margin: 0 auto;
}


/* =========================================================
   COMMON SECTION LABEL
========================================================= */

.pl-label {
    display: inline-flex;
    align-items: center;
    gap: 10px;

    color: var(--pl-blue);

    font-size: 13px;
    font-weight: 800;

    letter-spacing: 1.5px;
}

.pl-label::before {
    content: "";
    width: 32px;
    height: 2px;

    border-radius: 10px;

    background: linear-gradient(
        90deg,
        var(--pl-blue),
        var(--pl-green)
    );
}

.pl-label.center {
    justify-content: center;
}

.pl-label.center::after {
    content: "";
    width: 32px;
    height: 2px;

    border-radius: 10px;

    background: linear-gradient(
        90deg,
        var(--pl-green),
        var(--pl-blue)
    );
}


/* =========================================================
   HERO
========================================================= */

.pl-about-hero {
    position: relative;

    min-height: 430px;

    display: flex;
    align-items: center;
    justify-content: center;

    text-align: center;

    padding: 65px 20px 30px;

    overflow: hidden;

    background:
        radial-gradient(
            circle at 0% 20%,
            rgba(22,137,207,.18),
            transparent 28%
        ),
        radial-gradient(
            circle at 100% 80%,
            rgba(66,184,42,.15),
            transparent 30%
        ),
        linear-gradient(
            135deg,
            #E6F5FF 0%,
            #F8FBFF 50%,
            #EFF9E9 100%
        );
}

/* Decorative left circles */

.pl-about-hero::before {
    content: "";

    position: absolute;

    width: 470px;
    height: 470px;

    left: -285px;
    top: -190px;

    border-radius: 50%;

    border: 65px solid rgba(22,137,207,.07);

    box-shadow:
        0 0 0 35px rgba(22,137,207,.04),
        0 0 0 80px rgba(22,137,207,.025);

    pointer-events: none;
}

/* Decorative right circles */

.pl-about-hero::after {
    content: "";

    position: absolute;

    width: 400px;
    height: 400px;

    right: -250px;
    bottom: -250px;

    border-radius: 50%;

    border: 60px solid rgba(66,184,42,.07);

    box-shadow:
        0 0 0 35px rgba(66,184,42,.04),
        0 0 0 80px rgba(66,184,42,.025);

    pointer-events: none;
}

.pl-hero-content {
    position: relative;
    z-index: 5;

    width: 100%;
    max-width: 950px;

    margin: auto;
}

.pl-hero-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;

    padding: 8px 18px;

    border: 1px solid #D8E6F0;
    border-radius: 30px;

    background: rgba(255,255,255,.85);

    color: var(--pl-blue);

    font-size: 13px;
    font-weight: 800;

    letter-spacing: 1.5px;

    box-shadow: 0 8px 25px rgba(7,87,157,.06);
}

.pl-hero-badge i {
    color: var(--pl-green);
}

.pl-hero-content h1 {
    margin: 25px auto 20px;

    max-width: 950px;

    font-family: "Manrope", sans-serif;

    font-size: clamp(44px, 5.5vw, 70px);

    line-height: 1.03;

    letter-spacing: -2.5px;

    font-weight: 800;

    color: var(--pl-dark);
}

.pl-hero-content h1 span {
    display: block;

    background: linear-gradient(
        90deg,
        var(--pl-blue),
        var(--pl-sky),
        #1599B8,
        var(--pl-green)
    );

    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.pl-hero-content > p {
    max-width: 760px;

    margin: 0 auto;

    color: #48677D;

    font-size: 18px;
    line-height: 1.7;
}

.pl-breadcrumb {
    display: flex;
    align-items: center;
    justify-content: center;

    gap: 10px;

    margin-top: 27px;

    font-size: 14px;
    font-weight: 600;
}

.pl-breadcrumb a {
    color: var(--pl-blue);
}

.pl-breadcrumb i {
    color: var(--pl-orange);
    font-size: 11px;
}


/* =========================================================
   INTRODUCTION
========================================================= */

.pl-intro {
    padding: 105px 0;

    background:
        linear-gradient(
            180deg,
            #ffffff,
            #F5FAFE
        );
}

.pl-intro-grid {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 80px;

    align-items: center;
}


/* IMAGE */

.pl-main-image {
    position: relative;
}

.pl-main-image img {
    position: relative;
    z-index: 2;

    width: 100%;
    height: 570px;

    object-fit: cover;

    display: block;

    border-radius: 30px;

    box-shadow:
        0 25px 60px rgba(7,87,157,.16);
}

.pl-main-image::before {
    content: "";

    position: absolute;

    width: 130px;
    height: 130px;

    left: -22px;
    bottom: -22px;

    border-radius: 25px;

    background: linear-gradient(
        135deg,
        var(--pl-sky),
        var(--pl-green)
    );

    z-index: 1;
}

.pl-main-image::after {
    content: "";

    position: absolute;

    width: 90px;
    height: 90px;

    right: -28px;
    top: -28px;

    background-image:
        radial-gradient(
            var(--pl-green) 2px,
            transparent 2px
        );

    background-size: 15px 15px;

    z-index: 1;
}

.pl-image-card {
    position: absolute;

    z-index: 5;

    left: 25px;
    bottom: 25px;

    display: flex;
    align-items: center;

    gap: 13px;

    padding: 16px 20px;

    border-radius: 17px;

    background: rgba(255,255,255,.96);

    box-shadow:
        0 15px 40px rgba(0,0,0,.14);
}

.pl-image-card-icon {
    width: 48px;
    height: 48px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 14px;

    background: linear-gradient(
        135deg,
        var(--pl-blue),
        var(--pl-sky)
    );

    color: white;

    font-size: 20px;
}

.pl-image-card strong,
.pl-image-card span {
    display: block;
}

.pl-image-card strong {
    font-size: 15px;
}

.pl-image-card span {
    margin-top: 3px;

    color: #718494;

    font-size: 12px;
}


/* INTRO CONTENT */

.pl-intro-content h2 {
    margin: 20px 0;

    font-family: "Manrope", sans-serif;

    font-size: clamp(36px, 4vw, 52px);

    line-height: 1.1;

    letter-spacing: -1.7px;
}

.pl-intro-content h2 span {
    color: var(--pl-sky);
}

.pl-intro-content .lead {
    color: #304F67;

    font-size: 19px;
    line-height: 1.8;

    font-weight: 500;
}

.pl-intro-content p:not(.lead) {
    margin-top: 16px;

    color: var(--pl-text);

    font-size: 16px;
    line-height: 1.8;
}

.pl-intro-features {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 12px;

    margin-top: 28px;
}

.pl-intro-feature {
    display: flex;
    align-items: center;

    gap: 10px;

    padding: 13px 15px;

    border-radius: 12px;

    background: #F1F8FC;

    color: #405C71;

    font-size: 14px;
    font-weight: 700;
}

.pl-intro-feature i {
    color: var(--pl-sky);

    font-size: 18px;
}


/* =========================================================
   COMMUNITY ECOSYSTEM
========================================================= */

.pl-ecosystem {
    padding: 105px 0;

    background:
        linear-gradient(
            135deg,
            #EDF8FF,
            #FFFFFF 48%,
            #F3FBEF
        );
}

.pl-section-head {
    max-width: 850px;

    margin: 0 auto 55px;

    text-align: center;
}

.pl-section-head h2 {
    margin: 18px 0;

    font-family: "Manrope", sans-serif;

    font-size: clamp(36px, 4vw, 52px);

    line-height: 1.12;

    letter-spacing: -1.5px;
}

.pl-section-head h2 span {
    color: var(--pl-sky);
}

.pl-section-head p {
    color: #61778A;

    font-size: 17px;
    line-height: 1.75;
}


/* CARDS */

.pl-ecosystem-grid {
    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 25px;
}

.pl-eco-card {
    overflow: hidden;

    background: #fff;

    border-radius: 22px;

    box-shadow:
        0 15px 40px rgba(9,43,76,.08);

    transition: .35s ease;
}

.pl-eco-card:hover {
    transform: translateY(-8px);

    box-shadow:
        0 25px 55px rgba(9,43,76,.14);
}

.pl-eco-image {
    position: relative;

    height: 235px;
}

.pl-eco-image img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}

.pl-eco-image::after {
    content: "";

    position: absolute;
    inset: 0;

    background:
        linear-gradient(
            180deg,
            transparent 45%,
            rgba(0,0,0,.25)
        );
}

.pl-eco-icon {
    position: absolute;

    z-index: 5;

    left: 22px;
    bottom: -25px;

    width: 58px;
    height: 58px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 17px;

    background: var(--pl-blue);

    color: #fff;

    font-size: 22px;

    box-shadow: 0 10px 25px rgba(7,87,157,.3);
}

.pl-eco-card.green .pl-eco-icon {
    background: var(--pl-green);
}

.pl-eco-card.orange .pl-eco-icon {
    background: var(--pl-orange);
}

.pl-eco-card.purple .pl-eco-icon {
    background: var(--pl-purple);
}

.pl-eco-card.red .pl-eco-icon {
    background: var(--pl-red);
}

.pl-eco-card.teal .pl-eco-icon {
    background: #1599A8;
}

.pl-eco-content {
    padding: 45px 25px 27px;
}

.pl-eco-number {
    color: var(--pl-sky);

    font-size: 12px;
    font-weight: 800;
}

.pl-eco-content h3 {
    margin: 8px 0 10px;

    font-family: "Manrope", sans-serif;

    font-size: 21px;
}

.pl-eco-content p {
    color: #6A7E8E;

    font-size: 15px;

    line-height: 1.7;
}


/* =========================================================
   VISION / MISSION
========================================================= */

.pl-purpose {
    padding: 105px 0;

    background: #ffffff;
}

.pl-purpose-grid {
    display: grid;

    grid-template-columns: .95fr 1.05fr;

    gap: 75px;

    align-items: center;
}

.pl-purpose-image {
    position: relative;
}

.pl-purpose-image img {
    width: 100%;
    height: 600px;

    object-fit: cover;

    border-radius: 30px;

    box-shadow:
        0 25px 60px rgba(9,43,76,.14);
}

.pl-purpose-badge {
    position: absolute;

    left: 25px;
    bottom: 25px;

    display: flex;
    align-items: center;

    gap: 10px;

    padding: 14px 20px;

    border-radius: 15px;

    background: rgba(255,255,255,.95);

    color: var(--pl-blue);

    font-size: 12px;
    font-weight: 800;

    letter-spacing: 1px;
}

.pl-purpose-badge i {
    color: var(--pl-green);

    font-size: 20px;
}

.pl-purpose-content h2 {
    margin: 20px 0;

    font-family: "Manrope", sans-serif;

    font-size: clamp(35px, 4vw, 50px);

    line-height: 1.1;
}

.pl-purpose-content h2 span {
    color: var(--pl-sky);
}

.pl-purpose-card {
    display: flex;

    gap: 20px;

    padding: 24px;

    margin-top: 20px;

    border-radius: 18px;

    background: #F7FBFD;

    border: 1px solid var(--pl-border);
}

.pl-purpose-card.mission {
    background: #F7FCF4;

    border-color: #DDEDD8;
}

.pl-purpose-icon {
    flex: 0 0 55px;

    width: 55px;
    height: 55px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    background: #E6F3FC;

    color: var(--pl-blue);

    font-size: 21px;
}

.pl-purpose-card.mission .pl-purpose-icon {
    background: #E8F7E3;

    color: var(--pl-green);
}

.pl-purpose-card small {
    color: var(--pl-sky);

    font-size: 11px;
    font-weight: 800;

    letter-spacing: 1.2px;
}

.pl-purpose-card h3 {
    margin: 7px 0;

    font-size: 20px;
}

.pl-purpose-card p {
    color: #65798A;

    font-size: 15px;

    line-height: 1.7;
}


/* =========================================================
   MULTIPLE COMMUNITIES
========================================================= */

.pl-multiple {
    padding: 110px 0;

    background:
        linear-gradient(
            135deg,
            #F3FAFF,
            #EFF9EB
        );
}

.pl-multiple-grid {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 80px;

    align-items: center;
}

.pl-community-visual {
    position: relative;

    min-height: 510px;

    display: flex;

    align-items: center;
    justify-content: center;
}

.pl-circle {
    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;
}

.pl-circle.one {
    width: 420px;
    height: 420px;

    background: rgba(22,137,207,.08);

    border: 2px solid rgba(22,137,207,.14);
}

.pl-circle.two {
    width: 300px;
    height: 300px;

    background: rgba(66,184,42,.08);

    border: 2px solid rgba(66,184,42,.14);
}

.pl-circle.three {
    width: 170px;
    height: 170px;

    background: #ffffff;

    box-shadow:
        0 20px 50px rgba(9,43,76,.14);
}

.pl-circle.three img {
    width: 125px;
}

.pl-floating {
    position: absolute;

    display: flex;
    align-items: center;

    gap: 9px;

    padding: 13px 17px;

    background: #fff;

    border-radius: 14px;

    box-shadow:
        0 12px 30px rgba(9,43,76,.12);

    font-size: 14px;
    font-weight: 700;

    transition: .3s ease;
}

.pl-floating:hover {
    transform: translateY(-6px);
}

.pl-floating i {
    color: var(--pl-sky);
}

.pl-floating.one {
    top: 40px;
    left: 20px;
}

.pl-floating.two {
    top: 110px;
    right: 0;
}

.pl-floating.three {
    bottom: 90px;
    left: 0;
}

.pl-floating.four {
    bottom: 25px;
    right: 35px;
}

.pl-multiple-content {
    display: grid;

    gap: 17px;
}

.pl-multiple-item {
    display: flex;

    gap: 18px;

    padding: 23px;

    border-radius: 18px;

    background: rgba(255,255,255,.9);

    border: 1px solid #DFEAF0;

    transition: .3s ease;
}

.pl-multiple-item:hover {
    transform: translateX(6px);

    box-shadow:
        0 15px 35px rgba(9,43,76,.08);
}

.pl-multiple-item > i {
    flex: 0 0 52px;

    width: 52px;
    height: 52px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 14px;

    background: #EAF6FD;

    color: var(--pl-blue);

    font-size: 20px;
}

.pl-multiple-item h3 {
    margin-bottom: 7px;

    font-size: 18px;
}

.pl-multiple-item p {
    color: #687D8E;

    font-size: 14px;

    line-height: 1.65;
}


/* =========================================================
   DIGITAL IDENTITY
========================================================= */

.pl-identity {
    padding: 100px 0;

    background: #ffffff;
}

.pl-identity-grid {
    display: grid;

    grid-template-columns: repeat(7, 1fr);

    gap: 15px;
}

.pl-identity-card {
    min-height: 170px;

    padding: 20px 12px;

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    text-align: center;

    border-radius: 18px;

    background: #F5FAFD;

    border: 1px solid #DFEAF1;

    transition: .3s ease;
}

.pl-identity-card:hover {
    transform: translateY(-6px);

    background: #fff;

    box-shadow:
        0 15px 35px rgba(9,43,76,.09);
}

.pl-identity-card i {
    width: 52px;
    height: 52px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 13px;

    border-radius: 15px;

    background: #E6F3FC;

    color: var(--pl-blue);

    font-size: 20px;
}

.pl-identity-card strong {
    font-size: 15px;
}

.pl-identity-card span {
    margin-top: 5px;

    color: #7A8D9C;

    font-size: 12px;
}


/* =========================================================
   PRIVACY
========================================================= */

.pl-privacy {
    padding: 105px 0;

    background:
        linear-gradient(
            135deg,
            #EEF8FF,
            #F5FFF1
        );
}

.pl-privacy-grid {
    display: grid;

    grid-template-columns: .9fr 1.1fr;

    gap: 70px;

    align-items: center;
}

.pl-privacy-image {
    position: relative;
}

.pl-privacy-image img {
    width: 100%;
    height: 460px;

    object-fit: cover;

    border-radius: 28px;

    box-shadow:
        0 25px 55px rgba(9,43,76,.13);
}

.pl-privacy-icon {
    position: absolute;

    right: 25px;
    bottom: 25px;

    width: 70px;
    height: 70px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 20px;

    background: linear-gradient(
        135deg,
        var(--pl-blue),
        var(--pl-sky)
    );

    color: #fff;

    font-size: 27px;

    box-shadow:
        0 15px 35px rgba(7,87,157,.3);
}

.pl-privacy-content h2 {
    margin: 20px 0;

    font-family: "Manrope", sans-serif;

    font-size: clamp(35px, 4vw, 50px);

    line-height: 1.1;
}

.pl-privacy-content h2 span {
    color: var(--pl-sky);
}

.pl-privacy-content > p {
    color: #607688;

    font-size: 17px;

    line-height: 1.8;
}

.pl-privacy-list {
    display: grid;

    gap: 13px;

    margin-top: 25px;
}

.pl-privacy-list div {
    display: flex;

    align-items: center;

    gap: 12px;

    color: #40596D;

    font-size: 15px;

    font-weight: 600;
}

.pl-privacy-list i {
    width: 25px;
    height: 25px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #E7F7E2;

    color: var(--pl-green);

    font-size: 12px;
}


/* =========================================================
   ONE APP
========================================================= */

.pl-app {
    padding: 110px 0;

    background: var(--pl-dark);

    color: #fff;
}

.pl-app-grid {
    display: grid;

    grid-template-columns: 1.1fr .9fr;

    gap: 90px;

    align-items: center;
}

.pl-app-content .pl-label {
    color: #76C9F1;
}

.pl-app-content h2 {
    margin: 20px 0;

    font-family: "Manrope", sans-serif;

    font-size: clamp(36px, 4vw, 52px);

    line-height: 1.1;
}

.pl-app-content h2 span {
    color: var(--pl-green);
}

.pl-app-content > p {
    max-width: 650px;

    color: #B9CBD8;

    font-size: 17px;

    line-height: 1.8;
}

.pl-app-flow {
    display: flex;

    align-items: center;

    gap: 15px;

    margin-top: 40px;
}

.pl-app-step {
    text-align: center;
}

.pl-app-icon {
    width: 65px;
    height: 65px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 10px;

    border-radius: 18px;

    font-size: 23px;
}

.pl-app-icon.blue {
    background: rgba(22,137,207,.2);
    color: #4CB9F0;
}

.pl-app-icon.green {
    background: rgba(66,184,42,.18);
    color: #6ED45C;
}

.pl-app-icon.orange {
    background: rgba(245,138,22,.18);
    color: #FFAE50;
}

.pl-app-step small {
    display: block;

    color: #6F8DA3;

    font-size: 10px;

    font-weight: 800;
}

.pl-app-step strong {
    display: block;

    margin-top: 3px;

    font-size: 13px;

    white-space: nowrap;
}

.pl-app-arrow {
    color: #527086;
}


/* PHONE */

.pl-phone-wrap {
    display: flex;

    justify-content: center;
}

.pl-phone {
    width: 280px;
    height: 550px;

    padding: 12px;

    border-radius: 38px;

    background: #111C25;

    box-shadow:
        0 30px 70px rgba(0,0,0,.4),
        0 0 0 2px #334653;
}

.pl-phone-screen {
    height: 100%;

    padding: 25px 18px;

    border-radius: 29px;

    background:
        linear-gradient(
            180deg,
            #EDF9FF,
            #FFFFFF 50%,
            #F1FAED
        );

    color: var(--pl-dark);
}

.pl-phone-top {
    display: flex;

    align-items: center;

    justify-content: space-between;

    font-size: 14px;

    font-weight: 800;
}

.pl-phone-top i {
    color: var(--pl-blue);
}

.pl-phone-community {
    margin-top: 35px;

    padding: 18px;

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            var(--pl-blue),
            var(--pl-sky)
        );

    color: #fff;
}

.pl-phone-community small {
    display: block;

    opacity: .75;

    font-size: 9px;

    font-weight: 800;
}

.pl-phone-community strong {
    display: block;

    margin-top: 5px;

    font-size: 17px;
}

.pl-phone-services {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 10px;

    margin-top: 22px;
}

.pl-phone-services div {
    padding: 15px 8px;

    display: flex;

    flex-direction: column;

    align-items: center;

    gap: 8px;

    border-radius: 14px;

    background: #fff;

    box-shadow:
        0 6px 18px rgba(9,43,76,.08);

    font-size: 10px;

    font-weight: 700;
}

.pl-phone-services i {
    color: var(--pl-sky);

    font-size: 20px;
}


/* =========================================================
   GLOBAL SERVICES
========================================================= */

.pl-global {
    padding: 100px 0;

    background:
        linear-gradient(
            135deg,
            #FFF9F0,
            #FFFFFF
        );
}

.pl-global-grid {
    display: grid;

    grid-template-columns: repeat(4, 1fr);

    gap: 20px;
}

.pl-global-card {
    padding: 30px 23px;

    border-radius: 20px;

    background: #fff;

    border: 1px solid #F0E5D6;

    box-shadow:
        0 12px 35px rgba(9,43,76,.06);

    transition: .3s ease;
}

.pl-global-card:hover {
    transform: translateY(-7px);
}

.pl-global-card i {
    width: 55px;
    height: 55px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    background: #FFF0DB;

    color: var(--pl-orange);

    font-size: 22px;
}

.pl-global-card h3 {
    margin: 18px 0 9px;

    font-size: 20px;
}

.pl-global-card p {
    color: #718290;

    font-size: 14px;

    line-height: 1.65;
}


/* =========================================================
   OUR GOAL
========================================================= */

.pl-goal {
    padding: 100px 0;

    background: #F5FAFD;
}

.pl-goal-box {
    max-width: 1050px;

    margin: auto;

    display: grid;

    grid-template-columns: 85px 1fr;

    gap: 30px;

    align-items: start;
}

.pl-goal-icon {
    width: 75px;
    height: 75px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 22px;

    background:
        linear-gradient(
            135deg,
            var(--pl-blue),
            var(--pl-sky)
        );

    color: #fff;

    font-size: 28px;
}

.pl-goal-box h2 {
    margin: 17px 0;

    font-family: "Manrope", sans-serif;

    font-size: clamp(35px, 4vw, 50px);

    line-height: 1.1;
}

.pl-goal-box h2 span {
    color: var(--pl-sky);
}

.pl-goal-box p {
    color: #617689;

    font-size: 17px;

    line-height: 1.8;
}

.pl-goal-values {
    display: flex;

    justify-content: center;

    flex-wrap: wrap;

    gap: 15px;

    margin-top: 45px;
}

.pl-goal-values div {
    min-width: 150px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 9px;

    padding: 14px 20px;

    border-radius: 30px;

    background: #fff;

    box-shadow:
        0 8px 25px rgba(9,43,76,.07);

    color: #294E69;

    font-weight: 700;
}

.pl-goal-values i {
    color: var(--pl-sky);
}


/* =========================================================
   FINAL CTA
========================================================= */

.pl-final {
    position: relative;

    padding: 110px 20px;

    text-align: center;

    overflow: hidden;

    background:
        linear-gradient(
            135deg,
            #07579D,
            #092B4C 55%,
            #12466D
        );
}

.pl-final::before {
    content: "";

    position: absolute;

    width: 450px;
    height: 450px;

    left: -250px;
    top: -250px;

    border-radius: 50%;

    border: 70px solid rgba(255,255,255,.04);
}

.pl-final::after {
    content: "";

    position: absolute;

    width: 400px;
    height: 400px;

    right: -220px;
    bottom: -250px;

    border-radius: 50%;

    border: 65px solid rgba(66,184,42,.08);
}

.pl-final-content {
    position: relative;

    z-index: 3;

    max-width: 850px;

    margin: auto;
}

.pl-final .pl-hero-badge {
    color: #fff;

    background: rgba(255,255,255,.08);

    border-color: rgba(255,255,255,.15);
}

.pl-final h2 {
    margin: 25px 0 18px;

    font-family: "Manrope", sans-serif;

    font-size: clamp(40px, 5vw, 62px);

    line-height: 1.05;

    color: #fff;
}

.pl-final h2 span {
    color: var(--pl-green);
}

.pl-final p {
    max-width: 700px;

    margin: auto;

    color: #C4D8E7;

    font-size: 17px;

    line-height: 1.75;
}

.pl-final-buttons {
    display: flex;

    justify-content: center;

    flex-wrap: wrap;

    gap: 13px;

    margin-top: 35px;
}

.pl-btn {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 9px;

    padding: 14px 22px;

    border-radius: 12px;

    font-size: 14px;

    font-weight: 800;

    transition: .3s ease;
}

.pl-btn:hover {
    transform: translateY(-3px);
}

.pl-btn.white {
    background: #fff;
    color: var(--pl-blue);
}

.pl-btn.outline {
    color: #fff;

    border: 1px solid rgba(255,255,255,.3);

    background: rgba(255,255,255,.05);
}

.pl-btn.green {
    color: #fff;

    background: var(--pl-green);
}


/* =========================================================
   SCROLL REVEAL
========================================================= */

.pl-reveal {
    opacity: 0;

    transform: translateY(28px);

    transition:
        opacity .7s ease,
        transform .7s ease;
}

.pl-reveal.show {
    opacity: 1;

    transform: translateY(0);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1150px) {

    .pl-ecosystem-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .pl-identity-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .pl-global-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 950px) {

    .pl-intro-grid,
    .pl-purpose-grid,
    .pl-multiple-grid,
    .pl-privacy-grid,
    .pl-app-grid {
        grid-template-columns: 1fr;
    }

    .pl-main-image,
    .pl-purpose-image,
    .pl-privacy-image {
        max-width: 700px;

        margin: auto;
    }

    .pl-app-content {
        text-align: center;
    }

    .pl-app-content .pl-label {
        justify-content: center;
    }

    .pl-app-content > p {
        margin-left: auto;
        margin-right: auto;
    }

    .pl-app-flow {
        justify-content: center;
    }

    .pl-goal-box {
        grid-template-columns: 1fr;

        text-align: center;
    }

    .pl-goal-icon {
        margin: auto;
    }

}

@media (max-width: 700px) {

    .pl-container {
        width: min(100% - 30px, 650px);
    }

    .pl-about-hero {
        min-height: 390px;

        padding: 55px 15px 25px;
    }

    .pl-hero-content h1 {
        font-size: 40px;

        letter-spacing: -1.5px;
    }

    .pl-hero-content > p {
        font-size: 16px;
    }

    .pl-intro,
    .pl-ecosystem,
    .pl-purpose,
    .pl-multiple,
    .pl-identity,
    .pl-privacy,
    .pl-app,
    .pl-global,
    .pl-goal {
        padding: 75px 0;
    }

    .pl-ecosystem-grid {
        grid-template-columns: 1fr;
    }

    .pl-identity-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .pl-global-grid {
        grid-template-columns: 1fr;
    }

    .pl-main-image img,
    .pl-purpose-image img {
        height: 450px;
    }

    .pl-community-visual {
        min-height: 430px;
    }

    .pl-circle.one {
        width: 340px;
        height: 340px;
    }

    .pl-circle.two {
        width: 245px;
        height: 245px;
    }

    .pl-circle.three {
        width: 140px;
        height: 140px;
    }

    .pl-circle.three img {
        width: 105px;
    }

    .pl-floating {
        font-size: 12px;

        padding: 10px 13px;
    }

    .pl-floating.one {
        left: 0;
    }

    .pl-floating.two {
        right: 0;
    }

    .pl-floating.three {
        left: 0;
    }

    .pl-floating.four {
        right: 0;
    }

    .pl-phone {
        width: 250px;
        height: 500px;
    }

}

@media (max-width: 480px) {

    .pl-about-hero {
        min-height: 370px;

        padding: 50px 15px 25px;
    }

    .pl-hero-badge {
        font-size: 11px;

        padding: 7px 14px;

        letter-spacing: 1px;
    }

    .pl-hero-content h1 {
        font-size: 32px;

        line-height: 1.08;

        letter-spacing: -1px;
    }

    .pl-hero-content > p {
        font-size: 15px;

        line-height: 1.6;
    }

    .pl-intro-features {
        grid-template-columns: 1fr;
    }

    .pl-main-image img,
    .pl-purpose-image img {
        height: 380px;
    }

    .pl-image-card {
        left: 12px;
        bottom: 12px;
    }

    .pl-purpose-card {
        flex-direction: column;
    }

    .pl-app-flow {
        flex-direction: column;
    }

    .pl-app-arrow {
        transform: rotate(90deg);
    }

    .pl-goal-values {
        flex-direction: column;
    }

    .pl-goal-values div {
        width: 100%;
    }

    .pl-final {
        padding: 80px 18px;
    }

    .pl-final-buttons {
        flex-direction: column;
    }

    .pl-btn {
        width: 100%;
    }

}


/* =========================================================
   ACCESSIBILITY
========================================================= */

@media (prefers-reduced-motion: reduce) {

    html {
        scroll-behavior: auto;
    }

    .pl-reveal {
        opacity: 1;
        transform: none;
        transition: none;
    }

    .pl-eco-card,
    .pl-multiple-item,
    .pl-identity-card,
    .pl-global-card,
    .pl-floating,
    .pl-btn {
        transition: none;
    }

}

</style>

<main class="pl-about-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <section class="pl-about-hero">

        <div class="pl-hero-content">

            <div class="pl-hero-badge">
                <i class="fa-solid fa-people-group"></i>
                ABOUT PEOPLELINK
            </div>

            <h1>
                Connecting Communities
                <span>Through One Digital Platform</span>
            </h1>

            <p>
                A trusted digital ecosystem bringing people, families,
                professionals, businesses and communities together.
            </p>

            <div class="pl-breadcrumb">
                <a href="index.php">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>About Us</span>
            </div>

        </div>

    </section>


    <!-- =====================================================
         INTRODUCTION
    ====================================================== -->

    <section class="pl-intro">

        <div class="pl-container">

            <div class="pl-intro-grid">


                <!-- IMAGE -->

                <div class="pl-main-image">

                    <img
                        src="https://images.unsplash.com/photo-1511895426328-dc8714191300?auto=format&fit=crop&w=1200&q=85"
                        alt="Family and community">

                    <div class="pl-image-card">

                        <div class="pl-image-card-icon">
                            <i class="fa-solid fa-people-roof"></i>
                        </div>

                        <div>
                            <strong>One Community</strong>
                            <span>Many Possibilities</span>
                        </div>

                    </div>

                </div>


                <!-- CONTENT -->

                <div class="pl-intro-content">

                    <div class="pl-label">
                        WHO WE ARE
                    </div>

                    <h2>
                        More Than a Platform.
                        <span>A Connected Community.</span>
                    </h2>

                    <p class="lead">
                        PeopleLink is a multi-community digital platform
                        created to bring people, families, professionals,
                        businesses and community organisations together
                        through one trusted digital ecosystem.
                    </p>

                    <p>
                        PeopleLink enables different communities to use
                        the same technology while maintaining their own
                        identity, members, services, information and
                        administration.
                    </p>

                    <p>
                        Every community can have its own digital environment
                        while remaining connected to the larger PeopleLink
                        ecosystem.
                    </p>


                    <div class="pl-intro-features">

                        <div class="pl-intro-feature">
                            <i class="fa-solid fa-users"></i>
                            <span>People & Families</span>
                        </div>

                        <div class="pl-intro-feature">
                            <i class="fa-solid fa-briefcase"></i>
                            <span>Jobs & Opportunities</span>
                        </div>

                        <div class="pl-intro-feature">
                            <i class="fa-solid fa-store"></i>
                            <span>Businesses & Professionals</span>
                        </div>

                        <div class="pl-intro-feature">
                            <i class="fa-solid fa-calendar-days"></i>
                            <span>Events & Community Life</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         PEOPLELINK ECOSYSTEM
    ====================================================== -->

    <section class="pl-ecosystem">

        <div class="pl-container">

            <div class="pl-section-head">

                <div class="pl-label center">
                    PEOPLELINK ECOSYSTEM
                </div>

                <h2>
                    Bringing the Important Parts of
                    <span>Community Life Together</span>
                </h2>

                <p>
                    PeopleLink is designed around real community needs —
                    relationships, families, careers, businesses,
                    opportunities and everyday connections.
                </p>

            </div>


            <div class="pl-ecosystem-grid">


                <!-- 01 -->

                <article class="pl-eco-card pl-reveal">

                    <div class="pl-eco-image">

                        <img
                            src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1000&q=85"
                            alt="Matrimony and relationships">

                        <div class="pl-eco-icon">
                            <i class="fa-solid fa-heart"></i>
                        </div>

                    </div>

                    <div class="pl-eco-content">

                        <span class="pl-eco-number">01</span>

                        <h3>Matrimony & Relationships</h3>

                        <p>
                            Discover meaningful matrimonial connections
                            within your community and connect families
                            with shared values and backgrounds.
                        </p>

                    </div>

                </article>


                <!-- 02 -->

                <article class="pl-eco-card green pl-reveal">

                    <div class="pl-eco-image">

                        <img
                            src="https://images.unsplash.com/photo-1504150558240-0b4fd8946624?auto=format&fit=crop&w=1000&q=85"
                            alt="Family and community">

                        <div class="pl-eco-icon">
                            <i class="fa-solid fa-people-group"></i>
                        </div>

                    </div>

                    <div class="pl-eco-content">

                        <span class="pl-eco-number">02</span>

                        <h3>Family & Community</h3>

                        <p>
                            Keep families connected, register members,
                            build family relationships and strengthen
                            connections between generations.
                        </p>

                    </div>

                </article>


                <!-- 03 -->

                <article class="pl-eco-card orange pl-reveal">

                    <div class="pl-eco-image">

                        <img
                            src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1000&q=85"
                            alt="Jobs and career">

                        <div class="pl-eco-icon">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>

                    </div>

                    <div class="pl-eco-content">

                        <span class="pl-eco-number">03</span>

                        <h3>Jobs & Opportunities</h3>

                        <p>
                            Discover community employment opportunities,
                            share job openings and create new professional
                            connections.
                        </p>

                    </div>

                </article>


                <!-- 04 -->

                <article class="pl-eco-card purple pl-reveal">

                    <div class="pl-eco-image">

                        <img
                            src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1000&q=85"
                            alt="Professionals and businesses">

                        <div class="pl-eco-icon">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>

                    </div>

                    <div class="pl-eco-content">

                        <span class="pl-eco-number">04</span>

                        <h3>Professionals & Businesses</h3>

                        <p>
                            Find doctors, lawyers, CAs, engineers,
                            consultants, entrepreneurs, shops and
                            service providers.
                        </p>

                    </div>

                </article>


                <!-- 05 -->

                <article class="pl-eco-card red pl-reveal">

                    <div class="pl-eco-image">

                        <img
                            src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1000&q=85"
                            alt="Property and marketplace">

                        <div class="pl-eco-icon">
                            <i class="fa-solid fa-house"></i>
                        </div>

                    </div>

                    <div class="pl-eco-content">

                        <span class="pl-eco-number">05</span>

                        <h3>Property & Marketplace</h3>

                        <p>
                            Discover properties, vehicles, electronics
                            and other products shared within the
                            community marketplace.
                        </p>

                    </div>

                </article>


                <!-- 06 -->

                <article class="pl-eco-card teal pl-reveal">

                    <div class="pl-eco-image">

                        <img
                            src="https://images.unsplash.com/photo-1507504031003-b417219a0fde?auto=format&fit=crop&w=1000&q=85"
                            alt="Community events">

                        <div class="pl-eco-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>

                    </div>

                    <div class="pl-eco-content">

                        <span class="pl-eco-number">06</span>

                        <h3>Events & Celebrations</h3>

                        <p>
                            Discover festivals, meetings, cultural
                            programs, celebrations and community
                            gatherings.
                        </p>

                    </div>

                </article>

            </div>

        </div>

    </section>


    <!-- =====================================================
         VISION & MISSION
    ====================================================== -->

    <section class="pl-purpose">

        <div class="pl-container">

            <div class="pl-purpose-grid">


                <div class="pl-purpose-image">

                    <img
                        src="/peoplelink/first/images/in/family-1.jpg?auto=format&fit=crop&w=1200&q=85"
                        alt="People connected as a community">

                    <div class="pl-purpose-badge">
                        <i class="fa-solid fa-link"></i>
                        CONNECT • DISCOVER • BELONG
                    </div>

                </div>


                <div class="pl-purpose-content">

                    <div class="pl-label">
                        OUR PURPOSE
                    </div>

                    <h2>
                        Built Around
                        <span>People & Communities</span>
                    </h2>


                    <!-- VISION -->

                    <div class="pl-purpose-card pl-reveal">

                        <div class="pl-purpose-icon">
                            <i class="fa-solid fa-eye"></i>
                        </div>

                        <div>

                            <small>OUR VISION</small>

                            <h3>
                                A stronger digital future for communities.
                            </h3>

                            <p>
                                To create a trusted digital platform where
                                communities can preserve their identity,
                                strengthen relationships, support members
                                and access opportunities through technology.
                            </p>

                        </div>

                    </div>


                    <!-- MISSION -->

                    <div class="pl-purpose-card mission pl-reveal">

                        <div class="pl-purpose-icon">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>

                        <div>

                            <small>OUR MISSION</small>

                            <h3>
                                Simplifying community engagement.
                            </h3>

                            <p>
                                PeopleLink aims to simplify community
                                engagement by bringing essential services,
                                information and opportunities together
                                in one place.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         MULTIPLE COMMUNITIES
    ====================================================== -->

    <section class="pl-multiple">

        <div class="pl-container">

            <div class="pl-section-head">

                <div class="pl-label center">
                    ONE PLATFORM
                </div>

                <h2>
                    One Platform.
                    <span>Multiple Communities.</span>
                </h2>

                <p>
                    Each community can maintain its own identity and
                    digital environment while using the common
                    PeopleLink technology platform.
                </p>

            </div>


            <div class="pl-multiple-grid">


                <!-- VISUAL -->

                <div class="pl-community-visual">

                    <div class="pl-circle one">

                        <div class="pl-circle two">

                            <div class="pl-circle three">

                                <img
                                    src="images/peoplelink-logo.png"
                                    alt="PeopleLink">

                            </div>

                        </div>

                    </div>


                    <div class="pl-floating one">
                        <i class="fa-solid fa-users"></i>
                        Members
                    </div>

                    <div class="pl-floating two">
                        <i class="fa-solid fa-heart"></i>
                        Matrimony
                    </div>

                    <div class="pl-floating three">
                        <i class="fa-solid fa-briefcase"></i>
                        Jobs
                    </div>

                    <div class="pl-floating four">
                        <i class="fa-solid fa-calendar-days"></i>
                        Events
                    </div>

                </div>


                <!-- CONTENT -->

                <div class="pl-multiple-content">


                    <div class="pl-multiple-item pl-reveal">

                        <i class="fa-solid fa-building"></i>

                        <div>

                            <h3>
                                Its Own Community Environment
                            </h3>

                            <p>
                                Every community can have its own dedicated
                                digital space with relevant members,
                                services and information.
                            </p>

                        </div>

                    </div>


                    <div class="pl-multiple-item pl-reveal">

                        <i class="fa-solid fa-id-card"></i>

                        <div>

                            <h3>
                                Dedicated Members & Families
                            </h3>

                            <p>
                                Members and families can access services
                                relevant to their selected community.
                            </p>

                        </div>

                    </div>


                    <div class="pl-multiple-item pl-reveal">

                        <i class="fa-solid fa-bullhorn"></i>

                        <div>

                            <h3>
                                Community Announcements
                            </h3>

                            <p>
                                Share important updates, events,
                                announcements and community activities.
                            </p>

                        </div>

                    </div>


                    <div class="pl-multiple-item pl-reveal">

                        <i class="fa-solid fa-user-shield"></i>

                        <div>

                            <h3>
                                Independent Administration
                            </h3>

                            <p>
                                Communities can have their own
                                representatives, administrators and
                                management environment.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         DIGITAL IDENTITY
    ====================================================== -->

    <section class="pl-identity">

        <div class="pl-container">

            <div class="pl-section-head">

                <div class="pl-label center">
                    COMMUNITY IDENTITY
                </div>

                <h2>
                    Your Community.
                    <span>Your Digital Identity.</span>
                </h2>

                <p>
                    PeopleLink allows every community to establish
                    a recognizable and independent digital presence.
                </p>

            </div>


            <div class="pl-identity-grid">


                <div class="pl-identity-card pl-reveal">
                    <i class="fa-solid fa-image"></i>
                    <strong>Logo</strong>
                    <span>Community identity</span>
                </div>


                <div class="pl-identity-card pl-reveal">
                    <i class="fa-solid fa-palette"></i>
                    <strong>Branding</strong>
                    <span>Unique visual identity</span>
                </div>


                <div class="pl-identity-card pl-reveal">
                    <i class="fa-solid fa-globe"></i>
                    <strong>Domain</strong>
                    <span>Domain or subdomain</span>
                </div>


                <div class="pl-identity-card pl-reveal">
                    <i class="fa-solid fa-users"></i>
                    <strong>Members</strong>
                    <span>Dedicated member base</span>
                </div>


                <div class="pl-identity-card pl-reveal">
                    <i class="fa-solid fa-user-shield"></i>
                    <strong>Admins</strong>
                    <span>Community administration</span>
                </div>


                <div class="pl-identity-card pl-reveal">
                    <i class="fa-solid fa-table-cells-large"></i>
                    <strong>Services</strong>
                    <span>Community services</span>
                </div>


                <div class="pl-identity-card pl-reveal">
                    <i class="fa-solid fa-newspaper"></i>
                    <strong>Content</strong>
                    <span>Community information</span>
                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         PRIVACY
    ====================================================== -->

    <section class="pl-privacy">

        <div class="pl-container">

            <div class="pl-privacy-grid">


                <div class="pl-privacy-image">

                    <img
                        src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1100&q=85"
                        alt="Community privacy and secure information">

                    <div class="pl-privacy-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                </div>


                <div class="pl-privacy-content">

                    <div class="pl-label">
                        COMMUNITY PRIVACY
                    </div>

                    <h2>
                        Built for
                        <span>Community Privacy</span>
                    </h2>

                    <p>
                        PeopleLink is designed so that community-specific
                        information can remain within its intended
                        community environment.
                    </p>


                    <div class="pl-privacy-list">

                        <div>
                            <i class="fa-solid fa-check"></i>
                            Community-wise data separation
                        </div>

                        <div>
                            <i class="fa-solid fa-check"></i>
                            Dedicated community environments
                        </div>

                        <div>
                            <i class="fa-solid fa-check"></i>
                            Independent administration
                        </div>

                        <div>
                            <i class="fa-solid fa-check"></i>
                            Controlled access to community information
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         ONE APP
    ====================================================== -->

    <section class="pl-app">

        <div class="pl-container">

            <div class="pl-app-grid">


                <div class="pl-app-content">

                    <div class="pl-label">
                        PEOPLELINK MOBILE APP
                    </div>

                    <h2>
                        One App.
                        <span>All Your Communities.</span>
                    </h2>

                    <p>
                        Members can use one PeopleLink application
                        and select the community they belong to before
                        accessing their relevant services and information.
                    </p>


                    <div class="pl-app-flow">


                        <div class="pl-app-step">

                            <div class="pl-app-icon blue">
                                <i class="fa-solid fa-users"></i>
                            </div>

                            <small>01</small>

                            <strong>Select Community</strong>

                        </div>


                        <i class="fa-solid fa-arrow-right pl-app-arrow"></i>


                        <div class="pl-app-step">

                            <div class="pl-app-icon green">
                                <i class="fa-solid fa-right-to-bracket"></i>
                            </div>

                            <small>02</small>

                            <strong>Login</strong>

                        </div>


                        <i class="fa-solid fa-arrow-right pl-app-arrow"></i>


                        <div class="pl-app-step">

                            <div class="pl-app-icon orange">
                                <i class="fa-solid fa-table-cells-large"></i>
                            </div>

                            <small>03</small>

                            <strong>Access Services</strong>

                        </div>

                    </div>

                </div>


                <!-- PHONE -->

                <div class="pl-phone-wrap">

                    <div class="pl-phone">

                        <div class="pl-phone-screen">

                            <div class="pl-phone-top">

                                <span>PeopleLink</span>

                                <i class="fa-solid fa-bell"></i>

                            </div>


                            <div class="pl-phone-community">

                                <small>YOUR COMMUNITY</small>

                                <strong>Reddy Community</strong>

                            </div>


                            <div class="pl-phone-services">

                                <div>
                                    <i class="fa-solid fa-heart"></i>
                                    <span>Matrimony</span>
                                </div>

                                <div>
                                    <i class="fa-solid fa-users"></i>
                                    <span>Family</span>
                                </div>

                                <div>
                                    <i class="fa-solid fa-briefcase"></i>
                                    <span>Jobs</span>
                                </div>

                                <div>
                                    <i class="fa-solid fa-store"></i>
                                    <span>Business</span>
                                </div>

                                <div>
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <span>Events</span>
                                </div>

                                <div>
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>Near Me</span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         GLOBAL OPPORTUNITIES
    ====================================================== -->

    <section class="pl-global">

        <div class="pl-container">

            <div class="pl-section-head">

                <div class="pl-label center">
                    CONNECT BEYOND YOUR COMMUNITY
                </div>

                <h2>
                    Community Connections.
                    <span>Global Opportunities.</span>
                </h2>

                <p>
                    Some services can be configured to reach members
                    across multiple communities while community-specific
                    information remains protected.
                </p>

            </div>


            <div class="pl-global-grid">


                <div class="pl-global-card pl-reveal">

                    <i class="fa-solid fa-briefcase"></i>

                    <h3>Global Jobs</h3>

                    <p>
                        Opportunities can be shared across participating
                        communities.
                    </p>

                </div>


                <div class="pl-global-card pl-reveal">

                    <i class="fa-solid fa-calendar-days"></i>

                    <h3>Global Events</h3>

                    <p>
                        Events can be made available to a wider audience
                        when configured.
                    </p>

                </div>


                <div class="pl-global-card pl-reveal">

                    <i class="fa-solid fa-bullhorn"></i>

                    <h3>Global Advertisements</h3>

                    <p>
                        Businesses can promote selected products and
                        services across communities.
                    </p>

                </div>


                <div class="pl-global-card pl-reveal">

                    <i class="fa-solid fa-shop"></i>

                    <h3>Marketplace</h3>

                    <p>
                        Selected property and marketplace listings can
                        reach a broader audience.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         OUR GOAL
    ====================================================== -->

    <section class="pl-goal">

        <div class="pl-container">

            <div class="pl-goal-box">

                <div class="pl-goal-icon">
                    <i class="fa-solid fa-link"></i>
                </div>


                <div>

                    <div class="pl-label">
                        OUR GOAL
                    </div>

                    <h2>
                        More Than a Directory.
                        <span>A Complete Community Ecosystem.</span>
                    </h2>

                    <p>
                        PeopleLink is not simply designed to list people
                        or businesses. Our goal is to create a complete
                        digital ecosystem where community members can
                        connect, communicate, support one another,
                        discover opportunities and grow together.
                    </p>

                </div>

            </div>


            <div class="pl-goal-values">

                <div>
                    <i class="fa-solid fa-link"></i>
                    Connect
                </div>

                <div>
                    <i class="fa-solid fa-comments"></i>
                    Communicate
                </div>

                <div>
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    Support
                </div>

                <div>
                    <i class="fa-solid fa-compass"></i>
                    Discover
                </div>

                <div>
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    Grow
                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         FINAL CTA
    ====================================================== -->

    <section class="pl-final">

        <div class="pl-final-content">

            <div class="pl-hero-badge">

                <i class="fa-solid fa-people-group"></i>

                BECOME PART OF PEOPLELINK

            </div>


            <h2>
                Your Community.
                <span>Your Connections.</span>
            </h2>


            <p>
                Discover your community, connect with people,
                explore opportunities and become part of a growing
                digital community ecosystem.
            </p>


            <div class="pl-final-buttons">

                <a href="communities.php"
                   class="pl-btn white">

                    <i class="fa-solid fa-users"></i>

                    Explore Communities

                </a>


                <a href="register.php"
                   class="pl-btn outline">

                    <i class="fa-solid fa-user-plus"></i>

                    Create Account

                </a>


                <a href="#downloadApp"
                   class="pl-btn green">

                    <i class="fa-solid fa-mobile-screen-button"></i>

                    Download App

                </a>

            </div>

        </div>

    </section>

</main>


<script>

/* =========================================================
   PEOPLELINK ABOUT PAGE JAVASCRIPT
========================================================= */

document.addEventListener("DOMContentLoaded", function () {


    /* =====================================================
       SCROLL REVEAL
    ====================================================== */

    const revealElements =
        document.querySelectorAll(".pl-reveal");


    if ("IntersectionObserver" in window) {

        const revealObserver =
            new IntersectionObserver(
                function (entries, observer) {

                    entries.forEach(function (entry) {

                        if (entry.isIntersecting) {

                            entry.target.classList.add("show");

                            observer.unobserve(entry.target);

                        }

                    });

                },
                {
                    threshold: 0.12
                }
            );


        revealElements.forEach(function (element) {

            revealObserver.observe(element);

        });

    } else {

        revealElements.forEach(function (element) {

            element.classList.add("show");

        });

    }


    /* =====================================================
       FLOATING COMMUNITY CARDS
    ====================================================== */

    const floatingCards =
        document.querySelectorAll(".pl-floating");


    floatingCards.forEach(function (card) {

        card.addEventListener("mouseenter", function () {

            this.style.transform =
                "translateY(-7px)";

        });


        card.addEventListener("mouseleave", function () {

            this.style.transform = "";

        });

    });


    /* =====================================================
       SMOOTH INTERNAL LINKS
    ====================================================== */

    const internalLinks =
        document.querySelectorAll(
            '.pl-about-page a[href^="#"]'
        );


    internalLinks.forEach(function (link) {

        link.addEventListener("click", function (event) {

            const targetId =
                this.getAttribute("href");


            if (!targetId || targetId === "#") {

                return;

            }


            const target =
                document.querySelector(targetId);


            if (target) {

                event.preventDefault();


                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }

        });

    });


    /* =====================================================
       PHONE SERVICE ICON HOVER
    ====================================================== */

    const phoneServices =
        document.querySelectorAll(
            ".pl-phone-services div"
        );


    phoneServices.forEach(function (item) {

        item.addEventListener(
            "mouseenter",
            function () {

                this.style.transform =
                    "translateY(-3px)";

                this.style.boxShadow =
                    "0 10px 22px rgba(9,43,76,.12)";

            }
        );


        item.addEventListener(
            "mouseleave",
            function () {

                this.style.transform = "";

                this.style.boxShadow =
                    "0 6px 18px rgba(9,43,76,.08)";

            }
        );

    });


});

</script>

<?php include('footer.php'); ?>