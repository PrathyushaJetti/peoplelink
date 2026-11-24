<?php
/* ============================================================
   PEOPLELINK - PREMIUM COMING SOON PAGE
   SINGLE FILE
   Header + Main + Footer + CSS + JavaScript
   ============================================================ */

$logo = "images/logo.jpeg";
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<meta name="description"
      content="PeopleLink - One Platform. Many Communities. Stronger Connections.">

<title>PeopleLink | Coming Soon</title>


<!-- Bootstrap Icons -->
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<style>

html,
body {
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    min-width: 100% !important;
    overflow-x: hidden;
}


/* ============================================================
   PEOPLELINK SINGLE PAGE
   ALL CSS IS SCOPED
   ============================================================ */

.pl-coming-page-wrap {

    --pl-blue: #1261a8;
    --pl-dark: #073b70;
    --pl-light-blue: #1685c8;
    --pl-green: #42b72a;
    --pl-orange: #f7941d;
    --pl-red: #e72d55;
    --pl-purple: #7434c4;

    --pl-text: #19354d;
    --pl-muted: #667b8f;
    --pl-border: #e5edf4;
    --pl-soft: #f5f9fc;

    width: 100%;
    overflow: hidden;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    color: var(--pl-text);

    background: #fff;
}


/* ============================================================
   HEADER
   ============================================================ */

.pl-coming-page-wrap .pl-header {

    width: 100%;

    position: sticky;
    top: 0;

    z-index: 9999;

    background: rgba(255,255,255,.96);

    border-bottom: 1px solid rgba(7,59,112,.08);

    box-shadow:
        0 5px 25px rgba(7,59,112,.06);

    backdrop-filter: blur(12px);
}


.pl-coming-page-wrap .pl-header-inner {

    width: 100%;
    max-width: 1380px;

    min-height: 78px;

    margin: auto;

    padding: 0 28px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 25px;
}


/* LOGO */

.pl-coming-page-wrap .pl-header-logo {

    display: inline-flex;

    align-items: center;

    flex-shrink: 0;

    text-decoration: none;
}


.pl-coming-page-wrap .pl-header-logo img {

    display: block;

    width: auto;

    max-width: 205px;

    max-height: 58px;

    object-fit: contain;
}


/* NAVIGATION */

.pl-coming-page-wrap .pl-header-nav {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 4px;
}


.pl-coming-page-wrap .pl-header-nav a {

    min-height: 43px;

    padding: 0 14px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 5px;

    border-radius: 9px;

    color: #52687b;

    text-decoration: none;

    font-size: 13px;

    font-weight: 700;

    transition: all .25s ease;
}


.pl-coming-page-wrap .pl-header-nav a i {

    color: #1261a8;

    font-size: 15px;
}


.pl-coming-page-wrap .pl-header-nav a:hover {

    color: #1261a8;

    background: #edf7fd;
}


.pl-coming-page-wrap .pl-header-nav a.active {

    color: #1261a8;

    background: #edf7fd;
}


/* HEADER CTA */

.pl-coming-page-wrap .pl-header-nav a.pl-header-cta {

    margin-left: 7px;

    padding: 0 18px;

    color: #fff;

    background:
        linear-gradient(
            135deg,
            #1261a8,
            #1685c8
        );

    box-shadow:
        0 8px 20px rgba(18,97,168,.18);
}


.pl-coming-page-wrap .pl-header-nav a.pl-header-cta i {

    color: #fff;
}


.pl-coming-page-wrap .pl-header-nav a.pl-header-cta:hover {

    color: #fff;

    transform: translateY(-2px);

    box-shadow:
        0 12px 25px rgba(18,97,168,.25);
}


/* MOBILE BUTTON */

.pl-coming-page-wrap .pl-menu-btn {

    width: 44px;
    height: 44px;

    display: none;

    align-items: center;
    justify-content: center;

    border: 0;

    border-radius: 10px;

    color: #1261a8;

    background: #edf7fd;

    cursor: pointer;

    font-size: 23px;
}


/* MOBILE NAV */

.pl-coming-page-wrap .pl-mobile-nav {

    display: none;

    padding: 8px 18px 18px;

    background: #fff;

    border-top: 1px solid #edf2f6;
}


.pl-coming-page-wrap .pl-mobile-nav.open {

    display: block;
}


.pl-coming-page-wrap .pl-mobile-nav a {

    min-height: 47px;

    display: flex;

    align-items: center;

    gap: 11px;

    padding: 0 13px;

    border-radius: 9px;

    color: #40576c;

    text-decoration: none;

    font-size: 12px;

    font-weight: 700;
}


.pl-coming-page-wrap .pl-mobile-nav a i {

    width: 22px;

    color: #1261a8;

    font-size: 14px;
}


.pl-coming-page-wrap .pl-mobile-nav a:hover {

    color: #1261a8;

    background: #edf7fd;
}


/* ============================================================
   HERO
   ============================================================ */

.pl-coming-page-wrap .pl-hero {

    position: relative;

    min-height: 470px;

    display: flex;

    align-items: center;

    padding: 32px 24px 38px;

    background:

        radial-gradient(
            circle at 82% 20%,
            rgba(22,133,200,.13),
            transparent 31%
        ),

        linear-gradient(
            135deg,
            #f8fcff,
            #edf7fd
        );
}


.pl-coming-page-wrap .pl-hero-inner {

    width: 100%;
    max-width: 1240px;

    margin: auto;

    display: grid;

    grid-template-columns:
        1.05fr
        .95fr;

    align-items: center;

    gap: 32px;
}


.pl-coming-page-wrap .pl-hero-content {

    position: relative;

    z-index: 2;
}


.pl-coming-page-wrap .pl-coming-badge {

    width: fit-content;

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding: 8px 13px;

    border-radius: 50px;

    color: #1261a8;

    background: #e8f5fd;

    border: 1px solid #cce7f6;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: .8px;
}


.pl-coming-page-wrap .pl-coming-badge span {

    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: #42b72a;

    box-shadow:
        0 0 0 5px rgba(66,183,42,.12);
}


.pl-coming-page-wrap .pl-hero h1 {

    max-width: 700px;

    margin: 13px 0 10px;

    color: #073b70;

    font-size:
        clamp(
            34px,
            4.2vw,
            52px
        );

    line-height: 1.04;

    letter-spacing: -2px;

    font-weight: 500;
}


.pl-coming-page-wrap .pl-hero h1 strong {

    display: block;

    color: #1261a8;

    font-weight: 800;
}


.pl-coming-page-wrap .pl-hero-description {

    max-width: 610px;

    margin: 0;

    color: #667b8f;

    font-size: 13px;

    line-height: 1.55;
}


.pl-coming-page-wrap .pl-status {

    width: fit-content;

    display: flex;

    align-items: center;

    gap: 8px;

    margin-top: 12px;

    padding: 9px 13px;

    border-radius: 9px;

    color: #536b80;

    background: #fff;

    border: 1px solid #e3edf4;

    box-shadow:
        0 8px 22px rgba(7,59,112,.05);

    font-size: 11px;

    font-weight: 700;
}


.pl-coming-page-wrap .pl-status i {

    color: #f7941d;

    font-size: 16px;
}


.pl-coming-page-wrap .pl-hero-buttons {

    display: flex;

    flex-wrap: wrap;

    gap: 10px;

    margin-top: 14px;
}


.pl-coming-page-wrap .pl-btn {

    min-height: 46px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    padding: 0 19px;

    border-radius: 9px;

    text-decoration: none;

    font-size: 12px;

    font-weight: 800;

    transition: all .25s ease;
}


.pl-coming-page-wrap .pl-btn-primary {

    color: #fff;

    background:
        linear-gradient(
            135deg,
            #1261a8,
            #1685c8
        );

    box-shadow:
        0 9px 22px rgba(18,97,168,.2);
}


.pl-coming-page-wrap .pl-btn-primary:hover {

    color: #fff;

    transform: translateY(-2px);

    box-shadow:
        0 13px 28px rgba(18,97,168,.26);
}


.pl-coming-page-wrap .pl-btn-secondary {

    color: #1261a8;

    background: #fff;

    border: 1px solid #d8e5ee;
}


.pl-coming-page-wrap .pl-btn-secondary:hover {

    color: #fff;

    background: #1261a8;

    border-color: #1261a8;
}


.pl-coming-page-wrap .pl-platforms {

    display: flex;

    flex-wrap: wrap;

    align-items: center;

    gap: 18px;

    margin-top: 12px;
}


.pl-coming-page-wrap .pl-platforms span {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    color: #788b9c;

    font-size: 11px;

    font-weight: 700;
}


.pl-coming-page-wrap .pl-platforms i {

    color: #1261a8;

    font-size: 16px;
}


/* ============================================================
   HERO PHONE
   ============================================================ */

.pl-coming-page-wrap .pl-hero-visual {

    min-height: 400px;

    position: relative;

    display: flex;

    align-items: center;

    justify-content: center;
}


.pl-coming-page-wrap .pl-hero-glow {

    position: absolute;

    width: 330px;
    height: 330px;

    border-radius: 50%;

    background:
        radial-gradient(
            circle,
            rgba(22,133,200,.19),
            rgba(22,133,200,.03) 55%,
            transparent 70%
        );
}


