<?php

/*
|--------------------------------------------------------------------------
| PeopleLink Technologies Private Limited
| Corporate Website
|--------------------------------------------------------------------------
*/

$companyName = "PeopleLink Technologies Private Limited";

$companyEmail = "peoplelinktechnologies1@gmail.com";

$companyWebsite = "https://peoplelinktech.com";

$productWebsite = "https://digitalcommunity.in";

$logo = "images/logo.jpeg";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <!-- =========================================================
         BASIC META
    ========================================================== -->

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Cookie Policy explaining how PeopleLink may use cookies and similar technologies."
    >

    <meta
        name="keywords"
        content="PeopleLink Cookie Policy, cookies, privacy, consent, analytics, essential cookies, third-party services"
    >

    <meta
        name="author"
        content="PeopleLink Technologies Private Limited"
    >

    <title>
        Cookie Policy | PeopleLink Technologies
    </title>


    <!-- =========================================================
         BOOTSTRAP ICONS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <!-- =========================================================
         GOOGLE FONT
    ========================================================== -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >


    <!-- =========================================================
         COMPLETE CSS
    ========================================================== -->

    <style>

        /* =====================================================
           GLOBAL RESET
        ====================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            margin: 0;
            padding: 0;
            font-family: "Inter", sans-serif;
            color: #172033;
            background: #ffffff;
            overflow-x: hidden;
        }


        body,
        button,
        input,
        textarea,
        select {
            font-family: "Inter", sans-serif;
        }


        a {
            text-decoration: none !important;
        }


        img {
            max-width: 100%;
            height: auto;
        }


        /* =====================================================
           MAIN PAGE
        ====================================================== */

        .plt-page {
            width: 100%;
            overflow: hidden;
        }


        .plt-container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding-left: 24px;
            padding-right: 24px;
        }


        /* =====================================================
           HEADER
        ====================================================== */

        .plt-header {
            position: sticky;
            top: 0;
            z-index: 9999;
            width: 100%;
            background: rgba(255, 255, 255, 0.97);
            border-bottom: 1px solid #e6edf4;
            backdrop-filter: blur(15px);
            transition: 0.3s ease;
        }


        .plt-header-inner {
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }


        /* HEADER LOGO */

        .plt-logo {
            display: inline-flex;
            align-items: center;
            flex-shrink: 0;
        }


        .plt-logo img {
            width: 170px;
            height: auto;
            object-fit: contain;
        }


        /* DESKTOP NAVIGATION */

        .plt-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            margin-left: auto;
        }


        .plt-nav a {
            position: relative;
            color: #24384d;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none !important;
            transition: 0.25s ease;
        }


        .plt-nav a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -9px;
            width: 0;
            height: 2px;
            border-radius: 10px;
            background: #1261a8;
            transition: 0.25s ease;
        }


        .plt-nav a:hover {
            color: #1261a8;
        }


        .plt-nav a:hover::after {
            width: 100%;
        }


        /* HEADER CTA */

        .plt-header-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 46px;
            padding: 0 18px;
            border-radius: 9px;
            color: #ffffff !important;
            background: #1261a8;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none !important;
            transition: 0.25s ease;
        }


        .plt-header-cta:hover {
            color: #ffffff !important;
            background: #073b70;
            transform: translateY(-2px);
        }


        /* MOBILE MENU BUTTON */

        .plt-menu-btn {
            display: none;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            border: 1px solid #d6e1ec;
            border-radius: 9px;
            color: #073b70;
            background: #ffffff;
            font-size: 22px;
            cursor: pointer;
        }


        /* MOBILE NAV */

        .plt-mobile-nav {
            display: none;
            padding: 10px 0 18px;
            border-top: 1px solid #edf1f5;
        }


        .plt-mobile-nav.active {
            display: block;
        }


        .plt-mobile-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 4px;
            color: #24384d;
            border-bottom: 1px solid #edf1f5;
            font-size: 15px;
            font-weight: 700;
        }


        .plt-mobile-nav a i {
            width: 22px;
            color: #1261a8;
            font-size: 17px;
        }


        /* =====================================================
           HERO
        ====================================================== */

        .plt-hero {
            position: relative;
            min-height: 650px;
            display: flex;
            align-items: center;
            background:
                radial-gradient(
                    circle at 85% 20%,
                    rgba(22, 133, 200, 0.18),
                    transparent 34%
                ),
                linear-gradient(
                    135deg,
                    #f2f8ff 0%,
                    #ffffff 55%,
                    #eef7ff 100%
                );
        }


        .plt-hero-grid {
            display: grid;
            grid-template-columns: 1.12fr 0.88fr;
            align-items: center;
            gap: 65px;
        }


        .plt-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            color: #1261a8;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.4px;
        }


        .plt-hero-label::before {
            content: "";
            width: 32px;
            height: 2px;
            background: #42b72a;
        }


        .plt-hero h1 {
            margin-bottom: 24px;
            color: #073b70;
            font-size: clamp(42px, 5vw, 70px);
            line-height: 1.05;
            font-weight: 900;
            letter-spacing: -1.8px;
        }


        .plt-hero h1 span {
            display: block;
            color: #1261a8;
        }


        .plt-hero p {
            max-width: 730px;
            margin-bottom: 32px;
            color: #56677b;
            font-size: 18px;
            line-height: 1.8;
        }


        /* HERO BUTTONS */

        .plt-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 13px;
        }


        .plt-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 51px;
            padding: 0 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none !important;
            transition: 0.25s ease;
        }


        .plt-btn-primary {
            color: #ffffff !important;
            background: #1261a8;
            box-shadow: 0 12px 30px rgba(18, 97, 168, 0.22);
        }


        .plt-btn-primary:hover {
            color: #ffffff !important;
            background: #073b70;
            transform: translateY(-2px);
        }


        .plt-btn-outline {
            color: #1261a8 !important;
            background: #ffffff;
            border: 1px solid #cbd9e7;
        }


        .plt-btn-outline:hover {
            color: #ffffff !important;
            background: #1261a8;
            border-color: #1261a8;
        }


        /* HERO VISUAL */

        .plt-hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .plt-hero-card {
            width: 390px;
            height: 390px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(18, 97, 168, 0.12);
            border-radius: 38px;
            background: rgba(255, 255, 255, 0.88);
            box-shadow:
                0 35px 90px rgba(7, 59, 112, 0.14);
        }


        .plt-hero-icon {
            width: 150px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 35px;
            color: #ffffff;
            background:
                linear-gradient(
                    135deg,
                    #1261a8,
                    #1685c8
                );
            font-size: 68px;
            box-shadow:
                0 25px 55px rgba(18, 97, 168, 0.28);
        }


        /* =====================================================
           COMMON SECTION
        ====================================================== */

        .plt-section {
            padding: 85px 0;
        }


        .plt-section-heading {
            max-width: 780px;
            margin: 0 auto 50px;
            text-align: center;
        }


        .plt-section-label {
            display: inline-block;
            margin-bottom: 13px;
            color: #1261a8;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }


        .plt-section-heading h2 {
            margin-bottom: 17px;
            color: #073b70;
            font-size: clamp(32px, 4vw, 46px);
            line-height: 1.15;
            font-weight: 850;
            letter-spacing: -0.8px;
        }


        .plt-section-heading h2 span {
            color: #1261a8;
        }


        .plt-section-heading p {
            color: #64748b;
            font-size: 16px;
            line-height: 1.8;
        }


        /* =====================================================
           ABOUT
        ====================================================== */

        .plt-about {
            background: #ffffff;
        }


        .plt-about-content {
            max-width: 920px;
            margin: 0 auto;
            text-align: center;
        }


        .plt-about-description {
            margin-bottom: 38px;
            color: #5d6d80;
            font-size: 17px;
            line-height: 1.85;
        }


        .plt-about-points {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            text-align: left;
        }


        .plt-about-point {
            padding: 27px;
            border: 1px solid #e2eaf2;
            border-radius: 17px;
            background: #ffffff;
            box-shadow:
                0 10px 35px rgba(18, 59, 112, 0.06);
            transition: 0.3s ease;
        }


        .plt-about-point:hover {
            transform: translateY(-5px);
            box-shadow:
                0 18px 45px rgba(18, 59, 112, 0.10);
        }


        .plt-about-point-icon {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 17px;
            border-radius: 13px;
            color: #1261a8;
            background: #eaf4fc;
            font-size: 24px;
        }


        .plt-about-point h3 {
            margin-bottom: 9px;
            color: #073b70;
            font-size: 18px;
        }


        .plt-about-point p {
            color: #6b7888;
            font-size: 14px;
            line-height: 1.7;
        }


        /* =====================================================
           SERVICES
        ====================================================== */

        .plt-services {
            background: #f5f9fd;
        }


        .plt-services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }


        .plt-service-card {
            padding: 28px;
            border: 1px solid #e0e9f2;
            border-radius: 18px;
            background: #ffffff;
            transition: 0.3s ease;
        }


        .plt-service-card:hover {
            transform: translateY(-6px);
            border-color: #b9d3e9;
            box-shadow:
                0 18px 45px rgba(18, 59, 112, 0.10);
        }


        .plt-service-icon {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border-radius: 14px;
            color: #ffffff;
            background: #1261a8;
            font-size: 25px;
        }


        .plt-service-card h3 {
            margin-bottom: 12px;
            color: #073b70;
            font-size: 18px;
            line-height: 1.4;
        }


        .plt-service-card p {
            color: #687789;
            font-size: 14px;
            line-height: 1.75;
        }


        /* =====================================================
           SOLUTIONS
        ====================================================== */

        .plt-solution-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }


        .plt-solution-item {
            min-height: 72px;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px 20px;
            border: 1px solid #e2eaf2;
            border-radius: 13px;
            background: #ffffff;
            transition: 0.25s ease;
        }


        .plt-solution-item:hover {
            border-color: #b8d3e9;
            transform: translateY(-3px);
        }


        .plt-solution-item i {
            color: #1261a8;
            font-size: 22px;
        }


        .plt-solution-item span {
            color: #26394f;
            font-size: 14px;
            font-weight: 700;
        }


        /* =====================================================
           INDUSTRIES
        ====================================================== */

        .plt-industries {
            background: #073b70;
        }


        .plt-industries .plt-section-label {
            color: #67baf1;
        }


        .plt-industries .plt-section-heading h2 {
            color: #ffffff;
        }


        .plt-industries .plt-section-heading h2 span {
            color: #67baf1;
        }


        .plt-industries .plt-section-heading p {
            color: #c7d8e8;
        }


        .plt-industry-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }


        .plt-industry-card {
            display: flex;
            align-items: center;
            gap: 13px;
            min-height: 70px;
            padding: 18px;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 13px;
            background: rgba(255,255,255,.07);
            transition: 0.25s ease;
        }


        .plt-industry-card:hover {
            background: rgba(255,255,255,.12);
            transform: translateY(-3px);
        }


        .plt-industry-card i {
            color: #67baf1;
            font-size: 22px;
        }


        .plt-industry-card span {
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
        }


        /* =====================================================
           PRODUCT
        ====================================================== */

        .plt-product-box {
            position: relative;
            padding: 55px;
            overflow: hidden;
            border-radius: 25px;
            background:
                linear-gradient(
                    135deg,
                    #073b70,
                    #1261a8
                );
        }


        .plt-product-box::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            right: -100px;
            top: -100px;
            border-radius: 50%;
            background: rgba(255,255,255,.07);
        }


        .plt-product-content {
            position: relative;
            z-index: 2;
            max-width: 760px;
        }


        .plt-product-content .plt-section-label {
            color: #71c5f5;
        }


        .plt-product-content h2 {
            margin-bottom: 17px;
            color: #ffffff;
            font-size: 42px;
            line-height: 1.15;
        }


        .plt-product-content p {
            max-width: 720px;
            margin-bottom: 25px;
            color: #d2e3f1;
            font-size: 16px;
            line-height: 1.8;
        }


        .plt-product-content .plt-btn-primary {
            background: #ffffff;
            color: #073b70 !important;
            box-shadow: none;
        }


        .plt-product-content .plt-btn-primary:hover {
            background: #eaf5fc;
            color: #073b70 !important;
        }


        /* =====================================================
           TECHNOLOGY
        ====================================================== */

        .plt-tech-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }


        .plt-tech-item {
            min-height: 72px;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px;
            border: 1px solid #e4ebf2;
            border-radius: 13px;
            background: #f7fafc;
        }


        .plt-tech-item i {
            color: #1261a8;
            font-size: 23px;
        }


        .plt-tech-item span {
            color: #26394f;
            font-size: 14px;
            font-weight: 700;
        }


        /* =====================================================
           WHY PEOPLELINK
        ====================================================== */

        .plt-why {
            background: #f5f9fd;
        }


        .plt-why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }


        .plt-why-card {
            padding: 30px 20px;
            border: 1px solid #e2eaf2;
            border-radius: 17px;
            background: #ffffff;
            text-align: center;
            transition: 0.25s ease;
        }


        .plt-why-card:hover {
            transform: translateY(-5px);
            box-shadow:
                0 15px 40px rgba(18,59,112,.08);
        }


        .plt-why-card i {
            display: block;
            margin-bottom: 16px;
            color: #1261a8;
            font-size: 32px;
        }


        .plt-why-card h3 {
            color: #073b70;
            font-size: 17px;
        }


        /* =====================================================
           VISION / MISSION / VALUES
        ====================================================== */

        .plt-vmv-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }


        .plt-vmv-card {
            padding: 32px;
            border: 1px solid #e2eaf2;
            border-radius: 18px;
            background: #ffffff;
            text-align: center;
            box-shadow:
                0 10px 30px rgba(18,59,112,.05);
        }


        .plt-vmv-card-icon {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            border-radius: 15px;
            color: #ffffff;
            background: #1261a8;
            font-size: 26px;
        }


        .plt-vmv-card h3 {
            margin-bottom: 13px;
            color: #073b70;
            font-size: 20px;
        }


        .plt-vmv-card p {
            color: #687789;
            font-size: 14px;
            line-height: 1.8;
        }


        /* =====================================================
           CAREERS
        ====================================================== */

        .plt-careers {
            background: #f5f9fd;
        }


        .plt-careers-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 55px;
            align-items: center;
            padding: 55px;
            border-radius: 25px;
            background:
                linear-gradient(
                    135deg,
                    #073b70,
                    #1261a8
                );
        }


        .plt-careers-box .plt-section-label {
            color: #71c5f5;
        }


        .plt-careers-box h2 {
            margin-bottom: 20px;
            color: #ffffff;
            font-size: 42px;
            line-height: 1.15;
        }


        .plt-careers-box h2 span {
            color: #71c5f5;
        }


        .plt-careers-box p {
            margin-bottom: 12px;
            color: #d4e4f1;
            font-size: 15px;
            line-height: 1.8;
        }


        .plt-career-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }


        .plt-career-list span {
            min-height: 48px;
            display: flex;
            align-items: center;
            padding: 12px 14px;
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 10px;
            color: #ffffff;
            background: rgba(255,255,255,.07);
            font-size: 13px;
            font-weight: 600;
        }


        /* =====================================================
           CONTACT
        ====================================================== */

        .plt-contact {
            background: #ffffff;
        }


        .plt-contact-grid {
            display: grid;
            grid-template-columns: 1fr .8fr;
            gap: 55px;
            align-items: center;
        }


        .plt-contact-content h2 {
            margin-bottom: 20px;
            color: #073b70;
            font-size: 44px;
            line-height: 1.15;
        }


        .plt-contact-content h2 span {
            color: #1261a8;
        }


        .plt-contact-content p {
            max-width: 700px;
            margin-bottom: 12px;
            color: #687789;
            font-size: 16px;
            line-height: 1.8;
        }


        .plt-contact-card {
            padding: 35px;
            border: 1px solid #e1eaf2;
            border-radius: 20px;
            background: #f5f9fd;
        }


        .plt-contact-card h3 {
            margin-bottom: 25px;
            color: #073b70;
            font-size: 21px;
            line-height: 1.4;
        }


        .plt-contact-item {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 18px;
        }


        .plt-contact-item i {
            color: #1261a8;
            font-size: 21px;
        }


        .plt-contact-item a {
            color: #33475b;
            font-size: 14px;
            font-weight: 600;
            word-break: break-word;
        }


        .plt-contact-tagline {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #dce6f0;
            color: #1261a8;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.6;
        }


        /* =====================================================
           PREMIUM FOOTER
        ====================================================== */

        .plt-footer {
            position: relative;
            padding: 70px 0 0;
            overflow: hidden;
            color: #d5e1ec;
            background:
                linear-gradient(
                    135deg,
                    #041a31 0%,
                    #073b70 55%,
                    #062c52 100%
                );
        }


        /* FOOTER DECORATION */

        .plt-footer::before {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            top: -220px;
            right: -120px;
            border-radius: 50%;
            background: rgba(22, 133, 200, 0.12);
        }


        .plt-footer::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            bottom: -180px;
            left: -120px;
            border-radius: 50%;
            background: rgba(66, 183, 42, 0.08);
        }


        .plt-footer-inner {
            position: relative;
            z-index: 2;
        }


        /* FOOTER BRAND */

        .plt-footer-brand {
            max-width: 520px;
            margin-bottom: 50px;
        }


        .plt-footer-company-name {
            margin-bottom: 18px;
            color: #ffffff;
            font-size: 31px;
            line-height: 1.25;
            font-weight: 900;
            letter-spacing: -0.5px;
        }


        .plt-footer-company-name span {
            display: block;
            color: #67baf1;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: .3px;
        }


        .plt-footer-description {
            max-width: 500px;
            color: #b5c7d8;
            font-size: 15px;
            line-height: 1.85;
        }


        /* FOOTER MAIN GRID */

        .plt-footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1.1fr;
            gap: 45px;
            padding-bottom: 50px;
        }


        .plt-footer-column h3 {
            position: relative;
            margin-bottom: 23px;
            padding-bottom: 12px;
            color: #ffffff;
            font-size: 17px;
            font-weight: 800;
        }


        .plt-footer-column h3::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 34px;
            height: 2px;
            border-radius: 10px;
            background: #42b72a;
        }


        .plt-footer-links {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }


        .plt-footer-links a {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #b5c7d8;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none !important;
            transition: 0.25s ease;
        }


        .plt-footer-links a i {
            color: #67baf1;
            font-size: 13px;
        }


        .plt-footer-links a:hover {
            padding-left: 4px;
            color: #ffffff;
        }


        /* FOOTER CONTACT */

        .plt-footer-contact {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }


        .plt-footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 13px;
        }


        .plt-footer-contact-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 11px;
            color: #67baf1;
            background: rgba(255,255,255,.06);
            font-size: 18px;
        }


        .plt-footer-contact-content span {
            display: block;
            margin-bottom: 4px;
            color: #7f9ab2;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }


        .plt-footer-contact-content a,
        .plt-footer-contact-content p {
            margin: 0;
            color: #dbe7f0;
            font-size: 14px;
            line-height: 1.6;
            font-weight: 600;
            word-break: break-word;
        }


        .plt-footer-contact-content a:hover {
            color: #67baf1;
        }


        /* FOOTER SOCIAL AREA */

        .plt-footer-social-area {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            padding: 25px 0;
            border-top: 1px solid rgba(255,255,255,.10);
        }


        .plt-footer-social-text {
            color: #9db3c7;
            font-size: 14px;
            font-weight: 600;
        }


        .plt-footer-social {
            display: flex;
            align-items: center;
            gap: 10px;
        }


        .plt-footer-social a {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 11px;
            color: #ffffff;
            background: rgba(255,255,255,.05);
            font-size: 18px;
            text-decoration: none !important;
            transition: 0.25s ease;
        }


        .plt-footer-social a:hover {
            color: #ffffff;
            background: #1261a8;
            border-color: #1261a8;
            transform: translateY(-3px);
        }


        /* COPYRIGHT */

        .plt-footer-bottom {
            min-height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border-top: 1px solid rgba(255,255,255,.10);
        }


        .plt-footer-bottom p {
            margin: 0;
            color: #8fa6ba;
            font-size: 13px;
            line-height: 1.6;
        }


        .plt-footer-bottom-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }


        .plt-footer-bottom-links a {
            color: #9db3c7;
            font-size: 13px;
            font-weight: 600;
        }


        .plt-footer-bottom-links a:hover {
            color: #ffffff;
        }




        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1100px) {

            .plt-nav,
            .plt-header-cta {
                display: none;
            }


            .plt-menu-btn {
                display: flex;
            }


            .plt-hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }


            .plt-hero p {
                margin-left: auto;
                margin-right: auto;
            }


            .plt-hero-actions {
                justify-content: center;
            }


            .plt-services-grid {
                grid-template-columns: repeat(2, 1fr);
            }


            .plt-industry-grid {
                grid-template-columns: repeat(2, 1fr);
            }


            .plt-footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }


        @media (max-width: 800px) {

            .plt-section {
                padding: 65px 0;
            }


            .plt-about-points,
            .plt-solution-grid,
            .plt-tech-grid,
            .plt-why-grid,
            .plt-vmv-grid {
                grid-template-columns: 1fr;
            }


            .plt-careers-box,
            .plt-contact-grid {
                grid-template-columns: 1fr;
            }


            .plt-careers-box {
                padding: 38px 28px;
            }


            .plt-contact-content h2,
            .plt-careers-box h2 {
                font-size: 35px;
            }


            .plt-product-box {
                padding: 40px 28px;
            }

        }


        @media (max-width: 600px) {

            .plt-container {
                padding-left: 16px;
                padding-right: 16px;
            }


            .plt-header-inner {
                min-height: 70px;
            }


            .plt-logo img {
                width: 145px;
            }


            .plt-hero {
                min-height: auto;
                padding: 75px 0;
            }


            .plt-hero h1 {
                font-size: 40px;
                letter-spacing: -1px;
            }


            .plt-hero p {
                font-size: 15px;
            }


            .plt-hero-card {
                width: 100%;
                height: 300px;
            }


            .plt-hero-icon {
                width: 115px;
                height: 115px;
                font-size: 50px;
            }


            .plt-services-grid,
            .plt-industry-grid {
                grid-template-columns: 1fr;
            }


            .plt-career-list {
                grid-template-columns: 1fr;
            }


            /* FOOTER MOBILE */

            .plt-footer {
                padding-top: 55px;
            }


            .plt-footer-company-name {
                font-size: 26px;
            }


            .plt-footer-company-name span {
                font-size: 15px;
            }


            .plt-footer-description {
                font-size: 14px;
            }


            .plt-footer-grid {
                grid-template-columns: 1fr;
                gap: 35px;
            }


            .plt-footer-column h3 {
                font-size: 18px;
            }


            .plt-footer-links a {
                font-size: 15px;
            }


            .plt-footer-social-area {
                flex-direction: column;
                align-items: flex-start;
            }


            .plt-footer-bottom {
                min-height: auto;
                padding: 22px 0;
                flex-direction: column;
                align-items: flex-start;
            }


            .plt-footer-bottom-links {
                flex-wrap: wrap;
                gap: 12px 20px;
            }

        }




    </style>


