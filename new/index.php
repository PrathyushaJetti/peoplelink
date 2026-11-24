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
        content="PeopleLink Technologies Private Limited - Technology, Innovation and Digital Transformation."
    >

    <meta
        name="keywords"
        content="PeopleLink Technologies, Software Development, Web Development, Mobile App Development, Cloud Solutions, AI, Automation, Digital Transformation"
    >

    <meta
        name="author"
        content="PeopleLink Technologies Private Limited"
    >

    <title>
        PeopleLink Technologies Private Limited
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

    <main>


        <!-- =====================================================
             HERO SECTION
        ====================================================== -->

        <section
            class="plt-hero"
            id="home"
        >

            <div class="plt-container">

                <div class="plt-hero-grid">


                    <div class="plt-hero-content">

                        <span class="plt-hero-label">

                            PeopleLink Technologies Private Limited

                        </span>


                        <h1>

                            Technology That Connects.

                            <span>
                                Innovation That Transforms.
                            </span>

                        </h1>


                        <p>

                            PeopleLink Technologies Private Limited
                            is a technology-driven IT company focused
                            on delivering innovative, secure, scalable,
                            and future-ready digital solutions for
                            businesses, organizations, and communities.

                        </p>


                        <div class="plt-hero-actions">

                            <a
                                href="#services"
                                class="plt-btn plt-btn-primary"
                            >

                                Explore Services

                                <i class="bi bi-arrow-right"></i>

                            </a>


                            <a
                                href="#contact"
                                class="plt-btn plt-btn-outline"
                            >

                                Contact Us

                                <i class="bi bi-chat-dots"></i>

                            </a>

                        </div>

                    </div>


                    <div class="plt-hero-visual">

                        <div class="plt-hero-card">

                            <div class="plt-hero-icon">

                                <i class="bi bi-cpu"></i>

                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </section>


        <!-- =====================================================
             ABOUT SECTION
        ====================================================== -->

        <section
            class="plt-section plt-about"
            id="about"
        >

            <div class="plt-container">


                <div class="plt-section-heading">

                    <span class="plt-section-label">
                        About Us
                    </span>


                    <h2>

                        Building Technology

                        <span>
                            For Real-World Challenges
                        </span>

                    </h2>


                    <p>

                        PeopleLink Technologies is focused on
                        building modern software solutions,
                        digital platforms, cloud-based solutions,
                        and technology services that address
                        real-world business challenges.

                    </p>

                </div>


                <div class="plt-about-content">

                    <p class="plt-about-description">

                        Our approach combines innovation, security,
                        scalability, performance, and user-centric
                        design to create technology solutions that
                        deliver meaningful and long-term value.

                    </p>


                    <div class="plt-about-points">


                        <div class="plt-about-point">

                            <div class="plt-about-point-icon">

                                <i class="bi bi-lightbulb"></i>

                            </div>


                            <h3>
                                Innovation
                            </h3>


                            <p>

                                Modern solutions designed around
                                changing business requirements.

                            </p>

                        </div>


                        <div class="plt-about-point">

                            <div class="plt-about-point-icon">

                                <i class="bi bi-shield-check"></i>

                            </div>


                            <h3>
                                Security
                            </h3>


                            <p>

                                Security-focused engineering
                                across digital solutions.

                            </p>

                        </div>


                        <div class="plt-about-point">

                            <div class="plt-about-point-icon">

                                <i class="bi bi-graph-up-arrow"></i>

                            </div>


                            <h3>
                                Scalability
                            </h3>


                            <p>

                                Solutions designed to grow with
                                your organization.

                            </p>

                        </div>


                    </div>

                </div>

            </div>

        </section>


        <!-- =====================================================
             SERVICES SECTION
        ====================================================== -->

        <section
            class="plt-section plt-services"
            id="services"
        >

            <div class="plt-container">


                <div class="plt-section-heading">

                    <span class="plt-section-label">
                        Our Services
                    </span>


                    <h2>

                        Technology Services

                        <span>
                            That Move Businesses Forward
                        </span>

                    </h2>

                </div>


                <div class="plt-services-grid">


                    <article class="plt-service-card">

                        <div class="plt-service-icon">

                            <i class="bi bi-code-slash"></i>

                        </div>


                        <h3>
                            Software Development
                        </h3>


                        <p>

                            Custom software solutions designed
                            to meet specific business requirements.

                        </p>

                    </article>


                    <article class="plt-service-card">

                        <div class="plt-service-icon">

                            <i class="bi bi-phone"></i>

                        </div>


                        <h3>
                            Web & Mobile Application Development
                        </h3>


                        <p>

                            Modern, responsive, and user-friendly
                            web and mobile applications.

                        </p>

                    </article>


                    <article class="plt-service-card">

                        <div class="plt-service-icon">

                            <i class="bi bi-cloud"></i>

                        </div>


                        <h3>
                            Cloud Solutions
                        </h3>


                        <p>

                            Scalable cloud architecture, deployment,
                            migration, infrastructure, and optimization.

                        </p>

                    </article>


                    <article class="plt-service-card">

                        <div class="plt-service-icon">

                            <i class="bi bi-robot"></i>

                        </div>


                        <h3>
                            AI & Automation
                        </h3>


                        <p>

                            AI-powered solutions and intelligent
                            automation designed to improve productivity.

                        </p>

                    </article>


                    <article class="plt-service-card">

                        <div class="plt-service-icon">

                            <i class="bi bi-bar-chart"></i>

                        </div>


                        <h3>
                            Data Engineering & Analytics
                        </h3>


                        <p>

                            Data engineering, integration, analytics,
                            reporting, and business intelligence solutions.

                        </p>

                    </article>


                    <article class="plt-service-card">

                        <div class="plt-service-icon">

                            <i class="bi bi-diagram-3"></i>

                        </div>


                        <h3>
                            API & System Integration
                        </h3>


                        <p>

                            Secure and scalable APIs and integrations
                            connecting applications and business systems.

                        </p>

                    </article>


                    <article class="plt-service-card">

                        <div class="plt-service-icon">

                            <i class="bi bi-building"></i>

                        </div>


                        <h3>
                            Enterprise Solutions
                        </h3>


                        <p>

                            Technology solutions supporting business
                            operations and digital transformation.

                        </p>

                    </article>


                    <article class="plt-service-card">

                        <div class="plt-service-icon">

                            <i class="bi bi-person-workspace"></i>

                        </div>


                        <h3>
                            IT Consulting
                        </h3>


                        <p>

                            Technology consulting, solution architecture,
                            strategy, and digital transformation services.

                        </p>

                    </article>


                </div>

            </div>

        </section>


        <!-- =====================================================
             SOLUTIONS SECTION
        ====================================================== -->

        <section
            class="plt-section"
            id="solutions"
        >

            <div class="plt-container">


                <div class="plt-section-heading">

                    <span class="plt-section-label">
                        Our Solutions
                    </span>


                    <h2>

                        Solutions Built For

                        <span>
                            Digital Transformation
                        </span>

                    </h2>


                    <p>

                        We develop technology solutions that help
                        organizations modernize operations, improve
                        productivity, connect users, and accelerate
                        digital transformation.

                    </p>

                </div>


                <div class="plt-solution-grid">


                    <div class="plt-solution-item">

                        <i class="bi bi-arrow-repeat"></i>

                        <span>
                            Digital Transformation
                        </span>

                    </div>


                    <div class="plt-solution-item">

                        <i class="bi bi-gear"></i>

                        <span>
                            Business Process Automation
                        </span>

                    </div>


                    <div class="plt-solution-item">

                        <i class="bi bi-window-stack"></i>

                        <span>
                            Enterprise Applications
                        </span>

                    </div>


                    <div class="plt-solution-item">

                        <i class="bi bi-cloud-check"></i>

                        <span>
                            Cloud Solutions
                        </span>

                    </div>


                    <div class="plt-solution-item">

                        <i class="bi bi-database"></i>

                        <span>
                            Data & Analytics
                        </span>

                    </div>


                    <div class="plt-solution-item">

                        <i class="bi bi-stars"></i>

                        <span>
                            AI & Automation
                        </span>

                    </div>


                    <div class="plt-solution-item">

                        <i class="bi bi-grid"></i>

                        <span>
                            Digital Platforms
                        </span>

                    </div>


                    <div class="plt-solution-item">

                        <i class="bi bi-plug"></i>

                        <span>
                            API & System Integration
                        </span>

                    </div>


                    <div class="plt-solution-item">

                        <i class="bi bi-code-square"></i>

                        <span>
                            Custom Software Solutions
                        </span>

                    </div>


                </div>

            </div>

        </section>


        <!-- =====================================================
             INDUSTRIES SECTION
        ====================================================== -->

        <section
            class="plt-section plt-industries"
        >

            <div class="plt-container">


                <div class="plt-section-heading">

                    <span class="plt-section-label">
                        Industries We Serve
                    </span>


                    <h2>

                        Technology For

                        <span>
                            Different Industries
                        </span>

                    </h2>

                </div>


                <div class="plt-industry-grid">


                    <div class="plt-industry-card">

                        <i class="bi bi-briefcase"></i>

                        <span>
                            Businesses
                        </span>

                    </div>


                    <div class="plt-industry-card">

                        <i class="bi bi-buildings"></i>

                        <span>
                            Enterprises
                        </span>

                    </div>


                    <div class="plt-industry-card">

                        <i class="bi bi-mortarboard"></i>

                        <span>
                            Educational Organizations
                        </span>

                    </div>


                    <div class="plt-industry-card">

                        <i class="bi bi-person-badge"></i>

                        <span>
                            Professional Services
                        </span>

                    </div>


                    <div class="plt-industry-card">

                        <i class="bi bi-people"></i>

                        <span>
                            Associations
                        </span>

                    </div>


                    <div class="plt-industry-card">

                        <i class="bi bi-globe"></i>

                        <span>
                            Communities
                        </span>

                    </div>


                    <div class="plt-industry-card">

                        <i class="bi bi-heart"></i>

                        <span>
                            Social Organizations
                        </span>

                    </div>


                    <div class="plt-industry-card">

                        <i class="bi bi-graph-up"></i>

                        <span>
                            Growing Businesses
                        </span>

                    </div>


                </div>

            </div>

        </section>


        <!-- =====================================================
             PRODUCT SECTION
        ====================================================== -->

        <section class="plt-section">

            <div class="plt-container">


                <div class="plt-product-box">

                    <div class="plt-product-content">

                        <span class="plt-section-label">
                            Our Product
                        </span>


                        <h2>
                            Digital Community
                        </h2>


                        <p>

                            Next-generation digital community
                            platform designed to connect people,
                            communities, organizations, and
                            opportunities through technology.

                        </p>


                        <a
                            href="<?php echo htmlspecialchars($productWebsite); ?>"
                            target="_blank"
                            rel="noopener"
                            class="plt-btn plt-btn-primary"
                        >

                            Visit Digital Community

                            <i class="bi bi-arrow-up-right"></i>

                        </a>

                    </div>

                </div>

            </div>

        </section>


        <!-- =====================================================
             TECHNOLOGY SECTION
        ====================================================== -->

        <section
            class="plt-section"
            id="technology"
        >

            <div class="plt-container">


                <div class="plt-section-heading">

                    <span class="plt-section-label">
                        Technology & Innovation
                    </span>


                    <h2>

                        Engineering With

                        <span>
                            Modern Technology
                        </span>

                    </h2>

                </div>


                <div class="plt-tech-grid">


                    <div class="plt-tech-item">

                        <i class="bi bi-cloud"></i>

                        <span>
                            Cloud Computing
                        </span>

                    </div>


                    <div class="plt-tech-item">

                        <i class="bi bi-code-slash"></i>

                        <span>
                            Software Engineering
                        </span>

                    </div>


                    <div class="plt-tech-item">

                        <i class="bi bi-phone"></i>

                        <span>
                            Web & Mobile Technologies
                        </span>

                    </div>


                    <div class="plt-tech-item">

                        <i class="bi bi-plug"></i>

                        <span>
                            API Development & Integration
                        </span>

                    </div>


                    <div class="plt-tech-item">

                        <i class="bi bi-database"></i>

                        <span>
                            Data Engineering & Analytics
                        </span>

                    </div>


                    <div class="plt-tech-item">

                        <i class="bi bi-cpu"></i>

                        <span>
                            Artificial Intelligence & Automation
                        </span>

                    </div>


                    <div class="plt-tech-item">

                        <i class="bi bi-arrow-repeat"></i>

                        <span>
                            DevOps & CI/CD
                        </span>

                    </div>


                    <div class="plt-tech-item">

                        <i class="bi bi-hdd-network"></i>

                        <span>
                            Cloud Infrastructure
                        </span>

                    </div>


                    <div class="plt-tech-item">

                        <i class="bi bi-speedometer2"></i>

                        <span>
                            Monitoring & Performance Optimization
                        </span>

                    </div>


                </div>

            </div>

        </section>


        <!-- =====================================================
             WHY PEOPLELINK
        ====================================================== -->

        <section class="plt-section plt-why">

            <div class="plt-container">


                <div class="plt-section-heading">

                    <span class="plt-section-label">
                        Why PeopleLink Technologies
                    </span>


                    <h2>

                        Why Businesses

                        <span>
                            Choose Us
                        </span>

                    </h2>

                </div>


                <div class="plt-why-grid">


                    <div class="plt-why-card">

                        <i class="bi bi-lightning-charge"></i>

                        <h3>
                            Innovation Driven
                        </h3>

                    </div>


                    <div class="plt-why-card">

                        <i class="bi bi-arrows-angle-expand"></i>

                        <h3>
                            Scalable Solutions
                        </h3>

                    </div>


                    <div class="plt-why-card">

                        <i class="bi bi-shield-lock"></i>

                        <h3>
                            Security Focused
                        </h3>

                    </div>


                    <div class="plt-why-card">

                        <i class="bi bi-person-heart"></i>

                        <h3>
                            Customer Centric
                        </h3>

                    </div>


                    <div class="plt-why-card">

                        <i class="bi bi-award"></i>

                        <h3>
                            Quality Engineering
                        </h3>

                    </div>


                    <div class="plt-why-card">

                        <i class="bi bi-handshake"></i>

                        <h3>
                            Long-Term Partnership
                        </h3>

                    </div>


                </div>

            </div>

        </section>


        <!-- =====================================================
             VISION MISSION VALUES
        ====================================================== -->

        <section class="plt-section">

            <div class="plt-container">


                <div class="plt-vmv-grid">


                    <div class="plt-vmv-card">

                        <div class="plt-vmv-card-icon">

                            <i class="bi bi-eye"></i>

                        </div>


                        <h3>
                            Vision
                        </h3>


                        <p>

                            To become a trusted technology company
                            delivering innovative, secure, scalable,
                            and future-ready digital solutions that
                            create meaningful value for businesses
                            and society.

                        </p>

                    </div>


                    <div class="plt-vmv-card">

                        <div class="plt-vmv-card-icon">

                            <i class="bi bi-bullseye"></i>

                        </div>


                        <h3>
                            Mission
                        </h3>


                        <p>

                            To leverage technology, innovation,
                            and engineering excellence to build
                            reliable digital solutions that help
                            organizations connect, operate, grow,
                            and transform.

                        </p>

                    </div>


                    <div class="plt-vmv-card">

                        <div class="plt-vmv-card-icon">

                            <i class="bi bi-stars"></i>

                        </div>


                        <h3>
                            Values
                        </h3>


                        <p>

                            Innovation • Integrity • Customer Focus
                            • Quality • Collaboration • Continuous
                            Improvement

                        </p>

                    </div>


                </div>

            </div>

        </section>


        <!-- =====================================================
             CAREERS
        ====================================================== -->

        <section
            class="plt-section plt-careers"
            id="careers"
        >

            <div class="plt-container">


                <div class="plt-careers-box">


                    <div>

                        <span class="plt-section-label">
                            Careers
                        </span>


                        <h2>

                            Build The Future

                            <span>
                                With Us
                            </span>

                        </h2>


                        <p>

                            PeopleLink Technologies believes great
                            technology is created by talented and
                            passionate people.

                        </p>


                        <p>

                            We are building a team of professionals
                            passionate about technology, innovation,
                            problem-solving, and meaningful impact.

                        </p>

                    </div>


                    <div class="plt-career-list">

                        <span>
                            Software Engineering
                        </span>

                        <span>
                            Cloud & DevOps
                        </span>

                        <span>
                            Data Engineering
                        </span>

                        <span>
                            AI & Automation
                        </span>

                        <span>
                            Mobile Development
                        </span>

                        <span>
                            UI/UX
                        </span>

                        <span>
                            Quality Engineering
                        </span>

                        <span>
                            Business Development
                        </span>

                        <span>
                            Technology Consulting
                        </span>

                    </div>


                </div>

            </div>

        </section>


        <!-- =====================================================
             CONTACT
        ====================================================== -->

        <section
            class="plt-section plt-contact"
            id="contact"
        >

            <div class="plt-container">


                <div class="plt-contact-grid">


                    <div class="plt-contact-content">

                        <span class="plt-section-label">
                            Contact Us
                        </span>


                        <h2>

                            Let's Build Something

                            <span>
                                Great Together
                            </span>

                        </h2>


                        <p>

                            Have a business requirement,
                            technology challenge, or product idea?

                        </p>


                        <p>

                            Connect with PeopleLink Technologies
                            to discuss your requirements and explore
                            the right technology solution.

                        </p>

                    </div>


                    <div class="plt-contact-card">

                        <h3>

                            <?php
                            echo htmlspecialchars($companyName);
                            ?>

                        </h3>


                        <div class="plt-contact-item">

                            <i class="bi bi-envelope"></i>


                            <a
                                href="mailto:<?php echo htmlspecialchars($companyEmail); ?>"
                            >

                                <?php
                                echo htmlspecialchars($companyEmail);
                                ?>

                            </a>

                        </div>


                        <div class="plt-contact-item">

                            <i class="bi bi-globe"></i>


                            <a
                                href="<?php echo htmlspecialchars($companyWebsite); ?>"
                                target="_blank"
                                rel="noopener"
                            >

                                peoplelinktech.com

                            </a>

                        </div>


                        <div class="plt-contact-tagline">

                            Technology • Innovation • Digital Transformation

                        </div>

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


                    <!-- LEGAL & POLICY -->

                    <div class="plt-footer-column">

                        <h3>
                            Legal & Policy
                        </h3>


                        <div class="plt-footer-links">

                            <a href="privacy-policy.php">

                                <i class="bi bi-chevron-right"></i>

                                Privacy Policy

                            </a>


                            <a href="terms-conditions.php">

                                <i class="bi bi-chevron-right"></i>

                                Terms & Conditions

                            </a>


                            <a href="refund-cancellation-policy.php">

                                <i class="bi bi-chevron-right"></i>

                                Refund / Cancellation Policy

                            </a>


                            <a href="community-guidelines.php">

                                <i class="bi bi-chevron-right"></i>

                                Community Guidelines

                            </a>


                            <a href="disclaimer.php">

                                <i class="bi bi-chevron-right"></i>

                                Disclaimer

                            </a>


                            <a href="cookie-policy.php">

                                <i class="bi bi-chevron-right"></i>

                                Cookie Policy

                            </a>


                            <a href="data-account-deletion-request.php">

                                <i class="bi bi-chevron-right"></i>

                                Data / Account Deletion

                            </a>


                            <a href="grievance-support-contact.php">

                                <i class="bi bi-chevron-right"></i>

                                Grievance / Support

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

                        <a href="privacy-policy.php">
                            Privacy Policy
                        </a>

                        <a href="terms-conditions.php">
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