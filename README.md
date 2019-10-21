# generator

    Generator ini digunakan untuk mempermudah pengembangan system berbasis web. Dengan menggunakan framework 3.x, generator ini bisa membuat sebuah Controller, Model, view, dan migration melalui command prompt.


    Cara menggunakannya extract file generator-master.zip kemudian rename dengan nama folder generator.
    setelah itu pindahkan folder generator ke dalam projek anda, sejajar dengan folder application, system
    pathnya seperti ini namaprojek_anda/generator.

    Periksa kembali php versi anda, generator ini hanya support untuk versi 7.x.
    untuk cara mengeceknya silahkan buka command prompt dan ketik kan php --version
    jika php --version tidak terbaca, coba anda pasang di environtment variables

    caranya jika anda menggunakan xampp dan berada di disk C.
    cari folder xampp dan buka folder php, kemudian copy path address nya
    contoh seperti ini: C:\xampp\php

    kemudian klik start, klik kanan computer pilih properties, kemudian klik advanced system setting    
    kemudian klik juga Environtment Variables , pada users variable for admin cari variable path
    dan edit setelah itu tambahkan tanda ;C:\xampp\php; seperti ini.

    silahkan cek kembali di command prompt anda php --version.
    Jika versi dibawah 7 silahkan di update.

    untuk melihat isi perintahnya coba ketik perintah tersebut : php new help 

        contoh : php new controller:about index get update delete
                 about adalah nama controller sekaligus class
                 index get update delete adalah nama method dari controller

        contoh buat model:
                php new model:article resource
                article adalah nama model sekaligus class nya, sedangkan resource adalah perintah crud di dalam model sudah di siapkan

        contoh buat model ke dua tanpa resource
                php new model:article get update delete
                article adalah nama model sekaligus class model, sedangkan get update delete adalah nama method dari si model


        contoh buat view
                php new view:page.about.index
                page adalah folder, about adalah sub folder under page dan index adalah file.php
                jadi pathnya seperti ini views/page/about/index.php

        contoh menjalankan server development:
                php runserver
                server anda akan berjalan pada localhost:3000

        contoh membuat sebuah tabel migration database di command prompt
                silahkan buka file config.php partnya ada di generator/config.php
                setting database sesuai yang anda mau. kemudian:

        ketik : 
        php migrate user id:primarykey username:string_uniq password:string role:enum_['admin','user']
        
        nama user adalah nama table yang nantinya akan menjadi jamak/plural secara otomatis dan dibuatkan file migration pada folder generator/migration dengan nama file UserTable.php
        dokumentasi isi file UserTable dapat di lihat di dokumentasi laravel.

        setelah itu ketik:
        php migrate up
        setelah itu cek database anda akan dibuat kan secara otomatis nama tabel users beserta field nya


        sedangkan untuk:
        php migrate down
        digunakan untuk mendrop semua tabel yang ada di database, nama tabel anda akan hilang/dihapus.


        


        type data yang tersedia untuk migrate

        primarykey   : untuk id primary dan auto increment
        string       : untuk varchar(255); untuk mengubah length nya silahkan buka file migration dan                          dokumentasi ada di laravel

        string_uniq  : untuk varchar(255) namun bersifat unique
        date         : untuk type data date
        datetime     : untuk type data datetime
        enum_[array] : untuk type data enum beserta optionya
        float        : untuk type data decimal atau float
        text         : untuk type data longText
        integer      : untuk type data integer
        integer_uniq : untuk type data integer_uniq

        selanjutnya nanti akan saya kembangkan lebih luas lagi.


        salam:
        Abdul Rohim
        abdulrohim34@gmail.com
        whatsapp : 0821 1346 0348
