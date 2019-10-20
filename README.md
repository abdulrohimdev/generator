# generator
The generator (Make Controller, Make view and Make Model via Command prompt) for Codeigniter
Creator : Abdul Rohim
Email   : abdul.rohim@dp.dharmap.com
Phone   : 0821 1346 0348

installation :
extract generator.zip and move to under your project, path like this:
your_project/
    /application
    /generator   
    /system


1. How to create the Controller via Command ?
   answer : Your must in directory generator with example : cd generator 
            and then write in the syntax on your command prompt : 
                    php new controller:Dashboards
            if you want to create controller with the method, write like this:
                    php new controller:Dashboards index update delete edit

2. How to create the view via Command ?
    answer : this is a simple, please follow from this syntax :
                    php new view:dashboards
            and if you with the folder and sub folder
                    php new view:your_folder.sub_folder_in_your_folder.file_in_your_sub_folder
                    example: 
                    php new view:page.dashboards.index
                    the path : /application/views/page/dashboards/index.php
        
3. How to create the model via Command ?
    answer : this is a simple, please follow from this syntax :
                    php new model:your_model
                    example : php new model:Article
             if you want to create model and method, please follow the syntax like this:
                    php new model:Article insert delete update get find (and_more_your_method)
            
             and if you want to create model like eloquent, just follow the syntax like this:
                    php new model:article resource


4. if you want to use server development :
    just follow the syntax on command line : 
        php runserver
        and then open your browser with address http://localhost:3000


5. How to create table from command,
    before your create table via command, please setup your database in generator/config.php
    and then :
        write on command prompt like this:
            php migrate modelname id:primarykey username:string_uniq role:enum_['admin','user]
            php migrate up (if you want to migrate)
            php migrate down (if you want to drop table)
        and then check in folder migrate, the file migrate has been created, for documentation please check on laravel framework