<style>
/* =========================================================
   COOKIE POLICY PAGE
========================================================= */

.plt-cookie-page {
    background: #f5f9fd;
    color: #172033;
}

.plt-cookie-hero {
    position: relative;
    overflow: hidden;
    padding: 92px 0 82px;
    background:
        radial-gradient(circle at 88% 18%, rgba(22,133,200,.20), transparent 31%),
        linear-gradient(135deg, #073b70 0%, #1261a8 60%, #1685c8 100%);
}

.plt-cookie-hero::before,
.plt-cookie-hero::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
}

.plt-cookie-hero::before {
    width: 390px;
    height: 390px;
    right: -145px;
    top: -185px;
}

.plt-cookie-hero::after {
    width: 230px;
    height: 230px;
    left: -110px;
    bottom: -140px;
}

.plt-cookie-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 940px;
}

.plt-cookie-badge {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 18px;
    padding: 8px 14px;
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 999px;
    color: #ffffff;
    background: rgba(255,255,255,.09);
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.2px;
}

.plt-cookie-hero h1 {
    margin-bottom: 18px;
    color: #ffffff;
    font-size: clamp(40px, 5vw, 64px);
    line-height: 1.08;
    font-weight: 900;
    letter-spacing: -1.5px;
}

.plt-cookie-hero p {
    max-width: 820px;
    margin: 0;
    color: #dcecf8;
    font-size: 17px;
    line-height: 1.8;
}