.pl-coming-page-wrap .pl-phone {

    position: relative;

    z-index: 3;

    width: 225px;
    height: 435px;

    padding: 8px;

    border-radius: 37px;

    background: #102f4c;

    box-shadow:
        0 35px 65px rgba(7,59,112,.23),
        0 10px 25px rgba(7,59,112,.13);
}


.pl-coming-page-wrap .pl-phone-notch {

    position: absolute;

    left: 50%;
    top: 14px;

    transform: translateX(-50%);

    width: 92px;
    height: 19px;

    border-radius: 20px;

    background: #071d31;

    z-index: 5;
}


.pl-coming-page-wrap .pl-phone-screen {

    width: 100%;
    height: 100%;

    overflow: hidden;

    position: relative;

    border-radius: 29px;

    background: #f7fbfe;
}


.pl-coming-page-wrap .pl-app-header {

    height: 55px;

    display: flex;

    align-items: center;

    gap: 8px;

    padding: 17px 11px 6px;

    background: #fff;
}


.pl-coming-page-wrap .pl-app-logo {

    width: 27px;
    height: 27px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 8px;

    background: #1261a8;

    color: #fff;

    font-size: 14px;
}


.pl-coming-page-wrap .pl-app-title {

    flex: 1;
}


.pl-coming-page-wrap .pl-app-title strong {

    display: block;

    color: #073b70;

    font-size: 10px;
}


.pl-coming-page-wrap .pl-app-title small {

    display: block;

    color: #8a9baa;

    font-size: 6px;
}


.pl-coming-page-wrap .pl-app-header > i {

    color: #1261a8;

    font-size: 14px;
}


.pl-coming-page-wrap .pl-app-welcome {

    padding: 12px 11px 7px;
}


.pl-coming-page-wrap .pl-app-welcome small {

    display: block;

    color: #1685c8;

    font-size: 7px;

    font-weight: 800;

    letter-spacing: .7px;
}


.pl-coming-page-wrap .pl-app-welcome strong {

    display: block;

    max-width: 190px;

    margin-top: 4px;

    color: #073b70;

    font-size: 14px;

    line-height: 1.15;
}


.pl-coming-page-wrap .pl-app-search {

    height: 30px;

    margin: 0 11px 4px;

    padding: 0 8px;

    display: flex;

    align-items: center;

    gap: 6px;

    border-radius: 8px;

    color: #9aa9b6;

    background: #fff;

    border: 1px solid #e7eef3;

    font-size: 7px;

}

.pl-coming-page-wrap .pl-app-search i {

    color: #1261a8;

    font-size: 11px;

}


.pl-coming-page-wrap .pl-app-grid {

    display: grid;

    grid-template-columns:
        repeat(3,1fr);

    gap: 7px;

    padding: 5px 11px;
}


.pl-coming-page-wrap .pl-app-grid div {

    min-height: 55px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-direction: column;

    gap: 5px;

    border-radius: 9px;

    background: #fff;

    border: 1px solid #edf2f6;
}


.pl-coming-page-wrap .pl-app-grid i {

    color: #1261a8;

    font-size: 17px;
}


.pl-coming-page-wrap .pl-app-grid span {

    color: #597087;

    font-size: 7px;

    font-weight: 700;
}


.pl-coming-page-wrap .pl-app-community {

    margin: 6px 11px;

    display: flex;

    align-items: center;

    gap: 8px;

    padding: 7px;

    border-radius: 10px;

    background:
        linear-gradient(
            135deg,
            #eaf6ff,
            #f1fbf2
        );
}


.pl-coming-page-wrap .pl-app-community-icon {

    width: 26px;
    height: 26px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 8px;

    color: #fff;

    background: #42b72a;
}


.pl-coming-page-wrap .pl-app-community small {

    display: block;

    color: #7c8e9e;

    font-size: 6px;
}


.pl-coming-page-wrap .pl-app-community strong {

    display: block;

    color: #073b70;

    font-size: 8px;
}


.pl-coming-page-wrap .pl-app-bottom {

    position: absolute;

    left: 12px;
    right: 12px;
    bottom: 10px;

    height: 41px;

    display: flex;

    align-items: center;

    justify-content: space-around;

    border-radius: 11px;

    background: #fff;

    border: 1px solid #e9eff4;
}


.pl-coming-page-wrap .pl-app-bottom i {

    color: #9aaaba;

    font-size: 14px;
}


.pl-coming-page-wrap .pl-app-bottom i:first-child {

    color: #1261a8;
}


/* FLOATING CARDS */

.pl-coming-page-wrap .pl-floating-card {

    position: absolute;

    z-index: 5;

    display: flex;

    align-items: center;

    gap: 9px;

    padding: 10px 12px;

    border-radius: 12px;

    background: #fff;

    border: 1px solid #e5edf4;

    box-shadow:
        0 15px 35px rgba(7,59,112,.12);

    animation:
        plFloat 4s ease-in-out infinite;
}


.pl-coming-page-wrap .pl-floating-card-icon {

    width: 35px;
    height: 35px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 9px;

    color: #fff;

    background: #1261a8;
}


.pl-coming-page-wrap .pl-floating-card small {

    display: block;

    color: #91a1af;

    font-size: 6px;

    font-weight: 800;
}


.pl-coming-page-wrap .pl-floating-card strong {

    display: block;

    margin-top: 2px;

    color: #073b70;

    font-size: 9px;
}


.pl-coming-page-wrap .pl-community-card {

    top: 95px;

    left: 0;
}


.pl-coming-page-wrap .pl-opportunity-card {

    right: -4px;

    bottom: 85px;

    animation-delay: -2s;
}


.pl-coming-page-wrap .pl-opportunity-card .pl-floating-card-icon {

    background: #42b72a;
}


@keyframes plFloat {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-9px);
    }

}


/* ============================================================
   COMMON SECTIONS
   ============================================================ */

.pl-coming-page-wrap .pl-section-container {

    width: 100%;

    max-width: 1240px;

    margin: auto;

    padding: 62px 24px;
}


.pl-coming-page-wrap .pl-section-heading {

    max-width: 700px;
}


.pl-coming-page-wrap .pl-section-heading.centered {

    margin-left: auto;
    margin-right: auto;

    text-align: center;
}


.pl-coming-page-wrap .pl-section-label {

    display: inline-block;

    margin-bottom: 8px;

    color: #1685c8;

    font-size: 10px;

    font-weight: 800;

    letter-spacing: 1.1px;
}


.pl-coming-page-wrap .pl-section-heading h2 {

    margin: 0;

    color: #073b70;

    font-size:
        clamp(
            29px,
            4vw,
            43px
        );

    line-height: 1.12;

    letter-spacing: -1.3px;
}


.pl-coming-page-wrap .pl-section-heading h2 strong {

    color: #1261a8;
}


.pl-coming-page-wrap .pl-section-heading p {

    max-width: 640px;

    margin: 12px auto 0;

    color: #667b8f;

    font-size: 13px;

    line-height: 1.7;
}


/* ============================================================
   COMMUNITY STRIP
   ============================================================ */

.pl-coming-page-wrap .pl-community-section {

    background: #fff;
}


.pl-coming-page-wrap .pl-community-strip {

    margin-top: 32px;

    display: grid;

    grid-template-columns:
        repeat(6,1fr);

    overflow: hidden;

    border: 1px solid #e5edf4;

    border-radius: 14px;

    box-shadow:
        0 9px 28px rgba(7,59,112,.04);
}


.pl-coming-page-wrap .pl-community-item {

    min-height: 102px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-direction: column;

    gap: 7px;

    background: #fff;

    border-right: 1px solid #e5edf4;

    transition: .25s ease;
}


.pl-coming-page-wrap .pl-community-item:last-child {

    border-right: 0;
}


.pl-coming-page-wrap .pl-community-item:hover {

    background: #f5faff;

    transform: translateY(-2px);
}


.pl-coming-page-wrap .pl-community-item i {

    color: #1261a8;

    font-size: 23px;
}


.pl-coming-page-wrap .pl-community-item span {

    color: #526b80;

    font-size: 10px;

    font-weight: 700;
}


/* ============================================================
   FEATURES
   ============================================================ */

.pl-coming-page-wrap .pl-features-section {

    background: #f7fafc;
}


.pl-coming-page-wrap .pl-feature-grid {

    margin-top: 34px;

    display: grid;

    grid-template-columns:
        repeat(5,1fr);

    gap: 12px;
}


.pl-coming-page-wrap .pl-feature {

    min-height: 170px;

    padding: 18px;

    border-radius: 13px;

    background: #fff;

    border: 1px solid #e5edf4;

    box-shadow:
        0 5px 18px rgba(7,59,112,.03);

    transition: all .25s ease;
}


.pl-coming-page-wrap .pl-feature:hover {

    transform: translateY(-4px);

    box-shadow:
        0 15px 30px rgba(7,59,112,.08);
}


