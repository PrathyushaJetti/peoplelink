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
        content="Disclaimer explaining the role and limitations of PeopleLink as a technology platform."
    >

    <meta
        name="keywords"
        content="PeopleLink Disclaimer, platform role, matrimony, jobs, marketplace, business directory, events, technical availability"
    >

    <meta
        name="author"
        content="PeopleLink Technologies Private Limited"
    >

    <title>
        Disclaimer | PeopleLink Technologies
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
   DISCLAIMER PAGE
========================================================= */

.plt-disclaimer-page {
    background: #f5f9fd;
    color: #172033;
}

.plt-disclaimer-hero {
    position: relative;
    overflow: hidden;
    padding: 92px 0 82px;
    background:
        radial-gradient(circle at 88% 18%, rgba(247,148,29,.18), transparent 31%),
        linear-gradient(135deg, #073b70 0%, #1261a8 60%, #1685c8 100%);
}

.plt-disclaimer-hero::before,
.plt-disclaimer-hero::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
}

.plt-disclaimer-hero::before {
    width: 390px;
    height: 390px;
    right: -145px;
    top: -185px;
}

.plt-disclaimer-hero::after {
    width: 230px;
    height: 230px;
    left: -110px;
    bottom: -140px;
}

.plt-disclaimer-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 940px;
}