.plt-cookie-layout {
    display: grid;
    grid-template-columns: 265px minmax(0, 1fr);
    gap: 30px;
    align-items: start;
    padding-top: 65px;
    padding-bottom: 75px;
}

.plt-cookie-sidebar {
    position: sticky;
    top: 105px;
    padding: 22px;
    border: 1px solid #dfe8f1;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 12px 35px rgba(18,59,112,.07);
}

.plt-cookie-sidebar-title {
    margin-bottom: 14px;
    color: #073b70;
    font-size: 13px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.plt-cookie-sidebar-links {
    display: flex;
    flex-direction: column;
}

.plt-cookie-sidebar a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 10px;
    margin-bottom: 3px;
    border-radius: 9px;
    color: #526377;
    font-size: 13px;
    font-weight: 700;
    line-height: 1.45;
    transition: .2s ease;
}

.plt-cookie-sidebar a:hover,
.plt-cookie-sidebar a.active {
    color: #1261a8;
    background: #edf6fd;
}

.plt-cookie-sidebar a i {
    color: #1261a8;
    font-size: 15px;
}

.plt-cookie-content {
    min-width: 0;
}

.plt-cookie-card {
    margin-bottom: 20px;
    padding: 30px 32px;
    border: 1px solid #dfe8f1;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 9px 28px rgba(18,59,112,.05);
}