.pl-coming-page-wrap .pl-feature-icon {

    width: 41px;
    height: 41px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-bottom: 12px;

    border-radius: 10px;

    font-size: 17px;
}


.pl-coming-page-wrap .blue {

    color: #1261a8;

    background: #e9f4fd;
}


.pl-coming-page-wrap .green {

    color: #42b72a;

    background: #edf9eb;
}


.pl-coming-page-wrap .orange {

    color: #f7941d;

    background: #fff4e7;
}


.pl-coming-page-wrap .red {

    color: #e72d55;

    background: #fff0f3;
}


.pl-coming-page-wrap .purple {

    color: #7434c4;

    background: #f4effd;
}


.pl-coming-page-wrap .pl-feature h3 {

    margin: 0 0 6px;

    color: #073b70;

    font-size: 13px;

    line-height: 1.35;
}


.pl-coming-page-wrap .pl-feature p {

    margin: 0;

    color: #728496;

    font-size: 10px;

    line-height: 1.6;
}


/* ============================================================
   DIGITAL IDENTITY
   ============================================================ */

.pl-coming-page-wrap .pl-identity-section {

    background: #fff;
}


.pl-coming-page-wrap .pl-identity-box {

    min-height: 390px;

    display: grid;

    grid-template-columns:
        1fr
        .7fr;

    align-items: center;

    gap: 45px;

    padding: 42px;

    border-radius: 20px;

    background:

        radial-gradient(
            circle at 90% 50%,
            rgba(22,133,200,.13),
            transparent 35%
        ),

        linear-gradient(
            135deg,
            #f0f8fd,
            #f8fbfd
        );
}


.pl-coming-page-wrap .pl-identity-content h2 {

    max-width: 600px;

    margin: 0;

    color: #073b70;

    font-size:
        clamp(
            29px,
            4vw,
            43px
        );

    line-height: 1.1;

    letter-spacing: -1.4px;
}


.pl-coming-page-wrap .pl-identity-content h2 strong {

    color: #1261a8;
}


.pl-coming-page-wrap .pl-identity-content > p {

    max-width: 570px;

    margin: 13px 0 19px;

    color: #667b8f;

    font-size: 13px;

    line-height: 1.7;
}


.pl-coming-page-wrap .pl-identity-tags {

    display: flex;

    flex-wrap: wrap;

    gap: 6px;
}


.pl-coming-page-wrap .pl-identity-tags span {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 7px 9px;

    border-radius: 7px;

    color: #587087;

    background: #fff;

    border: 1px solid #e0ebf2;

    font-size: 9px;

    font-weight: 700;
}


.pl-coming-page-wrap .pl-identity-tags i {

    color: #1261a8;
}


/* IDENTITY VISUAL */

.pl-coming-page-wrap .pl-identity-visual {

    min-height: 290px;

    display: flex;

    align-items: center;

    justify-content: center;
}


.pl-coming-page-wrap .pl-identity-circle {

    width: 235px;
    height: 235px;

    position: relative;

    border-radius: 50%;

    border: 1px dashed #b9d7ea;
}


.pl-coming-page-wrap .pl-identity-circle::before,
.pl-coming-page-wrap .pl-identity-circle::after {

    content: "";

    position: absolute;

    border-radius: 50%;

    border: 1px solid rgba(18,97,168,.12);
}


.pl-coming-page-wrap .pl-identity-circle::before {

    inset: 23px;
}


.pl-coming-page-wrap .pl-identity-circle::after {

    inset: 47px;
}


.pl-coming-page-wrap .pl-identity-center {

    position: absolute;

    left: 50%;
    top: 50%;

    transform:
        translate(
            -50%,
            -50%
        );

    width: 87px;
    height: 87px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-direction: column;

    gap: 4px;

    border-radius: 50%;

    color: #fff;

    background:
        linear-gradient(
            135deg,
            #1261a8,
            #1685c8
        );

    box-shadow:
        0 13px 28px rgba(18,97,168,.25);
}


.pl-coming-page-wrap .pl-identity-center i {

    font-size: 21px;
}


.pl-coming-page-wrap .pl-identity-center span {

    font-size: 8px;

    font-weight: 800;
}


.pl-coming-page-wrap .pl-identity-node {

    position: absolute;

    width: 41px;
    height: 41px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #fff;

    border: 1px solid #dbe9f2;

    color: #1261a8;

    box-shadow:
        0 7px 18px rgba(7,59,112,.09);

    z-index: 3;
}


.pl-coming-page-wrap .node-1 {

    top: -6px;
    left: 50%;

    transform:
        translateX(-50%);
}


.pl-coming-page-wrap .node-2 {

    right: -5px;
    top: 50%;

    transform:
        translateY(-50%);
}


.pl-coming-page-wrap .node-3 {

    bottom: -6px;
    left: 50%;

    transform:
        translateX(-50%);
}


.pl-coming-page-wrap .node-4 {

    left: -5px;
    top: 50%;

    transform:
        translateY(-50%);
}


/* ============================================================
   APP SECTION
   ============================================================ */

.pl-coming-page-wrap .pl-app-section {

    background: #f7fafc;
}


.pl-coming-page-wrap .pl-app-box {

    min-height: 320px;

    display: grid;

    grid-template-columns:
        1fr
        280px;

    align-items: center;

    gap: 40px;

    padding: 40px;

    position: relative;

    overflow: hidden;

    border-radius: 20px;

    background:
        linear-gradient(
            135deg,
            #073b70,
            #1261a8
        );
}


.pl-coming-page-wrap .pl-app-box::after {

    content: "";

    position: absolute;

    width: 350px;
    height: 350px;

    right: -140px;
    top: -190px;

    border-radius: 50%;

    background: rgba(255,255,255,.06);
}


.pl-coming-page-wrap .pl-app-content {

    position: relative;

    z-index: 2;
}


.pl-coming-page-wrap .pl-app-content .pl-section-label {

    color: #9edbff;
}


.pl-coming-page-wrap .pl-app-content h2 {

    max-width: 600px;

    margin: 0;

    color: #fff;

    font-size:
        clamp(
            29px,
            4vw,
            42px
        );

    line-height: 1.1;

    letter-spacing: -1.3px;
}


.pl-coming-page-wrap .pl-app-content h2 strong {

    color: #8ed3ff;
}


.pl-coming-page-wrap .pl-app-content > p {

    max-width: 560px;

    margin: 12px 0 17px;

    color: rgba(255,255,255,.76);

    font-size: 12px;

    line-height: 1.7;
}


.pl-coming-page-wrap .pl-app-features {

    display: flex;

    flex-wrap: wrap;

    gap: 12px;
}


.pl-coming-page-wrap .pl-app-features span {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    color: rgba(255,255,255,.88);

    font-size: 9px;

    font-weight: 700;
}


.pl-coming-page-wrap .pl-app-features i {

    color: #70db8a;
}


.pl-coming-page-wrap .pl-store-buttons {

    display: flex;

    flex-wrap: wrap;

    gap: 8px;

    margin-top: 20px;
}


.pl-coming-page-wrap .pl-store-button {

    min-width: 140px;

    display: flex;

    align-items: center;

    gap: 8px;

    padding: 8px 10px;

    border-radius: 8px;

    border: 1px solid rgba(255,255,255,.16);

    background: rgba(255,255,255,.08);
}


.pl-coming-page-wrap .pl-store-button > i {

    color: #fff;

    font-size: 21px;
}


.pl-coming-page-wrap .pl-store-button small {

    display: block;

    color: rgba(255,255,255,.55);

    font-size: 6px;
}


.pl-coming-page-wrap .pl-store-button strong {

    display: block;

    margin-top: 2px;

    color: #fff;

    font-size: 10px;
}


/* QR */

.pl-coming-page-wrap .pl-qr-area {

    display: flex;

    justify-content: center;

    position: relative;

    z-index: 2;
}


.pl-coming-page-wrap .pl-qr-card {

    width: 180px;

    padding: 16px;

    border-radius: 14px;

    text-align: center;

    background: #fff;

    box-shadow:
        0 17px 33px rgba(0,0,0,.15);
}


.pl-coming-page-wrap .pl-qr-placeholder {

    width: 130px;
    height: 130px;

    margin: 0 auto 11px;

    padding: 10px;

    border: 1px solid #e3e9ee;
}


.pl-coming-page-wrap .pl-qr-pattern {

    width: 100%;
    height: 100%;

    display: grid;

    grid-template-columns:
        repeat(3,1fr);

    gap: 4px;
}


.pl-coming-page-wrap .pl-qr-pattern span {

    background: #073b70;
}


.pl-coming-page-wrap .pl-qr-pattern span:nth-child(2),
.pl-coming-page-wrap .pl-qr-pattern span:nth-child(5),
.pl-coming-page-wrap .pl-qr-pattern span:nth-child(8) {

    background: #fff;

    border: 4px solid #073b70;
}


.pl-coming-page-wrap .pl-qr-card > strong {

    display: block;

    color: #073b70;

    font-size: 10px;
}


.pl-coming-page-wrap .pl-qr-card > small {

    display: block;

    margin-top: 3px;

    color: #8798a7;

    font-size: 8px;
}


