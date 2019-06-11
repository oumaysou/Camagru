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