.plt-cookie-card:last-child {
    margin-bottom: 0;
}

.plt-cookie-card h2 {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 15px;
    color: #073b70;
    font-size: 22px;
    line-height: 1.35;
    font-weight: 850;
}

.plt-cookie-card h2 i {
    flex: 0 0 auto;
    color: #1261a8;
    font-size: 23px;
}

.plt-cookie-card p {
    margin-bottom: 13px;
    color: #59697b;
    font-size: 15px;
    line-height: 1.8;
}

.plt-cookie-card p:last-child {
    margin-bottom: 0;
}

.plt-cookie-card ul {
    margin: 8px 0 0;
    padding-left: 22px;
}

.plt-cookie-card li {
    margin-bottom: 9px;
    padding-left: 4px;
    color: #59697b;
    font-size: 15px;
    line-height: 1.7;
}

.plt-cookie-card li:last-child {
    margin-bottom: 0;
}

.plt-cookie-card strong {
    color: #263b53;
}

.plt-cookie-type {
    margin-top: 14px;
    padding: 18px;
    border: 1px solid #e0eaf2;
    border-radius: 13px;
    background: #f8fbfd;
}

.plt-cookie-type:first-of-type {
    margin-top: 0;
}

.plt-cookie-type h3 {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 7px;
    color: #073b70;
    font-size: 16px;
}