/* ============================================================
   FINAL CTA
   ============================================================ */

.pl-coming-page-wrap .pl-final-section {

    background:

        radial-gradient(
            circle at 50% 0,
            rgba(22,133,200,.14),
            transparent 35%
        ),

        #f4f9fc;
}


.pl-coming-page-wrap .pl-final-container {

    max-width: 850px;

    margin: auto;

    padding: 67px 24px;

    text-align: center;
}


.pl-coming-page-wrap .pl-final-logo {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    color: #073b70;

    font-size: 16px;

    font-weight: 800;
}


.pl-coming-page-wrap .pl-final-logo span {

    width: 37px;
    height: 37px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    color: #fff;

    background: #1261a8;
}


.pl-coming-page-wrap .pl-final-container h2 {

    margin: 17px 0 8px;

    color: #073b70;

    font-size:
        clamp(
            29px,
            4vw,
            45px
        );

    line-height: 1.12;

    letter-spacing: -1.4px;
}


.pl-coming-page-wrap .pl-final-container h2 strong {

    color: #1261a8;
}


.pl-coming-page-wrap .pl-final-tagline {

    margin: 0;

    color: #1685c8;

    font-size: 13px;

    font-weight: 800;

    letter-spacing: 2px;
}


.pl-coming-page-wrap .pl-launch-text {

    margin: 9px 0 21px;

    color: #73879a;

    font-size: 12px;
}


/* ============================================================
   FOOTER
   ============================================================ */

.pl-coming-page-wrap .pl-footer {

    background: #062e56;

    color: #fff;
}


.pl-coming-page-wrap .pl-footer-main {

    width: 100%;

    max-width: 1240px;

    margin: auto;

    padding: 52px 24px 42px;

    display: grid;

    grid-template-columns:
        1.5fr
        .8fr
        .9fr
        1.15fr;

    gap: 45px;
}


/* FOOTER LOGO */

.pl-coming-page-wrap .pl-footer-logo {

    display: inline-flex;

    align-items: center;

    text-decoration: none;

    color: #fff;
}


.pl-coming-page-wrap .pl-footer-logo img {

    width: auto;

    max-width: 190px;

    max-height: 54px;

    object-fit: contain;

    display: block;
}


.pl-coming-page-wrap .pl-footer-description {

    max-width: 330px;

    margin: 17px 0 19px;

    color: rgba(255,255,255,.63);

    font-size: 12px;

    line-height: 1.7;
}


/* SOCIAL */

.pl-coming-page-wrap .pl-social {

    display: flex;

    gap: 7px;
}


.pl-coming-page-wrap .pl-social a {

    width: 35px;
    height: 35px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 8px;

    color: rgba(255,255,255,.75);

    background: rgba(255,255,255,.08);

    text-decoration: none;

    transition: .25s ease;
}


.pl-coming-page-wrap .pl-social a:hover {

    color: #fff;

    background: #1685c8;

    transform: translateY(-2px);
}


/* FOOTER COLUMNS */

.pl-coming-page-wrap .pl-footer-column {

    display: flex;

    flex-direction: column;

    align-items: flex-start;
}


.pl-coming-page-wrap .pl-footer-column h3 {

    margin: 3px 0 17px;

    color: #fff;

    font-size: 13px;

    font-weight: 800;
}


.pl-coming-page-wrap .pl-footer-column > a {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    margin-bottom: 10px;

    color: rgba(255,255,255,.63);

    text-decoration: none;

    font-size: 11px;

    transition: .2s ease;
}


.pl-coming-page-wrap .pl-footer-column > a i {

    color: #5dbdf4;

    font-size: 8px;
}


.pl-coming-page-wrap .pl-footer-column > a:hover {

    color: #fff;

    transform: translateX(3px);
}


/* CONTACT */

.pl-coming-page-wrap .pl-contact-item {

    width: 100%;

    display: flex;

    align-items: flex-start;

    gap: 10px;

    margin-bottom: 13px;
}


.pl-coming-page-wrap .pl-contact-item > i {

    width: 33px;
    height: 33px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 8px;

    color: #5dbdf4;

    background: rgba(255,255,255,.08);

    font-size: 13px;
}


.pl-coming-page-wrap .pl-contact-item span {

    display: flex;

    flex-direction: column;

    gap: 2px;
}


.pl-coming-page-wrap .pl-contact-item small {

    color: rgba(255,255,255,.4);

    font-size: 8px;
}


.pl-coming-page-wrap .pl-contact-item strong {

    color: rgba(255,255,255,.82);

    font-size: 10px;

    font-weight: 600;
}


/* FOOTER BOTTOM */

.pl-coming-page-wrap .pl-footer-bottom {

    border-top: 1px solid rgba(255,255,255,.08);
}


.pl-coming-page-wrap .pl-footer-bottom-inner {

    width: 100%;

    max-width: 1240px;

    margin: auto;

    padding: 16px 24px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;
}


.pl-coming-page-wrap .pl-footer-bottom p {

    margin: 0;

    color: rgba(255,255,255,.47);

    font-size: 9px;
}


.pl-coming-page-wrap .pl-footer-bottom p strong {

    color: rgba(255,255,255,.76);
}


.pl-coming-page-wrap .pl-footer-links {

    display: flex;

    gap: 17px;
}


.pl-coming-page-wrap .pl-footer-links a {

    color: rgba(255,255,255,.47);

    text-decoration: none;

    font-size: 9px;
}


.pl-coming-page-wrap .pl-footer-links a:hover {

    color: #fff;
}


/* FLOATING BUTTONS */

.pl-coming-page-wrap .pl-floating-actions {

    position: fixed;

    right: 18px;

    bottom: 18px;

    z-index: 9998;

    display: flex;

    flex-direction: column;

    gap: 8px;
}


.pl-coming-page-wrap .pl-floating-actions a {

    width: 45px;
    height: 45px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    color: #fff;

    text-decoration: none;

    font-size: 17px;

    box-shadow:
        0 8px 22px rgba(0,0,0,.2);

    transition: .25s ease;
}


.pl-coming-page-wrap .pl-floating-actions a:hover {

    transform:
        translateY(-3px)
        scale(1.03);
}


.pl-coming-page-wrap .pl-call {

    background: #1261a8;
}


.pl-coming-page-wrap .pl-whatsapp {

    background: #25d366;
}


/* ============================================================
   RESPONSIVE
   ============================================================ */

@media(max-width:1100px) {

    .pl-coming-page-wrap .pl-feature-grid {

        grid-template-columns:
            repeat(4,1fr);
    }


    .pl-coming-page-wrap .pl-community-strip {

        grid-template-columns:
            repeat(3,1fr);
    }


    .pl-coming-page-wrap .pl-community-item:nth-child(3) {

        border-right: 0;
    }

}


@media(max-width:950px) {

    .pl-coming-page-wrap .pl-header-nav {

        display: none;
    }


    .pl-coming-page-wrap .pl-menu-btn {

        display: flex;
    }


    .pl-coming-page-wrap .pl-footer-main {

        grid-template-columns:
            1.2fr 1fr 1fr;
    }


    .pl-coming-page-wrap .pl-footer-contact {

        grid-column: span 3;
    }

}


@media(max-width:850px) {

    .pl-coming-page-wrap .pl-hero-inner {

        grid-template-columns: 1fr;
    }


    .pl-coming-page-wrap .pl-hero-content {

        text-align: center;
    }


    .pl-coming-page-wrap .pl-coming-badge,
    .pl-coming-page-wrap .pl-status {

        margin-left: auto;
        margin-right: auto;
    }


    .pl-coming-page-wrap .pl-hero-description {

        margin-left: auto;
        margin-right: auto;
    }


    .pl-coming-page-wrap .pl-hero-buttons {

        justify-content: center;
    }


    .pl-coming-page-wrap .pl-platforms {

        justify-content: center;
    }


    .pl-coming-page-wrap .pl-identity-box {

        grid-template-columns: 1fr;
    }


    .pl-coming-page-wrap .pl-app-box {

        grid-template-columns: 1fr;
    }


    .pl-coming-page-wrap .pl-qr-area {

        justify-content: flex-start;
    }

}