.plt-disclaimer-badge {
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

.plt-disclaimer-hero h1 {
    margin-bottom: 18px;
    color: #ffffff;
    font-size: clamp(40px, 5vw, 64px);
    line-height: 1.08;
    font-weight: 900;
    letter-spacing: -1.5px;
}

.plt-disclaimer-hero p {
    max-width: 820px;
    margin: 0;
    color: #dcecf8;
    font-size: 17px;
    line-height: 1.8;
}

.plt-disclaimer-layout {
    display: grid;
    grid-template-columns: 265px minmax(0, 1fr);
    gap: 30px;
    align-items: start;
    padding-top: 65px;
    padding-bottom: 75px;
}

.plt-disclaimer-sidebar {
    position: sticky;
    top: 105px;
    padding: 22px;
    border: 1px solid #dfe8f1;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 12px 35px rgba(18,59,112,.07);
}

.plt-disclaimer-sidebar-title {
    margin-bottom: 14px;
    color: #073b70;
    font-size: 13px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.plt-disclaimer-sidebar-links {
    display: flex;
    flex-direction: column;
}

.plt-disclaimer-sidebar a {
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

.plt-disclaimer-sidebar a:hover,
.plt-disclaimer-sidebar a.active {
    color: #1261a8;
    background: #edf6fd;
}

.plt-disclaimer-sidebar a i {
    color: #1261a8;
    font-size: 15px;
}

.plt-disclaimer-content {
    min-width: 0;
}

.plt-disclaimer-card {
    margin-bottom: 20px;
    padding: 30px 32px;
    border: 1px solid #dfe8f1;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 9px 28px rgba(18,59,112,.05);
}

.plt-disclaimer-card:last-child {
    margin-bottom: 0;
}

.plt-disclaimer-card h2 {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 15px;
    color: #073b70;
    font-size: 22px;
    line-height: 1.35;
    font-weight: 850;
}

.plt-disclaimer-card h2 i {
    flex: 0 0 auto;
    color: #1261a8;
    font-size: 23px;
}

.plt-disclaimer-card p {
    margin-bottom: 13px;
    color: #59697b;
    font-size: 15px;
    line-height: 1.8;
}

.plt-disclaimer-card p:last-child {
    margin-bottom: 0;
}

.plt-disclaimer-card ul {
    margin: 8px 0 0;
    padding-left: 22px;
}

.plt-disclaimer-card li {
    margin-bottom: 9px;
    padding-left: 4px;
    color: #59697b;
    font-size: 15px;
    line-height: 1.7;
}

.plt-disclaimer-card li:last-child {
    margin-bottom: 0;
}

.plt-disclaimer-card strong {
    color: #263b53;
}

.plt-disclaimer-highlight {
    margin-top: 18px;
    padding: 17px 18px;
    border-left: 4px solid #f7941d;
    border-radius: 9px;
    background: #fff7eb;
    color: #53606f;
    font-size: 14px;
    line-height: 1.7;
}

@media (max-width: 991px) {
    .plt-disclaimer-layout {
        grid-template-columns: 1fr;
    }

    .plt-disclaimer-sidebar {
        position: static;
    }

    .plt-disclaimer-sidebar-links {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 4px;
    }

    .plt-disclaimer-sidebar a {
        margin: 0;
    }
}

@media (max-width: 768px) {
    .plt-disclaimer-hero {
        padding: 65px 0 58px;
    }

    .plt-disclaimer-hero h1 {
        font-size: 38px;
    }

    .plt-disclaimer-hero p {
        font-size: 15px;
    }

    .plt-disclaimer-layout {
        padding-top: 42px;
        padding-bottom: 55px;
    }

    .plt-disclaimer-sidebar-links {
        grid-template-columns: 1fr;
    }

    .plt-disclaimer-card {
        padding: 24px 20px;
        border-radius: 15px;
    }

    .plt-disclaimer-card h2 {
        font-size: 20px;
    }

    .plt-disclaimer-card p,
    .plt-disclaimer-card li {
        font-size: 14px;
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

    
<main class="plt-disclaimer-page">

    <!-- =====================================================
         DISCLAIMER HERO
    ====================================================== -->

    <section class="plt-disclaimer-hero">

        <div class="plt-container">

            <div class="plt-disclaimer-hero-inner">

                <div class="plt-disclaimer-badge">
                    <i class="bi bi-exclamation-triangle"></i>
                    Important Information
                </div>

                <h1>
                    Disclaimer
                </h1>

                <p>
                    This page explains the limits of PeopleLink’s
                    responsibility as a technology platform connecting users,
                    communities, businesses and service providers.
                </p>

            </div>

        </div>

    </section>


    <!-- =====================================================
         DISCLAIMER CONTENT
    ====================================================== -->

    <section>

        <div class="plt-container">

            <div class="plt-disclaimer-layout">

                <!-- SIDEBAR -->

                <aside class="plt-disclaimer-sidebar">

                    <div class="plt-disclaimer-sidebar-title">
                        Legal Information
                    </div>

                    <div class="plt-disclaimer-sidebar-links">

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

                        <a href="disclaimer.php" class="active">
                            <i class="bi bi-exclamation-triangle"></i>
                            Disclaimer
                        </a>

                        <a href="cookie-policy.php">
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

                <div class="plt-disclaimer-content">

                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-layers"></i>
                            Platform Role
                        </h2>

                        <p>
                            PeopleLink acts primarily as a digital platform
                            that enables users to:
                        </p>

                        <ul>
                            <li>Connect with community members</li>
                            <li>View matrimony profiles</li>
                            <li>Discover jobs</li>
                            <li>Find professionals and businesses</li>
                            <li>Access marketplace listings</li>
                            <li>View events and advertisements</li>
                            <li>Request or offer community support</li>
                        </ul>

                        <p>
                            PeopleLink does not automatically verify every user,
                            listing, claim, document or transaction unless
                            specifically stated.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-person-lines-fill"></i>
                            User-Provided Information
                        </h2>

                        <p>
                            Most information available on PeopleLink is
                            submitted by users, businesses, employers,
                            organisers or community representatives.
                        </p>

                        <p>
                            Users should independently verify information
                            before making any personal, financial,
                            professional or matrimonial decision.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-heart"></i>
                            Matrimony Disclaimer
                        </h2>

                        <p>
                            PeopleLink does not guarantee:
                        </p>

                        <ul>
                            <li>Accuracy of profile information</li>
                            <li>Compatibility between users</li>
                            <li>Background or family details</li>
                            <li>Financial status</li>
                            <li>Employment information</li>
                            <li>Marriage outcome</li>
                        </ul>

                        <p>
                            Users should conduct their own verification before
                            proceeding with any matrimonial relationship.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-briefcase"></i>
                            Jobs Disclaimer
                        </h2>

                        <p>
                            PeopleLink does not guarantee:
                        </p>

                        <ul>
                            <li>Authenticity of every employer</li>
                            <li>Job selection</li>
                            <li>Salary</li>
                            <li>Interview outcome</li>
                            <li>Employment continuation</li>
                            <li>Recruitment results</li>
                        </ul>

                        <p>
                            Users should verify employers and job offers
                            independently.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-building"></i>
                            Professional &amp; Business Directory Disclaimer
                        </h2>

                        <p>
                            PeopleLink does not guarantee the quality,
                            qualification, pricing, availability or outcome of
                            services provided by listed professionals or
                            businesses.
                        </p>

                        <p>
                            Users should verify service providers before
                            engaging them.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-shop"></i>
                            Marketplace Disclaimer
                        </h2>

                        <p>
                            PeopleLink is not automatically the buyer, seller,
                            owner or guarantor of marketplace products.
                        </p>

                        <p>
                            Users are responsible for verifying:
                        </p>

                        <ul>
                            <li>Seller identity</li>
                            <li>Ownership</li>
                            <li>Product condition</li>
                            <li>Price</li>
                            <li>Documents</li>
                            <li>Delivery arrangements</li>
                            <li>Payment terms</li>
                        </ul>

                        <p>
                            PeopleLink is not responsible for disputes arising
                            directly between buyers and sellers unless
                            otherwise stated.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-calendar-event"></i>
                            Events &amp; Advertisements Disclaimer
                        </h2>

                        <p>
                            PeopleLink does not guarantee the accuracy of every:
                        </p>

                        <ul>
                            <li>Event date</li>
                            <li>Venue</li>
                            <li>Offer</li>
                            <li>Advertisement</li>
                            <li>Product claim</li>
                            <li>Service claim</li>
                        </ul>

                        <p>
                            Users should confirm details with the relevant
                            organiser or advertiser.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-life-preserver"></i>
                            Community Support Disclaimer
                        </h2>

                        <p>
                            PeopleLink facilitates support requests but does
                            not guarantee:
                        </p>

                        <ul>
                            <li>Authenticity of every request</li>
                            <li>Availability of assistance</li>
                            <li>Completion of promised help</li>
                            <li>Use of funds by a requester</li>
                        </ul>

                        <p>
                            Users should verify requests before providing
                            financial or material assistance.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-box-arrow-up-right"></i>
                            External Links
                        </h2>

                        <p>
                            PeopleLink may provide links to external websites,
                            payment gateways, WhatsApp, social media platforms,
                            maps or live-program links.
                        </p>

                        <p>
                            PeopleLink is not responsible for the content,
                            availability, security or policies of third-party
                            platforms.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-server"></i>
                            Technical Availability
                        </h2>

                        <p>
                            PeopleLink may occasionally experience:
                        </p>

                        <ul>
                            <li>Maintenance</li>
                            <li>Server downtime</li>
                            <li>Network issues</li>
                            <li>Third-party service failures</li>
                            <li>Payment gateway interruptions</li>
                            <li>App Store / Play Store related issues</li>
                        </ul>

                        <p>
                            Continuous or uninterrupted availability cannot be
                            guaranteed.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-credit-card"></i>
                            Financial Transactions
                        </h2>

                        <p>
                            Users should carefully verify all payment details
                            before making payments.
                        </p>

                        <p>
                            PeopleLink is not responsible for payments made
                            directly between users outside the platform.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-mortarboard"></i>
                            No Professional Advice
                        </h2>

                        <p>
                            Information available on PeopleLink should not
                            automatically be treated as legal, financial,
                            medical or other professional advice unless it is
                            specifically provided by an appropriately qualified
                            professional.
                        </p>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-shield-exclamation"></i>
                            Limitation of Responsibility
                        </h2>

                        <p>
                            To the extent permitted by applicable law, PeopleLink
                            should not be responsible for indirect losses,
                            disputes or damages resulting from independent
                            interactions or transactions between users.
                        </p>

                        <div class="plt-disclaimer-highlight">
                            Users are encouraged to independently verify
                            information, exercise appropriate judgment and
                            understand the risks associated with independent
                            interactions and transactions.
                        </div>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-arrow-repeat"></i>
                            Changes
                        </h2>

                        <p>
                            This Disclaimer may be updated when:
                        </p>

                        <ul>
                            <li>New modules are introduced</li>
                            <li>Platform functionality changes</li>
                            <li>Legal requirements change</li>
                            <li>Third-party integrations change</li>
                        </ul>

                    </article>


                    <article class="plt-disclaimer-card">

                        <h2>
                            <i class="bi bi-headset"></i>
                            Contact
                        </h2>

                        <p>
                            Users with concerns regarding this Disclaimer can
                            contact PeopleLink through the official support or
                            grievance channel.
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