.plt-cookie-type h3 i {
    color: #1261a8;
}

.plt-cookie-type p {
    margin: 0;
    font-size: 14px;
}

.plt-cookie-options {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-top: 18px;
}

.plt-cookie-option {
    padding: 16px;
    border: 1px solid #dce8f2;
    border-radius: 12px;
    background: #ffffff;
    text-align: center;
    color: #263b53;
    font-size: 13px;
    font-weight: 800;
    line-height: 1.5;
}

.plt-cookie-option i {
    display: block;
    margin-bottom: 8px;
    color: #1261a8;
    font-size: 22px;
}

.plt-cookie-highlight {
    margin-top: 18px;
    padding: 17px 18px;
    border-left: 4px solid #1261a8;
    border-radius: 9px;
    background: #eef7fd;
    color: #536576;
    font-size: 14px;
    line-height: 1.7;
}

@media (max-width: 991px) {
    .plt-cookie-layout {
        grid-template-columns: 1fr;
    }

    .plt-cookie-sidebar {
        position: static;
    }

    .plt-cookie-sidebar-links {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 4px;
    }

    .plt-cookie-sidebar a {
        margin: 0;
    }
}

@media (max-width: 768px) {
    .plt-cookie-hero {
        padding: 65px 0 58px;
    }

    .plt-cookie-hero h1 {
        font-size: 38px;
    }

    .plt-cookie-hero p {
        font-size: 15px;
    }

    .plt-cookie-layout {
        padding-top: 42px;
        padding-bottom: 55px;
    }

    .plt-cookie-sidebar-links {
        grid-template-columns: 1fr;
    }

    .plt-cookie-card {
        padding: 24px 20px;
        border-radius: 15px;
    }

    .plt-cookie-card h2 {
        font-size: 20px;
    }

    .plt-cookie-card p,
    .plt-cookie-card li {
        font-size: 14px;
    }

    .plt-cookie-options {
        grid-template-columns: 1fr;
    }
}
</style>