@media(max-width:650px) {

    .pl-coming-page-wrap .pl-header-inner {

        min-height: 68px;

        padding: 0 17px;
    }


    .pl-coming-page-wrap .pl-header-logo img {

        max-width: 165px;

        max-height: 48px;
    }


    .pl-coming-page-wrap .pl-hero {

        min-height: auto;

        padding: 42px 17px 48px;
    }


    .pl-coming-page-wrap .pl-hero h1 {

        font-size: 36px;

        letter-spacing: -1.5px;
    }


    .pl-coming-page-wrap .pl-hero-visual {

        min-height: 415px;
    }


    .pl-coming-page-wrap .pl-phone {

        width: 225px;

        height: 435px;
    }


    .pl-coming-page-wrap .pl-community-card {

        left: -5px;

        top: 62px;
    }


    .pl-coming-page-wrap .pl-opportunity-card {

        right: -5px;

        bottom: 50px;
    }


    .pl-coming-page-wrap .pl-section-container {

        padding: 48px 17px;
    }


    .pl-coming-page-wrap .pl-community-strip {

        grid-template-columns:
            repeat(2,1fr);
    }


    .pl-coming-page-wrap .pl-community-item {

        min-height: 88px;
    }


    .pl-coming-page-wrap .pl-community-item:nth-child(3) {

        border-right: 1px solid #e5edf4;
    }


    .pl-coming-page-wrap .pl-community-item:nth-child(even) {

        border-right: 0;
    }


    .pl-coming-page-wrap .pl-feature-grid {

        grid-template-columns:
            repeat(2,1fr);
    }


    .pl-coming-page-wrap .pl-feature {

        min-height: 155px;

        padding: 15px;
    }


    .pl-coming-page-wrap .pl-identity-box {

        padding: 25px 19px;
    }


    .pl-coming-page-wrap .pl-app-box {

        padding: 28px 20px;
    }


    .pl-coming-page-wrap .pl-qr-area {

        justify-content: center;
    }


    .pl-coming-page-wrap .pl-footer-main {

        grid-template-columns:
            1fr 1fr;

        padding: 42px 20px 34px;
    }


    .pl-coming-page-wrap .pl-footer-brand,
    .pl-coming-page-wrap .pl-footer-contact {

        grid-column: span 2;
    }


    .pl-coming-page-wrap .pl-footer-bottom-inner {

        flex-direction: column;

        align-items: flex-start;

        padding: 15px 20px;
    }

}


@media(max-width:430px) {

    .pl-coming-page-wrap .pl-header-logo img {

        max-width: 145px;

        max-height: 44px;
    }


    .pl-coming-page-wrap .pl-hero h1 {

        font-size: 32px;
    }


    .pl-coming-page-wrap .pl-hero-buttons {

        flex-direction: column;
    }


    .pl-coming-page-wrap .pl-btn {

        width: 100%;
    }


    .pl-coming-page-wrap .pl-feature-grid {

        grid-template-columns: 1fr;
    }


    .pl-coming-page-wrap .pl-footer-main {

        grid-template-columns: 1fr;
    }


    .pl-coming-page-wrap .pl-footer-brand,
    .pl-coming-page-wrap .pl-footer-contact {

        grid-column: auto;
    }

}



/* ================================
   PREMIUM HEADER LOGO - BIGGER
================================ */

.pl-coming-page-wrap .pl-header-logo img {
    width: 225px;
    height: auto;
    max-height: 78px;
    object-fit: contain;
    display: block;
}

.pl-coming-page-wrap .pl-header {
    min-height: 82px;
}

.pl-coming-page-wrap .pl-header-inner {
    min-height: 82px;
}


/* ================================
   BIGGER FOOTER FONTS
================================ */

.pl-coming-page-wrap .pl-footer {
    font-size: 16px;
}

.pl-coming-page-wrap .pl-footer-description {
    font-size: 17px;
    line-height: 1.8;
}

.pl-coming-page-wrap .pl-footer-column h4 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 18px;
}

.pl-coming-page-wrap .pl-footer-column a {
    font-size: 16px;
    line-height: 1.9;
}

.pl-coming-page-wrap .pl-contact-item {
    font-size: 16px;
    line-height: 1.7;
}

.pl-coming-page-wrap .pl-contact-item i {
    font-size: 19px;
}

.pl-coming-page-wrap .pl-footer-bottom {
    font-size: 15px;
}

.pl-coming-page-wrap .pl-footer-links a {
    font-size: 15px;
}

.pl-coming-page-wrap .pl-footer-logo img {
    width: 190px;
    max-height: 70px;
    object-fit: contain;
}


/* ================================
   MOBILE
================================ */

@media (max-width: 768px) {

    .pl-coming-page-wrap .pl-header-logo img {
        width: 185px;
        max-height: 65px;
    }

    .pl-coming-page-wrap .pl-header,
    .pl-coming-page-wrap .pl-header-inner {
        min-height: 72px;
    }

    .pl-coming-page-wrap .pl-footer-description {
        font-size: 16px;
    }

    .pl-coming-page-wrap .pl-footer-column h4 {
        font-size: 19px;
    }

    .pl-coming-page-wrap .pl-footer-column a,
    .pl-coming-page-wrap .pl-contact-item {
        font-size: 16px;
    }
}



/* =========================================================
   PEOPLELINK COMING SOON FOOTER - EXACT FULL WIDTH FIX
========================================================= */

