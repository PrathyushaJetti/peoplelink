PeopleLink Matrimony Dashboard

1. Upload to public_html and extract. It creates/overwrites public_html/matrimony/.
2. Open config.php: set DB_PASS. Set FRONTEND_URL to the folder holding your frontend pages (ending with /).
3. Open https://yourdomain/matrimony/login.php
4. Press Ctrl+F5 once so the browser loads the new CSS/JS.
5. Subdomains: set USE_SUBDOMAINS=true only after wildcard DNS (*.yourdomain.com) points to this folder.
6. Sidebar items: includes/layout.php (menu_items()).
7. Frontend connection: see CONNECT-FRONTEND.txt