</head>


<body>


<div class="plt-page">


    <!-- =========================================================
         HEADER
    ========================================================== -->

    <header class="plt-header">

        <div class="plt-container">

            <div class="plt-header-inner">


                <!-- LOGO -->

                <a
                    href="#home"
                    class="plt-logo"
                >

                    <img
                        src="<?php echo htmlspecialchars($logo); ?>"
                        alt="<?php echo htmlspecialchars($companyName); ?>"
                    >

                </a>


                <!-- DESKTOP NAVIGATION -->

                <nav class="plt-nav">

                    <a href="#home">
                        Home
                    </a>

                    <a href="#about">
                        About
                    </a>

                    <a href="#services">
                        Services
                    </a>

                    <a href="#solutions">
                        Solutions
                    </a>

                    <a href="#technology">
                        Technology
                    </a>

                    <a href="#careers">
                        Careers
                    </a>

                    <a href="#contact">
                        Contact
                    </a>

                </nav>


                <!-- HEADER CTA -->

                <a
                    href="#contact"
                    class="plt-header-cta"
                >

                    Let's Talk

                    <i class="bi bi-arrow-right"></i>

                </a>


                <!-- MOBILE BUTTON -->

                <button
                    type="button"
                    class="plt-menu-btn"
                    id="pltMenuBtn"
                    aria-label="Open Menu"
                >

                    <i class="bi bi-list"></i>

                </button>

            </div>


            <!-- MOBILE NAVIGATION -->

            <nav
                class="plt-mobile-nav"
                id="pltMobileNav"
            >

                <a href="#home">

                    <i class="bi bi-house"></i>

                    Home

                </a>


                <a href="#about">

                    <i class="bi bi-building"></i>

                    About

                </a>


                <a href="#services">

                    <i class="bi bi-grid"></i>

                    Services

                </a>


                <a href="#solutions">

                    <i class="bi bi-layers"></i>

                    Solutions

                </a>


                <a href="#technology">

                    <i class="bi bi-cpu"></i>

                    Technology

                </a>


                <a href="#careers">

                    <i class="bi bi-briefcase"></i>

                    Careers

                </a>


                <a href="#contact">

                    <i class="bi bi-envelope"></i>

                    Contact

                </a>

            </nav>

        </div>

    </header>


    <!-- =========================================================
         MAIN CONTENT
    ========================================================== -->

    