.pl-coming-page-wrap {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

.pl-coming-page-wrap .pl-footer {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    overflow: hidden;
}

.pl-coming-page-wrap .pl-footer-main {
    width: 100%;
    max-width: 100%;
    margin: 0;
    box-sizing: border-box;
    padding: 55px 5%;
}

.pl-coming-page-wrap .pl-footer-bottom {
    width: 100%;
    max-width: 100%;
    margin: 0;
    box-sizing: border-box;
    padding: 20px 5%;
}

.pl-coming-page-wrap .pl-footer-bottom-inner {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


/* Footer grid */
.pl-coming-page-wrap .pl-footer-main {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1.3fr;
    gap: 45px;
}


/* Bigger footer text */
.pl-coming-page-wrap .pl-footer-description {
    font-size: 17px;
    line-height: 1.8;
}

.pl-coming-page-wrap .pl-footer-column h4 {
    font-size: 20px;
    line-height: 1.3;
    margin-bottom: 18px;
}

.pl-coming-page-wrap .pl-footer-column a {
    font-size: 16px;
    line-height: 2;
}

.pl-coming-page-wrap .pl-contact-item {
    font-size: 16px;
    line-height: 1.8;
}


/* Footer logo */
.pl-coming-page-wrap .pl-footer-logo img {
    width: 200px;
    max-width: 100%;
    height: auto;
}


/* Footer social icons */
.pl-coming-page-wrap .pl-social {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}


/* Footer bottom */
.pl-coming-page-wrap .pl-footer-bottom {
    font-size: 15px;
}

.pl-coming-page-wrap .pl-footer-links {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 900px) {

    .pl-coming-page-wrap .pl-footer-main {
        grid-template-columns: 1fr 1fr;
        gap: 35px;
    }
}


@media (max-width: 600px) {

    .pl-coming-page-wrap .pl-footer-main {
        width: 100%;
        grid-template-columns: 1fr;
        gap: 30px;
        padding: 40px 22px;
    }

    .pl-coming-page-wrap .pl-footer-bottom {
        padding: 18px 22px;
    }

    .pl-coming-page-wrap .pl-footer-bottom-inner {
        text-align: center;
    }

    .pl-coming-page-wrap .pl-footer-links {
        justify-content: center;
    }

    .pl-coming-page-wrap .pl-footer-logo img {
        width: 180px;
    }
}


/* Footer text and links - larger and easier to read */
.pl-footer,
.pl-footer a,
.pl-footer p,
.pl-footer li,
.pl-footer span {
    font-size: 16px !important;
    line-height: 1.65 !important;
}

.pl-footer a {
    font-weight: 600 !important;
}

.pl-footer .pl-footer-title,
.pl-footer h3,
.pl-footer h4 {
    font-size: 19px !important;
    line-height: 1.35 !important;
    font-weight: 700 !important;
}

.pl-footer .pl-footer-bottom,
.pl-footer .pl-footer-bottom a,
.pl-footer .pl-footer-bottom p,
.pl-footer .pl-footer-bottom span {
    font-size: 15px !important;
    line-height: 1.6 !important;
}


/* FINAL FOOTER / HEADER ADJUSTMENTS */
.pl-coming-page-wrap .pl-header-logo img {
    width: 225px !important;
    max-width: 225px !important;
    max-height: 78px !important;
    height: auto !important;
}

.pl-coming-page-wrap .pl-footer-logo {
    display: none !important;
}

.pl-coming-page-wrap .pl-footer-column h3 {
    font-size: 22px !important;
    line-height: 1.3 !important;
    font-weight: 800 !important;
    margin-bottom: 20px !important;
}

.pl-coming-page-wrap .pl-footer-contact .pl-contact-item,
.pl-coming-page-wrap .pl-footer-contact .pl-contact-item strong {
    font-size: 18px !important;
    line-height: 1.75 !important;
}

.pl-coming-page-wrap .pl-footer-contact .pl-contact-item small {
    font-size: 12px !important;
}

.pl-coming-page-wrap .pl-footer-contact .pl-contact-item > i {
    width: 38px !important;
    height: 38px !important;
    font-size: 17px !important;
}

@media (max-width: 768px) {
    .pl-coming-page-wrap .pl-header-logo img {
        width: 185px !important;
        max-width: 185px !important;
        max-height: 65px !important;
    }

    .pl-coming-page-wrap .pl-footer-column h3 {
        font-size: 21px !important;
    }

    .pl-coming-page-wrap .pl-footer-contact .pl-contact-item,
    .pl-coming-page-wrap .pl-footer-contact .pl-contact-item strong {
        font-size: 17px !important;
    }
}

@media (max-width: 430px) {
    .pl-coming-page-wrap .pl-header-logo img {
        width: 165px !important;
        max-width: 165px !important;
        max-height: 54px !important;
    }
}


/* =========================================================
   FINAL FOOTER BRAND + UNIFORM TYPOGRAPHY
   ========================================================= */

.pl-coming-page-wrap .pl-footer-brand-text {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
    color: #fff;
    text-decoration: none;
}

.pl-coming-page-wrap .pl-footer-brand-icon {
    width: 48px;
    height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 13px;
    color: #fff;
    background: linear-gradient(135deg, #1261a8, #1685c8);
    box-shadow: 0 8px 22px rgba(0,0,0,.18);
    font-size: 22px;
}

.pl-coming-page-wrap .pl-footer-brand-name {
    color: #fff;
    font-size: 28px;
    line-height: 1;
    font-weight: 800;
    letter-spacing: -.5px;
}

/* Same readable size across all footer menu sections */
.pl-coming-page-wrap .pl-footer-column h3 {
    font-size: 20px !important;
    line-height: 1.35 !important;
    font-weight: 800 !important;
    margin-bottom: 18px !important;
}

.pl-coming-page-wrap .pl-footer-column > a,
.pl-coming-page-wrap .pl-footer-column > a i,
.pl-coming-page-wrap .pl-contact-item,
.pl-coming-page-wrap .pl-contact-item strong,
.pl-coming-page-wrap .pl-footer-description {
    font-size: 16px !important;
    line-height: 1.75 !important;
}

.pl-coming-page-wrap .pl-footer-column > a {
    margin-bottom: 9px !important;
    font-weight: 600 !important;
}

.pl-coming-page-wrap .pl-footer-column > a i {
    font-size: 11px !important;
}

.pl-coming-page-wrap .pl-contact-item small {
    font-size: 12px !important;
    line-height: 1.4 !important;
}

.pl-coming-page-wrap .pl-contact-item strong {
    font-weight: 600 !important;
}

.pl-coming-page-wrap .pl-footer-description {
    font-weight: 400 !important;
}

.pl-coming-page-wrap .pl-footer-bottom p,
.pl-coming-page-wrap .pl-footer-links a {
    font-size: 15px !important;
    line-height: 1.6 !important;
}

@media (max-width: 768px) {
    .pl-coming-page-wrap .pl-footer-brand-name {
        font-size: 25px;
    }

    .pl-coming-page-wrap .pl-footer-column h3 {
        font-size: 20px !important;
    }

    .pl-coming-page-wrap .pl-footer-column > a,
    .pl-coming-page-wrap .pl-contact-item,
    .pl-coming-page-wrap .pl-contact-item strong,
    .pl-coming-page-wrap .pl-footer-description {
        font-size: 16px !important;
    }
}

</style>

</head>


<body>


<div class="pl-coming-page-wrap">


<!-- ============================================================
     PREMIUM HEADER
     ============================================================ -->

<header class="pl-header">

    <div class="pl-header-inner">


        <!-- LOGO -->

        <a href="#home"
           class="pl-header-logo">

            <img
                src="<?php echo htmlspecialchars($logo); ?>"
                alt="PeopleLink">

        </a>


        <!-- DESKTOP NAVIGATION -->

        <nav class="pl-header-nav">

            <a href="#home"
               class="active">

                <i class="bi bi-house-door-fill"></i>

                Home

            </a>


            <a href="#communities">

                <i class="bi bi-people-fill"></i>

                Communities

            </a>


            <a href="#features">

                <i class="bi bi-grid-fill"></i>

                Features

            </a>


            <a href="#app">

                <i class="bi bi-phone-fill"></i>

                Mobile App

            </a>


            <a href="#contact"
               class="pl-header-cta">

                <i class="bi bi-envelope-fill"></i>

                Contact

            </a>

        </nav>


        <!-- MOBILE MENU -->

        <button
            type="button"
            class="pl-menu-btn"
            id="plMenuButton"
            aria-label="Open menu">

            <i class="bi bi-list"></i>

        </button>


    </div>


    <!-- MOBILE NAVIGATION -->

    <div
        class="pl-mobile-nav"
        id="plMobileNav">


        <a href="#home">

            <i class="bi bi-house-door-fill"></i>

            Home

        </a>


        <a href="#communities">

            <i class="bi bi-people-fill"></i>

            Communities

        </a>


        <a href="#features">

            <i class="bi bi-grid-fill"></i>

            Features

        </a>


        <a href="#app">

            <i class="bi bi-phone-fill"></i>

            Mobile App

        </a>


        <a href="#contact">

            <i class="bi bi-envelope-fill"></i>

            Contact

        </a>


    </div>

</header>


<!-- ============================================================
     HERO
     ============================================================ -->

<main class="pl-main"
      id="home">


<section class="pl-hero">

    <div class="pl-hero-inner">


        <div class="pl-hero-content">


            <div class="pl-coming-badge">

                <span></span>

                PEOPLELINK IS COMING SOON

            </div>


            <h1>

                One Platform.

                <strong>
                    Many Communities.
                </strong>

                Stronger Connections.

            </h1>


            <p class="pl-hero-description">

                Something powerful is coming soon.
                PeopleLink is building a unified digital
                platform for communities, families,
                professionals, businesses and opportunities.

            </p>


            <div class="pl-status">

                <i class="bi bi-stars"></i>

                Website &amp; Mobile App Under Development

            </div>


            <div class="pl-hero-buttons">


                <a href="#features"
                   class="pl-btn pl-btn-primary">

                    <i class="bi bi-grid-fill"></i>

                    Explore Features

                </a>


                <a href="#app"
                   class="pl-btn pl-btn-secondary">

                    <i class="bi bi-phone-fill"></i>

                    App Coming Soon

                </a>


            </div>


            <div class="pl-platforms">

                <span>

                    <i class="bi bi-android2"></i>

                    Android

                </span>


                <span>

                    <i class="bi bi-apple"></i>

                    iOS

                </span>


                <span>

                    <i class="bi bi-phone-fill"></i>

                    Mobile App

                </span>

            </div>


        </div>


        <!-- HERO PHONE -->

        <div class="pl-hero-visual">


            <div class="pl-hero-glow"></div>


            <div class="pl-phone">


                <div class="pl-phone-notch"></div>


                <div class="pl-phone-screen">


                    <div class="pl-app-header">


                        <div class="pl-app-logo">

                            <i class="bi bi-people-fill"></i>

                        </div>


                        <div class="pl-app-title">

                            <strong>
                                PeopleLink
                            </strong>

                            <small>
                                Your Community
                            </small>

                        </div>


                        <i class="bi bi-bell-fill"></i>


                    </div>


                    <div class="pl-app-welcome">

                        <small>
                            WELCOME TO PEOPLELINK
                        </small>

                        <strong>
                            Connect. Discover. Belong.
                        </strong>

                    </div>


                    <div class="pl-app-search">

                        <i class="bi bi-search"></i>

                        <span>
                            Search people, businesses...
                        </span>

                    </div>


                    <div class="pl-app-grid">


                        <div>

                            <i class="bi bi-heart-fill"></i>

                            <span>
                                Matrimony
                            </span>

                        </div>


                        <div>

                            <i class="bi bi-briefcase-fill"></i>

                            <span>
                                Jobs
                            </span>

                        </div>


                        <div>

                            <i class="bi bi-building-fill"></i>

                            <span>
                                Business
                            </span>

                        </div>


                        <div>

                            <i class="bi bi-calendar-event-fill"></i>

                            <span>
                                Events
                            </span>

                        </div>


                        <div>

                            <i class="bi bi-geo-alt-fill"></i>

                            <span>
                                Near Me
                            </span>

                        </div>


                        <div>

                            <i class="bi bi-people-fill"></i>

                            <span>
                                Community
                            </span>

                        </div>


                    </div>


                    <div class="pl-app-community">


                        <div class="pl-app-community-icon">

                            <i class="bi bi-people-fill"></i>

                        </div>


                        <div>

                            <small>
                                COMMUNITY NETWORK
                            </small>

                            <strong>
                                Connect • Discover • Belong
                            </strong>

                        </div>


                    </div>


                    <div class="pl-app-bottom">

                        <i class="bi bi-house-door-fill"></i>

                        <i class="bi bi-search"></i>

                        <i class="bi bi-plus-circle-fill"></i>

                        <i class="bi bi-chat-dots-fill"></i>

                        <i class="bi bi-person-circle"></i>

                    </div>


                </div>

            </div>


            <!-- FLOATING CARD -->

            <div class="pl-floating-card pl-community-card">


                <div class="pl-floating-card-icon">

                    <i class="bi bi-people-fill"></i>

                </div>


                <span>

                    <small>
                        COMMUNITIES
                    </small>

                    <strong>
                        Connect Together
                    </strong>

                </span>


            </div>


            <div class="pl-floating-card pl-opportunity-card">


                <div class="pl-floating-card-icon">

                    <i class="bi bi-briefcase-fill"></i>

                </div>


                <span>

                    <small>
                        OPPORTUNITIES
                    </small>

                    <strong>
                        Grow Together
                    </strong>

                </span>


            </div>


        </div>


    </div>

</section>


<!-- ============================================================
     COMMUNITIES
     ============================================================ -->

<section class="pl-community-section"
         id="communities">

    <div class="pl-section-container">


        <div class="pl-section-heading centered">

            <span class="pl-section-label">
                ONE PLATFORM
            </span>


            <h2>

                One App.
                <strong>
                    Multiple Communities.
                </strong>

            </h2>


            <p>

                PeopleLink brings community life,
                family connections, professional
                opportunities and local support together
                in one digital ecosystem.

            </p>

        </div>


        <div class="pl-community-strip">


            <div class="pl-community-item">

                <i class="bi bi-people-fill"></i>

                <span>
                    Communities
                </span>

            </div>


            <div class="pl-community-item">

                <i class="bi bi-house-heart-fill"></i>

                <span>
                    Families
                </span>

            </div>


            <div class="pl-community-item">

                <i class="bi bi-heart-fill"></i>

                <span>
                    Matrimony
                </span>

            </div>


            <div class="pl-community-item">

                <i class="bi bi-briefcase-fill"></i>

                <span>
                    Careers
                </span>

            </div>


            <div class="pl-community-item">

                <i class="bi bi-shop"></i>

                <span>
                    Businesses
                </span>

            </div>


            <div class="pl-community-item">

                <i class="bi bi-megaphone-fill"></i>

                <span>
                    Updates
                </span>

            </div>


        </div>


    </div>

</section>


<!-- ============================================================
     FEATURES
     ============================================================ -->

<section class="pl-features-section"
         id="features">

    <div class="pl-section-container">


        <div class="pl-section-heading centered">

            <span class="pl-section-label">
                WHAT'S COMING
            </span>


            <h2>

                Everything Your
                <strong>
                    Community Needs
                </strong>

            </h2>


            <p>

                Designed to connect people,
                create opportunities and strengthen
                community networks.

            </p>

        </div>


        <div class="pl-feature-grid">


            <div class="pl-feature">

                <div class="pl-feature-icon red">

                    <i class="bi bi-heart-fill"></i>

                </div>

                <h3>
                    Matrimony
                </h3>

                <p>
                    Discover meaningful connections
                    within your community.
                </p>

            </div>


            <div class="pl-feature">

                <div class="pl-feature-icon blue">

                    <i class="bi bi-diagram-3-fill"></i>

                </div>

                <h3>
                    Family Tree
                </h3>

                <p>
                    Build and preserve your family
                    connections digitally.
                </p>

            </div>


            <div class="pl-feature">

                <div class="pl-feature-icon green">

                    <i class="bi bi-briefcase-fill"></i>

                </div>

                <h3>
                    Jobs &amp; Careers
                </h3>

                <p>
                    Find jobs, share opportunities
                    and grow professionally.
                </p>

            </div>


            <div class="pl-feature">

                <div class="pl-feature-icon purple">

                    <i class="bi bi-building-fill"></i>

                </div>

                <h3>
                    Professionals &amp; Businesses
                </h3>

                <p>
                    Discover professionals and
                    businesses within your network.
                </p>

            </div>


            <div class="pl-feature">

                <div class="pl-feature-icon orange">

                    <i class="bi bi-house-fill"></i>

                </div>

                <h3>
                    Property &amp; Marketplace
                </h3>

                <p>
                    Explore local property,
                    products and listings.
                </p>

            </div>


            <div class="pl-feature">

                <div class="pl-feature-icon blue">

                    <i class="bi bi-calendar-event-fill"></i>

                </div>

                <h3>
                    Events &amp; Advertisements
                </h3>

                <p>
                    Discover events, announcements
                    and promotions.
                </p>

            </div>


            <div class="pl-feature">

                <div class="pl-feature-icon green">

                    <i class="bi bi-geo-alt-fill"></i>

                </div>

                <h3>
                    Near Me
                </h3>

                <p>
                    Find useful services and
                    businesses around you.
                </p>

            </div>


            <div class="pl-feature">

                <div class="pl-feature-icon red">

                    <i class="bi bi-shield-plus"></i>

                </div>

                <h3>
                    Education &amp; Emergency Support
                </h3>

                <p>
                    Access useful resources and
                    community support networks.
                </p>

            </div>


            <div class="pl-feature">

                <div class="pl-feature-icon purple">

                    <i class="bi bi-person-badge-fill"></i>

                </div>

                <h3>
                    Community Leadership
                </h3>

                <p>
                    Connect with community leaders
                    and representatives.
                </p>

            </div>


            <div class="pl-feature">

                <div class="pl-feature-icon orange">

                    <i class="bi bi-megaphone-fill"></i>

                </div>

                <h3>
                    Community Updates
                </h3>

                <p>
                    Stay informed about important
                    community activities.
                </p>

            </div>


        </div>

    </div>

</section>


<!-- ============================================================
     DIGITAL IDENTITY
     ============================================================ -->

<section class="pl-identity-section">

    <div class="pl-section-container">


        <div class="pl-identity-box">


            <div class="pl-identity-content">


                <span class="pl-section-label">
                    YOUR DIGITAL IDENTITY
                </span>


                <h2>

                    Your Community.
                    <strong>
                        Your Digital Identity.
                    </strong>

                </h2>


                <p>

                    PeopleLink is designed to give
                    members, families, professionals
                    and businesses a connected digital
                    presence inside their community network.

                </p>


                <div class="pl-identity-tags">


                    <span>
                        <i class="bi bi-person-fill"></i>
                        Members
                    </span>


                    <span>
                        <i class="bi bi-people-fill"></i>
                        Families
                    </span>


                    <span>
                        <i class="bi bi-heart-fill"></i>
                        Matrimony
                    </span>


                    <span>
                        <i class="bi bi-briefcase-fill"></i>
                        Jobs
                    </span>


                    <span>
                        <i class="bi bi-person-badge-fill"></i>
                        Professionals
                    </span>


                    <span>
                        <i class="bi bi-award-fill"></i>
                        Leadership
                    </span>


                    <span>
                        <i class="bi bi-calendar-event-fill"></i>
                        Events
                    </span>


                    <span>
                        <i class="bi bi-shop"></i>
                        Marketplace
                    </span>


                    <span>
                        <i class="bi bi-life-preserver"></i>
                        Support Network
                    </span>


                </div>


            </div>


            <div class="pl-identity-visual">


                <div class="pl-identity-circle">


                    <div class="pl-identity-node node-1">

                        <i class="bi bi-people-fill"></i>

                    </div>


                    <div class="pl-identity-node node-2">

                        <i class="bi bi-briefcase-fill"></i>

                    </div>


                    <div class="pl-identity-node node-3">

                        <i class="bi bi-heart-fill"></i>

                    </div>


                    <div class="pl-identity-node node-4">

                        <i class="bi bi-calendar-event-fill"></i>

                    </div>


                    <div class="pl-identity-center">

                        <i class="bi bi-people-fill"></i>

                        <span>
                            PeopleLink
                        </span>

                    </div>


                </div>


            </div>


        </div>


    </div>

</section>


<!-- ============================================================
     APP SECTION
     ============================================================ -->

<section class="pl-app-section"
         id="app">

    <div class="pl-section-container">


        <div class="pl-app-box">


            <div class="pl-app-content">


                <span class="pl-section-label">
                    MOBILE APP
                </span>


                <h2>

                    PeopleLink is
                    <strong>
                        Coming to Mobile
                    </strong>

                </h2>


                <p>

                    Take your community with you.
                    The PeopleLink mobile experience
                    is being developed for Android and iOS.

                </p>


                <div class="pl-app-features">

                    <span>

                        <i class="bi bi-check-circle-fill"></i>

                        Android App

                    </span>


                    <span>

                        <i class="bi bi-check-circle-fill"></i>

                        iOS App

                    </span>


                    <span>

                        <i class="bi bi-check-circle-fill"></i>

                        Secure Community Network

                    </span>

                </div>


                <div class="pl-store-buttons">


                    <div class="pl-store-button">

                        <i class="bi bi-google-play"></i>

                        <span>

                            <small>
                                COMING SOON ON
                            </small>

                            <strong>
                                Google Play
                            </strong>

                        </span>

                    </div>


                    <div class="pl-store-button">

                        <i class="bi bi-apple"></i>

                        <span>

                            <small>
                                COMING SOON ON
                            </small>

                            <strong>
                                App Store
                            </strong>

                        </span>

                    </div>


                </div>


            </div>


            <div class="pl-qr-area">


                <div class="pl-qr-card">


                    <div class="pl-qr-placeholder">

                        <div class="pl-qr-pattern">

                            <span></span>
                            <span></span>
                            <span></span>

                            <span></span>
                            <span></span>
                            <span></span>

                            <span></span>
                            <span></span>
                            <span></span>

                        </div>

                    </div>


                    <strong>
                        Scan to stay connected
                    </strong>


                    <small>
                        App download coming soon
                    </small>


                </div>


            </div>


        </div>


    </div>

</section>


<!-- ============================================================
     FINAL CTA
     ============================================================ -->

<section class="pl-final-section"
         id="contact">

    <div class="pl-final-container">


        <div class="pl-final-logo">

            <span>

                <i class="bi bi-people-fill"></i>

            </span>

            PEOPLELINK

        </div>


        <h2>

            Building Stronger Communities
            <strong>
                Through Technology.
            </strong>

        </h2>


        <p class="pl-final-tagline">

            CONNECT • DISCOVER • BELONG

        </p>


        <p class="pl-launch-text">

            Something powerful is coming soon.

        </p>


        <a href="#home"
           class="pl-btn pl-btn-primary">

            <i class="bi bi-arrow-up"></i>

            Back to Top

        </a>


    </div>

</section>


</main>


<!-- ============================================================
     FOOTER
     ============================================================ -->

<footer class="pl-footer">


    <div class="pl-footer-main">


        <!-- BRAND -->

        <div class="pl-footer-brand">

            <a href="#home" class="pl-footer-brand-text">
                <span class="pl-footer-brand-icon">
                    <i class="bi bi-people-fill"></i>
                </span>
                <span class="pl-footer-brand-name">PeopleLink</span>
            </a>
<p class="pl-footer-description">

                One platform connecting communities,
                families, professionals, businesses
                and opportunities.

            </p>


            <div class="pl-social">


                <a href="#"
                   aria-label="Facebook">

                    <i class="bi bi-facebook"></i>

                </a>


                <a href="#"
                   aria-label="Instagram">

                    <i class="bi bi-instagram"></i>

                </a>


                <a href="#"
                   aria-label="LinkedIn">

                    <i class="bi bi-linkedin"></i>

                </a>


                <a href="#"
                   aria-label="YouTube">

                    <i class="bi bi-youtube"></i>

                </a>


            </div>


        </div>


        <!-- PEOPLELINK -->

        <div class="pl-footer-column">


            <h3>
                PeopleLink
            </h3>


            <a href="#home">

                <i class="bi bi-chevron-right"></i>

                Home

            </a>


            <a href="#communities">

                <i class="bi bi-chevron-right"></i>

                Communities

            </a>


            <a href="#features">

                <i class="bi bi-chevron-right"></i>

                Features

            </a>


            <a href="#app">

                <i class="bi bi-chevron-right"></i>

                Mobile App

            </a>


        </div>


        <!-- SERVICES -->

        <div class="pl-footer-column">


            <h3>
                Services
            </h3>


            <a href="#features">

                <i class="bi bi-chevron-right"></i>

                Matrimony

            </a>


            <a href="#features">

                <i class="bi bi-chevron-right"></i>

                Jobs &amp; Careers

            </a>


            <a href="#features">

                <i class="bi bi-chevron-right"></i>

                Businesses

            </a>


            <a href="#features">

                <i class="bi bi-chevron-right"></i>

                Marketplace

            </a>


        </div>


        <!-- CONTACT -->

        <div class="pl-footer-column">


            <h3>
                Get In Touch
            </h3>


            <div class="pl-contact-item">


                <i class="bi bi-envelope-fill"></i>


                <span>

                    <small>
                        Email
                    </small>

                    <strong>
                        info@peoplelink.in
                    </strong>

                </span>


            </div>


            <div class="pl-contact-item">


                <i class="bi bi-phone-fill"></i>


                <span>

                    <small>
                        Phone
                    </small>

                    <strong>
                        Coming Soon
                    </strong>

                </span>


            </div>


            <div class="pl-contact-item">


                <i class="bi bi-globe2"></i>


                <span>

                    <small>
                        Website
                    </small>

                    <strong>
                        peoplelink.in
                    </strong>

                </span>


            </div>


        </div>


    </div>


    <!-- FOOTER BOTTOM -->

    <div class="pl-footer-bottom">


        <div class="pl-footer-bottom-inner">


            <p>

                &copy;
                <?php echo date("Y"); ?>

                <strong>
                    PeopleLink
                </strong>.

                All Rights Reserved.

            </p>


            <div class="pl-footer-links">

                <a href="#">
                    Privacy Policy
                </a>

                <a href="#">
                    Terms &amp; Conditions
                </a>

            </div>


        </div>


    </div>


    <!-- FLOATING BUTTONS -->

    <div class="pl-floating-actions">


        <a
            href="tel:+910000000000"
            class="pl-call"
            aria-label="Call PeopleLink">

            <i class="bi bi-telephone-fill"></i>

        </a>


        <a
            href="https://wa.me/910000000000"
            target="_blank"
            rel="noopener"
            class="pl-whatsapp"
            aria-label="WhatsApp PeopleLink">

            <i class="bi bi-whatsapp"></i>

        </a>


    </div>


</footer>


</div>


<script>

/* ============================================================
   PEOPLELINK COMING SOON JAVASCRIPT
   ============================================================ */

document.addEventListener(
    "DOMContentLoaded",
    function () {


        /* ==========================================
           MOBILE MENU
           ========================================== */

        const menuButton =
            document.getElementById(
                "plMenuButton"
            );


        const mobileNav =
            document.getElementById(
                "plMobileNav"
            );


        if (
            menuButton &&
            mobileNav
        ) {


            menuButton.addEventListener(
                "click",
                function () {


                    mobileNav.classList.toggle(
                        "open"
                    );


                    const icon =
                        menuButton.querySelector(
                            "i"
                        );


                    if (
                        mobileNav.classList.contains(
                            "open"
                        )
                    ) {

                        icon.classList.remove(
                            "bi-list"
                        );

                        icon.classList.add(
                            "bi-x-lg"
                        );

                    } else {

                        icon.classList.remove(
                            "bi-x-lg"
                        );

                        icon.classList.add(
                            "bi-list"
                        );

                    }

                }
            );


            /* Close menu after clicking */

            mobileNav
                .querySelectorAll("a")
                .forEach(
                    function (link) {


                        link.addEventListener(
                            "click",
                            function () {


                                mobileNav.classList.remove(
                                    "open"
                                );


                                const icon =
                                    menuButton.querySelector(
                                        "i"
                                    );


                                icon.classList.remove(
                                    "bi-x-lg"
                                );


                                icon.classList.add(
                                    "bi-list"
                                );

                            }
                        );

                    }
                );

        }


        /* ==========================================
           SMOOTH SCROLL
           ========================================== */

        document
            .querySelectorAll(
                '.pl-coming-page-wrap a[href^="#"]'
            )
            .forEach(
                function (link) {


                    link.addEventListener(
                        "click",
                        function (event) {


                            const id =
                                this.getAttribute(
                                    "href"
                                );


                            if (
                                !id ||
                                id === "#"
                            ) {
                                return;
                            }


                            const target =
                                document.querySelector(
                                    id
                                );


                            if (!target) {
                                return;
                            }


                            event.preventDefault();


                            const header =
                                document.querySelector(
                                    ".pl-header"
                                );


                            const headerHeight =
                                header
                                    ? header.offsetHeight
                                    : 0;


                            const targetPosition =
                                target
                                    .getBoundingClientRect()
                                    .top +
                                window.pageYOffset -
                                headerHeight;


                            window.scrollTo({

                                top:
                                    targetPosition,

                                behavior:
                                    "smooth"

                            });

                        }
                    );

                }
            );


        /* ==========================================
           ACTIVE MENU
           ========================================== */

        const sections =
            document.querySelectorAll(
                ".pl-main section[id]"
            );


        const navLinks =
            document.querySelectorAll(
                ".pl-header-nav a"
            );


        function updateActiveMenu() {


            let current =
                "home";


            sections.forEach(
                function (section) {


                    const top =
                        section.offsetTop - 150;


                    if (
                        window.scrollY >= top
                    ) {

                        current =
                            section.id;

                    }

                }
            );


            navLinks.forEach(
                function (link) {


                    link.classList.remove(
                        "active"
                    );


                    const href =
                        link.getAttribute(
                            "href"
                        );


                    if (
                        href ===
                        "#" + current
                    ) {

                        link.classList.add(
                            "active"
                        );

                    }

                }
            );

        }


        window.addEventListener(
            "scroll",
            updateActiveMenu
        );


        updateActiveMenu();


        /* ==========================================
           SCROLL REVEAL
           ========================================== */

        const revealItems =
            document.querySelectorAll(
                ".pl-feature, " +
                ".pl-community-item, " +
                ".pl-identity-box, " +
                ".pl-app-box"
            );


        if (
            "IntersectionObserver"
            in window
        ) {


            const observer =
                new IntersectionObserver(
                    function (
                        entries,
                        observer
                    ) {


                        entries.forEach(
                            function (
                                entry
                            ) {


                                if (
                                    entry.isIntersecting
                                ) {


                                    entry.target.style.opacity =
                                        "1";


                                    entry.target.style.transform =
                                        "translateY(0)";


                                    observer.unobserve(
                                        entry.target
                                    );

                                }

                            }
                        );

                    },
                    {
                        threshold: .12
                    }
                );


            revealItems.forEach(
                function (item) {


                    item.style.opacity =
                        "0";


                    item.style.transform =
                        "translateY(18px)";


                    item.style.transition =
                        "opacity .6s ease, transform .6s ease";


                    observer.observe(
                        item
                    );

                }
            );

        }


    }
);

</script>

</body>
</html>