# A 42's project - An instagram-like

#SOME PIC :

#https://github.com/oumaysou/camagru/blob/master/vue/photos/oumaysou12/2-oumaysou12-1558441759.png
#https://github.com/oumaysou/camagru/blob/master/vue/photos/oumaysou12/3-oumaysou12-1558441745.png

#Sujet : https://github.com/oumaysou/camagru/blob/master/camagru.fr.pdf

1st Project of Web Branch

#OUTILS : PHP/MySQL/JS

LES ETAPES POUR LANCER LE PROJET :

1 - Mettre en place la base donnée

    => Une fois le serveur LAMP/MAMP (ou autre) est pret, veuillez vous rendre sur localhost:"port"/config/setup.php
    => Vérifier le SENDMAIL_PATH dans le fichier php.ini :
        exp MAMP : 
                    ; http://php.net/smtp-port
                    ;smtp_port = 25

                    ; For Win32 only.
                    ; http://php.net/sendmail-from
                    ;sendmail_from = me@example.com

                    ; For Unix only.  You may supply arguments as well (default: "sendmail -t -i").
                    ; http://php.net/sendmail-path
                    ;sendmail_path = "env -i /usr/sbin/sendmail -t -i"
                    sendmail_path = /usr/sbin/sendmail -t -i -f Camagru-oumaysou@student.42.fr

2 - Inscrive-vous et profiter du site.

Project Tree :

.
├── auteur
├── camagru.fr.pdf
├── config
│   ├── base
│   │   └── db.sql
│   ├── database.php
│   ├── setup.css
│   └── setup.php
├── css
│   ├── account-page.css
│   ├── camera.css
│   ├── comment-page.css
│   ├── delete-account.css
│   ├── footer.css
│   ├── forgetPassword-page.css
│   ├── gallery.css
│   ├── home.css
│   ├── login-page.css
│   ├── main.css
│   ├── navbar.css
│   └── register-page.css
├── images
│   ├── account.jpg
│   ├── arrow2.png
│   ├── camagru.jpg
│   ├── collage-1.jpg
│   ├── collage.jpg
│   ├── comment-page.png
│   ├── comment.png
│   ├── cutmypic.png
│   ├── delete-account-title.jpg
│   ├── delete-comment.png
│   ├── donut.png
│   ├── Example to UPLOAD
│   │   ├── 1000.jpg
│   │   ├── 2000.jpg
│   │   ├── 3008-2008.jpg
│   │   ├── 300.jpg
│   │   ├── 4000.jpg
│   │   ├── 400.png
│   │   ├── 450-650.jpg
│   │   ├── 480.jpg
│   │   ├── 500.jpg
│   │   ├── 5184-3456.JPG
│   │   ├── 600.jpeg
│   │   └── 800.jpg
│   ├── gallery-by-filter.jpg
│   ├── gallery.jpg
│   ├── heart-3.png
│   ├── heart-4.png
│   ├── logo.png
│   ├── new-password.jpg
│   ├── others-comments.jpg
│   ├── photo.jpg
│   ├── pizza.png
│   └── pow.png
├── inc
│   ├── db.php
│   └── functions.php
├── index.php
├── README.md
├── test-mail.php
└── vue
    ├── account-page
    │   ├── account.php
    │   └── delete-account.php
    ├── footer
    │   └── footer.php
    ├── forgetPassword-page
    │   ├── forget.php
    │   └── reset.php
    ├── gallery-page
    │   ├── comment.php
    │   ├── delete-comment.js
    │   ├── deleteComment.php
    │   ├── filter.php
    │   ├── gallery.php
    │   ├── like.php
    │   └── set-gallery.js
    ├── header
    │   └── header.php
    ├── home-page
    │   ├── deletePhoto.js
    │   ├── deletePhoto.php
    │   ├── get-webcam-photo.php
    │   ├── home.php
    │   ├── login-page.php
    │   ├── logout.php
    │   └── webcam.js
    ├── navbar
    │   └── navbar.php
    ├── photos
    │   └── oumaysou12
    │       ├── 0-oumaysou12-1558442313.png
    │       ├── 1-oumaysou12-1558441764.png
    │       ├── 2-oumaysou12-1558441759.png
    │       └── 3-oumaysou12-1558441745.png
    └── register-page
        ├── confirm.php
        ├── end-register.php
        └── register.php