<main class="plt-cookie-page">

    <!-- =====================================================
         COOKIE POLICY HERO
    ====================================================== -->

    <section class="plt-cookie-hero">

        <div class="plt-container">

            <div class="plt-cookie-hero-inner">

                <div class="plt-cookie-badge">
                    <i class="bi bi-cookie"></i>
                    Privacy &amp; Technology
                </div>

                <h1>
                    Cookie Policy
                </h1>

                <p>
                    This policy explains how PeopleLink may use cookies and
                    similar technologies on its website and related digital
                    services.
                </p>

            </div>

        </div>

    </section>


    <!-- =====================================================
         COOKIE POLICY CONTENT
    ====================================================== -->

    <section>

        <div class="plt-container">

            <div class="plt-cookie-layout">

                <!-- SIDEBAR -->

                <aside class="plt-cookie-sidebar">

                    <div class="plt-cookie-sidebar-title">
                        Legal Information
                    </div>

                    <div class="plt-cookie-sidebar-links">

                        <a href="privacy-policy.php">
                            <i class="bi bi-shield-check"></i>
                            Privacy Policy
                        </a>

                        <a href="terms-conditions.php">
                            <i class="bi bi-file-earmark-text"></i>
                            Terms &amp; Conditions
                        </a>

                        <a href="refund-cancellation-policy.php">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Refund / Cancellation
                        </a>

                        <a href="community-guidelines.php">
                            <i class="bi bi-people"></i>
                            Community Guidelines
                        </a>

                        <a href="disclaimer.php">
                            <i class="bi bi-exclamation-triangle"></i>
                            Disclaimer
                        </a>

                        <a href="cookie-policy.php" class="active">
                            <i class="bi bi-cookie"></i>
                            Cookie Policy
                        </a>

                        <a href="account-deletion.php">
                            <i class="bi bi-person-x"></i>
                            Account Deletion
                        </a>

                        <a href="support-grievance.php">
                            <i class="bi bi-headset"></i>
                            Support / Grievance
                        </a>

                    </div>

                </aside>


                <!-- MAIN CONTENT -->

                <div class="plt-cookie-content">

                    <article class="plt-cookie-card">

                        <h2>
                            <i class="bi bi-question-circle"></i>
                            What Are Cookies?
                        </h2>

                        <p>
                            Cookies are small files stored on a user’s device
                            when visiting a website. They help the platform
                            remember preferences, improve performance and
                            support certain features.
                        </p>

                    </article>


                    <article class="plt-cookie-card">

                        <h2>
                            <i class="bi bi-gear"></i>
                            How PeopleLink May Use Cookies
                        </h2>

                        <p>
                            Cookies may be used for:
                        </p>

                        <ul>
                            <li>User login and session management</li>
                            <li>Remembering selected community</li>
                            <li>Saving user preferences</li>
                            <li>Improving website performance</li>
                            <li>Security and fraud prevention</li>
                            <li>Understanding general website usage</li>
                            <li>Supporting payment or third-party integrations</li>
                        </ul>

                    </article>


                    <article class="plt-cookie-card">

                        <h2>
                            <i class="bi bi-collection"></i>
                            Types of Cookies
                        </h2>

                        <div class="plt-cookie-type">

                            <h3>
                                <i class="bi bi-shield-lock"></i>
                                Essential Cookies
                            </h3>

                            <p>
                                Required for basic website functions such as
                                login, authentication and security.
                            </p>

                        </div>


                        <div class="plt-cookie-type">

                            <h3>
                                <i class="bi bi-sliders"></i>
                                Preference Cookies
                            </h3>

                            <p>
                                Used to remember settings such as selected
                                community, language or display preferences.
                            </p>

                        </div>


                        <div class="plt-cookie-type">

                            <h3>
                                <i class="bi bi-bar-chart"></i>
                                Analytics Cookies
                            </h3>

                            <p>
                                May be used to understand how users interact
                                with the website and improve usability.
                            </p>

                        </div>


                        <div class="plt-cookie-type">

                            <h3>
                                <i class="bi bi-box-arrow-up-right"></i>
                                Third-Party Cookies
                            </h3>

                            <p>
                                May be set by integrated services such as:
                            </p>

                            <ul>
                                <li>Payment gateways</li>
                                <li>Maps</li>
                                <li>Video / live-program platforms</li>
                                <li>Social media or external services</li>
                                <li>Analytics providers</li>
                            </ul>

                        </div>

                    </article>


                    <article class="plt-cookie-card">

                        <h2>
                            <i class="bi bi-check2-square"></i>
                            Cookie Consent
                        </h2>

                        <p>
                            Where required, users should be given the option to:
                        </p>

                        <div class="plt-cookie-options">

                            <div class="plt-cookie-option">
                                <i class="bi bi-check-circle"></i>
                                Accept All Cookies
                            </div>

                            <div class="plt-cookie-option">
                                <i class="bi bi-shield-check"></i>
                                Accept Essential Cookies Only
                            </div>

                            <div class="plt-cookie-option">
                                <i class="bi bi-sliders"></i>
                                Manage Cookie Preferences
                            </div>

                        </div>

                    </article>


                    <article class="plt-cookie-card">

                        <h2>
                            <i class="bi bi-toggles"></i>
                            Managing Cookies
                        </h2>

                        <p>
                            Users can manage or disable cookies through their
                            browser settings.
                        </p>

                        <p>
                            Disabling certain cookies may affect:
                        </p>

                        <ul>
                            <li>Login functionality</li>
                            <li>Saved preferences</li>
                            <li>Community selection</li>
                            <li>Payment flow</li>
                            <li>Other website features</li>
                        </ul>

                    </article>


                    <article class="plt-cookie-card">

                        <h2>
                            <i class="bi bi-diagram-3"></i>
                            Third-Party Services
                        </h2>

                        <p>
                            Third-party providers may use their own cookies or
                            tracking technologies according to their respective
                            policies.
                        </p>

                        <div class="plt-cookie-highlight">
                            PeopleLink does not control all cookies placed by
                            external service providers.
                        </div>

                    </article>


                    <article class="plt-cookie-card">

                        <h2>
                            <i class="bi bi-shield-check"></i>
                            Data and Privacy
                        </h2>

                        <p>
                            Any personal information collected through cookies
                            should be handled according to the
                            <strong>PeopleLink Privacy Policy</strong>.
                        </p>

                        <div class="plt-cookie-highlight">
                            Please review the Privacy Policy for information
                            about how PeopleLink collects, uses, stores and
                            protects personal information.
                        </div>

                    </article>


                    <article class="plt-cookie-card">

                        <h2>
                            <i class="bi bi-arrow-repeat"></i>
                            Updates to Cookie Policy
                        </h2>

                        <p>
                            This policy may be updated if:
                        </p>

                        <ul>
                            <li>New technologies are introduced</li>
                            <li>Website functionality changes</li>
                            <li>New third-party integrations are added</li>
                            <li>Legal requirements change</li>
                        </ul>

                    </article>


                    <article class="plt-cookie-card">

                        <h2>
                            <i class="bi bi-headset"></i>
                            Contact
                        </h2>

                        <p>
                            For questions regarding cookies or privacy, users
                            can contact PeopleLink through the official
                            grievance or support channel.
                        </p>

                    </article>

                </div>

            </div>

        </div>

    </section>

</main>



    <!-- =========================================================
         PREMIUM FOOTER
    ========================================================== -->

    <footer class="plt-footer">


        <div class="plt-container">

            <div class="plt-footer-inner">
 

                <!-- =================================================
                     FOOTER COLUMNS
                ================================================== -->

                <div class="plt-footer-grid">


                    <!-- COMPANY -->

                    <div class="plt-footer-column">

                        <h3>
                            Company
                        </h3>


                        <div class="plt-footer-links">

                            <a href="#home">

                                <i class="bi bi-chevron-right"></i>

                                Home

                            </a>


                            <a href="#about">

                                <i class="bi bi-chevron-right"></i>

                                About Us

                            </a>


                            <a href="#services">

                                <i class="bi bi-chevron-right"></i>

                                Our Services

                            </a>


                            <a href="#solutions">

                                <i class="bi bi-chevron-right"></i>

                                Our Solutions

                            </a>


                            <a href="#careers">

                                <i class="bi bi-chevron-right"></i>

                                Careers

                            </a>


                            <a href="#contact">

                                <i class="bi bi-chevron-right"></i>

                                Contact Us

                            </a>

                        </div>

                    </div>


                    <!-- SERVICES -->

                    <div class="plt-footer-column">

                        <h3>
                            Services
                        </h3>


                        <div class="plt-footer-links">

                            <a href="#services">

                                <i class="bi bi-chevron-right"></i>

                                Software Development

                            </a>


                            <a href="#services">

                                <i class="bi bi-chevron-right"></i>

                                Web & Mobile Apps

                            </a>


                            <a href="#services">

                                <i class="bi bi-chevron-right"></i>

                                Cloud Solutions

                            </a>


                            <a href="#services">

                                <i class="bi bi-chevron-right"></i>

                                AI & Automation

                            </a>


                            <a href="#services">

                                <i class="bi bi-chevron-right"></i>

                                Data & Analytics

                            </a>


                            <a href="#services">

                                <i class="bi bi-chevron-right"></i>

                                IT Consulting

                            </a>

                        </div>

                    </div>


                    <!-- TECHNOLOGY -->

                    <div class="plt-footer-column">

                        <h3>
                            Technology
                        </h3>


                        <div class="plt-footer-links">

                            <a href="#technology">

                                <i class="bi bi-chevron-right"></i>

                                Cloud Computing

                            </a>


                            <a href="#technology">

                                <i class="bi bi-chevron-right"></i>

                                Software Engineering

                            </a>


                            <a href="#technology">

                                <i class="bi bi-chevron-right"></i>

                                API Integration

                            </a>


                            <a href="#technology">

                                <i class="bi bi-chevron-right"></i>

                                Data Engineering

                            </a>


                            <a href="#technology">

                                <i class="bi bi-chevron-right"></i>

                                AI & Automation

                            </a>


                            <a href="#technology">

                                <i class="bi bi-chevron-right"></i>

                                DevOps & CI/CD

                            </a>

                        </div>

                    </div>


                    <!-- CONTACT -->

                    <div class="plt-footer-column">

                        <h3>
                            Get In Touch
                        </h3>


                        <div class="plt-footer-contact">


                            <div class="plt-footer-contact-item">

                                <div class="plt-footer-contact-icon">

                                    <i class="bi bi-envelope"></i>

                                </div>


                                <div class="plt-footer-contact-content">

                                    <span>
                                        Email
                                    </span>


                                    <a
                                        href="mailto:<?php echo htmlspecialchars($companyEmail); ?>"
                                    >

                                        <?php
                                        echo htmlspecialchars($companyEmail);
                                        ?>

                                    </a>

                                </div>

                            </div>


                            <div class="plt-footer-contact-item">

                                <div class="plt-footer-contact-icon">

                                    <i class="bi bi-globe2"></i>

                                </div>


                                <div class="plt-footer-contact-content">

                                    <span>
                                        Website
                                    </span>


                                    <a
                                        href="<?php echo htmlspecialchars($companyWebsite); ?>"
                                        target="_blank"
                                        rel="noopener"
                                    >

                                        peoplelinktech.com

                                    </a>

                                </div>

                            </div>


                            <div class="plt-footer-contact-item">

                                <div class="plt-footer-contact-icon">

                                    <i class="bi bi-box-arrow-up-right"></i>

                                </div>


                                <div class="plt-footer-contact-content">

                                    <span>
                                        Our Product
                                    </span>


                                    <a
                                        href="<?php echo htmlspecialchars($productWebsite); ?>"
                                        target="_blank"
                                        rel="noopener"
                                    >

                                        digitalcommunity.in

                                    </a>

                                </div>

                            </div>


                        </div>

                    </div>


                </div>


                <!-- =================================================
                     SOCIAL MEDIA
                ================================================== -->

                <div class="plt-footer-social-area">


                    <div class="plt-footer-social-text">

                        Connect With PeopleLink Technologies

                    </div>


                    <div class="plt-footer-social">


                        <a
                            href="#"
                            aria-label="LinkedIn"
                        >

                            <i class="bi bi-linkedin"></i>

                        </a>


                        <a
                            href="#"
                            aria-label="Facebook"
                        >

                            <i class="bi bi-facebook"></i>

                        </a>


                        <a
                            href="#"
                            aria-label="Instagram"
                        >

                            <i class="bi bi-instagram"></i>

                        </a>


                        <a
                            href="#"
                            aria-label="YouTube"
                        >

                            <i class="bi bi-youtube"></i>

                        </a>


                        <a
                            href="#"
                            aria-label="X"
                        >

                            <i class="bi bi-twitter-x"></i>

                        </a>


                    </div>


                </div>


                <!-- =================================================
                     FOOTER BOTTOM
                ================================================== -->

                <div class="plt-footer-bottom">


                    <p>

                        © 2026
                        <?php
                        echo htmlspecialchars($companyName);
                        ?>.
                        All Rights Reserved.

                    </p>


                    <div class="plt-footer-bottom-links">

                        <a href="#home">
                            Privacy Policy
                        </a>

                        <a href="#home">
                            Terms & Conditions
                        </a>

                    </div>


                </div>


            </div>

        </div>

    </footer>


</div>


<!-- =========================================================
     JAVASCRIPT
========================================================== -->

<script>


    /* =========================================================
       MOBILE MENU
    ========================================================== */

    const pltMenuBtn =
        document.getElementById("pltMenuBtn");


    const pltMobileNav =
        document.getElementById("pltMobileNav");


    if (
        pltMenuBtn &&
        pltMobileNav
    ) {

        pltMenuBtn.addEventListener(
            "click",
            function () {

                pltMobileNav.classList.toggle(
                    "active"
                );


                const icon =
                    pltMenuBtn.querySelector("i");


                if (
                    pltMobileNav.classList.contains(
                        "active"
                    )
                ) {

                    icon.className =
                        "bi bi-x-lg";

                } else {

                    icon.className =
                        "bi bi-list";

                }

            }
        );


        /* CLOSE MENU AFTER LINK CLICK */

        const pltMobileLinks =
            pltMobileNav.querySelectorAll("a");


        pltMobileLinks.forEach(
            function (link) {

                link.addEventListener(
                    "click",
                    function () {

                        pltMobileNav.classList.remove(
                            "active"
                        );


                        const icon =
                            pltMenuBtn.querySelector("i");


                        icon.className =
                            "bi bi-list";

                    }
                );

            }
        );

    }


    /* =========================================================
       HEADER SHADOW ON SCROLL
    ========================================================== */

    window.addEventListener(
        "scroll",
        function () {

            const header =
                document.querySelector(".plt-header");


            if (!header) {
                return;
            }


            if (window.scrollY > 20) {

                header.style.boxShadow =
                    "0 8px 30px rgba(18, 59, 112, 0.10)";

            } else {

                header.style.boxShadow =
                    "none";

            }

        }
    );


</script>


</body>

</html>